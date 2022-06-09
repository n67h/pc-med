<?php
    session_start();
    require_once 'db.inc.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql1 = "UPDATE order_details SET is_deleted = 1 WHERE order_details_id = $id;";

        $sql_select1 = "SELECT * FROM orders WHERE order_details_id = $id;";
        $result1 = mysqli_query($conn, $sql_select1);
        if(mysqli_num_rows($result1) > 0){
            $sql2 = "UPDATE orders SET is_deleted = 1 WHERE order_details_id = $id;";
            mysqli_query($conn, $sql2);
        }

        $sql_select2 = "SELECT * FROM payment_details WHERE order_details_id = $id;";
        $result2 = mysqli_query($conn, $sql_select2);
        if(mysqli_num_rows($result2) > 0){
            $sql3 = "UPDATE payment_details SET is_deleted = 1 WHERE order_details_id = $id;";
            mysqli_query($conn, $sql3);
        }
        
        if(mysqli_query($conn, $sql1)) {
            header("location: ../orders.php");
            die();
        } 
    }