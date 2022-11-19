<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../pages/login.php');
}
include("config.php");

if (isset($_POST['post'])) {
    $ref_table = "announcements";
    $fetch_announcement = $database->getReference($ref_table)->getValue();

    if ($fetch_announcement > 0) {
        //update
        $announcement = $_POST['announcement'];

        if (strlen($announcement) < 1) {
            $key = $database->getReference($ref_table)->getChildKeys()[0];
            $delete_query_result =  $database->getReference($ref_table)->remove();

            $_SESSION['post_announcement_flag'] = true;
            $_SESSION['post_announcement'] = "Announcement removed!";

            header('location: ../pages/post_announcement.php');
        }

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

        if (strlen($announcement) < 1) {
            $key = $database->getReference($ref_table)->getChildKeys()[0];
            $delete_query_result =  $database->getReference($ref_table)->remove();

            $_SESSION['post_announcement_flag'] = true;
            $_SESSION['post_announcement'] = "Announcement removed!";

            header('location: ../pages/post_announcement.php');
        }

        $postData = [
            'announcement' => $announcement,
        ];

        $postRef_result = $database->getReference($ref_table)->push($postData);

        $_SESSION['post_announcement_flag'] = true;
        $_SESSION['post_announcement'] = 'Announcement posted!';
    }
    //delete
} else if (isset($_POST['delete'])) {
    $ref_table = "announcements";
    $key = $database->getReference($ref_table)->getChildKeys()[0];
    $delete_query_result =  $database->getReference($ref_table)->remove();

    if ($delete_query_result) {
        $_SESSION['post_announcement_flag'] = true;
        $_SESSION['post_announcement'] = "Announcement removed!";
    } else {
        $_SESSION['post_announcement_flag'] = false;
        $_SESSION['post_announcement'] = "couldn't remove the announcement, please try again later";
    }
} else {
    $_SESSION['post_announcement_flag'] = false;
    $_SESSION['post_announcement'] = 'Something went wrong';
}

header('location: ../pages/post_announcement.php');
?>