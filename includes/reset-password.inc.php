<?php

if(isset($_POST['reset-password-submit'])) {
    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    $selector = mysqli_real_escape_string($conn, $_POST['selector']);
    $validator = mysqli_real_escape_string($conn, $_POST['validator']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $passwordRepeat = mysqli_real_escape_string($conn, $_POST['password-repeat']);

    if(passwordEmpty($password) !== false) {
        header('location: ../reset-password.php?error=passworderror');
        die();
    } else {
        if(passwordInvalid($password)  !== false) {
            header('location: ../reset-password.php?error=passworderror');
            die();
        }
    }

    if(passwordRepeatEmpty($passwordRepeat) !== false) {
        header('location: ../reset-password.php?error=passworderror');
        die();
    } else {
        if(passwordRepeatInvalid($passwordRepeat) !== false) {
            header('location: ../reset-password.php?error=passworderror');
            die();
        } elseif(passwordMatch($password, $passwordRepeat) !== false) {
            header('location: ../reset-password.php?error=passworderror');
            die();
        }
    }

    $currentDate = date('U');

    $sql = "SELECT * FROM password_reset WHERE password_reset_selector = ? AND password_reset_expires >= ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'There was an error.';
        die();
    } else {
        mysqli_stmt_bind_param($stmt, 'ss', $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if(!$row = mysqli_fetch_assoc($result)) {
            echo 'You need to re-submit your reset password request.';
            die();
        } else {

            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['password_reset_token']);

            if($tokenCheck === false) {
                echo 'You need to re-submit your reset password request.';
                die();
            }elseif($tokenCheck === true) {

                $tokenEmail = $row['password_reset_email'];

                $sql = "SELECT * FROM users WHERE email = ?;";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'There was an error.';
                    die();
                } else {
                    mysqli_stmt_bind_param($stmt, 's', $tokenEmail);
                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);

                    if(!$row = mysqli_fetch_assoc($result)) {
                        echo 'There was an error.';
                        die();
                    } else {
                        $sql = "UPDATE users SET password = ? WHERE email = ?;";
                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt, $sql)) {
                            echo 'There was an error.';
                            die();
                        } else {
                            $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, 'ss', $newPasswordHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROm password_reset WHERE password_reset_email = ?;";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                echo 'There was an error.';
                                die();
                            } else {
                                mysqli_stmt_bind_param($stmt, 's', $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                header("location: ../login.php?password=updated");
                                die();
                            }
                        }
                    }
                }
            } 
        }
    }
} else {
    header('location: ../index.php');
}