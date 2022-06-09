    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="./vendor/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <link href="./vendor/chartist/css/chartist.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">

            <!-- logo -->
            <a href="dashboard.php" class="brand-logo">
                <h3 id="pc-med" style="color: white;">PC-MED</h3>
                <img class="logo-abbr" src="#" alt="">
                <img class="logo-compact" src="#" alt="">
                <img class="brand-title" src="#" alt="">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
        <!--**********************************
            Header start
        ***********************************-->
        <style>
            #notif-count {
                background-color: #2F80ED;
                border-radius: 50%;
                padding: 3px 5px;
                position: relative;
                top: -10px;
                right: -36px;
            }
            .header{
                color: #fff;
            }


        </style>
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                <!-- <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <i class="mdi mdi-magnify"></i>
                                </span> -->
                                <!-- <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                    </form>
                                </div> -->
                            </div>
                        </div>



                        
                        <!-- dropdown order notification -->
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <?php
                                    $sql_count = "SELECT * FROM order_details WHERE is_read = 0;";
                                    $result_count = mysqli_query($conn, $sql_count);
                                    $notif_count = mysqli_num_rows($result_count);
                                ?>
                                <h4 id="notif-count"><?php echo $notif_count; ?></h4>
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-bell"></i>
                                    
                                    <!-- <div class="pulse-css"></div> -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php
                                        $sql = "SELECT order_details.*, users.f_name, users.l_name FROM users INNER JOIN order_details USING(user_id) WHERE order_details.is_read != 1 AND order_details.is_deleted != 1 ORDER BY order_details_id DESC;";
                                        $result = mysqli_query($conn, $sql);
                                        if(mysqli_num_rows($result) > 0){
                                            while($row = mysqli_fetch_assoc($result)){
                                                $order_details_id = $row['order_details_id'];
                                                $f_name = $row['f_name'];
                                                $l_name = $row['l_name'];
                                                $date_added = $row['date_added'];
                                    ?>
                                                <ul class="list-unstyled">
                                                    <li class="media dropdown-item">
                                                        <div class="media-body">
                                                            <a href="orders.php?orderid=<?php echo $order_details_id; ?>">
                                                                <p>New order from <strong><?php echo $f_name. ' ' .$l_name; ?></strong></p>
                                                            </a>
                                                        </div>
                                                        <span class="notify-time"><?php echo $date_added; ?></span>
                                                    </li>
                                                </ul>
                                    <?php
                                            }//end of while fetch assoc order_details
                                        }else {
                                            echo '
                                            <ul class="list-unstyled">
                                                <li class="media dropdown-item">
                                                    <div class="media-body">
                                                        <p>No new orders</p>
                                                    </div>
                                                </li>
                                            </ul>';
                                        }//end of else of if result num rows order_details
                                    ?>
                                    <!-- <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <div class="media-body">
                                                <a href="#">
                                                    <p>
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                    </ul> -->
                                    <a class="all-notification" href="#">See all notifications <i
                                            class="ti-arrow-right"></i></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <!-- <i class="mdi mdi-account"></i>
                                 -->
                                 <?php
                                            if(isset($_SESSION)){
                                                $idSession = $_SESSION['id'];
                                                $emailSession = $_SESSION['email'];
                                                $roleSession = $_SESSION['user_role_id'];
                                                $sql = "SELECT * FROM users WHERE user_id = $idSession;";
                                                $result = mysqli_query($conn, $sql);
                                                if(mysqli_num_rows($result) > 0) {
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        $user_id = $row['user_id'];
                                                        $email = $row['email'];
                                                        $f_name = $row['f_name'];
                                                        $l_name = $row['l_name'];
                                                        $phone_no = $row['phone_no'];
                                                        $address = $row['address'];
                                                        $profile_img = $row['profile_img'];

                                                        if($profile_img == 1) {
                                                                $fileName = '../profile-pictures/profile' .$user_id. '.*';
                                                                $fileInfo = glob($fileName);
                                                                $fileExt = explode(".", $fileInfo[0]);
                                                                $fileActualExt = $fileExt[1];
                                                                echo '<img src="../profile-pictures/profile' .$user_id. '.' .$fileActualExt. '?' .mt_rand(). '" alt="" class="profile_img">';
                                                                ;
                                                        }else {
                                                            echo '<img src="../profile-pictures/profile-picture-default.png" alt="" class="profile_img">';
                                                            echo '<br><br>';
                                                        }   
                                                    }
                                                }
                                            }
                                        ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="profile.php" class="dropdown-item">
                                        
                                            <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="includes/logout.inc.php" class="dropdown-item">
                                        <i class="icon-key"></i>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="quixnav">
            <div class="quixnav-scroll">
                <ul class="metismenu" id="menu">
                    <!-- <li class="nav-label first">Main Menu</li> -->
                    <!-- <li><a href="index.html"><i class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                    </li> -->
                    <!-- <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                        <ul aria-expanded="false">
                            <li><a href="dashboard.php">Dashboard 1</a></li>
                            <li><a href="#">Dashboard 2</a></li>
                        </ul>
                    </li> -->
                    <li><a href="dashboard.php" aria-expanded="false"><i class="icon icon-globe-2"></i><span class="nav-text">Dashboard</span></a></li>

                    <li><a href="category.php" aria-expanded="false"><i class="fa fa-laptop" aria-hidden="true"></i><span class="nav-text">Categories</span></a></li>

                    <li><a href="product.php" aria-expanded="false"><i class="fa fa-desktop" aria-hidden="true"></i><span class="nav-text">Products</span></a></li>

                    <li><a href="orders.php" aria-expanded="false"> <i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="nav-text">Transactions</span></a></li>

                    <?php 
                        if(isset($_SESSION)){
                            $idSession = $_SESSION['id'];
                            $emailSession = $_SESSION['email'];
                            $roleSession = $_SESSION['user_role_id'];

                            if($roleSession !== 3){

                            }elseif($roleSession == 3){
                                echo '<li><a href="users.php" aria-expanded="false"><i class="fa fa-male" aria-hidden="true"></i><span class="nav-text">Users</span></a></li>';
                            }
                        }
                    ?>
                    <li><a href="service-offered.php" aria-expanded="false"><i class="fa fa-wrench" aria-hidden="true"></i><span class="nav-text">Services</span></a></li>


                    <li><a href="service.php" aria-expanded="false"><i class="fa fa-wrench" aria-hidden="true"></i><span class="nav-text">Service Reservation</span></a></li>
                    
                    <?php 
                        if(isset($_SESSION)){
                            $idSession = $_SESSION['id'];
                            $emailSession = $_SESSION['email'];
                            $roleSession = $_SESSION['user_role_id'];

                            if($roleSession !== 3){

                            }elseif($roleSession == 3){
                                echo '<li><a href="feedback.php" aria-expanded="false"><i class="fa fa-comments" aria-hidden="true"></i><span class="nav-text">Feedback</span></a></li>';
                            }
                        }
                    ?>
                    

                    
                    <li><a href="includes/logout.inc.php" aria-expanded="false"><i class="fa fa-sign-out" aria-hidden="true"></i><span class="nav-text">Log out</span></a></li>

                    <!-- <li class="nav-label">Apps</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-app-store"></i><span class="nav-text">Apps</span></a>
                        <ul aria-expanded="false">
                            <li><a href="#">Testing</a></li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Profile</a>
                                <ul aria-expanded="false">
                                    <li><a href="#">Bogart</a></li>
                                    <li><a href="#">Pederico</a></li>
                                    <li><a href="#">Pedring</a></li>
                                </ul>
                            </li>
                            <li><a href="./app-calender.html">Test Test</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-chart-bar-33"></i><span class="nav-text">Charts</span></a>
                        <ul aria-expanded="false">
                            <li><a href="#">Testtest1</a></li>
                            <li><a href="#">Testtest2</a></li>
                        </ul>
                    </li> -->
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->