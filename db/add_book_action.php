<?php
include("config.php");
include("../util/functions.php");

if (isset($_POST['add_book'])) {
    $isbn = $_POST['isbn'];

    //check if this book already exists in the database
    $book_exists = item_exists($isbn, $database, 'books', 'isbn');
    if ($book_exists) {
        $_SESSION['book_added_flag'] = false;
        $_SESSION['book_added'] = "This book already exists in the database!";

    //check if it contains none number values and of length other than 10 or 13
    }else if (!ctype_digit($isbn) || !(strlen($isbn) == 10 || strlen($isbn) == 13)) {
        $_SESSION['book_added_flag'] = false;
        $_SESSION['book_added'] = "ISBN should only contain numbers and of length 10 or 13!";

    //doesn't exist & only numbers of length 10 or 13 -> add it
    } else {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        //removing white space from image name
        $image = preg_replace('/\s+/', '', $_FILES['image']['name']);
        $date = $_POST['date'];
        $summary = $_POST['summary'];
        $times_borrowed = 0;

        //if there's an uploaded image -> mix the isbn with its name and upload it to the FB storage
        if ($image != Null) {
            $image_name = $isbn . $image;

            $file_contents = file_get_contents($_FILES['image']['tmp_name']);
            $bucket->upload($file_contents, ['name' => "images/$image_name"]);
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
            'timesBorrowed' => $times_borrowed,
            'dateRegistered' => date("Y-m-d"),
            'ratings' => ['default' => '-1']
        ];

        $ref_table = "books";
        $database->getReference($ref_table)->push($postData);

        $_SESSION['book_added_flag'] = true;
        $_SESSION['book_added'] = "Book added successfully!";
    }
} else {
    $_SESSION['book_added_flag'] = false;
    $_SESSION['book_added'] = "Something went wrong, please validate your inputs!";
}

header('location: ../pages/add_book.php');
