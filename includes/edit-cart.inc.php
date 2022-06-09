<?php
require_once 'db.inc.php';
if(isset($_POST['edit_submit'])) {
    $edit_qty = mysqli_real_escape_string($conn, $_POST['edit_qty']);
    

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "UPDATE cart SET quantity  = $edit_qty WHERE cart_id = $id;";
        
        if(mysqli_query($conn, $sql) === true) {
            header("location: ../cart.php");
            die();
        } 
    }
}else{
    header('location: ../cart.php');
    die();
}