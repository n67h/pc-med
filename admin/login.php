<?php
    session_start();
    require_once 'includes/db.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- latest jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- latest bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- font awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="css/dashboardstyle.css">
    <!-- bootstrap js -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script><script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
    if(isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);

        if(empty($email) && empty($password)) {
            header('location: login.php?error=emptyfields');
            die();
        }


        // function to check if email already exists
        function emailExists($conn, $email) {
            $sql = "SELECT * FROM users WHERE email = ?;";
            $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                // header("location: ../register.php?error");
                // die();
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
        // end of function

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

                header("location: dashboard.php");
                die();
            } else {
                header("location: login.php?error=emailnotverifiedyet");
                die();
            }
        }
    }
    ?>

    <br><br>
    <div class="container">
        <!-- <p>ADMIN DASHBOARD</p> -->
        <form action="" method="post">

            <label for="email">Email/Username</label><br>
            <input type="text" name="email" placeholder="" id="email"><br><br>

            <label for="password">Password</label><br>
            <input type="password" name="password" placeholder="" id="password"><br><br>

            <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>