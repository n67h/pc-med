<?php
require_once 'db.inc.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql1 = "UPDATE users SET is_deleted = 0 WHERE user_id = $id;";

    $sql_service = "SELECT * FROM service_reservation WHERE user_id = $id;";
    $result_service = mysqli_query($conn, $sql_service);
    if(mysqli_num_rows($result_service) > 0){
        $sql5 = "UPDATE service_reservation SET is_deleted = 0 WHERE user_id = $id;";
        mysqli_query($conn, $sql5);
    }

    $sql_feedback = "SELECT * FROM feedback WHERE user_id = $id;";
    $result_feedback = mysqli_query($conn, $sql_feedback);
    if(mysqli_num_rows($result_feedback) > 0){
        $sql6 = "UPDATE feedback SET is_deleted = 0 WHERE user_id = $id;";
        mysqli_query($conn, $sql6);
    }

    $sql_order_details = "SELECT * FROM order_details WHERE user_id = $id;";
    $result_order_details = mysqli_query($conn, $sql_order_details);
    if(mysqli_num_rows($result_order_details) > 0){
        $sql2 = "UPDATE order_details SET is_deleted = 0 WHERE user_id = $id;";
        if(mysqli_query($conn, $sql2)){
            $sql_order = "SELECT order_details_id FROM order_details ORDER BY last_updated DESC LIMIT 1;";
            $result = mysqli_query($conn, $sql_order);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    $order_details_id = $row['order_details_id'];
                }
            }
            $sql_orders = "SELECT * FROM orders WHERE order_details_id = $order_details_id;";
            $result_orders = mysqli_query($conn, $sql_orders);
            if(mysqli_num_rows($result_orders) > 0){
                $sql3 = "UPDATE orders SET is_deleted = 0 WHERE order_details_id = $order_details_id;";
                mysqli_query($conn, $sql3);
            }
            $sql_payment = "SELECT * FROM payment_details WHERE order_details_id = $order_details_id;";
            $result_payment = mysqli_query($conn, $sql_payment);
            if(mysqli_num_rows($result_payment) > 0){
                $sql4 = "UPDATE payment_details SET is_deleted = 0 WHERE order_details_id = $order_details_id;";
                mysqli_query($conn, $sql4);
            }
        }
    }

    if(mysqli_query($conn, $sql1)){
        header("location: ../users.php");
        die();
    }
}