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
    <title>SERVICE | PC MED DATA SOLUTION</title>

    <?php
       require_once 'header.php';
    ?>

</section>
<style>
    /* #service-container {
        display: flex;
        justify-content: center;
    } */
</style>

 <section class="service" id="service">
    <h1>Services We Offer</h1>
    <p>Good day, We also avail of servicing! Just contact us and provide proper information.</p>

    <div class="row" id="service-container">
        <div class="service-col">
            <a href="service-reservation.php?serviceid=1"><h3>SOFTWARE INSTALLATION</h3></a>
            <a href="service-reservation.php?serviceid=1"><p>We provide software installation.</p></a>
        </div>

        <div class="service-col" id="service-link">
            <a href="service-reservation.php?serviceid=2"><h3>HARDWARE INSTALLATION</h3></a>
            <a href="service-reservation.php?serviceid=2"><p>We provide software installation</p></a>
        </div>
        
        <div class="service-col">
            <a href="service-reservation.php?serviceid=3"><h3>TROUBLESHOOTING</h3></a>
            <a href="service-reservation.php?serviceid=3"><p>If you are having problem about troubleshooting, just contact us.</p></a>
        </div>
    </div>
</section>



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