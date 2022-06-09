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
    .container{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    @media(max-width:955px){
        .container{
            flex-direction: column;
            margin-top: 30%;
        }
    }
    .form-control {
        width: 50%;
        margin: auto;
    }

    .form-select {
        width: 50%;
        margin: auto;
    }

    .reminders {
        width: 50%;
        margin: auto;
    }

    .btn {
        width: 50%;
        margin-left: 25%;
    }

</style>
<br><br>
<div class="container1">

<?php 
    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
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
                echo '<div class="container">';
                echo '<p>ProductName:   ' .$name. '</p>';
                echo '<img class="checkout_image" src="admin/' .$image. '" alt="' .$name. '">';
                echo '<p>Qty:   ' .$quantity. '</p>';
                echo '<p>Price: &#8369;' .$total_price. '</p>';
                echo '</div>';
            }//end of cart_details while loop fetch assoc
        }else{
            echo '<script>window.location.href = "cart.php";</script>';
            die();
        }//end of else of num rows
        
        $sql_cust = "SELECT * FROM users WHERE user_id = $user_id;";
        $result_cust = mysqli_query($conn, $sql_cust);
        if(mysqli_num_rows($result_cust) > 0) {
            while($row_cust = mysqli_fetch_assoc($result_cust)){
                $f_name = $row_cust['f_name'];
                $l_name = $row_cust['l_name'];
                $email = $row_cust['email'];
                $phone_no = $row_cust['phone_no'];
                $address = $row_cust['address'];
                ?>
                <form action="place-order.php" method="post">
                    

                    <input class="form-control" type="hidden" placeholder="" aria-label="default input example" name="user_id" value="<?php echo $user_id; ?>"><br>
                    <input class="form-control" type="text" placeholder="" aria-label="default input example" name="fullname" value="<?php echo $f_name. ' ' .$l_name;?>" disabled><br>
                    <input class="form-control" type="text" placeholder="" aria-label="default input example" name="email" value="<?php echo $email; ?>" disabled><br>
                    <input class="form-control" type="number" placeholder="" aria-label="default input example" name="phone_no" value="<?php echo $phone_no; ?>" disabled><br><br>


                    <!-- needed for db -->
                    <h3>Shipping Address</h3><br>
                    <!-- <input class="form-control" name="address" type="text" placeholder="Street number / Building number / District" aria-label="default input example" value=""><br> -->
                    <input class="form-control" name="street" type="text" placeholder="Street number / Building number / District" aria-label="default input example" value="<?php echo $address; ?>" required><br>
                    <input class="form-control" name="zip" type="number" placeholder="Zip Code / Postal Code" aria-label="default input example" required><br>
                    
                    <h3><label for="city" class="city">City</label></h3>
                    <!-- needed for db -->
                    <select class="form-select" aria-label="Default select example" name="city" id="city">
                        <?php
                            $sql_city = "SELECT * FROM shipping_fee ORDER BY city";
                            $result_city = mysqli_query($conn, $sql_city);
                            if(mysqli_num_rows($result_city) > 0) {
                                while($row_city = mysqli_fetch_assoc($result_city)){
                                    $sf_id = $row_city['sf_id'];
                                    $city = $row_city['city'];
                                    echo '<option value="' .$city. '">' .$city. '</option>';
                                }
                            }
                        ?>
                    </select><br>

                    <!-- needed for db -->
                    <select class="form-select" aria-label="Default select example" name="method" id="method">
                        <option value="Courier Service">Courier Service</option>
                        <option value="Pick up">Pick up</option>
                    </select><br>

                    <!-- needed for db -->
                    <div class="mb-3">
                        <textarea class="form-control" name="instructions" id="exampleFormControlTextarea1" rows="5" placeholder="Additional Instructions" style="resize:none;"></textarea>
                    </div>
                    <div class="reminders">
                        <h4>Reminders:</h4>
                        <ul>
                            <li>Processing will be at least one (1) business day. It may take longer, depending on the availability of the item(s).</li>
                            <li>Availability of the item(s) will be confirmed through email. Once your order has been submitted, please wait for the email confirmation that will be sent by our customer representative.</li>
                            <li>Prices and specifications are subject to change without notice.</li>
                            <li>Pickup location: #419 PPSTA BLDG 1, Corner Banawe st. Quezon Ave,
                    Quezon City</li>
                            <li>Pickup schedule: 8AM to 6PM, Monday to Friday only.</li>
                        </ul><br>
                    </div>
                    <button type="submit" name="checkout_submit" class="btn btn-primary">Continue</button>
                </form><br><br>
                <?php
            }//end of users while loop fetch assoc
        }//end of users if num rows



    }else{
        header('location: index.php');
        die();
    }//end of else of isset session
    ?>
    
</div>
<br><br><br>



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













<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<?php
    require_once 'footer.php';
?>