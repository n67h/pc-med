<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/jpg" href="images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;1,700&family=Oswald:wght@200;300&family=Roboto:wght@100;300&display=swap" rel="stylesheet">
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
			 background-repeat: no-repeat;
height: 100vh;


		}
    	form{

    		display: flex;
    		justify-content: center;
    		align-content: center;
    		text-align: center;
    	}
    	.login-form{
    	width: 90%;
        max-width: 440px;
        margin-top: 5%;
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
    	.login-form .disc{

    	}
    	input{
    		font-size: 20px;
    		border: none;
    		outline: none;
    		 border-bottom: 2px solid #555;
    		 color: #555;
    		 padding-right: 0;
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
    		opacity: 0.4;
    	}
    	.title{
    		text-align: center;
    		font-style: oblique;
    		color: #555;
    	}
    </style>
</head>
<body>
	<h1 class="title">
			Reset Password
		</h1>
	<form action="includes/reset-request.inc.php" method="post">
				<div class="login-form">
				<p class="disc">An email will be send to your gmail account<br> with instructions on how to reset your password.</p>
				<br>				
					<i class="fa fa-envelope" aria-hidden="true">&nbsp;<input type="text" name="email" class="input" placeholder="Enter your email address" required></i><br><br>
					<button type="submit" name="reset-request-submit">Submit</button>
		

				<?php
					if(isset($_GET['error'])) {
						if($_GET['error'] == 'emptyfield') {
							echo '<p style="color:green; font-size:30px;">This field is required</p>';
						}elseif($_GET['error'] == 'invalidemail') {
							echo '<p style="color:green; font-size:30px;">Invalid email</p>';
						}elseif($_GET['error'] == 'passworderror') {
							echo '<p style="color:Red; font-size:18px;">*There was an error in your new password. Please repeat the process.</p>';
						}
					}

					if(isset($_GET['reset'])) {
						if($_GET['reset'] == 'success') {
							echo '<p style="color:#008F7A; margin-top:12px; font-size:18px; text-decoration:underline; text-transform:uppercase;"><a href="gmail.com"></a>Please Check Your Email.</a></p>';
						}
					}

					/*if(isset($_GET['password'])) {
						if($_GET['password'] == 'updated') {
							echo '<p style="color: #85D512">Password successfully updated.</p>';
						}
					}*/
				?>
		</div>
	</form>


</body>
</html>