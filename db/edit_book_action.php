<?php
include("config.php");
include('functions.php');

if (isset($_POST['update_book'])) {
    $key = $_POST['key'];
    $isbn = $_POST['isbn'];

    $book_exists = object_exists($key, $isbn, $database, 'books', 'isbn');
    if ($book_exists) {
        //if a different book with the same isbn exists
        $_SESSION['book_key'] = $key;
        $_SESSION['book_updated_flag'] = false;
        $_SESSION['book_updated'] = "A book with the same isbn exists, please check if the book already exists in the books table!";
    } else {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $image = $_FILES['image']['name'];
        $date = $_POST['date'];
        $summary = $_POST['summary'];

        $ref_table = "books/" . $key;
        if ($image != Null) {
            //new image is uploaded
            $image_name = $database->getReference($ref_table)->getValue()['image'];
            if ($image_name > 0) {
                //deleting the old img
                // unlink('../images/book_images/' . $image_name);
                $bucket->object('images/' . $image_name)->delete();
            }

            //uploading the new image
            $image_name = $isbn . $image;
            // move_uploaded_file($_FILES['image']['tmp_name'], '../images/book_images/' . $image_name);
            $file_contents = file_get_contents($_FILES['image']['tmp_name']);
            $bucket->upload($file_contents, ['name' => 'images/' . $image_name]);
        } else {
            //no uploaded image
            $image_name = $database->getReference($ref_table)->getValue()['image'];

            //if there was an image in DB
            if ($image_name > 0) {
                $no_isbn_name = substr($image_name, 10);
                $new_image_name = $isbn . $no_isbn_name;

                // rename('../images/book_images/' . $image_name, '../images/book_images/' . $new_image_name);
                if ($image_name != $new_image_name) {
                    //if image or its isbn changed -> change image in db storage
                    $object = $bucket->object('images/' . $image_name);
                    $object->copy($bucket, ['name' => 'images/' . $new_image_name]);
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

        $update_query_result =  $database->getReference($ref_table)->update($updateData);

        $_SESSION['book_key'] = $key;
        if ($update_query_result) {
            $_SESSION['book_updated_flag'] = true;
            $_SESSION['book_updated'] = "Book updated successfully!";
        } else {
            $_SESSION['book_updated_flag'] = false;
            $_SESSION['book_updated'] = "Something went wrong, please try again later!";
        }
    }
} else {
    $_SESSION['book_key'] = false;
    $_SESSION['book_updated_flag'] = false;
    $_SESSION['book_updated'] = "Something went wrong, please validate your inputs!";
}

header('location: ../pages/edit_book.php');
