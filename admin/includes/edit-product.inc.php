<?php
require_once 'db.inc.php';
if(isset($_POST['edit_submit'])) {
    $edit_name = mysqli_real_escape_string($conn, $_POST['edit_name']);
    $edit_specs = mysqli_real_escape_string($conn, $_POST['edit_specs']);
    $edit_price = mysqli_real_escape_string($conn, $_POST['edit_price']);
    $edit_quantity = mysqli_real_escape_string($conn, $_POST['edit_quantity']);
    $edit_warranty = mysqli_real_escape_string($conn, $_POST['edit_warranty']);

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        if(!empty($edit_name) && !empty($edit_specs) && !empty($edit_price) && !empty($edit_quantity) && !empty($edit_warranty)){

            $file = $_FILES['edit_image'];
            $fileName = $_FILES['edit_image']['name'];
            $fileTmpName = $_FILES['edit_image']['tmp_name'];
            $fileSize = $_FILES['edit_image']['size'];
            $fileError = $_FILES['edit_image']['error'];
            $fileType = $_FILES['edit_image']['type'];
    
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
    
            $allowed = array('jpg', 'jpeg', 'png');
            
            // product-images/.$product_category.

            if(in_array($fileActualExt, $allowed)) {
                if($fileError === 0) {
                    if($fileSize < 5000000) {
                        
                        $sql = "SELECT * FROM product WHERE product_id = $id;";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $product_category_id = $row['product_category_id'];
                            }
                        }

                        $sql_category = "SELECT * FROM product_category WHERE product_category_id = $product_category_id;";
                        $result_category = mysqli_query($conn, $sql_category);
                        if(mysqli_num_rows($result_category) > 0){
                            while($row_category = mysqli_fetch_assoc($result_category)){
                                $category_id = $row_category['product_category_id'];
                                $category_name = $row_category['name'];

                                $six_digit_random_number = random_int(100000, 999999);

                                $fileNameNew = $six_digit_random_number. "." .$fileActualExt;
                                $filePath = "product-images/" .$category_name. "/" .$fileNameNew;
                                $fileDestination = "../product-images/" .$category_name. "/" .$fileNameNew;
                                move_uploaded_file($fileTmpName, $fileDestination);

                                $sql_update = "UPDATE product SET name = '$edit_name', image = '$filePath', specification = '$edit_specs', price = $edit_price, quantity = $edit_quantity, warranty = '$edit_warranty' WHERE product_id = $id;";

                                if(mysqli_query($conn, $sql_update) === true) {
                                    header("location: ../product.php");
                                    die();
                                }
                            }
                        }

                    }else {
                        echo 'Your file is too big.';
                    }
                }else {
                    echo 'There was an error uploading your file.';
                }
            }else {
                echo 'You cannot upload files of this type.';
            }

        }
    }


}else{
    header('location: ../product.php');
    die();
}