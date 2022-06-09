<?php
session_start();
require_once 'db.inc.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['edit_submit'])) {

    if(isset($_GET['od_id']) && $_GET['user_id'] && $_GET['method']){
        $od_id = $_GET['od_id'];
        $user_id = $_GET['user_id'];
        $method = $_GET['method'];

        $sql_email = "SELECT * FROM users WHERE user_id = $user_id;";
        $result_email = mysqli_query($conn, $sql_email);
        if(mysqli_num_rows($result_email) > 0){
            while($row_email = mysqli_fetch_assoc($result_email)){
                $email = $row_email['email'];
            }

        }

        $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);

        echo $order_status;
        // $sql_update = "UPDATE order_details";

        if($order_status == 'Processing' && $method == 'Courier Service'){
            $sql_orders = "SELECT * FROM orders WHERE order_details_id = $od_id;";
            $result_orders = mysqli_query($conn, $sql_orders);
            if(mysqli_num_rows($result_orders) > 0){
                while($row_orders = mysqli_fetch_assoc($result_orders)){
                    $product_id = $row_orders['product_id'];
                    $quantity = $row_orders['quantity'];

                    echo $product_id . '<br>';
                    echo $quantity . '<br>';

                    $sql_status = "UPDATE order_details SET order_status = '$order_status' WHERE order_details_id = $od_id;";
                    
                    $sql_quantity = "UPDATE product SET quantity = quantity - $quantity WHERE product_id = $product_id;";
                    
                    $sql_sold = "UPDATE product SET sold = sold + $quantity WHERE product_id = $product_id;";
                    
                    $sql_available = "UPDATE product SET available = available - $quantity WHERE product_id = $product_id;";
                    
                    if(mysqli_query($conn, $sql_status) && mysqli_query($conn, $sql_quantity) &&mysqli_query($conn, $sql_sold) && mysqli_query($conn, $sql_available)){
                        //tapos may email na matatanggap dapat yung customer
                        // echo $od_id . ' ' . $user_id . ' ' . $method;
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
                            <p>Thank you for shopping with us!</p>
                            <p>We appreciate you for ordering, we received and confirmed your order, expect your order to arrive within 5-8 days. Thank you.</p>
                            <p>Let us know if we can do anything to make your experience better!</p>
                            <p>Your growth partner,</p>
                            <p>PC-Med</p>";
                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Thank you for shopping with us!';
                            $mail->Body    = $body;
                            $mail->AltBody = strip_tags($body);
                        
                            $mail->send();
                            header('location: ../orders.php');
                            // header('location: ../order-success.php');
                            die();
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                    // mysqli_query($conn, $sql_status);
                    // mysqli_query($conn, $sql_quantity);
                    // mysqli_query($conn, $sql_sold);
                    // mysqli_query($conn, $sql_available);                  
                    

                }//end of while fetch assoc orders
            }//end of orders if num rows
        }elseif($order_status == 'Processing' && $method == 'Pick up'){
            $sql_status = "UPDATE order_details SET order_status = '$order_status' WHERE order_details_id = $od_id;";
            if(mysqli_query($conn, $sql_status)){
                //tapos may email na matatanggap dapat yung customer
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
                    <p>Thank you for shopping with us!</p>
                    <p>We appreciate you for ordering, we received and confirmed your order, we expect you to pick up your order within 2 weeks. Thank you.</p>
                    <p>Let us know if we can do anything to make your experience better!</p>
                    <p>Your growth partner,</p>
                    <p>PC-Med</p>";
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Thank you for shopping with us!';
                    $mail->Body    = $body;
                    $mail->AltBody = strip_tags($body);
                
                    $mail->send();
                    header('location: ../orders.php');
                    // header('location: ../order-success.php');
                    die();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }

        if($order_status == 'Delivered' && $method == 'Courier Service'){
            $sql_status = "UPDATE order_details SET order_status = '$order_status' WHERE order_details_id = $od_id;";
            if(mysqli_query($conn, $sql_status)){
                //tapos may email na matatanggap dapat yung customer
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
                    <p>Thank you for shopping with us!</p>
                    <p>We appreciate you for ordering, we hope you to enjoy your day and have fun. Thank you.</p>
                    <p>Let us know if we can do anything to make your experience better!</p>
                    <p>Your growth partner,</p>
                    <p>PC-Med</p>";
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Thank you for shopping with us!';
                    $mail->Body    = $body;
                    $mail->AltBody = strip_tags($body);
                
                    $mail->send();
                    header('location: ../orders.php');
                    // header('location: ../order-success.php');
                    die();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }elseif($order_status == 'Picked up' && $method == 'Pick up'){
            // $sql_status = "UPDATE order_details SET order_status = '$order_status' WHERE order_details_id = $od_id;";
            // if(mysqli_query($conn, $sql_status)){
            //     //tapos may email na matatanggap dapat yung customer
            //     header('location: ../orders.php');
            // }
            $sql_orders = "SELECT * FROM orders WHERE order_details_id = $od_id;";
            $result_orders = mysqli_query($conn, $sql_orders);
            if(mysqli_num_rows($result_orders) > 0){
                while($row_orders = mysqli_fetch_assoc($result_orders)){
                    $product_id = $row_orders['product_id'];
                    $quantity = $row_orders['quantity'];

                    echo $product_id . '<br>';
                    echo $quantity . '<br>';

                    $sql_status = "UPDATE order_details SET order_status = '$order_status' WHERE order_details_id = $od_id;";
                    
                    $sql_quantity = "UPDATE product SET quantity = quantity - $quantity WHERE product_id = $product_id;";
                    
                    $sql_sold = "UPDATE product SET sold = sold + $quantity WHERE product_id = $product_id;";
                    
                    $sql_available = "UPDATE product SET available = available - $quantity WHERE product_id = $product_id;";
                    
                    if(mysqli_query($conn, $sql_status) && mysqli_query($conn, $sql_quantity) &&mysqli_query($conn, $sql_sold) && mysqli_query($conn, $sql_available)){
                        //tapos may email na matatanggap dapat yung customer
                        // echo $od_id . ' ' . $user_id . ' ' . $method;
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
                            <p>Thank you for shopping with us!</p>
                            <p>We appreciate you for picking up your order, we hope you to enjoy your day and have fun. Thank you.</p>
                            <p>Let us know if we can do anything to make your experience better!</p>
                            <p>Your growth partner,</p>
                            <p>PC-Med</p>";
                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Thank you for shopping with us!';
                            $mail->Body    = $body;
                            $mail->AltBody = strip_tags($body);
                        
                            $mail->send();
                            header('location: ../orders.php');
                            // header('location: ../order-success.php');
                            die();
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                    // mysqli_query($conn, $sql_status);
                    // mysqli_query($conn, $sql_quantity);
                    // mysqli_query($conn, $sql_sold);
                    // mysqli_query($conn, $sql_available);                  
                    

                }//end of while fetch assoc orders
            }//end of orders if num rows
        }

        if($order_status == 'Cancelled' && method == 'Pick up'){
            $sql_status = "UPDATE order_details SET order_status = '$order_status' WHERE order_details_id = $od_id;";
            if(mysqli_query($conn, $sql_status)){
                //tapos may email na matatanggap dapat yung customer
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
                    <p>Thank you for choosing our us!</p>
                    <p>We appreciate you for placing an order, unfortunately, we would like to inform you that we cancelled your order due to 2 weeks already passing.</p>
                    <p>Let us know if we can do anything to make your experience better!</p>
                    <p>Your growth partner,</p>
                    <p>PC-Med</p>";
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Order Cancelled';
                    $mail->Body    = $body;
                    $mail->AltBody = strip_tags($body);
                
                    $mail->send();
                    header('location: ../orders.php');
                    // header('location: ../order-success.php');
                    die();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }


    }//end of if isset get od_id
}else{
    header('location: ../dashboard.php');
    die();   
    
}