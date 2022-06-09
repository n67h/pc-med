<?php
require_once 'db.inc.php';
if(isset($_POST['edit_submit'])) {
    $edit_service = mysqli_real_escape_string($conn, $_POST["edit_service"]);
    $edit_price = mysqli_real_escape_string($conn, $_POST["edit_price"]);
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "UPDATE service SET service = '$edit_service', price = $edit_price WHERE service_id = $id;";
        
        if(mysqli_query($conn, $sql) === true) {
            header("location: ../service-offered.php");
            die();
        } 


    }
}else{
    header('location: ../service-offered.php');
    die();
}