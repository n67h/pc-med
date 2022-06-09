<?php
    function firstnameEmpty($firstname) {
        $result;

        if(empty($firstname)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function firstnameInvalid($firstname) {
        $result;
        $firstnameLength = strlen($firstname);

        if((!preg_match("/^[a-zA-Z ,.'-]+$/i", $firstname)) || ($firstnameLength < 2)) {
            $result = true;  
        } else {
            $result = false;
        }
        return $result;
    }

    function lastnameEmpty($lastname) {
        $result;

        if(empty($lastname)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function lastnameInvalid($lastname) {
        $result;
        $lastnameLength = strlen($lastname);

        if((!preg_match("/^[a-zA-Z ,.'-]+$/i", $lastname)) || ($lastnameLength < 2)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }


    function isRealDate($date) { 
        if(false === strtotime($date)) { 
            return false;
        } 
        list($day, $month, $year) = explode('-', $date); 
        return checkdate($day, $month, $year);
    }


    function birthdateEmpty($birthdate) {
        $result;

        if(empty($birthdate)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function birthdateInvalid($birthdate) {
        $result;

        if(isRealDate($birthdate)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function genderEmpty($gender) {
        $result;

        if($gender == 'none') {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function addressEmpty($address) {
        $result;

        if(empty($address)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function addressInvalid($address) {
        $result;
        $addressLength = strlen($address);

        if ($addressLength < 10) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function emailEmpty($email) {
        $result;

        if(empty($email)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function emailInvalid($email) {
        $result;

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function phoneEmpty($phone) {
        $result;

        if(empty($phone)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function phoneInvalid($phone) {
        $result;

        if (!preg_match("/((\+[0-9]{2})|0)[.\- ]?9[0-9]{2}[.\- ]?[0-9]{3}[.\- ]?[0-9]{4}/", $phone)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function passwordEmpty($password) {
        $result;

        if(empty($password)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function passwordInvalid($password) {
        $result;
        $passwordLength = strlen($password);

        if($passwordLength < 8) {
            $result = true;
        } elseif($passwordLength > 16) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function passwordRepeatEmpty($password_repeat) {
        $result;

        if(empty($password_repeat)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function passwordRepeatInvalid($password_repeat) {
        $result;
        $password_repeatLength = strlen($password_repeat);

        if($password_repeatLength < 8) {
            $result = true;
        } elseif($password_repeatLength > 16) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function passwordMatch($password, $password_repeat) {
        $result;

        if($password !== $password_repeat) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function emailExists($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../register.php?error");
            die();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        } else {
            $result = false;
            return $result;
        }

        mysqli_stmt_close($stmt);
    }

    function createUser($conn, $email, $firstname, $lastname, $phone, $address, $password, $vkey) {

        $sql = "INSERT INTO users (email, f_name, l_name, phone_no, address, password, verification_key) VALUES (?, ?, ?, ?, ?, ?, ?);";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../register.php?error");
            die();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sssssss", $email, $firstname, $lastname, $phone, $address, $hashedPassword, $vkey);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        //header("location: login.php?accountsuccessfullycreated");
        //die();
    }

    function emptyInputLogin($email, $password) {
        $result;

        if(empty($email) || empty($password)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function loginUser($conn, $email, $password) {
        $emailExists = emailExists($conn, $email);

        if($emailExists === false) {
            header("location: login.php?error=invalidemail");
            die();
        }
         
        $passwordHashed = $emailExists["password"];

        $checkPassword = password_verify($password, $passwordHashed);

        if($checkPassword === false) {
            header("location: login.php?error=invalidpassword");
            die();
        } elseif($checkPassword === true) {
            
            $query = "SELECT * FROM users WHERE user_id = '" .$emailExists['user_id']. "' AND email = '" .$emailExists['email']. "' AND is_verified = 1;";
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);
            if($count === 1) {    
                session_start();
                $_SESSION['id'] = $emailExists['user_id'];
                $_SESSION['email'] = $emailExists['email'];
                $_SESSION['user_role_id'] = $emailExists['user_role_id'];

                $query = "UPDATE users SET last_login = NOW() WHERE user_id = '" .$emailExists['user_id']. "' AND email = '" .$emailExists['email']. "';";
                $result = mysqli_query($conn, $query);

                header("location: index.php");
                die();
            } else {
                header("location: login.php?error=emailnotverifiedyet");
                die();
            }
            
        }
    }