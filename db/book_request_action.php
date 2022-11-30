<?php
include("config.php");
include("../util/functions.php");

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
        $image = $_POST['image'];
        $date = $_POST['date'];
        $summary = $_POST['summary'];

        if (strlen($image) > 0) {
            // rename('../images/requests_images/' . $image, '../images/book_images/' . $image);
            
            //moving the image from requests_images to images
            //removing the initial isbn then adding the POSTed isbn just incase it was changed
            $no_isbn_name = substr($image, 10);
            $image_name = $isbn . $no_isbn_name;

            $object = $bucket->object("requests_images/$image");
            $object->copy($bucket, ['name' => "images/$image_name"]);
            $object->delete();
        }else{
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
        $requests_table = "book_requests/$key";
        $database->getReference($requests_table)->remove();

        $_SESSION['book_accepted_flag'] = true;
        $_SESSION['book_accepted'] = "Book added successfully!";
    }
}
//decline request
else if (isset($_POST['decline_request'])) {
    $key = $_POST['key'];
    $image = $_POST['image'];
    
    if (strlen($image) > 0) {
        // unlink('../images/requests_images/' . $image);
        $bucket->object("requests_images/$image")->delete();
    }
    
    $requests_table = "book_requests/$key";
    $database->getReference($requests_table)->remove();

    // if (isset($_SESSION['book_key'])) {
    //     unset($_SESSION['book_key']);
    // }
    $_SESSION['book_declined_flag'] = true;
    $_SESSION['book_declined'] = "Request declined successfully!";
} else {
    $_SESSION['book_accepted_flag'] = false;
    $_SESSION['book_accepted'] = "Something went wrong, please validate your inputs!";
}


if (!isset($send_to_view)) {
    header('location: ../pages/book_requests.php');
} else {
    unset($send_to_view);
    header('location: ../pages/view_request.php');
}
