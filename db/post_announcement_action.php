<?php
session_start();
include("config.php");

if (isset($_POST['submit'])) {
    $ref_table = "announcements";
    $fetch_announcement = $database->getReference($ref_table)->getValue();

    if ($fetch_announcement > 0) {
        //update

        $_SESSION['post_announcement'] = 'Announcement updated!';
    } else {
        $announcement = $_POST['announcement'];

        $postData = [
            'announcement' => $announcement,
        ];

        $ref_table = "announcements";
        $postRef_result = $database->getReference($ref_table)->push($postData);

        $_SESSION['post_announcement'] = 'Announcement added!';
    }
}else{
    $_SESSION['post_announcement'] = 'Something went wrong';
}

header('location: ../pages/Post_Announcement.php')
?>