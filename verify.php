<?php
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
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification</title>
</head>
<body>
    <?php
        if(isset($_GET['verificationkey'])){
            require_once 'includes/db.inc.php';
            $vkey = mysqli_real_escape_string($conn, $_GET['verificationkey']);

            $sql = "SELECT email, verification_key, is_verified FROM users WHERE is_verified = 0 AND verification_key = '$vkey' LIMIT 1;";

            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);

            while($row = mysqli_fetch_assoc($result)){
                $email = $row['email'];
            }

            if($count > 0) {
                
                $sql = "UPDATE users SET is_verified = 1 WHERE verification_key = '$vkey';";

                if(mysqli_query($conn, $sql)) {

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
                    
                        $body = "<p>Hi there,</p>
                        <p>We have successfully verified the e-mail address associated with your PC-Med account.</p>
                        <p>Again, thank you for registering with us. We could not be more excited to be part of your journey.</p>
                        <p>As always, please let us know if you have any questions or concerns.</p>
                        <p>Your growth partner,</p>
                        <p>PC-Med</p>";
                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Your e-mail address has been successfully confirmed.';
                        $mail->Body    = $body;
                        $mail->AltBody = strip_tags($body);
                    
                        $mail->send();
                        echo 'Message has been sent';
                        echo '
                        <div>
                            <p>Your e-mail address has been successfully confirmed. You will automatically be redirected to login page after a few seconds or click <a href="login.php">here</a> to proceed now.</p>
                        </div>';
                        header( "refresh:10;url=login.php" );
                        die();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }else {
                    echo 'Something went wrong.';
                }
            }else{
                echo 'Invalid account or this account is already verified';
            }
        }else{
            die('Something went wrong.');
        }
    ?>
</body>
</html>