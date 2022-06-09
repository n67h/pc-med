<?php

namespace Sample;

require __DIR__ . '/vendor/autoload.php';
// 1. Import the PayPal SDK client that was created in Set up Server-Side SDK.
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
require_once 'paypal-client.php';
$orderID = $_GET['orderID'];

class GetOrder
{
    // 2. Set up your server to receive a call from client
    // You can use this function to retrieve an order by passing order ID as an argument.
    public static function getOrder($orderId)
    {
        // 3. Call PayPal to get the transaction detail
        $client = PayPalClient::client();
        $response = $client->execute(new OrdersGetRequest($orderId));

        $orderID = $response->result->id;
        $email = $response->result->payer->email_address;
        $fullname = $response->result->purchase_units[0]->shipping->name->full_name;
        $payerID = $response->result->payer->payer_id;

        // Insert to database
        require_once '../includes/db.inc.php';

        $sql = "INSERT INTO payment_details (order_id, email, fullname, payer_id) VALUES ('$orderID', '$email', '$fullname', '$payerID')";

        if(mysqli_query($conn, $sql)){  
            header('location: ../test-paypal-success.php');
            die();
        };
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