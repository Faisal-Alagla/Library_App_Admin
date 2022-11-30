<?php
include("config.php");

if (isset($_POST['post'])) {
    $announcement = $_POST['announcement'];
    $audience = $_POST['audience'];
    
    $ref_table = "announcements";
    $fetch_announcements = $database->getReference($ref_table)->getValue();
    
    //update
    if ($fetch_announcements > 0) {
        $key = array_keys($fetch_announcements)[0];

        //if empty -> remove the post
        if (strlen($announcement) < 1) {
            $delete_query_result =  $database->getReference("$ref_table/$key/$audience")->remove();

            $_SESSION['post_announcement_flag'] = true;
            $_SESSION['post_announcement'] = "Announcement for \"$audience\" is removed!";
        }else{
            $updateData = [
                $audience => $announcement,
            ];
            
            $update_query_result =  $database->getReference("$ref_table/$key")->update($updateData);
            
            $_SESSION['post_announcement_flag'] = true;
            $_SESSION['post_announcement'] = "Announcement for \"$audience\" is updated!";
        }
    //post new announcement
    } else {
        //if empty -> do nothing and show msg to fill the post
        if (strlen($announcement) < 1) {
            $_SESSION['post_announcement_flag'] = true;
            $_SESSION['post_announcement'] = "Announcement field must be filled!";
        }else{
            $postData = [
                $audience => $announcement,
            ];
            
            $database->getReference($ref_table)->push($postData);
            
            $_SESSION['post_announcement_flag'] = true;
            $_SESSION['post_announcement'] = "Announcement for \"$audience\" is posted!";
        }
    }
    //delete
} else if (isset($_POST['delete'])) {
    $audience = $_POST['audience'];
    $ref_table = "announcements";
    $key = $database->getReference($ref_table)->getChildKeys()[0];
    $delete_query_result =  $database->getReference("$ref_table/$key/$audience")->remove();

    if ($delete_query_result) {
        $_SESSION['post_announcement_flag'] = true;
        $_SESSION['post_announcement'] = "The Announcement for \"$audience\" removed!";
    } else {
        $_SESSION['post_announcement_flag'] = false;
        $_SESSION['post_announcement'] = "couldn't remove the announcement, please try again later";
    }
} else {
    $audience = "everyone";
    $_SESSION['post_announcement_flag'] = false;
    $_SESSION['post_announcement'] = 'Something went wrong, try again later!';
}

header("location: ../pages/post_announcement.php?announcement=$audience");
?>