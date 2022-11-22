<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../pages/login.php');
}
include("config.php");

if (isset($_POST['submit'])) {
    $isbn = $_POST['isbn'];

        //check if this book already exists in the database
    $book_exists = book_exists($isbn, $database);
    if ($book_exists) {
        $_SESSION['book_added_flag'] = false;
        $_SESSION['book_added'] = "This book already exists in the database!";
    
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

        $ref_table = "books";
        $database->getReference($ref_table)->push($postData);

        $_SESSION['book_added_flag'] = true;
        $_SESSION['book_added'] = "Book added successfully!";
    }
} else {
    $_SESSION['book_added_flag'] = false;
    $_SESSION['book_added'] = "Something went wrong, please validate your inputs!";
}

/*
book_exists(): function to check if a book already exists in the database
parameters:   $isbn: the isbn of the book to check for
              $db: to pass $database for querying
returns true if the passed book already exists, false otherwise
*/
function book_exists($isbn, $db)
{
    $categories_table = 'books';
    $fetch_categories = $db->getReference($categories_table)->getValue();

    foreach ($fetch_categories as $category_key => $row) {
        if ($row['isbn'] == $isbn) {
            return true;
        }
    }
    return false;
}

header('location: ../pages/add_book.php');
?>