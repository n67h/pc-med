<?php
    require_once 'includes/db.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Paypal</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AUu5zoJ_q4bYnIOx-obNVF0jUm2XJSJCNIQ7Dr5cP8YkOBekxutIHYrLDDLIFSwcrqbFmFxaUUzL89Ch&currency=PHP"></script>
</head>
<body>
    
    <div id="paypal-button-container">

    </div>

    <?php
        $subTotal = 250000;
    ?>

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
                return actions.order.capture().then(function(details){

                    // window.location = "test-paypal/transaction-completed.php?&orderID=" + data.orderID;

                    // console.log(details.payer.name.given_name);
                    // console.log(details.payer.name.surname);
                    // console.log(details.payer.email_address);
                    // console.log(details.payer.payer_id);
                    // console.log(details.status);
                    console.log(details);
                });
            }
            
        }).render('#paypal-button-container');
        </script>
        <?php echo 'transaction completed'; ?>

</body>
</html>

<!--
CREATE TABLE payment_details (
	pd_id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    order_id varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    fullname varchar(128) NOT NULL,
    payer_id varchar(50) NOT NULL
);
-->