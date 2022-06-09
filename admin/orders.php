<?php
    require_once 'includes/session.inc.php';
    if(isset($_GET['orderid'])){
        $notif_id = $_GET['orderid'];
        $sql_read = "UPDATE order_details SET is_read = 1 WHERE order_details_id = $notif_id AND is_deleted != 1;";
        mysqli_query($conn, $sql_read);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <!-- latest jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- latest bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- font awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- bootstrap js -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script><script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<?php
    require_once 'sidebar.php';
?>
<style>
    .content-body {
        margin-left: 25%;
        margin-right: 5%;
    }

    .edit-label {
        color: black;
    }
    


    /* .table {
        margin-left: 5%;
        width: 90%;
    } */
</style>
<div class="content-body">
    <?php
        $sql = "SELECT * FROM users WHERE user_id = $idSession AND user_role_id = 3 AND is_deleted = 0;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $f_name = $row['f_name'];
                echo '<br><br>';
            }//end of while loop users
        }//end of if num rows users


        
    ?>  
            <br><br>
            <style>
                        .container {
                            display: flex;
                        }
                    </style>

            <div class="container">
                <form action="" method="post" id="form-record" class="form-record">
                    <select class="form-select" name="form-select" aria-label="Default select example" id="form-select">
                        <option selected disabled>-- Limit Records --</option>
                        <?php
                            foreach([6, 10, 15, 20] as $recordlimit):
                        ?>
                            <option <?php if(isset($_POST['form-select']) && $_POST['form-select'] == $recordlimit) {
                                echo 'selected';
                            }?> value="<?php echo $recordlimit; ?>"><?php echo $recordlimit; ?></option>
                        <?php
                            endforeach;
                        ?>
                    </select>
                </form><br>

                <button type="button" class="btn btn-primary" style="margin-left: 50px;"><a href="orders.php?archive" style="color: white;">Show Archived Records</a></button><br>


            </div>
            <br>
                <style>
                            tr{
                            color: black;
                            font-size: 17px;
                            }
                            thead,th{
                                background: #444;
                                color: #fff;
                                white-space: nowrap;
                            }
                        </style>

                <table class="table table-default">
                <thead>
                    <tr>
                        <th scope="col">Order No.</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Last Updated</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php
                $limit = isset($_POST['form-select']) ? $_POST['form-select'] : 6;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($page - 1) * $limit;
                $sql = "SELECT * FROM order_details WHERE is_deleted != 1 ORDER BY order_details_id DESC LIMIT $start, $limit;";

                if(isset($_GET['orderid'])){
                    $notif_id1 = $_GET['orderid'];

                    $resultCount = $conn->query("SELECT count(order_details_id) AS order_details_id FROM order_details WHERE order_details_id = $notif_id1 AND is_deleted != 1;");
                    $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                    $total = $totalCount[0]['order_details_id'];
                    $pages = ceil($total / $limit);
                    
                    $previousPage = $page - 1;
                    $nextPage = $page + 1;

                    $sql_read1 = "SELECT * FROM order_details WHERE order_details_id = $notif_id1 AND is_deleted != 1;";
                    $result_read1 = mysqli_query($conn, $sql_read1);
                    if(mysqli_num_rows($result_read1) > 0){
                        while($row_read1 = mysqli_fetch_assoc($result_read1)){
                            $order_details_id = $row_read1['order_details_id'];
                            $user_id = $row_read1['user_id'];
                            $total = $row_read1['total'];
                            $sf = $row_read1['shipping_fee'];
                            $sub_total = $row_read1['subtotal'];
                            $address = $row_read1['address'];
                            $zip = $row_read1['zipcode'];
                            $instructions = $row_read1['instructions'];
                            $method = $row_read1['delivery_method'];
                            $payment = $row_read1['payment'];
                            $order_status = $row_read1['order_status'];
                            $date_added = $row_read1['date_added'];
                            $last_updated = $row_read1['last_updated'];

                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' .$order_details_id. '</td>';
                            echo '<td>&#8369;' .$sub_total. '</td>';
                            echo '<td>' .$order_status. '</td>';
                            echo '<td>' .$date_added. '</td>';
                            echo '<td>' .$last_updated. '</td>';
                            echo '<td></td>';
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
                                        <table class="table table-default" style="background: #fff;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Total Price</th>
                                                </tr>
                                            </thead>
                                        
                                            <style>
                            tr{
                            color: black;
                            font-size: 17px;
                            }
                            thead,th{
                                background: #444;
                                color: #fff;
                                white-space: nowrap;
                            }
                        </style>
                                        <?php
                                                echo '<h3>Order details:</h3>';
                                                $sql_users = "SELECT * FROM users WHERE user_id = $user_id;";
                                                $result_users = mysqli_query($conn, $sql_users);
                                                if(mysqli_num_rows($result_users) > 0){
                                                    while($row_users = mysqli_fetch_assoc($result_users)){
                                                        $email = $row_users['email'];
                                                        $f_name = $row_users['f_name'];
                                                        $l_name = $row_users['l_name'];

                                                        echo '<h5>Email: ' .$email. '</h5>';
                                                        echo '<h5>Full Name: ' .$f_name. '' .$l_name. '</h5>';
                                                    }
                                                }
                                                if($payment == 0){
                                                    echo '<h5>Payment Method: Cash</h5>';
                                                    echo '<h5>Payment Status: Pending</h5>';
                                                }elseif($payment == 1){
                                                    echo '<h5>Payment Method: PayPal</h5>';
                                                    echo '<h5>Payment Status: Paid';
                                                }

                                                if($method == 'Courier Service'){
                                                    echo '<h5>Delivery Method: Courier Service</h5>';
                                                    echo '<h5>Address: ' .$address. '</h5>';
                                                    echo '<h5>Zipcode: ' .$zip. '</h5>';
                                                }elseif($method == 'Pick up'){
                                                    echo '<h5>Delivery Method: Pick up</h5>';
                                                }
                                                echo '<h5>Additional Instructions: ' .$instructions. '</h5><br><br>';

                                                $sql_orders = "SELECT * FROM ordered_product WHERE order_details_id = $order_details_id;";
                                            $result_orders = mysqli_query($conn, $sql_orders);
                                            if(mysqli_num_rows($result_orders) > 0){
                                                while($row_orders = mysqli_fetch_assoc($result_orders)){
                                                    $product_image = $row_orders['image'];
                                                    $product_name = $row_orders['name'];
                                                    $price = $row_orders['price'];
                                                    $total_price = $row_orders['total_price'];
                                                    $quantity = $row_orders['quantity'];
                                                    
                                                    echo '<tbody>';
                                                    echo '<tr>';
                                                    echo '<td><img src="' .$product_image. '" alt="" height="60px" width="100px"></td>';
                                                    echo '<td>' .$product_name. '</td>';
                                                    echo '<td>' .$quantity. '</td>';
                                                    echo '<td>&#8369;' .$price. '</td>';
                                                    echo '<td>&#8369;' .$total_price. '</td>';
                                                    echo '</tr>';
                                                }// end of while assoc orders
                                            }//end of if num rows 
                                                echo '<tr>';
                                                echo '<td></td>';
                                                echo '<td></td>';
                                                echo '<td></td>';
                                                echo '<td></td>';
                                                echo '<td>&#8369;' .$total. '</td>';
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
            ?>
                     <!-- Button edit trigger modal -->
                     <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $order_details_id; ?>">
                        <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                        </button>
    
                            <!-- Modal Edit Start -->
                            <div class="modal fade" id="modal-edit<?php echo $order_details_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Order No. <?php echo $order_details_id; ?></h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4></h4>
                                            <!-- <select class="form-select" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select> -->
                                            <form action="includes/edit-orders.inc.php?od_id=<?php echo $order_details_id; ?>&user_id=<?php echo $user_id; ?>&method=<?php echo $method; ?>" method="post">
                                            <select class="form-select" name="order_status" aria-label="Default select example">
                                                <?php 
                                                    if($order_status == 'Pending' && $method == 'Pick up'){
                                                ?>
                                                        <option value="Processing">Confirm</option>
                                                        <!-- <option value="Picked up">Picked up</option> -->
                                                        <option value="Cancelled">Cancelled</option>
                                                <?php
                                                    }elseif($order_status == 'Processing' && $method == 'Pick up'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option> -->
                                                        <option value="Picked up">Picked up</option>
                                                        <option value="Cancelled">Cancelled</option>
                                                <?php        
                                                    }elseif($order_status == 'Picked up' && $method == 'Pick up'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="Cancelled">Cancelled</option> -->
                                                <?php
                                                    }elseif($order_status == 'Cancelled' && $method == 'Pick up'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="Picked up">Picked up</option> -->
                                                <?php
                                                    }elseif($order_status == 'Pending' && $method == 'Courier Service'){
                                                ?>
                                                        <option value="Processing">Confirm</option>
                                                        <!-- <option value="Delivered">Delivered</option> -->
                                                        <!-- <option value="Cancelled">Cancelled</option> -->
                                                <?php
                                                    }elseif($order_status == 'Processing' && $method == 'Courier Service'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option> -->
                                                        <option value="Delivered">Delivered</option>
                                                        <!-- <option value="Cancelled">Cancelled</option> -->
                                                <?php
                                                    }elseif($order_status == 'Delivered' && $method == 'Courier Service'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="Cancelled">Cancelled</option> -->
                                                <?php        
                                                    }elseif($order_status == 'Cancelled' && $method == 'Courier Service'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="Delivered">Delivered</option> -->
                                        <?php
                                                    }
                                                ?>
                                                <!-- <option value="Processing">Processing</option>
                                                <option value="Delivered">Delivered</option>
                                                <option value="Cancelled">Cancelled</option> -->
                                            </select>
                                            
                                            
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit_submit">Save changes</button>
                                            </form>
                                        <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Edit End -->

                            <!-- Button delete trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $order_details_id; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
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
                                            <h4>Are you sure you want to delete this order?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger"><a href="includes/delete-order.inc.php?id=<?php echo $order_details_id; ?>" style="color: #fff;">Delete</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete End -->
                        
                        <?php
                        echo '</td>';
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';
                        }
                    }else{

                    }
                }elseif(isset($_GET['archive'])){
                    $resultCount = $conn->query("SELECT count(order_details_id) AS order_details_id FROM order_details WHERE is_deleted = 1;");
                    $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                    $total = $totalCount[0]['order_details_id'];
                    $pages = ceil($total / $limit);

                    $previousPage = $page - 1;
                    $nextPage = $page + 1;

                    $sql = "SELECT * FROM order_details WHERE is_deleted = 1 ORDER BY order_details_id DESC LIMIT $start, $limit;";

                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $order_details_id = $row['order_details_id'];
                            $user_id = $row['user_id'];
                            $total = $row['total'];
                            $sf = $row['shipping_fee'];
                            $sub_total = $row['subtotal'];
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
                            echo '<td>&#8369;' .$sub_total. '</td>';
                            echo '<td>' .$order_status. '</td>';
                            echo '<td>' .$date_added. '</td>';
                            echo '<td>' .$last_updated. '</td>';
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
                                            <h5><strong>Current Status: </strong><?php echo $order_status; ?></h5>
                                            <br>
                                            <table class="table table-default">
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
    
                                                            echo '<h5>Email: ' .$email. '</h5>';
                                                            echo '<h5>Full Name: ' .$f_name. ' ' .$l_name. '</h5>';
                                                        }
                                                    }
                                                    if($payment == 0){
                                                        echo '<h5>Payment Method: Cash</h5>';
                                                        echo '<h5>Payment Status: Pending</h5>';
                                                    }elseif($payment == 1){
                                                        echo '<h5>Payment Method: PayPal</h5>';
                                                        echo '<h5>Payment Status: Paid';
                                                    }
    
                                                    if($method == 'Courier Service'){
                                                        echo '<h5>Delivery Method: Courier Service</h5>';
                                                        echo '<h5>Address: ' .$address. '</h5>';
                                                        echo '<h5>Zipcode: ' .$zip. '</h5>';
                                                    }elseif($method == 'Pick up'){
                                                        echo '<h5>Delivery Method: Pick up</h5>';
                                                    }
                                                    echo '<h5>Additional Instructions: ' .$instructions. '</h5><br><br>';
                                                    
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
                                                        echo '<td><img src="' .$product_image. '" alt="" height="60px" width="100px"></td>';
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
                                                    echo '<td>Sub Total: </td>';
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
                            ?>
                            <!-- Button restore trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-restore<?php echo $order_details_id; ?>">
                            Restore
                            </button>

                            <!-- Modal restore Start -->
                            <div class="modal fade" id="modal-restore<?php echo $order_details_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Are you sure you want to restore this user?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success"><a href="includes/restore-order.inc.php?id=<?php echo $order_details_id; ?>" style="color: #fff;">Yes</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal restore End -->
                            <?php
                            echo '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                        }//end of while fetch assoc archive
                    }else{
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td colspan="5">No record found';
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';
                    }//end of else if num rows archive
                }else{
                    //read the notification
                    $sql_notif = "UPDATE order_details SET is_read = 1 WHERE is_read = 0;";
                    if(mysqli_query($conn, $sql_notif)){
                        // echo '<script>window.location.reload(true);</script>';
                        echo "<script>window.onload = function() {
                            if(!window.location.hash) {
                                window.location = window.location + '#loaded';
                                window.location.reload();
                            }
                        }</script>";
                    }
                    $resultCount = $conn->query("SELECT count(order_details_id) AS order_details_id FROM order_details WHERE is_deleted != 1;");
                    $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                    $total = $totalCount[0]['order_details_id'];
                    $pages = ceil($total / $limit);
                    
                    $previousPage = $page - 1;
                    $nextPage = $page + 1;
    
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $order_details_id = $row['order_details_id'];
                            $user_id = $row['user_id'];
                            $total = $row['total'];
                            $sf = $row['shipping_fee'];
                            $sub_total = $row['subtotal'];
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
                            echo '<td>&#8369;' .$sub_total. '</td>';
                            echo '<td>' .$order_status. '</td>';
                            echo '<td>' .$date_added. '</td>';
                            echo '<td>' .$last_updated. '</td>';
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
                                            <h5><strong>Current Status: </strong><?php echo $order_status; ?></h5>
                                            <br>
                                            <table class="table table-default">
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
    
                                                            echo '<h5>Email: ' .$email. '</h5>';
                                                            echo '<h5>Full Name: ' .$f_name. ' ' .$l_name. '</h5>';
                                                        }
                                                    }
                                                    if($payment == 0){
                                                        echo '<h5>Payment Method: Cash</h5>';
                                                        echo '<h5>Payment Status: Pending</h5>';
                                                    }elseif($payment == 1){
                                                        echo '<h5>Payment Method: PayPal</h5>';
                                                        echo '<h5>Payment Status: Paid';
                                                    }
    
                                                    if($method == 'Courier Service'){
                                                        echo '<h5>Delivery Method: Courier Service</h5>';
                                                        echo '<h5>Address: ' .$address. '</h5>';
                                                        echo '<h5>Zipcode: ' .$zip. '</h5>';
                                                    }elseif($method == 'Pick up'){
                                                        echo '<h5>Delivery Method: Pick up</h5>';
                                                    }
                                                    echo '<h5>Additional Instructions: ' .$instructions. '</h5><br><br>';
                                                    
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
                                                        echo '<td><img src="' .$product_image. '" alt="" height="60px" width="100px"></td>';
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
                                                    echo '<td>Sub Total: </td>';
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
                ?>
                
                        <!-- Button edit trigger modal -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $order_details_id; ?>">
                        <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                        </button>
    
                            <!-- Modal Edit Start -->
                            <div class="modal fade" id="modal-edit<?php echo $order_details_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Order No. <?php echo $order_details_id; ?></h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4></h4>
                                            <!-- <select class="form-select" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select> -->
                                            <form action="includes/edit-orders.inc.php?od_id=<?php echo $order_details_id; ?>&user_id=<?php echo $user_id; ?>&method=<?php echo $method; ?>" method="post">
                                            <select class="form-select" name="order_status" aria-label="Default select example">
                                                <?php 
                                                    if($order_status == 'Pending' && $method == 'Pick up'){
                                                ?>
                                                        <option value="Processing">Confirm</option>
                                                        <!-- <option value="Picked up">Picked up</option> -->
                                                        <option value="Cancelled">Cancelled</option>
                                                <?php
                                                    }elseif($order_status == 'Processing' && $method == 'Pick up'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option> -->
                                                        <option value="Picked up">Picked up</option>
                                                        <option value="Cancelled">Cancelled</option>
                                                <?php        
                                                    }elseif($order_status == 'Picked up' && $method == 'Pick up'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="Cancelled">Cancelled</option> -->
                                                <?php
                                                    }elseif($order_status == 'Cancelled' && $method == 'Pick up'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="Picked up">Picked up</option> -->
                                                <?php
                                                    }elseif($order_status == 'Pending' && $method == 'Courier Service'){
                                                ?>
                                                        <option value="Processing">Confirm</option>
                                                        <!-- <option value="Delivered">Delivered</option> -->
                                                        <!-- <option value="Cancelled">Cancelled</option> -->
                                                <?php
                                                    }elseif($order_status == 'Processing' && $method == 'Courier Service'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option> -->
                                                        <option value="Delivered">Delivered</option>
                                                        <!-- <option value="Cancelled">Cancelled</option> -->
                                                <?php
                                                    }elseif($order_status == 'Delivered' && $method == 'Courier Service'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="Cancelled">Cancelled</option> -->
                                                <?php        
                                                    }elseif($order_status == 'Cancelled' && $method == 'Courier Service'){
                                                ?>
                                                        <!-- <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="Delivered">Delivered</option> -->
                                        <?php
                                                    }
                                                ?>
                                                <!-- <option value="Processing">Processing</option>
                                                <option value="Delivered">Delivered</option>
                                                <option value="Cancelled">Cancelled</option> -->
                                            </select>
                                            
                                            
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit_submit">Save changes</button>
                                            </form>
                                        <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Edit End -->
    
    
                            <!-- Button delete trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $order_details_id; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
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
                                            <h4>Are you sure you want to delete this order?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger"><a href="includes/delete-order.inc.php?id=<?php echo $order_details_id; ?>" style="color: #fff;">Delete</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete End -->
                            <?php
                            echo '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                            echo '';
                        }//end of while assoc for order_details table
                    }//end of if num rows for order_details table
                }
                    ?>
                    

            </table>
                <br>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?php echo $page == 1 ? 'disabled':''; ?>"><a class="page-link" href="orders.php?page=<?php echo $previousPage; ?>">Previous</a></li>
                        <?php for($i = 1; $i <= $pages; $i++) : ?>

                        <li class="page-item"><a class="page-link" href="orders.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        
                        <?php endfor; ?>
                        <li class="page-item <?php echo $page == $pages ? 'disabled':''; ?>"><a class="page-link" href="orders.php?page=<?php echo $nextPage; ?>">Next</a></li>
                    </ul>
                </nav>

                
                
</div>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- limit records script -->
    <script>
        $(document).ready(function(){
            $('#form-select').change(function(){
                $('#form-record').submit();
            })
        })
    </script>
<?php
    require_once 'footer.php';
?>