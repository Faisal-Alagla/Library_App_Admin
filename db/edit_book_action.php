<?php
include("config.php");

if (isset($_POST['update_book'])) {
    $key = $_POST['key'];
    $isbn = $_POST['isbn'];
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
            unlink('../images/book_images/' . $image_name);
        }

        $image_name = $isbn . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/book_images/' . $image_name);
    } else {
        //no uploaded image
        $image_name = $database->getReference($ref_table)->getValue()['image'];

        //if there was an image in DB
        if ($image_name > 0) {
            $no_isbn_name = substr($image_name, 10);
            $new_image_name = $isbn . $no_isbn_name;

            rename('../images/book_images/' . $image_name, '../images/book_images/' . $new_image_name);

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
} else {
    $_SESSION['book_key'] = false;
    $_SESSION['book_updated_flag'] = false;
    $_SESSION['book_updated'] = "Something went wrong, please validate your inputs!";
}

header('location: ../pages/edit_book.php');
