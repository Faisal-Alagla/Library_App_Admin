<?php
include('config.php');

if(isset($_GET['borrower']) && isset($_GET['book'])) {
    $borrower_key = $_GET['borrower'];
    $book_isbn = $_GET['book'];

    $fetch_borrower = $database->getReference("students/$borrower_key/borrowedBooks/$book_isbn")->getValue();
    if($fetch_borrower > 0){
        $database->getReference("students/$borrower_key/borrowedBooks/$book_isbn")->remove();

        //feedback messages
        $_SESSION['book_return_msg'] = "Book is returned successfully";
        $_SESSION['book_return_flag'] = true;
    }else{
        //couldn't fetch the book isbn from the borrowed books of this user
        $_SESSION['book_return_msg'] = "Couldn't return the book, try again later!";
        $_SESSION['book_return_flag'] = false;
    }
    header("location: ../pages/view_borrower.php?borrower=$borrower_key");
}else{
    //error with the GET values
    $_SESSION['book_return_msg'] = "Something went wrong, try again later!";
    $_SESSION['book_return_flag'] = false;
    header('location: ../pages/borrowers.php');
}


?>