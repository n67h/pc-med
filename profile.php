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
    </style>
    <nav>
    <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
    <br>
    <a href="order-transactions.php"><i class="fa fa-cart-plus" aria-hidden="true"></i>Order Transactions</a>
    <br>
    <a href="change-password.php"><i class="fa fa-lock" aria-hidden="true"></i>Change Password</a>
    <br>
    <a href="includes/logout.inc.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
</nav>
    <br><br>

<div class="container">
<div class="form">


    <?php
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
            $sql = "SELECT * FROM users WHERE user_id = $id;";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $user_id = $row['user_id'];
                    $email = $row['email'];
                    $f_name = $row['f_name'];
                    $l_name = $row['l_name'];
                    $phone_no = $row['phone_no'];
                    $address = $row['address'];
                    $profile_img = $row['profile_img'];

                    if($profile_img == 1) {
                            $fileName = 'profile-pictures/profile' .$user_id. '.*';
                            $fileInfo = glob($fileName);
                            $fileExt = explode(".", $fileInfo[0]);
                            $fileActualExt = $fileExt[1];
                            echo '<img src="profile-pictures/profile' .$user_id. '.' .$fileActualExt. '?' .mt_rand(). '" alt="" class="profile_img">';
                            echo '<br><br>';
                            echo '<form action="includes/delete-profile.inc.php" method="POST">
                            <button type="submit" name="submit-delete" class="del-btn">Delete Profile Image</button>
                            </form>';
                    }else {
                        echo '<img src="profile-pictures/profile-picture-default.png" alt="" class="profile_img">';
                        echo '<br><br>';
                    }



                        echo'<br><br>';
                        ?>
                       <form method="post" action="">
                            <input type="text" name="email" style="width: 100%;" disabled value="<?php echo $email;?>"><br><br>
                            <input type="text" name="firstname" style="width: 100%;" disabled value="<?php echo $f_name;?>"><br><br>
                            <input type="text" name="lastname" style="width: 100%;" disabled value="<?php echo $l_name;?>"><br><br>
                            <input type="number" name="phone" style="width: 100%;" value="<?php echo $phone_no; ?>"><br><br>
                            <input type="text" name="address" style="width: 100%;" value="<?php echo $address; ?>"><br><br>
                            <button type="submit" name="edit-submit" style="width: 100%;">Edit</button>
                        </form>
                        <br>
                        <?php
                    }
            }else {
                echo 'There are no users yet.';
            }
        }else{
            header('location: index.php');
            die();
        }
        ?>

    </div>
</div>

<?php
    if(isset($_POST['edit-submit'])){
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);

        if(!empty($phone) && !empty($address)){
            $sql = "UPDATE users SET phone_no = '$phone', address = '$address' WHERE user_id = $id;";
            if(mysqli_query($conn, $sql)){
                header('location: profile.php?updatedsuccessfully');
                die();
            }
        }
    }
?>
        <style type="text/css">
        body{
             /*background-image:url(images/bg-img.jpg);*/
             background-size: cover;
             background-position: center;

        }

            button{
                border: none;
                padding: 12px;
                border-radius:5px;
                background: #0081CF;
                color: #fff;
                cursor: pointer;
                margin-top:10px;
            }
            button:hover{
                background: #2C73D2;
            }
            .info{
                font-size: 17px;
                white-space: inherit;
                word-wrap: break-word;
            }
     
            .profile_img{
                border-radius: 50%;
                width: 50%;
                height: 60%;
                cursor: pointer;
                position: relative;

            }
            .container{
                display: flex;
                justify-content: center;
                align-content: center;
                align-items: center;
            }
        .form{
        width: 90%;
        max-width: 440px;
        color: #444;
        text-align: center;
        padding: 50px 35px;
        border: 1px solid rgba(255, 255, 255,0.3);
        background: rgba(255, 255, 255,0.2);

        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        animation: move 4s infinite;

}   
@keyframes move{
    20%{ box-shadow: 0 4px 20px rgba(70, 80, 90, 0.4);}
    50%{ box-shadow: 0 4px 40px rgba(255, 80, 255, 0.4);}
    100%{ box-shadow: 0 4px 100px rgba(80, 255, 70, 0.4);}
}
    .choose-image{
        text-align: center;
    }
    .custome-file{
        border:2px solid #ccc;
        border-radius:16px;
        padding: 2px;

    }
    .custome-file::-webkit-file-upload-button{
        background:#444;
        color:#fff;
        padding:12px;
        border:none;
        border-radius:16px;
        cursor: url("images/cursor1.png"),auto;
    }

            @media(max-width: 780px){
                .profile_img{
                    width: 50%;
                    height: 40%;
                }
            }
            @media(max-width:700px){
                nav a{
                    font-size:17px;
                }
                button{
                    padding:4px;
                }
            }
        </style>


        <form action="includes/upload-profile.inc.php" method="post" enctype="multipart/form-data" class="choose-image">
            <input type="file" name="file" class="custome-file">
            <button type="submit" name="submit-upload">Upload</button>  
        </form>
        <br><br>

    
</body>
</html>