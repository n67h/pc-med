<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require_once 'db.inc.php';
    if(isset($_GET['od_id']) && isset($_GET['user_id']) && isset($_GET['email'])){
        $order_details_id = $_GET['od_id'];
        $user_id = $_GET['user_id'];
        $email = $_GET['email'];

        $query = "DELETE FROM cart WHERE user_id = $user_id;";
        mysqli_query($conn, $query);

        $update = "UPDATE order_details SET payment = 0, is_deleted = 0 WHERE order_details_id = $order_details_id;";
        mysqli_query($conn, $update);

        if(mysqli_query($conn, $query) && mysqli_query($conn, $update)){
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


                $body = "<p>Hi there,</p>
                <p>Thank you for shopping with us!</p>
                <p>We appreciate your order. This email confirms that we received your order. Thank you.</p>

                <p>Let us know if we can do anything to make your experience better!</p>
                <p>If you have any questions or concerns, kindly respond to this email</p>
                <p>Your growth partner,</p>
                <p>PC-Med</p>";
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Thank you for shopping with us!';
                $mail->Body    = $body;
                $mail->AltBody = strip_tags($body);
            
                $mail->send();
                header('location: ../order-success.php');
                die();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }




        }else{
            echo 'for the love of god, please work';
            echo $orderdetailsID;
        }
    }