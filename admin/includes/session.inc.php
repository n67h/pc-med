<?php
    session_start();
    require_once 'includes/db.inc.php';
    if(isset($_SESSION['id'])){
        $idSession = $_SESSION['id'];
        $emailSession = $_SESSION['email'];
        $roleSession = $_SESSION['user_role_id'];

        if(($roleSession !== 2) && ($roleSession !== 3)) {
            header('location: login.php?error=invalidlogin');
            die();
        }elseif($roleSession === 2) {
        }elseif($roleSession === 3) {
        }
    } else {
        header('location: login.php');
        die();
    }