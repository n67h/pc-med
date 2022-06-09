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
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <title>CART | PC MED DATA SOLUTION</title>
    <!-- latest jquery cdn -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
    .form-control {
        width: 50%;
        margin: auto;
    }

    .form-select {
        width: 50%;
        margin: auto;
    }

    .btn {
        width: 50%;
        margin: auto;
    }

    .reminders {
        width: 50%;
        margin: auto;
    }
</style>
<br><br>

<div class="container">
    <?php
        if(isset($_SESSION['id'])){
            $user_id = $_SESSION['id'];
            
            if(isset($_GET['serviceid'])){
                $s_id = $_GET['serviceid'];

                $sql = "SELECT * FROM users WHERE user_id = $user_id AND is_deleted != 1;";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $email = $row['email'];
                        $f_name = $row['f_name'];
                        $l_name = $row['l_name'];
                        $phone_no = $row['phone_no'];
                        $address = $row['address'];
                    }
                }
                $full_name = $f_name. ' ' .$l_name;
                ?>
                <form action="" method="post">
                <h1 style="text-align: center;">Service Reservation</h1><br>
                <input name="email" value="<?php echo $email; ?>" class="form-control" type="text" placeholder="" aria-label="default input example" disabled required><br>
                <input name="fullname" value="<?php echo $full_name; ?>" class="form-control" type="text" placeholder="" aria-label="default input example" disabled required><br>
                <input name="phone_no" value="<?php echo $phone_no; ?>" class="form-control" type="text" placeholder="" aria-label="default input example" disabled required><br>

                <h3>Address</h3>
                <input class="form-control" name="street" type="text" placeholder="Street number / Building number / District" aria-label="default input example" value="<?php echo $address; ?>" required><br>
                <input class="form-control" name="zip" type="number" placeholder="Zip Code / Postal Code" aria-label="default input example" required><br>
                    
                <!-- needed for db -->
                <select class="form-select" aria-label="Default select example" name="city" id="city">
                    <?php
                        $sql_city = "SELECT * FROM shipping_fee WHERE destination = 'Metro Manila' ORDER BY city";
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

                <h3>Choose what type of service you need.</h3>
                <select class="form-select" aria-label="Default select example" name="service" id="service" disabled>
                    <?php
                        $sql_service = "SELECT * FROM service WHERE service_id = $s_id;";
                        $result_service = mysqli_query($conn, $sql_service);
                        if(mysqli_num_rows($result_service) > 0) {
                            while($row_service = mysqli_fetch_assoc($result_service)){
                                $service_id = $row_service['service_id'];
                                $service = $row_service['service'];
                                $price = $row_service['price'];
                                echo '<option value="' .$service_id. '">' .$service. '</option>';
                            }
                        }
                    ?>
                </select><br>
                
                
                <input class="form-control" type="date" name="date" id="datefield" required max="2022-06-30"><br>
                <input class="form-control" type="time" name="time" id="time" required min="08:00" max="18:00">
                <div class="mb-3"><br>
                    <textarea class="form-control" name="instructions" id="exampleFormControlTextarea1" rows="5" placeholder="State your problems..." style="resize:none;" required></textarea>
                </div><br>

                <h3>Total Cost: &#8369;<?php echo $price; ?></h3><br>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit" name="submit_service">Submit</button><br><br>
                </div>
                <div class="reminders">
                    <h4>Reminders:</h4>
                        <ul>
                            <li>Schedule must be 8:00 AM - 6:00 PM only.</li>
                            <li>The services offered are only available for Metro Manila</li>
                            <!-- <li>Lorem </li> -->
                        </ul><br>

                </div>
                </form>
                
                
                
                <?php
            }
        }else {
            echo "<script>location.href = 'index.php';</script>";
        }
    ?>
</div>
    <?php
        if(isset($_POST['submit_service'])){
            $street = mysqli_real_escape_string($conn, $_POST['street']);
            $zip = mysqli_real_escape_string($conn, $_POST['zip']);
            $city = mysqli_real_escape_string($conn, $_POST['city']);
            $service = mysqli_real_escape_string($conn, $_POST['service']);
            $date = mysqli_real_escape_string($conn, $_POST['date']);
            $time = mysqli_real_escape_string($conn, $_POST['time']);
            $instructions = mysqli_real_escape_string($conn, $_POST['instructions']);

            $service_address = $street. ' ' .$city;

            $query = "INSERT INTO service_reservation (user_id, service_id, address, zipcode, service_date, service_time, instructions) VALUES ($user_id, $s_id, '$service_address', '$zip', '$date', '$time', '$instructions');";
            if(mysqli_query($conn, $query)){
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
                <p>This email confirms that we received the reservation that you submitted. We will send you another email once the service reservation request has been approved. Thank you.</p>
                <p>Let us know if we can do anything to make your experience better!</p>
                <p>Your growth partner,</p>
                <p>PC-Med</p>";
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Thank you for choosing our service!';
                $mail->Body    = $body;
                $mail->AltBody = strip_tags($body);
            
                $mail->send();
                // echo "<script>location.href = 'service.php';</script>";
                echo '<script>swal("Service Reservation Success!", "", "success");</script>';
                // header('location: ../order-success.php');
                die();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }


            }
        }
    ?>

<br><br><br><br><br><br>
    
    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        if (dd < 10) {
        dd = '0' + dd;
        }

        if (mm < 10) {
        mm = '0' + mm;
        } 
    
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("datefield").setAttribute("min", today);
    </script>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<?php
    require_once 'footer.php';
?>