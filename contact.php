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
    <title> CONTACT | PC-MED DATA SOLUTION </title>
    <?php
        require_once 'header.php';
    ?>

<section class="location">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9875.154739873438!2d121.0038877465322!3d14.62497249049498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b6144e063ab9%3A0xee10eaf25bfb88ea!2sPpsta%20Bldg!5e1!3m2!1sen!2sph!4v1648038970648!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</section>

<!-- contact STARTS HERE -->


    <!-- about us content -->
    <section class="contact_us">
        <div class="row">
            <div class="about">
                <div>
                    <i class="fa fa-home"></i>
                        <span>
                            <h5>#419 PPSTA BLDG 1, Corner Banawe st. Quezon Ave, Q.C
                            </h5>
                            <p>QUEZON CITY</p>
                        </span>
                </div>
                <div>
                    <i class="fa fa-phone"></i>
                        <span>
                            <h5>(+63) 9057083882 / 9914166456
                            </h5>
                            <p>Monday to Saturday, 8AM to 6PM</p>
                        </span>
                </div>
                <div>
                    <i class="fa fa-envelope-o"></i>
                        <span>
                            <h5>marvindelosreyes1126@yahoo.com<br>marvindelosreyes1126@gmail.com 
                            </h5>
                            <p>Email us you query</p>
                        </span>
                    </div>
                </div>
                <!-- form for contact -->
<!--                 
                             <div class="about">
                            <form action="" method="post" style="border:1px solid #ccc; padding: 1em 1em; border-radius: 20px;">
                                <h1 style="text-align: center; margin-bottom: 1em;">CONTACT FORM</h1>
                                
                                <input type="text" name="subject" placeholder="Enter your subject" required>
                                <textarea rows="8" name="body" placeholder="Message" required></textarea>
                                <button type="submit" name="submit" class="button" >Send Message</button>
                            </form>
                        </div>             -->
              
                          <br><br><br><br> 
            </div>
        </div>
    </section>
   
<!-- contact US ENDS HERE -->




<!-- footer starts here -->
<?php
require_once 'footer.php'
?>

<!-- footer ends here -->









    <!-- JAVASCRIPT FOR TOGGLE BUTTON -->
    <script>
    var navLinks = document.getElementById("navLinks");
    function showMenu(){
        navLinks.style.right = "0";
    }
    function hideMenu(){
        navLinks.style.right = "-200px";
    }

</script>

</body>
</html>