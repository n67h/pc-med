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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;1,700&family=Oswald:wght@200;300&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    
    <!--<link rel="stylesheet" href="css/style.css">-->
    
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/landingpage.css">

    <!-- latest jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <title>ABOUT US | PC MED DATA SOLUTION</title>

  <style>



      body{
          background: #fff;
      }
      .wrapper{
          display: flex;
          width: 100%;
          gap: 1.5em;
          justify-content: space-around;
          flex-wrap: wrap;
          margin-top: 5%;
      }
      .card{
          width: 220px;
          height: 360px;
          padding: 2rem 1rem;
          background: #fff;
          position:relative;
          display: flex;
          align-items: center;
          box-shadow: 0px 7px 10px rgba(0, 0, 0, 0.5);
          transition: 0.5s ease-in-out;
          border-radius: 10px;
          flex-wrap: wrap;
      }
      .card:hover{
          transform: translateY(20px);
      }
      .card::before{
          content: "";
          position: absolute;
          top :0;
          left: 0;
          display: block;
          width: 100%;
          height: 100%;
          background: linear-gradient(to bottom, rgba(10,176,195,0.5),rgba(17,65,189,1));
          z-index: 2;
          transition: 0.5s all;
          opacity: 0;
          border-radius: 10px;
      }
      .card:hover::before{
          opacity: 1;
      }
      .card img{
          width: 100%;
          height: 100%;
          object-fit: cover;
          position: absolute;
          left: 0;
          top:0;
          border-radius: 10px;
         opacity: 0.8;
      }
      .card .info{
          position: relative;
          z-index: 3;
          color: #fff;
          opacity: 0;
          transform: translateY(30px);
          transition: 0.5s all;
      }
      .card .info p{
          color: #fff;
      }
      .card:hover .info{
          opacity: 1;
          transform: translateY(0px);
      }
      .btn{
          padding: 10px;
          background: dodgerblue;
          border-radius: 10px;
          text-decoration: none;
          color: #fff;
          border: none;
      }

  </style>
       
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
                
                <?php
                    if(isset($_SESSION['id'])){
                        echo '<li class="bg-cart"><a href="cart.php"><ion-icon name="cart" class="cart-icon"></ion-icon></a></li>';
                    }
                ?>
            </ul>
        </div>
        <i class="fa fa-bars" onclick="showMenu()"></i>
    </nav>
</section>




















<div class="wrapper">
    <div class="card">
        <img src="images/rosebert.jpg" alt="">
        <div class="info">
            <h1>Rosebert</h1>
            <p>Alarcon Jr, Rosebert L. As System Designer</p>
            <a href="https://www.facebook.com/zxcjcz/" class="btn">Visit</a>
        </div>
    </div>

    <div class="card">
        <img src="images/mabel.jpg" alt="">
        <div class="info">
            <h1>Mabell</h1>
            <p>Mabell Dela Soledad As</p>
            <a href="#" class="btn">Visit</a>
        </div>
    </div>
    <div class="card">
        <img src="images/faustino.jpg" alt="">
        <div class="info">
            <h1>Paul Vincent Faustino</h1>
            <p>Jocelyn Haber As</p>
            <a href="https://www.facebook.com/profile.php?id=100008474177562" class="btn">Visit</a>
        </div>
    </div>
    <div class="card">
        <img src="images/haber.jpg" alt="">
        <div class="info">
            <h1>Jocelyn</h1>
            <p>Jocelyn Haber As Project Manager</p>
            <a href="https://www.facebook.com/profile.php?id=100008474177562" class="btn">Visit</a>
        </div>
    </div>

    <div class="card">
        <img src="images/sta.clara.jpg" alt="">
        <div class="info">
            <h1>Andre Paul</h1>
            <p>Andre Paul Sta.Clara As Programmer</p>
            <a href="#" class="btn">Visit</a>
        </div>
    </div>

    <div class="card">
        <img src="images/viene.jpg" alt="">
        <div class="info">
            <h1>Airene</h1>
            <p>Airene Viene As System Analyst</p>
            <a href="https://www.facebook.com/airene.viene.6" class="btn">Visit</a>
        </div>
    </div>
    
    
</div>
























    


<!-- footer starts here -->


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

<?php

require_once 'footer.php';
?>


<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
