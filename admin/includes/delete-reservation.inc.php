<?php
    session_start();
    require_once 'db.inc.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "UPDATE service_reservation SET is_deleted = 1 WHERE sr_id = $id";
        if(mysqli_query($conn, $sql) === true) {
            header("location: ../service.php");
            die();
        } 
    }