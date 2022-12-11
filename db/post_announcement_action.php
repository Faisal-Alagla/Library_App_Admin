<?php
include("config.php");
include("../util/functions.php");

if (isset($_POST['post'])) {
    $announcement = $_POST['announcement'];
    $audience = $_POST['audience'];
    
    //fetching the announcements
    $ref_table = "announcements";
    $fetch_announcements = $database->getReference($ref_table)->getValue();
    
    //if there's an announcements table -> update it
    if ($fetch_announcements > 0) {
        //getting the key of the table entry
        $key = $database->getReference($ref_table)->getChildKeys()[0];

        if (strlen($announcement) < 1) {
            //if empty string

            //check if there was an announcement for the same audience
            $check_announcement = $database->getReference("$ref_table/$key/$audience")->getValue();

            //if there was an announcement for this audiece -> remove it
            if ($check_announcement > 0){
                $delete_query_result =  $database->getReference("$ref_table/$key/$audience")->remove();
    
                $_SESSION['post_announcement_flag'] = true;
                $_SESSION['post_announcement'] = "Announcement for \"$audience\" is removed!";
            //else -> display field must be filled message
            } else {
                $_SESSION['post_announcement_flag'] = false;
                $_SESSION['post_announcement'] = "Announcement field must be filled!";
            }
        }else{
            //else: update the table with the new announcement [audience => announcement]
            $updateData = [
                $audience => $announcement,
            ];
            
            $update_query_result =  $database->getReference("$ref_table/$key")->update($updateData);
            
            $_SESSION['post_announcement_flag'] = true;
            $_SESSION['post_announcement'] = "Announcement for \"$audience\" is updated!";
        }
    //if there's no announcements at all -> post new announcement (create the table)
    } else {
        if (strlen($announcement) < 1) {
            //if empty string -> do nothing and show msg to fill the post
            $_SESSION['post_announcement_flag'] = false;
            $_SESSION['post_announcement'] = "Announcement field must be filled!";
        }else{
            //create the table with only the chosen audience as key, and annuncement as value
            $postData = [
                $audience => $announcement,
            ];
            
            $database->getReference($ref_table)->push($postData);
            
            $_SESSION['post_announcement_flag'] = true;
            $_SESSION['post_announcement'] = "Announcement for \"$audience\" is posted!";
        }
    }
//delete the post for chosen audience
} else if (isset($_POST['delete'])) {
    $audience = $_POST['audience'];
    $ref_table = "announcements";
    //fetching the key
    try {
        $key = $database->getReference($ref_table)->getChildKeys()[0];
        $delete_query_result =  $database->getReference("$ref_table/$key/$audience")->remove();
    
        if ($delete_query_result) {
            $_SESSION['post_announcement_flag'] = true;
            $_SESSION['post_announcement'] = "The Announcement for \"$audience\" removed!";
        } else {
            $_SESSION['post_announcement_flag'] = false;
            $_SESSION['post_announcement'] = "couldn't remove the announcement, please try again later";
        }
    } catch (Exception $exception) {
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