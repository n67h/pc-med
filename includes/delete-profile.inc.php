<?php
session_start();
require_once 'db.inc.php';
$id = $_SESSION['id'];

$fileName = '../profile-pictures/profile' .$id. '*';
$fileInfo = glob($fileName);
$fileExt = explode(".", $fileInfo[0]);
$fileActualExt = $fileExt[1];

$file = '../profile-pictures/profile' .$id. '.' .$fileActualExt;

if(!unlink($file)) {
    echo 'File was not deleted.';
}else {
    echo 'File was deleted.';
}

$sql = "UPDATE users SET profile_img = 0 WHERE user_id = $id;";
mysqli_query($conn, $sql);

header('location: ../profile.php');
die();