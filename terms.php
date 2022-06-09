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
    <title> TERMS AND CONDITIONS | PC-MED DATA SOLUTION </title>
    <?php
        require_once 'header.php';
    ?>
<br><br><br><br><br>


        <div class="container">
            <h6>Last Updated: 05/19/2022</h6>
            <h5>Using this website, you accept these Terms & Conditions, Warranty policy, Payment Policy. If you disagreenwith any of these terms, conditions and policies, you must not use this website.</h5><br>
            

            <h3 style="text-align: left;">Prices, Payment and Shipping</h3>
            <ul>
                <li>All Prices displayed on the website are subject to change without any prior notice.</li>
                <li>Our Standard Payment terms are strictly Paypal, COD and for Pickup Only.</li>
                <li>The shop uses J&T and Personal Rider to deliver.</li>
            </ul>

            <br>

            <h3 style="text-align: left;">Warranty Policy</h3>
            <ul>
                <li>There is a one-year warranty on brand-new laptops and computer desktops.</li>
                <li>There is a 6-month warranty when purchasing used laptops and computers from the store.</li>
                <li>This website offers a 3-month warranty on all electronics and computer parts purchased.</li>
            </ul>

        </div>





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