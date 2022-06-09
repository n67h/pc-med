<?php
    session_start();
    require_once 'db.inc.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "UPDATE feedback SET is_deleted = 1 WHERE feedback_id = $id";
        if(mysqli_query($conn, $sql) === true) {
            header("location: ../feedback.php");
            die();
        } 
    }