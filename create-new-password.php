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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@300&family=Nunito:ital,wght@0,200;0,300;0,400;0,600;1,700&family=Oswald:wght@200&family=Roboto+Mono:wght@200&family=Roboto:wght@100;300&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <title>Reset Password</title>
    <style type="text/css">
        *{
            font-family: 'Roboto',sans-serif;
        }
                body{
             /*background-image:url(images/bg-img.jpg);*/
             background-size: cover;
             background-position: center;
             height: 100vh;
             background-repeat: no-repeat;


        }
        .form{
            display: flex;
            justify-content: center;
            align-items: center;
            align-items: center;
            margin-top: 10em;
        }
        form {
        width: 90%;
        max-width: 440px;
        color: #444;
        text-align: center;
        padding: 100px 35px;
        border: 3px solid rgba(255, 255, 255,0.3);
        background: rgba(255, 255, 255,0.2);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        animation: move 5s infinite;
        }
                @keyframes move{
            10%{box-shadow: 0 4px 60px rgba(80, 90, 255, 0.4);}
            50%{box-shadow: 0 4px 30px rgba(255, 255, 0, 0.4);}
            100%{box-shadow: 0 4px 60px rgba(0, 80, 255, 0.4);}
        }
        input{
            font-size: 20px;
            outline: none;
            border: none;
            border-bottom: 2px solid #D65DB1;
            background: transparent;
        }
        .fa{
            font-size: 20px;
        }
        button{
            border: none;
            outline: none;
            background: #0081CF;
            padding: 12px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover{
            background: #2C73D2;
        }
        button:active{
            opacity: 0.3;
            outline: none;
        }
        .title{
            text-align: center;
            font-style: oblique;
            color: #999;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="title">
        <h1>
            Create New Password
        </h1>
    </div>
    <section class="form">
    <?php
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];

        if(empty($selector) || empty($validator)) {
            echo 'Could not validate your request.';
        }else {
            if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
    ?>
                <form action="includes/reset-password.inc.php" method="post">
                    <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                    <input type="hidden" name="validator" value="<?php echo $validator; ?>">

                    <i class="fa fa-lock" aria-hidden="true"><input type="password" name="password" placeholder="New Password" required></i><br><br>
                    <i class="fa fa-lock" aria-hidden="true"><input type="password" name="password-repeat" placeholder="Re-Type New Password" required></i><br><br>
                    <button type="submit" name="reset-password-submit">Reset password</button>
                </form>
    <?php     
            }
        }
    ?>
</section>
    
</body>
</html>