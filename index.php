<?php 
    include("db/config.php");

    if (!isset($_SESSION['user'])){
        header("location: pages/login.php");
    }else {
        header("location: pages/home.php");
    }
?>