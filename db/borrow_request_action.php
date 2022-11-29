<?php
include("config.php");

//accept request case
if (isset($_GET['accept'])){
    $key = $_GET['accept'];
  
    //fetching the borrow request
    $ref_table = "borrow_requests/$key";
    $borrow_request = $database->getReference($ref_table)->getValue();

    if($borrow_request > 0) {
        //the key of the user for this borrow request
        $user_key = $borrow_request["userKey"];
        $book_isbn = $borrow_request['isbn'];
        
        //change from pending to due date in students table (borrowedBooks)
        $today = date("Y-m-d");
        $borrowdays = 7;
        $due_date = date( "Y-m-d", strtotime("$today +$borrowdays day"));

        $update_request_date = [
            "borrowedBooks/$book_isbn" => $due_date
        ];

        $ref_student_update = "students/$user_key";
        $student_update_query =  $database->getReference($ref_student_update)->update($update_request_date);
        
        //remove from book_requests table
        $request_delete_query = $database->getReference($ref_table)->remove();

        //incerement timesBorrowed for this book in books table
        $books_table = 'books';
        $fetch_books = $database->getReference($books_table)->getValue();

        foreach ($fetch_books as $book_key => $row) {
            //when book is found (matching isbn) -> increment timesBorrowed by 1 and break the loop
            if ($row['isbn'] == $book_isbn) {
                $updateCategory = [
                    'timesBorrowed' => $row['timesBorrowed'] + 1,
                ];

                $book = "$books_table/$book_key";
                $update_query_result =  $database->getReference($book)->update($updateCategory);
                unset($fetch_books);
                break;
            }
        }
        
        //session variables for feedback messages
        $_SESSION['borrow_request_flag'] = true;
        $_SESSION['borrow_reuqest_accepted'] = "Borrow request accepted, the due-date for this request is $due_date";
    }else{
        $_SESSION['borrow_request_flag'] = false;
        $_SESSION['borrow_reuqest_accepted'] = "Something went wrong, the request couldn't be accepted!";
    }
//decline request case
}else if (isset($_GET['decline'])) {
    $key = $_GET['decline'];
  
    //fetching the borrow request
    $ref_table = "borrow_requests/$key";
    $borrow_request = $database->getReference($ref_table)->getValue();

    if ($borrow_request > 0) {
        //remove the request from the user's table (pending request in borrowedBooks)
        $user_key = $borrow_request["userKey"];
        $book_isbn = $borrow_request['isbn'];

        $ref_student_update = "students/$user_key/borrowedBooks/$book_isbn";
        $request_delete_query = $database->getReference($ref_student_update)->remove();

        //removing the request
        $request_delete_query = $database->getReference($ref_table)->remove();

        //session variables for feedback messages
        $_SESSION['borrow_request_flag'] = true;
        $_SESSION['borrow_reuqest_accepted'] = "Borrow request declined successfully";
    }else{
        $_SESSION['borrow_request_flag'] = false;
        $_SESSION['borrow_reuqest_accepted'] = "Something went wrong, the request couldn't be declined!";
    }
//error with GET
} else{
    $_SESSION['borrow_request_flag'] = false;
    $_SESSION['borrow_reuqest_accepted'] = "Something went wrong, try again later!";
}

header('location: ../pages/borrow_requests.php');