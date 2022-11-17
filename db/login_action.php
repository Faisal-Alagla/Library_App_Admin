<?php
session_start();
include("config.php");

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $postData = [
        'email'=>$email,
        'password'=>$password
    ];

    $ref_table = "users";
    $postRef_result = $database->getReference($ref_table)->push($postData);

}
?>