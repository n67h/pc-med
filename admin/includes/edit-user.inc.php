<?php
require_once 'db.inc.php';
if(isset($_POST['edit_submit'])) {
    $edit_email = mysqli_real_escape_string($conn, $_POST['edit_email']);
    $edit_firstname = mysqli_real_escape_string($conn, $_POST['edit_first_name']);
    $edit_lastname = mysqli_real_escape_string($conn, $_POST['edit_last_name']);
    $edit_phone = mysqli_real_escape_string($conn, $_POST['edit_phone']);
    $edit_address = mysqli_real_escape_string($conn, $_POST['edit_address']);
    $edit_role = mysqli_real_escape_string($conn, $_POST['edit_role']);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "UPDATE users SET email = '$edit_email', f_name = '$edit_firstname', l_name = '$edit_lastname', phone_no = '$edit_phone', address = '$edit_address', user_role_id = $edit_role WHERE user_id = $id;";
        
        if(mysqli_query($conn, $sql) === true) {
            header("location: ../users.php");
            die();
        } 
    }
}else{
    header('location: ../users.php');
    die();
}