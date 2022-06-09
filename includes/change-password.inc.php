<?php
    session_start();
    require_once 'db.inc.php';

    if(isset($_POST['change-submit'])){

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $password = mysqli_real_escape_string($conn, $_POST['new-password']);
            $repeat_password = mysqli_real_escape_string($conn, $_POST['repeat-new-password']);
    
            if(empty($password) || empty($repeat_password)){
                header("location: ../change-password.php?error=emptyfields");
                die();
            }
    
            if(strlen($password) < 8 || strlen($password) > 16) {
                header("location: ../change-password.php?error=passwordlessthan8");
                die();
            }
    
            if(strlen($repeat_password) < 8 || strlen($repeat_password) > 16) {
                header("location: ../change-password.php?error=passwordlessthan8");
                die();
            }
    
            if($password !== $repeat_password){
                header("location: ../change-password.php?error=passwordoesnotmatch");
                die();
            }elseif($password == $repeat_password){
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $sql = "UPDATE users SET password = '$hashedPassword' WHERE user_id = $id;";
                if(mysqli_query($conn, $sql)){
                    header('location: ../profile.php?passwordchanged');
                    die();
                }
            }
        }else{
            
        }

    }else{
        header("location: ../change-password.php");
        die();
    }