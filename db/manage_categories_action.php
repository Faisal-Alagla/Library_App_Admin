<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../pages/login.php');
}
include("config.php");

if (isset($_POST['update_category'])) {
    //update
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
} else if (isset($_GET['id'])) {
    $key = $_GET['id'];
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
