<?php
include("config.php");

//accept
if (isset($_GET['accept'])){
    $key = $_GET['accept'];
  
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
            if ($row['isbn'] == $book_isbn) {
                $updateCategory = [
                    'timesBorrowed' => $row['timesBorrowed'] + 1,
                ];

                $book = "$books_table/$book_key";
                $update_query_result =  $database->getReference($book)->update($updateCategory);
                break;
            }
        }
        //###set success message to go back here!!!
    }else{
        //###set error msg!!!
    }
//decline
}else if (isset($_GET['decline'])) {

} else{

}

