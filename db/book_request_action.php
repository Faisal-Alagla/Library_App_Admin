<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../pages/login.php');
}
include("config.php");
include("functions.php");

//accept request
if (isset($_POST['accept_request'])) {
    $isbn = $_POST['isbn'];
    $key = $_POST['key'];

    //check if this book already exists in the database
    $book_exists = item_exists($isbn, $database, 'books', 'isbn');
    if ($book_exists) {
        $_SESSION['book_accepted_flag'] = false;
        $_SESSION['book_accepted'] = "This book already exists in the database!";

        $_SESSION['book_key'] = $key;
        $send_to_view = true;
        //doesn't exist -> add it
    } else {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $image = $_FILES['image']['name'];
        $date = $_POST['date'];
        $summary = $_POST['summary'];

        if ($image != Null) {
            $image_name = $isbn . $image;

            move_uploaded_file($_FILES['image']['tmp_name'], '../images/book_images/' . $image_name);
        } else {
            $image_name = "";
        }

        $postData = [
            'isbn' => $isbn,
            'title' => $title,
            'author' => $author,
            'category' => $category,
            'image' => $image_name,
            'date' => $date,
            'summary' => $summary,
        ];

        $books_table = "books";
        $database->getReference($books_table)->push($postData);

        //remove from requests
        $requests_table = "book_requests/" . $key;
        
        $image_name = $database->getReference($requests_table)->getValue()['image'];
        if ($image_name > 0) {
            unlink('../images/book_images/' . $image_name);
        }
        $delete_query_result =  $database->getReference($requests_table)->remove();

        $_SESSION['book_accepted_flag'] = true;
        $_SESSION['book_accepted'] = "Book added successfully!";
    }
}
//decline request
else if (isset($_POST['decline_request'])) {
    $key = $_POST['key'];
    $requests_table = "book_requests/" . $key;

    $image_name = $database->getReference($requests_table)->getValue()['image'];
    if ($image_name > 0) {
        unlink('../images/book_images/' . $image_name);
    }

    $delete_query_result =  $database->getReference($requests_table)->remove();


    if ($_SESSION['book_key']) {
        unset($_SESSION['book_key']);
    }
    $_SESSION['book_declined_flag'] = true;
    $_SESSION['book_declined'] = "Request declined successfully!";
} else {
    $_SESSION['book_accepted_flag'] = false;
    $_SESSION['book_accepted'] = "Something went wrong, please validate your inputs!";
}

if (!isset($send_to_view)) {
    header('location: ../pages/book_requests.php');
} else {
    header('location: ../pages/view_request.php');
}