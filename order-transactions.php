<?php
    session_start();
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

        <!-- latest bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Order Transactions</title>
</head>
<body>
    <style type="text/css">
        nav{
            display: flex;
            gap: 1em;
            justify-content: center;
        }
        nav a{
            text-decoration: none;
            font-size: 20px;
            color: #555;
        }
        nav a:hover{
            text-decoration: underline;
        }
    </style>
    <nav>
    <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
    <br>
    <a href="profile.php"><i class="fa fa-cart-plus" aria-hidden="true"></i>Profile</a>
    <br>
    <a href="change-password.php"><i class="fa fa-lock" aria-hidden="true"></i>Change Password</a>
    <br>
    <a href="includes/logout.inc.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
</nav>
    <br><br><br><br><br>

    <div class="container">

    <h1>Order History</h1>
    <br>
        <table class="table">
        <thead>
            <tr>
            <th scope="col">Order No.</th>
            <th scope="col">Total Price</th>
            <th scope="col">Order Status</th>
            <th scope="col">Date</th>
            <th scope="col"></th>
            <th scope="col"></th>
            </tr>
        </thead>
        <?php
            if(isset($_SESSION['id'])){
                $id = $_SESSION['id'];
                $sql = "SELECT * FROM order_details WHERE user_id = $id AND is_deleted != 1 ORDER BY order_details_id DESC;";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $order_details_id = $row['order_details_id'];
                            $user_id = $row['user_id'];
                            $total = $row['total'];
                            $address = $row['address'];
                            $zip = $row['zipcode'];
                            $instructions = $row['instructions'];
                            $method = $row['delivery_method'];
                            $payment = $row['payment'];
                            $order_status = $row['order_status'];
                            $date_added = $row['date_added'];
                            $last_updated = $row['last_updated'];
    
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' .$order_details_id. '</td>';
                            echo '<td>&#8369;' .$total. '</td>';
                            echo '<td>' .$order_status. '</td>';
                            echo '<td>' .$date_added. '</td>';
                            echo '<td>'
                            ?>
                            <!-- Button view trigger modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-view<?php echo $order_details_id; ?>">View Order Details</button>
    
                            <!-- Modal view Start -->
                            <div class="modal fade scrollable" id="modal-view<?php echo $order_details_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2%;">
                                <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50%;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Order details</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h2>Order No. <?php echo $order_details_id?></h2>
                                            <br>
                                            <h5><strong>Date Ordered: </strong><?php echo $date_added; ?></h5>
                                            <h5><strong>Current Status: </strong><strong><u><?php echo $order_status; ?></u></strong></h5>
                                            <br>
                                            <table class="table table-dark">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Total Price</th>
                                                    </tr>
                                                </thead>
                                            <?php
                                                    echo '<h3>Order details:</h3>';
                                                    $sql_users = "SELECT * FROM users WHERE user_id = $user_id;";
                                                    $result_users = mysqli_query($conn, $sql_users);
                                                    if(mysqli_num_rows($result_users) > 0){
                                                        while($row_users = mysqli_fetch_assoc($result_users)){
                                                            $email = $row_users['email'];
                                                            $f_name = $row_users['f_name'];
                                                            $l_name = $row_users['l_name'];
    
                                                            echo '<h5><strong>Email: </strong>' .$email. '</h5>';
                                                            echo '<h5><strong>Full Name: </strong>' .$f_name. '' .$l_name. '</h5>';
                                                        }
                                                    }
                                                    if($payment == 0){
                                                        echo '<h5><strong>Payment Method: </strong>Cash</h5>';
                                                        echo '<h5><strong>Payment Status: </strong>Pending</h5>';
                                                    }elseif($payment == 1){
                                                        echo '<h5><strong>Payment Method: </strong>PayPal</h5>';
                                                        echo '<h5><strong>Payment Status: </strong>Paid';
                                                    }
    
                                                    if($method == 'Courier Service'){
                                                        echo '<h5><strong>Delivery Method: </strong>Courier Service</h5>';
                                                        echo '<h5><strong>Address: </strong>' .$address. '</h5>';
                                                        echo '<h5><strong>Zipcode: </strong>' .$zip. '</h5>';
                                                    }elseif($method == 'Pick up'){
                                                        echo '<h5><strong>Delivery Method: </strong>Pick up</h5>';
                                                    }
                                                    echo '<h5><strong>Additional Instructions: </strong>' .$instructions. '</h5><br><br>';
                                                    
                                                    $sql_orders = "SELECT * FROM ordered_product WHERE order_details_id = $order_details_id;";
                                                $result_orders = mysqli_query($conn, $sql_orders);
                                                if(mysqli_num_rows($result_orders) > 0){
                                                    while($row_orders = mysqli_fetch_assoc($result_orders)){
                                                        $product_image = $row_orders['image'];
                                                        $product_name = $row_orders['name'];
                                                        $price = $row_orders['price'];
                                                        $total_price = $row_orders['total_price'];
                                                        $shipping_fee = $row_orders['shipping_fee'];
                                                        $subtotal = $row_orders['subtotal'];
                                                        $quantity = $row_orders['quantity'];
                                                        
                                                        echo '<tbody>';
                                                        echo '<tr>';
                                                        echo '<td><img src="admin/' .$product_image. '" alt="" height="60px" width="100px"></td>';
                                                        echo '<td>' .$product_name. '</td>';
                                                        echo '<td>' .$quantity. '</td>';
                                                        echo '<td>&#8369;' .$price. '</td>';
                                                        echo '<td>&#8369;' .$total_price. '</td>';
                                                        echo '</tr>';
                                                    }// end of while assoc orders
                                                }//end of if num rows 
                                                    if($shipping_fee !== NULL){
                                                        echo '<tr>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td>Shipping Fee:</td>';
                                                        echo '<td>&#8369;' .$shipping_fee. '</td>';
                                                        echo '</tr>';
                                                    }

                                                    echo '<tr>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>Sub Total:</td>';
                                                    echo '<td>&#8369;' .$subtotal. '</td>';
                                                    echo '</tr>';
                                                    echo '</tbody>';
                                                    echo '</table>';
                                                    echo '<br>';
                                                
                                            ?>
                                        </div>
    
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal view End -->
    
                <?php        
                            '</td>';
                            echo '<td>';
                                
                                if($order_status == 'Pending' && $method == 'Pick up'){
                                    // echo '<h1>--------</h1>';
                                    ?>
                                    <!-- Button delete trigger modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $order_details_id; ?>">
                                    <!-- <i class="fa fa-trash" aria-hidden="true"></i> -->
                                    Cancel Order
                                    </button>
            
                                    <!-- Modal Delete Start -->
                                    <div class="modal fade" id="modal-delete<?php echo $order_details_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4>Are you sure you want to cancel this order?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger"><a href="includes/cancel-order.inc.php?id=<?php echo $order_details_id; ?>" style="color: #fff;">Cancel Order</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Delete End -->
                                <?php
                                }elseif($order_status == 'Processing' && $method == 'Pick up'){
                                    // echo '<h1>--------</h1>';
                                    ?>
                                    <!-- Button delete trigger modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $order_details_id; ?>">
                                    <!-- <i class="fa fa-trash" aria-hidden="true"></i> -->
                                    Cancel Order
                                    </button>
            
                                    <!-- Modal Delete Start -->
                                    <div class="modal fade" id="modal-delete<?php echo $order_details_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4>Are you sure you want to cancel this order?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger"><a href="includes/cancel-order.inc.php?id=<?php echo $order_details_id; ?>" style="color: #fff;">Cancel Order</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Delete End -->
                                    <?php
                                }else {
                                    echo '<h1>--------</h1>';
                                }
                        }//end of while fetch assoc
                    } else {
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td colspan="6">No record found';
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';
                    }
                    
    
                }else{
                    header('location: index.php');
                    die();
                }
                        
                ?>

        
        </table>
    </div>  



    <!-- bootstrap script links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>