<?php
require_once 'db.inc.php';
$name_error = " *";
$name_val = "";
$name_success = "";

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    if(empty($name)){
        $name_error = ' This field is required';
    }else{
        $name_error = '';
        $name_val = $name;
        $name_success = ' <i class="fa fa-check-circle" aria-hidden="true" style="color: green;"></i>';
    }


    if(!empty($name)) {
        $sql = "INSERT INTO product_category (name) VALUES('$name');";

        if(mysqli_query($conn, $sql)){  
            $nameDirectory = strtolower($name);
            mkdir('../product-images/' .$nameDirectory, 0777, true);
            header('location: ../category.php');
            // Warning: Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\pc-med\admin\sidebar.php:1) in C:\xampp\htdocs\pc-med\admin\category.php on line 96
        };
    }
}