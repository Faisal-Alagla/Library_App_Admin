<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../pages/login.php');
}
include("config.php");

if(isset($_POST['update_dName'])){
    $uid = $_POST['id'];
    $display_name = $_POST['dName'];

    $properties = [
        'displayName' => $display_name,
    ];

    $auth->updateUser($uid, $properties);
    $_SESSION['dName_updated'] = "Display name has been updated";
}else{
    $_SESSION['profile_error'] = "Something went wrong!";
}

header('location: ../pages/profile.php');
?>