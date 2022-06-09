<?php
    session_start();
    if(isset($_SESSION['id'])){
        $idSession = $_SESSION['id'];
        $emailSession = $_SESSION['email'];
        $roleSession = $_SESSION['user_role_id'];

        if($roleSession !== 1) {
            header('location: login.php?error=invalidlogin');
            die();
        }
    } else {

    }
    require_once 'includes/db.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <title>Profile</title>
</head>
<body>
    <style type="text/css">
        nav{
            display: flex;
            gap: 1em;
            justify-content: center;
        }
        nav a{
            text-decoration: none;
            font-size: 20px;
            color: #555;
        }
        nav a:hover{
            text-decoration: underline;
        }

        .form-control {
            width: 50%;
            margin: auto;
        }
        .btn {
            width: 50%;
        }
    </style>
    <nav>
    <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
    <br>
    <a href="profile.php"><i class="fa fa-lock" aria-hidden="true"></i>Profile</a>
    <br>
    <a href="order-transactions.php"><i class="fa fa-cart-plus" aria-hidden="true"></i>Order Transactions</a>
    <br>
    <a href="includes/logout.inc.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
</nav>
    <br><br>

    <?php
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];

            if(isset($_POST['submit'])){
                $password = mysqli_real_escape_string($conn, $_POST['password']);

                $sql = "SELECT * FROM users WHERE user_id = $id;";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result)){
                    while($row = mysqli_fetch_assoc($result)){
                        $passwordHashed = $row['password'];
                    }
                }

                if(empty($password)){
                    header("location: change-password.php?error=emptypassword");
                    die();
                }
                $checkPassword = password_verify($password, $passwordHashed);

                if($checkPassword === false) {
                    header("location: change-password.php?error=invalidpassword");
                    die();
                } elseif($checkPassword === true) {
                    ?>
                        <div class="container">
                            <div class="form" style="text-align: center;">
                                <h1>Enter your new password</h1><br><br><br>

                                <form action="includes/change-password.inc.php?id=<?php echo $id;?>" method="post">
                                    <input class="form-control" name="new-password" type="password" placeholder="Enter your new password" aria-label="default input example"><br>

                                    <input class="form-control" name="repeat-new-password" type="password" placeholder="Repeat your new password" aria-label="default input example"><br>

                                    <button type="submit" name="change-submit" class="btn btn-primary">Change Password</button>
                                </form>

                            </div>
                        </div>

                    <?php
                }
            }else{
                header("location: change-password.php");
                die();
            }
    ?>
            



    <?php
        }else{
            header('location: index.php');
            die();
        }
    ?>


    <!-- bootstrap script links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>