<?php
    session_start();
    require_once 'db.inc.php';
    $id = $_SESSION['id'];

    if(isset($_POST['submit-upload'])) {
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if(in_array($fileActualExt, $allowed)) {
            if($fileError === 0) {
                if($fileSize < 5000000) {
                    $fileNameNew = "profile" .$id. "." .$fileActualExt;
                    $fileDestination = '../profile-pictures/' .$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $sql = "UPDATE users SET profile_img = 1 WHERE user_id = $id;";
                    $result = mysqli_query($conn, $sql);
                    header('location: ../profile.php?uploadsuccess');
                    die();
                }else {
                    echo 'Your file is too big.';
                }
            }else {
                echo 'There was an error uploading your file.';
            }
        }else {
            echo 'You cannot upload files of this type.';
        }
    }else{
        header('location: ../index.php');
        die();
    }