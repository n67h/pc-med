<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/jpg" href="images/logo.png">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="stylesheet" type="text/css" href="css/landingpage.css">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;1,700&family=Oswald:wght@200;300&family=Roboto:wght@100;300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<script src="https://kit.fontawesome.com/3ef9dc3e62.js" crossorigin="anonymous"></script>
	<title>Login</title>


	<style type="text/css">
		*{
			font-family: 'Roboto',sans-serif;
		}
		
		body{
			 /* background-image:linear-gradient(rgba(4, 9, 30,0.4),rgba(4, 9, 30, 0.4)), url(images/bg-img.jpg); */
			 background-size: cover;
			 background-position: center;
			 height: 100vh;

		}

		.form{
			display: flex;
			justify-content: center;
			align-content: center;
			align-items: center;
			margin-top:8em;
		}
		form{
		 		width: 90%;
        max-width: 300px;
        color: #999;
        text-align: center;
        padding: 40px 35px;
        border: 3px solid rgba(255, 255, 255,0.3);
        background: rgba(255, 255, 255,0.3);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        animation: move 5s infinite;
		}
		@keyframes move{
			50%{box-shadow: 0 4px 90px rgba(255, 255, 0, 0.4);}
			100%{box-shadow: 0 4px 60px rgba(0, 80, 255, 0.4);}
		}
		input{
			margin-top: 12px;
			outline: none;
			border: none;
			font-size: 20px;
			border-bottom: 1px solid #555;
			background: transparent;
		}
		.forgot ,
		.create-acc {
		text-decoration: none;
		color: #999;
		font-size:20px;
		}

		 button{
            border: none;
            outline: none;
            background: #0081CF;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 40px;
            padding-left: 40px;
            text-align: center;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
            font-size: 15px;
            margin-bottom: 12px;
        }
        button:hover{
            background: #2C73D2;
        }
        button:active{
            opacity: 0.3;
        }
        img{
        	width: 40%;
        	height: 55%;
        }
	</style>



</head>

<body>

<section class="header">

    <nav class="head">
         <!-- <a href="index.php" class="title"><img src="images/logo.png"> </a> -->
        <div class="nav_links" id="navLinks">

            <i class="fa fa-times" onclick="hideMenu()"></i>
            <ul>
						<li><a href="index.php"><ion-icon name="home-outline"></ion-icon>Home</a></li>
                <li><a href="product.php"><ion-icon name="pricetags-outline"></ion-icon>Products</a></li>
                <li><a href="contact.php"><ion-icon name="call-outline"></ion-icon>Contact</a></li>
                <li><a href="service.php"><ion-icon name="build-outline"></ion-icon>Services</a></li>
                <li><a href="about.php"><ion-icon name="people-outline"></ion-icon>About us</a></li>
                
                                <!-- <li><a href="cart.php">CART</a></li> -->
                          

            </ul>
        </div>
        <i class="fa fa-bars" onclick="showMenu()"></i>
    </nav>
</section>

	<?php

		if(isset($_POST['submit'])) {
			require_once 'includes/db.inc.php';
            require_once 'includes/functions.inc.php';
			
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			
			if(emptyInputLogin($email, $password) !== false) {
				header("location: login.php?error=emptyinput");
				die();		
			}
			loginUser($conn, $email, $password);
		}
	?>


	<div class="form">

			<form action="" method="post">
				<img src="images/logo.png">
				<h1 class="title1">
					Log in form					
				</h1>
				<br>

			<?php
				if(isset($_GET["error"])) {
					if($_GET["error"] == "emptyinput") {
						echo "<p>Fill in all the fields</p>";
					}
					if($_GET["error"] == "invalidemail") {
						echo "<p>Invalid Email</p>";
					}
					if($_GET["error"] == "invalidpassword") {
						echo "<p>Invalid Password</p>";
					}
					if($_GET["error"] == "emailnotverifiedyet") {
						echo '<p>This account has not yet been verified.</p>';
						echo '<p>We sent an email to your email.</p>';
						echo '<a href="resend-email.php">Resend email verification</a>';
					}
				}

				if(isset($_GET['password'])) {
					if($_GET['password'] == 'updated') {
						echo '<p style="color: green;">Password Successfully updated</p>';
					}
				}
			?>
			
				<div class="input-fields">
					<i id="icons" class="fa-solid fa-user"></i>
					<input id="email" type="text" class="input" name="email" placeholder="Username" required>
				</div>
				<div class="input-fields">
					<i  id="icons" class="fa-solid fa-lock" id="icon">
					</i>
					<input id="password" type="password" class="input" name="password" placeholder="Password"  required>
				</div>
				<br>
				<a class="forgot" href="reset-password.php" target="_blank">Forgot password?</a>
					<br><br>
					<button type="submit" name="submit" class="submit" value="submit">Log in</button>
					<br>
					<a class="create-acc" href="register.php">Create an account</a>
			</form>
			<br>
						
</div>
<br>
<br>
<br>
<?php
include 'footer.php';
?>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>