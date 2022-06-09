<?php
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
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="css/landingpage.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/d63bcd1488.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;1,700&family=Oswald:wght@200;300&family=Roboto:wght@100;300&display=swap" rel="stylesheet">
    <title>Register</title>
</head>
<body>
<section class="header">

    <nav class="head">
         <!-- <a href="index.php" class="title"><img src="images/logo.png"> </a> -->
        <div class="nav_links" id="navLinks">

            <i class="fa fa-times" onclick="hideMenu()"></i>
            <ul>
                <li><a href="index.php"><ion-icon name="home-outline"></ion-icon>Home</a></li>
                <li><a href="product.php"><ion-icon name="pricetags-outline"></ion-icon>Products</a></li>
                <li><a href="contact.php"><ion-icon name="call-outline"></ion-icon>Contact</a></li>
                <li><a href="service.php"><ion-icon name="build-outline"></ion-icon>Services</a></li>
                <li><a href="about.php"><ion-icon name="people-outline"></ion-icon>About us</a></li>
                          

            </ul>
        </div>
        <i class="fa fa-bars" onclick="showMenu()"></i>
    </nav>
</section>


    <?php
        $firstname_error = " *";
        $lastname_error = " *";
        $email_error = " *";
        $password_error = " *";
        $password_repeat_error = " *";
        $checkbox_error = " *";

        $firstname_val = "";
        $lastname_val = "";
        $email_val = "";
        $password_val = "";
        $password_repeat_val = "";

        $firstname_success = "";
        $lastname_success = "";
        $email_success = "";
        $password_success = "";
        $password_repeat_success = "";
        $checkbox_success = "";

        

        if(isset($_POST['submit'])) {
            require_once 'includes/db.inc.php';
            require_once 'includes/functions.inc.php';

            $firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
            $lastname = mysqli_real_escape_string($conn, $_POST['last_name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password_repeat = mysqli_real_escape_string($conn, $_POST['password_repeat']);


            //FIRST NAME
            if(firstnameEmpty($firstname) !== false) {
                $firstname_error = " This field is required";
            } else {
                if(firstnameInvalid($firstname) !== false) {
                    $firstname_error = " Invalid first name";
                } else {
                    $firstname_error = "";
                    $firstname_success = ' <i class="fas fa-check-circle"></i>';
                    $firstname_val = $firstname;
                }
            }

            //LAST NAME
            if(lastnameEmpty($lastname) !== false) {
                $lastname_error = " This field is required";
            } else {
                if(lastnameInvalid($lastname) !== false) {
                    $lastname_error = " Invalid last name";
                } else {
                    $lastname_error = "";
                    $lastname_success = ' <i class="fas fa-check-circle"></i>';
                    $lastname_val = $lastname;
                }
            }
   
            //EMAIL
            if(emailEmpty($email) !== false) {
                $email_error = " This field is required";
            } else {
                if(emailInvalid($email) !== false) {
                    $email_error = " Invalid email";
                } elseif(emailExists($conn, $email) !== false) {
                    $email_error = " Email is already taken";
                } else {
                    $email_error = "";
                    $email_success = ' <i class="fas fa-check-circle"></i>';
                    $email_val = $email;
                }
            }

            if(emailExists($conn, $email) !== false) {
                $email_error = " Email is already taken";
            }
            
            //PASSWORD
            if(passwordEmpty($password) !== false) {
                $password_error = " This field is required";
            } else {
                if(passwordInvalid($password)  !== false) {
                    $password_error = " Must be  8 to 16 characters";
                } else {
                    $password_error = "";
                    $password_success = ' <i class="fas fa-check-circle"></i>';
                    $password_val = $password;
                }
            }

            //PASSWORD REPEAT
            if(passwordRepeatEmpty($password_repeat) !== false) {
                $password_repeat_error = " This field is required";
            } else {
                if(passwordRepeatInvalid($password_repeat) !== false) {
                    $password_repeat_error = " Must be 8 to 16 characters";
                } elseif(passwordMatch($password, $password_repeat) !== false) {
                    $password_repeat_error = " Password does not match";
                } else {
                    $password_repeat_error = "";
                    $password_repeat_success = ' <i class="fas fa-check-circle"></i>';
                    $password_repeat_val = $password_repeat;
                }
            }

            //GENERATE VERIFICATION KEY
            $vkey = md5(time());

            //CHECKBOX
            if(!isset($_POST['checkbox'])) {
                $checkbox_error = " This field is required";
            } else {
                $checkbox_error = "";
                $checkbox_success = ' <i class="fas fa-check-circle"></i>';
            }

            if(!empty($firstname) && !empty($lastname) && !empty($address) && !empty($email) && !empty($phone)  && !empty($password)  && !empty($password_repeat) && firstnameInvalid($firstname) === false && lastnameInvalid($lastname) === false && addressInvalid($address) === false && emailInvalid($email) === false && emailExists($conn, $email) === false &&  phoneInvalid($phone) === false && passwordInvalid($password) === false && passwordRepeatInvalid($password_repeat) === false && passwordMatch($password, $password_repeat) === false && $vkey != "" && $checkbox_error === "") {

            
                createUser($conn, $email, $firstname, $lastname, $phone, $address, $password, $vkey);

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
                    <p>Thanks for registering!</p>
                    <p>You're one step closer on creating your account. To start using your account, you need to confirm your e-mail address first clicking the button below:</p>
                    <button><a href='http://localhost/pc-med/verify.php?verificationkey=" .$vkey. "'>Click here to confirm e-mail address</a></button>
                    <p>If you have any questions or concerns, kindly respond to this e-mail</p>
                    <p>Your growth partner,</p>
                    <p>PC-Med</p>";
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Welcome to PC-Med! Confirm the e-mail address of your account here.';
                    $mail->Body    = $body;
                    $mail->AltBody = strip_tags($body);
                
                    $mail->send();
                    echo 'Message has been sent';
                    header('location: register-success.php');
                    die();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
            //echo $vkey;
        }
    ?>

<!-- CSS SECTION -->

<style type="text/css">
    *{
        box-sizing: border-box;
        font-family: 'Roboto',sans-serif;
    }


        .form{
            display: flex;
            justify-content: center;
            align-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 2em;

        }
        form{
        width: 90%;
        max-width: 500px;
        margin-top:3em;
        color: #444;
        text-align: center;
        padding: 30px 50px;
        border: 1px solid rgba(255, 255, 255,0.3);
        background: rgba(255, 255, 255,0.6);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        animation: move 5s infinite;


        }
        @keyframes move{
            10%{box-shadow: 0 4px 60px rgba(80, 90, 255, 0.4);}
            50%{box-shadow: 0 4px 30px rgba(255, 255, 0, 0.4);}
            100%{box-shadow: 0 4px 60px rgba(0, 80, 255, 0.4);}
        }
        .title1{
            color: #fff;
            font-size:30px;
        }
        input{
            font-size: 19px;
             font-size: 20px;
            border: none;
            outline: none;
             border-bottom: 2px solid #555;
             color: #555;
             padding-right: 0;
             background: transparent;
             line-height: 2;
             overflow: hidden;
        }
         #birthdate{
           border-bottom: none;
        }
        select{
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 15%;
            padding-left: 15%;
            outline: none;
            font-size: 20px;
            border-radius: 16px;
        }
        option{
            border-radius: 16px;
        }
        label{
            font-style: italic;
        }
        button{
            border: none;
            outline: none;
            background: #0081CF;
            padding: 12px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
            font-size: 15px;
        }
        button:hover{
            background: #2C73D2;
        }
        button:active{
            opacity: 0.4;
        }
        a{
            text-decoration: none;
            font-size: 20px;
            color: #555;
            white-space: nowrap;
        }
        a:hover{
            text-decoration: underline;
        }

</style>

<div class="form">

        <form action="" method="post" class="container">

            
            <h2 class="title1">Create an account</h2>
            
            <!-- Email -->
                <label for="email">Email<span class="error"><?php echo $email_error ?></span><span class="success"><?php echo $email_success ?></span></label><br>
                <input type="text" name="email" id="email" placeholder="Email"  value="<?php echo $email_val ?>"><br>
            
            <!-- First name -->
                <label  for="first_name">First name<span class="error"><?php echo $firstname_error ?></span><span class="success"><?php echo $firstname_success ?></span></label><br>
                <input type="text" name="first_name" id="first_name" placeholder="Firstname" value="<?php echo $firstname_val ?>"><br>
            
            <!-- Last name -->
                <label for="last_name">Last name<span class="error"><?php echo $lastname_error ?></span><span class="success"><?php echo $lastname_success ?></span></label><br>
                <input type="text" name="last_name" id="last_name" placeholder="Lastname" value="<?php echo $lastname_val ?>"><br> 

            <!-- Address -->
                <label for="address">Address<span class="error"><?php echo $address_error ?></span><span class="success"><?php echo $address_success ?></span></label><br>
                <input type="text" name="address" id="address" placeholder="Address" value="<?php echo $address_val ?>"><br><br>
                
            <!-- </form> -->
            <!-- <div class="form2"> -->
                
            <!-- Phone -->
                <label for="phone">Phone<span class="error"><?php echo $phone_error ?></span><span class="success"><?php echo $phone_success ?></span></label><br>
                <input type="text" name="phone" id="phone" placeholder="Phone no."  value="<?php echo $phone_val ?>"><br><br>

            <!-- Password -->
                <label for="password">Password<span class="error"><?php echo $password_error ?></span><span class="success"><?php echo $password_success ?></span></label><br>
                <input type="password" name="password" id="password" placeholder="Password"  value="<?php echo $password_val ?>"><br>

            <!-- Repeat password -->
                <label for="password_repeat">Repeat Password<span class="error"><?php echo $password_repeat_error ?></span><span class="success"><?php echo $password_repeat_success ?></span></label><br>
                <input type="password" name="password_repeat" id="password_repeat" placeholder="Retype-Password"  value="<?php echo $password_repeat_val ?>"><br><br>

            <!-- Checkbox -->
                <input type="checkbox" name="checkbox" id="checkbox" <?php if(isset($_POST['checkbox'])) { echo 'checked'; } ?>>
                <label for="checkbox">I agree and consent to the use of my submitted information in accordance with the <a href="terms.php">Terms and Conditions</a> of PC-Med Data Solution.<span class="error"><?php echo $checkbox_error ?></span><span class="success"><?php echo $checkbox_success ?></span></label><br><br>

                <button type="submit" name="submit" class="submit" value="submit">Create your account</button>
                <br><br>
                <br>
                <a href="login.php" class="create-acc">Already have an account?</a>
        </form>
       </div>

</div>

<?php

include 'footer.php';
?>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>