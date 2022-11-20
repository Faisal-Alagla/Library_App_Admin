<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../pages/login.php');
}
include("config.php");

//update
if (isset($_POST['update_category'])) {
    $category_key = $_POST['key'];
    $label = $_POST['label'];
    $value = $_POST['value'];

    $updateData = [
        'label' => $label,
        'value' => $value,
    ];

    $ref_table = 'categories/' . $category_key;
    $update_query_result =  $database->getReference($ref_table)->update($updateData);

    if ($update_query_result) {
        $_SESSION['cateogry_updated_flag'] = true;
        $_SESSION['cateogry_updated'] = "Category updated successfully!";
    } else {
        $_SESSION['cateogry_updated_flag'] = false;
        $_SESSION['cateogry_updated'] = "Something went wrong, please try again later!";
    }
    //add
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
//delete
else if (isset($_GET['delete_id'])) {
    $key = $_GET['delete_id'];
    $ref_table = "categories/" . $key;

    $delete_query_result =  $database->getReference($ref_table)->remove();

    if ($delete_query_result) {
        $_SESSION['cateogry_deleted_flag'] = true;
        $_SESSION['cateogry_deleted'] = "Category deleted successfully!";
    } else {
        $_SESSION['cateogry_deleted_flag'] = false;
        $_SESSION['cateogry_deleted'] = "Couldn't delete the Category, please try again later!";
    }
} else {
    //error
    $_SESSION['cateogry_updated_flag'] = false;
    $_SESSION['cateogry_updated'] = "Something went wrong, please validate your inputs!";
}

header('location: ../pages/manage_categories.php');
