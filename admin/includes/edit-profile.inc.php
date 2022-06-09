<?php
    require_once 'db.inc.php';

    if(isset($_POST['edit_submit'])){
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
            $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
            $address = mysqli_real_escape_string($conn, $_POST['address']);
    
            if(!empty($email) && !empty($firstname) && !empty($lastname) && !empty($phone_no) && !empty($address)){
                $sql = "UPDATE users SET email = '$email', f_name = '$firstname', l_name = '$lastname', phone_no = '$phone_no', address = '$address' WHERE user_id = $id;";
                if(mysqli_query($conn, $sql)){
                    header('location: ../profile.php?updatedsuccessfully');
                    die();
                }
            }
        }else{
            header('location: ../profile.php');
            die();
        }
    }