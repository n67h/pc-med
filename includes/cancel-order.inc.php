<?php
    session_start();
    require_once 'db.inc.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "UPDATE order_details SET order_status = 'Cancelled' WHERE order_details_id = $id";
        if(mysqli_query($conn, $sql) === true) {
            header("location: ../order-transactions.php");
            die();
        } 
    }