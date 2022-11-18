<?php
session_start();
include("config.php");

if (isset($_POST['submit'])) {
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $image = $_POST['image'];
    $author = $_POST['author'];
    $date = $_POST['date'];
    $summary = $_POST['summary'];

    $postData = [
        'isbn' => $isbn,
        'title' => $title,
        'image' => $image,
        'author' => $author,
        'date' => $date,
        'summary' => $summary,
    ];

    /*
    Upload image to book_images folder here!!!
    code goes here...
    
    */

    $ref_table = "books";
    $postRef_result = $database->getReference($ref_table)->push($postData);    

    $_SESSION['book_added_flag'] = true;
    $_SESSION['book_added'] = "Book added successfully!";

} else {
    $_SESSION['book_added_flag'] = false;
    $_SESSION['book_added'] = "Something went wrong, please validate your inputs!";
}

header('location: ../pages/add_book.php')
?>