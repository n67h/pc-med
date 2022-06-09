<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resend Email Verification</title>

    <style type="text/css">
        body{
             background-image:linear-gradient(rgba(4, 9, 30,0.7),rgba(4, 9, 30, 0.7)),url(./images/bg.jpg);
         }
         form{
      text-align: center;
      margin-bottom: 30em;
         }
         input{
            padding: 5px 30px;
            border-radius: 20px;
            outline: none;
            border: 1px solid #444;
            font-size: 20px;
         }
         h4{
            color: #fff;
         }
         button{
            padding: 10px 20px;
            font-size: 15px;
            cursor: pointer;
            border-radius: 20px;
            border: 1px solid #333;
            background: #fff;
            transition: 0.4s;
         }
         button:hover{
            background: black;
            color: #fff;
         }
         button:active{
            opacity: 0.4;
         }
    </style>
</head>


<body>
    
    <form action="" method="post">
        <h4>Didn't receive a verification key?</h4>
        <input type="email" name="email" class="email" id="email"><br><br>
        <button type="submit" name="submit" class="submit" id="submit">Resend</button>
    </form>

    <?php
        if(isset($_POST['email'])) {
            require_once 'includes/db.inc.php';
            $email = mysqli_real_escape_string($conn, $_POST['email']);

            $sql = "SELECT * FROM users WHERE email = '$email';";

            if($result = $conn->query($sql)) {
                while ($row = $result->fetch_assoc()) {
                    $vkey = $row['verification_key'];
                    echo $vkey;

                    //Load Composer's autoloader
            require 'vendor/autoload.php';

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'ketano.ecommerce@gmail.com';                     //SMTP username
                $mail->Password   = 'testketanotest';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('ketano.ecommerce@gmail.com', 'KetAno Admin');
                $mail->addAddress($email, '.');     //Add a recipient
                /*
                $mail->addAddress('ellen@example.com');               //Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');
                */
            
                //Attachments
                /*
                $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                */
            
            
                $body = "<h3>Welcome to PC-Med</h3><br>
                <p>Hello, thank you for creating account on PC-Med. You're all set up! To get you started, please click the button below to verify your account.</p><br>
                <button><a href='http://localhost/pc-med/verify.php?verificationkey=" .$vkey. "'>Verify Account</a></button>";
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Account Verification';
                $mail->Body    = $body;
                $mail->AltBody = strip_tags($body);
            
                $mail->send();
                echo 'Message has been sent';
                header('location: register-success.php');
                die();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
                }
            }

            
        }
    ?>

    <?php

    include 'footer.php';
    ?>
</body>
</html>