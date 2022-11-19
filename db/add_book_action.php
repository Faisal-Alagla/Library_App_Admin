<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location: ../pages/login.php');
}
include("config.php");

if (isset($_POST['submit'])) {
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];
    $author = $_POST['author'];
    $date = $_POST['date'];
    $summary = $_POST['summary'];

    if($image != Null) {
        $image_name = $isbn.$image;
        
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/book_images/'.$image_name);
    }else{
        $image_name = Null;
    }
    
    $postData = [
        'isbn' => $isbn,
        'title' => $title,
        'image' => $image_name,
        'author' => $author,
        'date' => $date,
        'summary' => $summary,
    ];

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