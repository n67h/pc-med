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
</head>
<body>
<style>
    /* #cart-count {
    background-color: red;
    height: 10px;
    width: 15px;
    border: black
} */
</style>
<!-- HEADER -->
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
                        echo '<li class="bg-cart"><a href="cart.php"><ion-icon name="cart"></ion-icon></a></li>';
                    }
                ?>
            </ul>
        </div>
        <i class="fa fa-bars" onclick="showMenu()"></i>
    </nav>
</section>


<!-- dropdown starts here -->
<div class="maindrop">  
        <ul class="dropdown">
            <h4 style="margin-top:20px ;"><ion-icon name="filter-circle-outline"></ion-icon>Categories</i></h4>
            <div class="list1">
                <ul>
                    <?php
                        $sql = "SELECT * FROM product_category;";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $product_category_id = $row['product_category_id'];
                                $product_category = $row['name'];
                                echo '<li><a href="product.php?category=' .$product_category_id. '" style="text-transform: uppercase;">' .$product_category. '</li>';
                            }
                        }
                    ?>

                </ul>
            </div>
        </ul>

    
             <ul class="dropdown">
            <h4 class="accounts-dropdown"><ion-icon name="person-circle-outline"></ion-icon>Accounts</i></h4>
            <div class="list1">
            <ul>          
                <?php
                    if(isset($_SESSION['id'])){
                        echo '<li><a href="profile.php"">Profile</a></li>';
                    } else {
                        echo '<li><a href="login.php" >Log in</a></li>';
                    }
                    if(isset($_SESSION['id'])){
                        echo '<li><a href="includes/logout.inc.php">Log out</a></li>';
                    } else {
                        echo '<li><a href="register.php" >Register</a></li>';
                    }
                ?>         
            </ul>
            </div>
        </ul>



</div>


<!-- dropdown ends here -->
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


<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>