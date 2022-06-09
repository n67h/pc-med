<?php
    session_start();
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
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
    date_default_timezone_set('Asia/Singapore');
    require_once 'includes/db.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <title>CHECKOUT | PC MED DATA SOLUTION</title>
    <!-- latest jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- latest bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- font awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- bootstrap js -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script><script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <script src="https://www.paypal.com/sdk/js?client-id=AUu5zoJ_q4bYnIOx-obNVF0jUm2XJSJCNIQ7Dr5cP8YkOBekxutIHYrLDDLIFSwcrqbFmFxaUUzL89Ch&currency=PHP&disable-funding=credit,card"></script>
<?php
    require_once 'header.php';
?>
<style>
    .checkout_container {
        margin-left: 30%;
    }
    .checkout_image {
        height: 120px;
        width: 160px;
    }
</style>
<br><br>
<div class="checkout_container">
    <?php
        if(isset($_SESSION['id'])){
            $user_id = $_SESSION['id'];
            $email = $_SESSION['email'];
            $total = 0;
            $sql_cart = "SELECT * FROM cart_details WHERE user_id = $user_id;";
            $result_cart = mysqli_query($conn, $sql_cart);
            if(mysqli_num_rows($result_cart) > 0) {
                while($row_cart = mysqli_fetch_assoc($result_cart)){
                    $cart_id = $row_cart['cart_id'];
                    $product_id = $row_cart['product_id'];
                    $image = $row_cart['image'];
                    $name = $row_cart['name'];
                    $quantity = $row_cart['quantity'];
                    $price = $row_cart['price'];
                    $total_price = $row_cart['total_price'];
                    $date_added = $row_cart['date_added'];

                    $total += $total_price;
                }//end of cart_details while loop fetch assoc
            }//end of cart_details if num rows
            echo '<h4>Total: &#8369;' .$total. '</h4>';
            echo '';

            // $address = mysqli_real_escape_string($conn, $_POST["address"]);

            $street = mysqli_real_escape_string($conn, $_POST["street"]);
            $zip = mysqli_real_escape_string($conn, $_POST["zip"]);
            $city = mysqli_real_escape_string($conn, $_POST["city"]);
            $instructions = mysqli_real_escape_string($conn, $_POST["instructions"]);
            $method = mysqli_real_escape_string($conn, $_POST["method"]);

            $sql_sf = "SELECT * FROM shipping_fee WHERE city LIKE '%$city%' LIMIT 1;";
            $result_sf = mysqli_query($conn, $sql_sf);
            if(mysqli_num_rows($result_sf) > 0) {
                while($row_sf = mysqli_fetch_assoc($result_sf)){
                    $shipping_fee = $row_sf['shipping_fee'];
                }
            }
            echo '<h4>Shipping Fee: &#8369;' .$shipping_fee. '</h4>';
            echo '<br>';

            $subTotal = 0;
            $subTotal = $total + $shipping_fee;

            echo '<h2>Sub Total: &#8369;' .$subTotal. '</h2>';


            $shipping_address = $street. ' ' .$city;

            if($method == 'Pick up') {

                $query = "INSERT INTO order_details (user_id, total, subtotal, address, zipcode, instructions, delivery_method) VALUES ($user_id, $total, $total, '$shipping_address', '$zip', '$instructions', '$method');";

                if(mysqli_query($conn, $query)){
                    $order_details_id = mysqli_insert_id($conn);

                    $sql = "SELECT * FROM cart WHERE user_id = $user_id;";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $cart_product_id = $row['product_id'];
                            $cart_quantity = $row['quantity'];
    
                            $sql_insert_orders = "INSERT INTO orders (order_details_id, product_id, quantity) VALUES ($order_details_id, $cart_product_id, $cart_quantity);";
    
                            mysqli_query($conn, $sql_insert_orders);
    
                        }//end of while fetch assoc cart
                    }//end of if num rows cart
                }//end of mysqli_query of insert order_details

                $deleteQuery = "DELETE FROM cart WHERE user_id = '$user_id';";
                mysqli_query($conn, $deleteQuery);
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
                $mail->addAddress($emailSession, '.');     //Add a recipient
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
                <p>We appreciate your order. This email confirms that we received your order. This order is only available to pick up for only 2 weeks. Thank you.</p>
                <p>Order No.:<strong>".$order_details_id."</strong></p>
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
                echo '<script>window.location.href = "order-success.php";</script>';
                // header('location: ../order-success.php');
                die();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }


            }elseif($method == 'Courier Service') {
                // $sql1 = "INSERT INTO orders (user_id, product_id, quantity, address, delivery_method, additional_instructions) VALUES ($user_id, $product_id)";

                $query1 = "INSERT INTO order_details (user_id, total, shipping_fee, subtotal, address, zipcode, instructions, delivery_method, payment, is_deleted) VALUES ($user_id, $total, $shipping_fee, $subTotal, '$shipping_address', '$zip','$instructions', '$method', 0, 1);";
                if(mysqli_query($conn, $query1)){
                    $order_details_id1 = mysqli_insert_id($conn);
                    $sql1 = "SELECT * FROM cart WHERE user_id = $user_id;";
                    $result = mysqli_query($conn, $sql1);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $cart_product_id = $row['product_id'];
                            $cart_quantity = $row['quantity'];
    
                            $sql_insert_orders = "INSERT INTO orders (order_details_id, product_id, quantity) VALUES ($order_details_id1, $cart_product_id, $cart_quantity);";
    
                            mysqli_query($conn, $sql_insert_orders);
    
                        }//end of while fetch assoc cart
                    }//end of if num rows cart
                }

                echo '<button type="button" class="btn btn-primary"><a href="includes/cod.inc.php?od_id='.$order_details_id1.'&user_id='.$user_id.'&email='.$email.'" style="color: white;">Cash on Delivery</a></button><br><br>';
                

                echo '<div id="paypal-button-container">

                </div>';
            
            }

        }else {
            header('location: index.php');
            die();
        }
    ?>
    <style>
        .btn {
            width: 71%;
            max-height: 50%;
        }

        .btn:hover {
            background-color: black;
        }
    </style>


</div>


<!-- display
items from cart
full name
email
phone number
delivery address (defaults to user_address)
customer can change the delivery address
additional instructions
choose a delivery method, Pick up or delivery

click the continue button

then..

proceeds to place order page

if pickup is chosen, only Cash is available
if delivery is chosen, COD or PayPal

choose a payment method, if Cash or PayPal

if Cash is chosen
then store the info to orders table

if payment is done through PayPal
then store the info to orders table and payment details table -->

    <script>
        paypal.Buttons({
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $subTotal; ?>
                        }
                    }]
                })
            },

            onApprove: function(data, actions){
                console.log('Data: ' + data);
                console.log('Action: ' + actions);
                return actions.order.capture().then(function(){

                    var user_id = <?php echo json_encode($user_id, JSON_HEX_TAG); ?>;
                    var email = <?php echo json_encode($email, JSON_HEX_TAG); ?>;
                    var od_id = <?php echo json_encode($order_details_id1, JSON_HEX_TAG); ?>; // Don't forget the extra semicolon!
                    window.location = "paypal/transaction-completed.php?&orderID=" + data.orderID + "&orderdetailsID=" + od_id + "&userID=" + user_id + "&email=" + email;
                    // window.location = "paypal/transaction-completed.php?&orderID=" + data.orderID;

                    // console.log(details.payer.name.given_name);
                    // console.log(details.payer.name.surname);
                    // console.log(details.payer.email_address);
                    // console.log(details.payer.payer_id);
                    // console.log(details.status);
                    // console.log(details);
                });
            }
            
        }).render('#paypal-button-container');
    </script>

<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<?php
    require_once 'footer.php';
?>
 <!-- //                 INSERT INTO orders (order_details_id, product_id, quantity)
                // VALUES (1, (SELECT product_id FROM cart WHERE user_id = 3 LIMIT 1), (SELECT quantity FROM CART WHERE user_id = 3 LIMIT 1));

                // $insertQuery = "INSERT INTO orders (user_id, product_id, quantity) SELECT user_id, product_id, quantity FROM cart WHERE user_id = '$user_id';";

                // if ((mysqli_query($conn, $insertQuery) === true) && (mysqli_query($conn, $deleteQuery) === true)) {
                //     echo '<script>window.location.href = "order-success.php";</script>';
                // }
                
                // $insertQuery = "INSERT INTO orders (user_id, product_id, quantity, address, delivery_method, additional_instructions) VALUES ((SELECT user_id FROM cart WHERE user_id = $user_id), (SELECT product_id FROM cart WHERE user_id = $user_id), (SELECT quantity FROM cart WHERE user_id = $user_id), '$address', '$method', '$instructions');";
                
                // $deleteQuery = "DELETE FROM cart WHERE user_id = '$user_id';";

                // if ((mysqli_query($conn, $insertQuery) === true) && (mysqli_query($conn, $deleteQuery) === true)) {
                //     echo '<script>window.location.href = "order-success.php";</script>';
                // }



                // $sql = "INSERT INTO orders (user_id, product_id, quantity, address,delivery_method, additional_instructions) VALUES ($user_id, $product_id, $quantity, '$address', '$method', '$instructions');";

                // if(mysqli_query($conn, $sql)){  
                //     // echo '<h1>Order Success tanginamo</h1>';
                //     echo '<script>window.location.href = "order-success.php";</script>';
                // } -->