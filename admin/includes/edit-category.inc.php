<?php
require_once 'db.inc.php';
if(isset($_POST['edit_submit'])) {
    $edit_name = mysqli_real_escape_string($conn, $_POST["edit_name"]);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql_update = "SELECT * FROM product_category WHERE product_category_id = $id;";
        $result = mysqli_query($conn, $sql_update);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $name = $row["name"];
                $directory = strtolower($name);
                $finalDirectory = '../product-images/' .$directory;
        
                $newDirectory = strtolower($edit_name);
                $finalNewDirectory = '../product-images/' .$newDirectory;
                $updatedFinalNewDirectory = rename($finalDirectory, $finalNewDirectory);
            }
        }
        $query = "UPDATE product SET image = REPLACE(image, '$name', '$newDirectory') WHERE image LIKE '%$name%'";
        mysqli_query($conn, $query);

        $sql = "UPDATE product_category SET name = '$edit_name' WHERE product_category_id = $id;";
        
        if(mysqli_query($conn, $sql) === true) {
            header("location: ../category.php");
            die();
        }
    }
}else{
    header('location: ../category.php');
    die();
}
        // UPDATE product SET image = REPLACE(image, 'Mouse', 'newDirectory') WHERE image LIKE '%Mouse%'