<?php
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

                header('location: ../pages/home.php');
                exit();
            } catch (Exception $e) {
                echo 'The token is invalid: ' . $e->getMessage();
                $_SESSION['invalid_login'] = "Invalid login";
                header('location: ../pages/login.php');
                exit();
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
            $_SESSION['invalid_login'] = "Invalid login";
            header('location: ../pages/login.php');
            exit();
        }
        
    } catch (Exception $e) {
        echo $e->getMessage();
        $_SESSION['invalid_login'] = "Invalid login";
        header('location: ../pages/login.php');
        exit();
    }
}
?>