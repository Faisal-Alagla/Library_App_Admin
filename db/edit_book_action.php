<?php
include("config.php");
include("../util/functions.php");

//update book
if (isset($_POST['update_book'])) {
    $key = $_POST['key'];
    $isbn = $_POST['isbn'];

    //check if a different book with the same isbn exists
    $book_exists = object_exists($key, $isbn, $database, 'books', 'isbn');
    if ($book_exists) {
        $_SESSION['book_key'] = $key;
        $_SESSION['book_updated_flag'] = false;
        $_SESSION['book_updated'] = "A book with the same isbn exists, please check if the book already exists in the books table!";
    } 

    //check if it contains none number values and of length other than 10 or 13
    else if (!ctype_digit($isbn) || !(strlen($isbn) == 10 || strlen($isbn) == 13)) {
        $_SESSION['book_key'] = $key;
        $_SESSION['book_updated_flag'] = false;
        $_SESSION['book_updated'] = "ISBN should only contain numbers and of length 10 or 13!";
    }

    //update
    else {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        //removing white space from image name
        $image = preg_replace('/\s+/', '', $_FILES['image']['name']);
        $date = $_POST['date'];
        $summary = $_POST['summary'];

        $ref_table = "books/$key";
        if ($image != Null) {
            //new image is uploaded
            $image_name = $database->getReference($ref_table)->getValue()['image'];
            if ($image_name > 0) {
                //deleting the old img
                $bucket->object("images/$image_name")->delete();
            }

            //uploading the new image
            $image_name = $isbn . $image;
            $file_contents = file_get_contents($_FILES['image']['tmp_name']);
            $bucket->upload($file_contents, ['name' => "images/$image_name"]);
        } else {
            //no uploaded image
            $image_name = $database->getReference($ref_table)->getValue()['image'];

            //if there was an image in DB
            if ($image_name > 0) {
                $no_isbn_name = substr($image_name, strlen($isbn));
                $new_image_name = $isbn . $no_isbn_name;

                if ($image_name != $new_image_name) {
                    //if image or its isbn changed -> change image in db storage
                    $object = $bucket->object("images/$image_name");
                    $object->copy($bucket, ['name' => "images/$new_image_name"]);
                    $object->delete();
                }

                $image_name = $new_image_name;
            }
        }

        $updateData = [
            'isbn' => $isbn,
            'title' => $title,
            'author' => $author,
            'category' => $category,
            'image' => $image_name,
            'date' => $date,
            'summary' => $summary,
        ];

        //This old isbn will be used for updating borrow requests and borrowers tables (check below)
        $old_isbn = $database->getReference($ref_table)->getValue()['isbn'];

        $update_query_result =  $database->getReference($ref_table)->update($updateData);

        //update borrow requests that had the old isbn / title with the new ones
        $borrow_requests_table = 'borrow_requests';
        $fetch_borrow_requests = $database->getReference($borrow_requests_table)->getValue();

        if($fetch_borrow_requests > 0) {
            //loop through borrow requests to update the isbn / title in them too
            foreach ($fetch_borrow_requests as $borrow_key => $row) {
                if ($row['isbn'] == $old_isbn) {
                    $updateCategory = [
                        'isbn' => $isbn,
                        'title' => $title
                    ];

                    $new_requests_table = "$borrow_requests_table/$borrow_key";
                    $update_query_result =  $database->getReference($new_requests_table)->update($updateCategory);
                }
            }
        }

        //update borrowed books in students tables
        $students_table = 'students';
        $fetch_students = $database->getReference($students_table)->getValue();
        foreach ($fetch_students as $student_key => $row) {
            //checking if the student has borrowed books and the isbn matches the edited book -> update it with the new isbn
            if (isset($row['borrowedBooks']) && array_key_exists($old_isbn, $row['borrowedBooks'])) {
                $prev_value = $row['borrowedBooks']["$old_isbn"];
                $updateCategory = [
                    "borrowedBooks/$old_isbn" => null,
                    "borrowedBooks/$isbn" => $prev_value,
                ];

                $new_book_table = "$students_table/$student_key/";
                $update_query_result =  $database->getReference($new_book_table)->update($updateCategory);
            }
        }

        $_SESSION['book_key'] = $key;
        if ($update_query_result) {
            $_SESSION['book_updated_flag'] = true;
            $_SESSION['book_updated'] = "Book updated successfully!";
        } else {
            $_SESSION['book_updated_flag'] = false;
            $_SESSION['book_updated'] = "Something went wrong, please try again later!";
        }
    }
//remove image
} else if (isset($_POST['remove_img'])){
    $key = $_POST['key'];
    $ref_table = "books/$key";
    $image = $database->getReference($ref_table)->getValue()['image'];

    if (($image > 0) && (strlen($image) > 0)) {
        //deleting the old img
        $updateData = [
            'image' => "",
        ];

        $bucket->object("images/$image")->delete();
        $database->getReference($ref_table)->update($updateData);

        //feedback messages
        $_SESSION['book_key'] = $key;
        $_SESSION['book_updated_flag'] = true;
        $_SESSION['book_updated'] = "Image deleted successfully!";
    }else{
        //no uploaded image file
        $_SESSION['book_key'] = $key;
        $_SESSION['book_updated_flag'] = false;
        $_SESSION['book_updated'] = "Something went wrong, please try again later!";
    }
}
//error
else {
    $_SESSION['book_key'] = false;
    $_SESSION['book_updated_flag'] = false;
    $_SESSION['book_updated'] = "Something went wrong, please try again later!";
}

if (!isset($_SESSION['book_key'])){
    header('location: ../pages/edit_book.php');
}else{
    header("location: ../pages/edit_book.php?id=".$_SESSION['book_key']);
}
