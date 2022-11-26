<?php
include("config.php");

//update display name
if(isset($_POST['update_dName'])){
    $uid = $_POST['id'];
    $display_name = $_POST['dName'];

    $properties = [
        'displayName' => $display_name,
    ];

    $auth->updateUser($uid, $properties);
    $_SESSION['profile_update'] = "Display name has been updated";

    header('location: ../pages/profile.php');
}
//update password
else if(isset($_POST['update_pwd'])) {
    $password = $_POST['password'];
    $re_password = $_POST['re-password'];
    
    if(($password == $re_password) && (8 <= strlen($password))) {
        $uid = $_POST['id'];

        $updatedUser = $auth->changeUserPassword($uid, $password);

        if($updatedUser) {
            $_SESSION['profile_update'] = "Password updated!";
        }else{
            $_SESSION['profile_error'] = "Couldn't update password!";
        }
        
        header('location: ../pages/profile.php');
    }else{
        //passwords don't match or less than 8
        $_SESSION['profile_error'] = "Password and Re-password must match!";
        header('location: ../pages/profile.php?changepwd=changepwd');
    }
}
//error
else{
    $_SESSION['profile_error'] = "Something went wrong!";
    header('location: ../pages/profile.php');
}

?>