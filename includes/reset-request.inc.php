<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

    if(isset($_POST['reset-request-submit'])) {
        require_once 'db.inc.php';
        require_once 'functions.inc.php';

        $email = mysqli_real_escape_string($conn, $_POST['email']);

        if(emailEmpty($email) !== false) {
            //$email_error = " This field is required";
            header('location: ../reset-password.php?error=emptyfield');
            die();
        } else {
            if(emailInvalid($email) !== false) {
                //$email_error = " Invalid email";
                header('location: ../reset-password.php?error=invalidemail');
                die();
            } elseif(emailExists($conn, $email) !== false) {
                
                $selector = bin2hex(random_bytes(8));
                $token = random_bytes(32);
        
                $url = 'http://localhost/pc-med/create-new-password.php?selector=' . $selector . '&validator=' . bin2hex($token);
        
                $expires = date('U') + 1800;

                $sql = "DELETE FROM password_reset WHERE password_reset_email = ?;";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'There was an error.';
                    die();
                } else {
                    mysqli_stmt_bind_param($stmt, 's', $email);
                    mysqli_stmt_execute($stmt);
                }

                $sql = "INSERT INTO password_reset (password_reset_email, password_reset_selector, password_reset_token, password_reset_expires) VALUES (?, ?, ?, ?);";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'There was an error.';
                    die();
                } else {
                    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                    
                    mysqli_stmt_bind_param($stmt, 'ssss', $email, $selector, $hashedToken, $expires);
                    mysqli_stmt_execute($stmt);
                }

                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                

                //Load Composer's autoloader
                require '../vendor/autoload.php';

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


                    $body = '<p>We received a password reset request. The link to reset your password is below.<br> </p><br><p><a href="' . $url . '">' . $url . '</a></p>';
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Reset password request';
                    $mail->Body    = $body;
                    $mail->AltBody = strip_tags($body);

                    $mail->send();
                    header('location: ../reset-password.php?reset=success');
                    die();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }//end of email exists elseif
        }//end of email empty else    

    } else {
        header('location: ../index.php');
    }