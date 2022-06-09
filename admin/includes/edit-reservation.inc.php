<?php
session_start();
require_once 'db.inc.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['edit_submit'])) {

    if(isset($_GET['sr_id']) && isset($_GET['email'])){
        $sr_id = $_GET['sr_id'];
        $email = $_GET['email'];

        $status = mysqli_real_escape_string($conn, $_POST['status']);

        if($status == 'Confirmed'){
            $sql1 = "UPDATE service_reservation SET status = '$status' WHERE sr_id = $sr_id;";
            if(mysqli_query($conn, $sql1)){
            //Load Composer's autoloader
            require '../../vendor/autoload.php';

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
                <p>Thank you for choosing our service!</p>
                <p>We received and confirmed the reservation that you submitted. Please expect us to arrive to your specified address on the date and time given. Thank you.</p>
                <p>Let us know if we can do anything to make your experience better!</p>
                <p>Your growth partner,</p>
                <p>PC-Med</p>";
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Thank you for choosing our service!';
                $mail->Body    = $body;
                $mail->AltBody = strip_tags($body);
            
                $mail->send();
                header('location: ../service.php');
                // echo "<script>location.href = 'service.php';</script>";
                // header('location: ../order-success.php');
                die();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            }
        }

        if($status == 'Done'){
            $sql2 = "UPDATE service_reservation SET status = '$status' WHERE sr_id = $sr_id;";
            if(mysqli_query($conn, $sql2)){
            //Load Composer's autoloader
            require '../../vendor/autoload.php';

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
                <p>Thank you for choosing our service!</p>
                <p>We appreciate you for availing our service, we hope to see you again. Thank you.</p>
                <p>Let us know if we can do anything to make your experience better!</p>
                <p>Your growth partner,</p>
                <p>PC-Med</p>";
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Thank you for choosing our service!';
                $mail->Body    = $body;
                $mail->AltBody = strip_tags($body);
            
                $mail->send();
                header('location: ../service.php');
                // header('location: ../order-success.php');
                die();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            }
        }

        if($status == 'Cancelled'){
            $sql3 = "UPDATE service_reservation SET status = '$status' WHERE sr_id = $sr_id;";
            if(mysqli_query($conn, $sql3)){
            //Load Composer's autoloader
            require '../../vendor/autoload.php';

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
                <p>Thank you for choosing our service!</p>
                <p>We appreciate you for availing our service, unfortunately, we would like to inform you that we cancelled your reservation.</p>
                <p>Let us know if we can do anything to make your experience better!</p>
                <p>Your growth partner,</p>
                <p>PC-Med</p>";
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Reservation Cancelled';
                $mail->Body    = $body;
                $mail->AltBody = strip_tags($body);
            
                $mail->send();
                header('location: ../service.php');
                // header('location: ../order-success.php');
                die();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            
            }
        }


    }
}