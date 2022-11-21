<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location: ../pages/login.php');
}
include("config.php");

if (isset($_GET['id']) && $_GET['id'] != '') {
    $key = $_GET['id'];
    $ref_table = "books/" . $key;
    
    $image_name = $database->getReference($ref_table)->getValue()['image'];
    if($image_name > 0) {
        unlink('../images/book_images/'.$image_name);
    }

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
