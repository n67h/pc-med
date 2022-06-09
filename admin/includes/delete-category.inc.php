<?php
    session_start();
    require_once 'db.inc.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];


        $sql_delete = "SELECT * FROM product_category WHERE product_category_id = $id;";
            $result = mysqli_query($conn, $sql_delete);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $name = $row['name'];
                    $directory = strtolower($name);

                    $finalDirectory = '../product-images/' .$directory;
                    array_map('unlink', glob("$finalDirectory/*.*"));
                    rmdir($finalDirectory);
                }
            }

        $sql = "DELETE FROM product_category WHERE product_category_id = $id";
        if(mysqli_query($conn, $sql) === true) {
    
            
            header("location: ../category.php?deletedsuccessfully");
            die();
        } 
    }