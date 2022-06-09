<?php


namespace Sample;

require __DIR__ . '/vendor/autoload.php';
// 1. Import the PayPal SDK client that was created in Set up Server-Side SDK.
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
require_once 'paypal-client.php';
$orderID = $_GET["orderID"];

class GetOrder
{
    // 2. Set up your server to receive a call from client
    // You can use this function to retrieve an order by passing order ID as an argument.
    public static function getOrder($orderId)
    {
        // 3. Call PayPal to get the transaction detail
        $client = PayPalClient::client();
        $response = $client->execute(new OrdersGetRequest($orderId));
        
        $orderdetailsID = $_GET["orderdetailsID"];
        $userID = $_GET["userID"];
        $emailSession = $_GET["email"];
        $orderID = $response->result->id;
        $email = $response->result->payer->email_address;
        $fullname = $response->result->purchase_units[0]->shipping->name->full_name;
        $payerID = $response->result->payer->payer_id;
        $value = $response->result->purchase_units[0]->amount->value;

        // Insert to database
        require_once '../includes/db.inc.php';

        $sql = "INSERT INTO payment_details (order_details_id, transaction_id, email, fullname, payer_id, amount_paid) VALUES ($orderdetailsID, '$orderID', '$email', '$fullname', '$payerID', '$value');";

        $query = "DELETE FROM cart WHERE user_id = $userID;";
        mysqli_query($conn, $query);

        $update = "UPDATE order_details SET payment = 1, is_deleted = 0 WHERE order_details_id = $orderdetailsID;";
        mysqli_query($conn, $update);
        

        if(mysqli_query($conn, $sql) && mysqli_query($conn, $query) && mysqli_query($conn, $update)){  

            $sql_orders = "SELECT * FROM order_details WHERE order_details_id = $orderdetailsID;";
            $result_orders = mysqli_query($conn, $sql_orders);
            if(mysqli_num_rows($sql_orders) > 0){
                while($row = mysqli_fetch_assoc($result_orders)){
                    $total = $row['total'];
                    $shipping_fee = $row['shipping_fee'];
                    $subtotal = $row['subtotal'];
                    $address = $row['address'];
                    $zipcode = $row['zipcode'];
                    $instructions = $row['instructions'];
                    $delivery_method = $row['delivery_method'];
                    $payment  = $row['payment'];
                }
            }
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
                $test = $total + $shipping_fee;

                $body = "<p>Hi there,</p>
                <p>Thank you for shopping with us!</p>
                <p>We appreciate your order. This email confirms that we received your order and to confirm that your payment has been completed.</p>
                <p>Order No.:    <strong>" .$orderdetailsID. "</strong></p>
                <p>Channel:     <strong>PayPal</strong></p>
                <p>Status:      <strong>Success</strong></p>

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


        // $stmt = $conn->prepare("INSERT INTO payment_details (order_id, email, fullname, payer_id) VALUES (?, ?, ?, ?)");
        // $stmt->bind_param("isss", $orderID, $email, $fullname, $payerID);
        // $stmt->execute();
        
        // if(!$stmt) {
        //     echo 'There was an error' . mysqli_error($conn);
        // }else{
        //     header('location: ../test-paypal-success.php');
        // }
        // $stmt->close();
        // $conn->close();

        // Enable the following line to print complete response as JSON
        // print json_encode($response->result);

        // print "Status Code: {$response->statusCode}\n";
        // print "Status: {$response->result->status}\n";
        // print "Order ID: {$response->result->id}\n";
        // print "Intent: {$response->result->intent}\n";
        // print "Links:\n";
        // foreach($response->result->links as $link)
        // {
        //     print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
        // }
        // // 4. Save the transaction in your database. Implement logic to save transaction to your database for future reference.
        // print "Gross Amount: {$response->result->purchase_units[0]->amount->currency_code} {$response->result->purchase_units[0]->amount->value}\n";

        // To print the whole response body, uncomment the following line
        // echo json_encode($response->result, JSON_PRETTY_PRINT);
    }
}

if(!count(debug_backtrace()))
{
    GetOrder::getOrder($orderID, true);
}
?>