<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../pages/login.php');
}
include("config.php");

//update category
if (isset($_POST['update_category'])) {
    $category_key = $_POST['key'];
    $label = $_POST['label'];
    $value = $_POST['value'];

    $updateData = [
        'label' => $label,
        'value' => $value,
    ];

    $ref_table = 'categories/' . $category_key;
    $old_category = $database->getReference($ref_table)->getValue()['value'];
    $update_query_result = $database->getReference($ref_table)->update($updateData);

    if ($update_query_result) {
        //update books that had the old category with the new one
        $books_table = 'books';
        $fetch_books = $database->getReference($books_table)->getValue();
        
        foreach ($fetch_books as $book_key => $row) {
            if ($row['category'] == $old_category) {
                $updateCategory = [
                    'category' => $value,
                ];

                $new_book_table = $books_table . '/' . $book_key;
                $update_query_result =  $database->getReference($new_book_table)->update($updateCategory);
            }
        }

        $_SESSION['cateogry_updated_flag'] = true;
        $_SESSION['cateogry_updated'] = "Category updated successfully!";
    } else {
        $_SESSION['cateogry_updated_flag'] = false;
        $_SESSION['cateogry_updated'] = "Something went wrong, please try again later!";
    }
    //add category
} else if (isset($_POST['add_category'])) {
    $label = $_POST['label'];
    $value = $_POST['value'];

    $postData = [
        'label' => $label,
        'value' => $value,
    ];

    $ref_table = "categories";
    $database->getReference($ref_table)->push($postData);

    $_SESSION['category_added_flag'] = true;
    $_SESSION['category_added'] = "Category added successfully!";
}
//delete category
else if (isset($_GET['delete_id']) && $_GET['delete_id'] != '') {
    $key = $_GET['delete_id'];
    $ref_table = "categories/" . $key;

    $old_category = $database->getReference($ref_table)->getValue()['value'];
    $delete_query_result = $database->getReference($ref_table)->remove();

    if ($delete_query_result) {
        //update books that had the old category with empty category
        $books_table = 'books';
        $fetch_books = $database->getReference($books_table)->getValue();
        
        foreach ($fetch_books as $book_key => $row) {
            if ($row['category'] == $old_category) {
                $updateCategory = [
                    'category' => "",
                ];

                $new_book_table = $books_table . '/' . $book_key;
                $update_query_result =  $database->getReference($new_book_table)->update($updateCategory);
            }
        }

        $_SESSION['cateogry_deleted_flag'] = true;
        $_SESSION['cateogry_deleted'] = "Category deleted successfully!";
    } else {
        $_SESSION['cateogry_deleted_flag'] = false;
        $_SESSION['cateogry_deleted'] = "Couldn't delete the Category, please try again later!";
    }
} else {
    //error
    $_SESSION['cateogry_updated_flag'] = false;
    $_SESSION['cateogry_updated'] = "Something went wrong, please try again later!";
}

header('location: ../pages/manage_categories.php');
