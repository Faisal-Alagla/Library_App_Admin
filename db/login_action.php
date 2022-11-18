<?php
session_start();
include("config.php");

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $clearTextPassword = $_POST['password'];

    try {
        $user = $auth->getUserByEmail("$email");

        try {
            $signInResult = $auth->signInWithEmailAndPassword($email, $clearTextPassword);
            $idTokenString = $signInResult->idToken();

            try {
                $verifiedIdToken = $auth->verifyIdToken($idTokenString);
                $uid = $verifiedIdToken->claims()->get('sub');

                $_SESSION['verified_user_id'] = $uid;
                $_SESSION['idTokenString'] = $idTokenString;

                // echo get_object_vars($user)['userProperties'];
                // $ref_table = "users";
                // $fetch_user = $database->getReference($ref_table)->getValue();
                // $username = $fetch_user[$uid]['fname'];

                $_SESSION['coming_from'] = 'login';
                $_SESSION['user'] = $user->displayName;
                header('location: fetch_announcement.php');
                exit();
            } catch (FailedToVerifyToken $e) {
                echo 'The token is invalid: ' . $e->getMessage();
            }

        } catch (Exception $e) {
            $_SESSION['invalid_login'] = "Invalid login";
            header('location: ../pages/login.php');
            exit();
        }

    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        $_SESSION['invalid_login'] = "Invalid login";
        header('location: ../pages/login.php');
        exit();
    }
}
?>