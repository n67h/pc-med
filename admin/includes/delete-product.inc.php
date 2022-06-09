<?php
    session_start();
    require_once 'db.inc.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "DELETE FROM product WHERE product_id = $id";
        if(mysqli_query($conn, $sql) === true) {
            header("location: ../product.php");
            die();
        } 
    }