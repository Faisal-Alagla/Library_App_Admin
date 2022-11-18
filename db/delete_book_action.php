<?php
session_start();
include("config.php");

if (isset($_GET['id'])) {
    $key = $_GET['id'];

    $ref_table = "books/" . $key;
    $delete_query_result =  $database->getReference($ref_table)->remove();

    if ($delete_query_result) {
        $_SESSION['book_deleted_flag'] = true;
        $_SESSION['book_deleted'] = "Book deleted successfully!";
    } else {
        $_SESSION['book_deleted_flag'] = false;
        $_SESSION['book_deleted'] = "Couldn't delete the book, please try again later!";
    }
} else {
    $_SESSION['book_deleted_flag'] = false;
    $_SESSION['book_deleted'] = "Couldn't delete the book, please try again later!";
}

header('location: ../pages/book_list.php');
