<?php
session_start();
include("config.php");

if (isset($_POST['submit'])) {
    $ref_table = "announcements";
    $fetch_announcement = $database->getReference($ref_table)->getValue();

    if ($fetch_announcement > 0) {
        //update
        $announcement = $_POST['announcement'];

        $updateData = [
            'announcement' => $announcement,
        ];

        $key = $database->getReference($ref_table)->getChildKeys()[0];
        $ref_table = "announcements/" . $key;
        $update_query_result =  $database->getReference($ref_table)->update($updateData);

        $_SESSION['post_announcement_flag'] = true;
        $_SESSION['post_announcement'] = 'Announcement updated!';
    } else {
        //post
        $announcement = $_POST['announcement'];

        $postData = [
            'announcement' => $announcement,
        ];

        $postRef_result = $database->getReference($ref_table)->push($postData);
        
        $_SESSION['post_announcement_flag'] = true;
        $_SESSION['post_announcement'] = 'Announcement posted!';
    }
}else{
    $_SESSION['post_announcement_flag'] = false;
    $_SESSION['post_announcement'] = 'Something went wrong';
}

header('location: ../pages/post_announcement.php')
?>