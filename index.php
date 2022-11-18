<?php
    session_start();
    if (!isset($_SESSION['success_login'])){
        header("location: pages/login.php");
    }else {
        header("location: pages/home.php");
    }
?>