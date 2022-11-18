<?php
session_start();
include("config.php");

if (isset($_POST['update_book'])) {
    $key = $_POST['key'];
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $image = $_POST['image'];
    $author = $_POST['author'];
    $date = $_POST['date'];
    $summary = $_POST['summary'];

    //current bug: if no image is used for updating, it deletes the previous one
    //implement image uploads before fixing this

    $updateData = [
        'isbn' => $isbn,
        'title' => $title,
        'image' => $image,
        'author' => $author,
        'date' => $date,
        'summary' => $summary,
    ];

    $ref_table = "books/" . $key;
    $update_query_result =  $database->getReference($ref_table)->update($updateData);

    $_SESSION['book_key'] = $key;
    if ($update_query_result) {
        $_SESSION['book_updated_flag'] = true;
        $_SESSION['book_updated'] = "Book added successfully!";
    } else {
        $_SESSION['book_updated_flag'] = false;
        $_SESSION['book_updated'] = "Something went wrong, please validate your inputs!";
    }
} else {
    $_SESSION['book_key'] = $key;
    $_SESSION['book_updated_flag'] = false;
    $_SESSION['book_updated'] = "Something went wrong, please validate your inputs!";
}

header('location: ../pages/edit_book.php');
