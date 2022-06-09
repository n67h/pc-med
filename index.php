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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <title>PC-MED | HOME</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;1,700&family=Oswald:wght@200;300&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="css/landingpage.css">
    <!--<link rel="stylesheet" href="css/style.css">-->

    <style>

        .container{
            position: fixed;
            top: 30%;
            right: 16%;
            z-index: 99;
            display: none;
            animation: move 1s ease-in;
        }
        .card{
            height: 120%;
            box-shadow: 1px 1px 10px 1px rgba(0, 0, 0,0.5);
        }

        @keyframes move {
            50%{transform: scale(1.2);}
            60%{transform: scale(1);}
            70%{transform: scale(1.1);} 
            80%{transform: scale(1);}
            90%{transform: scale(1.1);}
            100%{transform: scale(1);}
        }
        .chat-btn{
            position: fixed;
            z-index: 99999;
            right: 16%;
            top: 90%;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            cursor: pointer;
            text-align: center;
            color: #fff;
            background: #0082c8;
            box-shadow: 1px 1px 10px 1px rgba(0, 0, 0,0.5);
            transition: all 0.3s ease-in;
        }
        .chat-btn:hover{
            background: #667db6;
        }
        .chat-btn ion-icon{
            margin: 10px 11px;
            font-size: 40px;
            
        }
        input[type="checkbox"]{
            display:none ;
        }
        .chatbot:checked ~ .container{
            display:block;
        }
        .chat-title{
            height: 40px;
            width: 100%;
            background: #0089BA;
        }
        .chat-title p{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 6px;
            color: #fff;
            font-size: 20px;
            font-style: italic;
        }
        .card-header{
            background: #0089BA;
        }
        /*========== CHATBOT CSS ==========*/
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

a {
    text-decoration: none;
    color: black;
}

a:hover {
    color: black;
}

.unread {
	cursor: pointer;
	background-color: #f4f4f4;
}

.messages-box {
	max-height: 28rem;
	overflow: auto;
}

.online-circle {
	border-radius: 5rem;
	width: 5rem;
	height: 5rem;
}

.messages-title {
	float: right;
	margin: 0px 5px;
}

.message-img {
	float: right;
	margin: 0px 5px;
}

.message-header {
	text-align: right;
	width: 100%;
	margin-bottom: 0.5rem;
}

.text-editor {
	min-height: 18rem;
}

.messages-list li.messages-you .messages-title {
	float: left;
}

.messages-list li.messages-you .message-img {
	float: left;
}

.messages-list li.messages-you p {
	float: left;
	text-align: left;
}

.messages-list li.messages-you .message-header {
	text-align: left;
}

.messages-list li p {
	max-width: 60%;
	padding: 5px;
	border: #e6e7e9 1px solid;
}

.messages-list li.messages-me p {
	float: right;
}

.ql-editor p {
	font-size: 1rem;
}  

.container {
	margin-right: 0;
	float: right;
	margin-bottom: 0;
}

.card {
	margin-right: 0;
	float: right;
}
.welcome{
    font-size: 40px;
    font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif ;
    padding: 20px;
    margin-left: 10px;
    background: #0082c8;
    width: 40%;
    color: #f4f4f4;
    border-radius: 20px;
    border: 5px solid 
}
    </style>

</head>
<body>

<!-- HEADER -->
<?php

require_once 'header.php'
?>
<!-- HEADER ENDS -->


<!-- 
<p class="welcome">Welcome to PC-MED DATA SOLUTION!</p> -->

<!-- chatbot -->
<?php
    if(isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
?>
        <input type="checkbox" name="haha" id="show" class="chatbot">
		<label for="show" class="chat-btn">
	<ion-icon name="help-outline"></ion-icon>
		</label>
        <div class="container">
            <div class="row justify-content-md-end mb-4">
                <div class="col-md-6">
                    <!--start code-->
                    <div class="card">
											<label for="" class="chat-title">
										<p>Hi, I am your Guide!</p>
										</label>
                        <div class="card-body messages-box">
					        <ul class="list-unstyled messages-list">

							<?php
							$res=mysqli_query($conn,"SELECT * FROM messages WHERE user_id = $id;");
							if(mysqli_num_rows($res)>0){
								$html='';
								while($row=mysqli_fetch_assoc($res)){
									$message = $row['message'];
									$dateCreated = $row['date_added'];
									$strtotime = strtotime($dateCreated);
									$time = date('Y-m-d H:i:s',$strtotime);
									$role = $row['user_role_id'];
									if($role == 1){
										$class="messages-me";
										$name="You";
									}else {
										$class = "messages-you";
										$name = "Chatbot";
									}
									$html.='<li class="'.$class.' clearfix"><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">'.$name.'</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'.$time.'</span></small> </div><p class="messages-p">'.$message.'</p></div></li>';

									$sql = "SELECT * FROM messages WHERE user_role_id = 4 AND date_added = '$dateCreated';";
									$result = mysqli_query($conn, $sql);
									if(mysqli_num_rows($result) > 0) {
										while($row = mysqli_fetch_assoc($result)) {
											$messageBot = $row['message'];
											$dateCreatedBot = $row['date_added'];
											$strtotimeBot = strtotime($dateCreated);
											$timeBot = date('Y-m-d H:i:s',$strtotime);
											$roleBot = $row['user_role_id'];

											$classBot = "messages-you";
											$nameBot = "Chatbot";
											$html.='<li class="'.$classBot.' clearfix"><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">'.$nameBot.'</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'.$timeBot.'</span></small> </div><p class="messages-p">'.$messageBot.'</p></div></li>';
										}
									}
									
								}
								echo $html;
							}else{
								?>
								<li class="messages-me clearfix start_chat">
								   Please start
								</li>
								<?php
							}
							?>
                    
                            </ul>
                        </div>
                            <div class="card-header">
															
                                <div class="input-group">
					                <input id="input-me" type="text" name="messages" class="form-control input-sm" placeholder="Type your message here..." />
					                <span class="input-group-append">
					                <input type="button" class="btn btn-primary" value="Send" onclick="send_msg()">
					                </span>
					            </div> 
                            </div>
                    </div>
                    <!--end code-->
                </div>
            </div>
        </div>
    <?php
        } 
    ?>
<!-- end of chatbot -->




 <!-- Swiper -->
 <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="product-images/mouse/mouse1.jpeg" />
        </div>
        <div class="swiper-slide">
        <img src="product-images/mouse/mouse2.jpeg" />
        </div>
        <div class="swiper-slide">
          <img src="product-images/headset/headset1.jpg" />
        </div>
        <div class="swiper-slide">
        <img src="product-images/headset/headset2.jpg" />
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>

<br>


<style type="text/css">
        .preview{
            max-width: 80%;
            margin-left: 10%;
            border-radius: 5px;

        }
        .preview .sub-preview{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 3em;
            flex-shrink: 1;

            }

        .sub-preview img{
            margin-top: 20px;
            position: relative;
            max-height: 15em;
            max-width: 20em;
            border: 2px solid dodgerblue;
            transition: 0.5s;
            border-radius: 10px;
        }
         .sub-preview img:hover{
            transform: scale(1.1);
            box-shadow:0 0 50px 0px dodgerblue;
         }
        .sub-preview li{
            list-style: none;
        }
</style>
<section class="preview">
    <ul class="sub-preview">
        <li><a href="#"><img src="product-images/mouse/mouse1.jpeg"></a></li>
        <li><a href="#"><img src="product-images/mouse/mouse2.jpeg"></a></li>
        <li><a href="#"><img src="product-images/headset/headset1.jpg"></a></li>
        <li><a href="#"><img src="product-images/headset/headset2.jpg"></a></li>

    </ul>
</section>

 <!-- sub-slideshow ends -->









    <!-- service -->
<section class="service" id="service">
    <h1>Services We Offered</h1>
    <p>Good day, We also avail of servicing! Just contact us and provide proper information.</p>

    <div class="row">
        <div class="service-col">
            <a href="service-reservation.php?serviceid=1"><h3>SOFTWARE INSTALLATION</h3></a>
            <a href="service-reservation.php?serviceid=1"><p>We provide software installation.</p></a>

        </div>
        <div class="service-col">
            <a href="service-reservation.php?serviceid=2"><h3>HARDWARE INSTALLATION</h3></a>
            <a href="service-reservation.php?serviceid=2"><p>We provide software installation</p></a>
        </div>
        <div class="service-col">
        <a href="service-reservation.php?serviceid=3"><h3>TROUBLESHOOTING</h3></a>
            <a href="service-reservation.php?serviceid=3"><p>If you are having problem about troubleshooting, just contact us.</p></a>
        </div>
    </div>
</section>

    <!-- service ends here -->





<!-- TOP SELLING PRODUCTS STARTS -->
<h1 class="top_products" id="top_products">TOP SELLING PRODUCTS</h1>
<section class="products">

    <?php
            $sql = "SELECT product_id, SUM(quantity) AS most_ordered FROM orders GROUP BY (product_id) ORDER BY (most_ordered) DESC LIMIT 6;
            ";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)){
                while($row = mysqli_fetch_assoc($result)){
                    $product_id = $row['product_id'];
                    $most_ordered = $row['most_ordered'];

                    $sql2 = "SELECT * FROM product WHERE product_id = $product_id;";
                    $result2 = mysqli_query($conn, $sql2);
                    if(mysqli_num_rows($result2) > 0) {
                        while($row2 = mysqli_fetch_assoc($result2)){
                            $prod_id = $row2['product_id'];
                            $image = $row2['image'];
                            $name = $row2['name'];
                            $price = $row2['price'];
                            $specification = $row2['specification'];
                            
                            echo '<div class="top-products">';
                            echo '<img src="admin/' .$image. '">';
                            echo '<p class="item_title">' .$name. '</p>';
                            echo '<p>Price: ' .$price. '</p>';

                            echo '</div>';
                        }
                    }

                }
            }
        ?>




        
    <!-- <div class="top-products">
        <img src="product-images/mouse/mouse2.jpeg">
        <p class="item_title">PHILIPS 3-Button Wired Computer</p>
        <p>Price: ₱499</p>
       <button class="button" id="btn2">Show Description</button> 

             <dialog class="modal2">
            <h1>PHILIPS 3-Button Wired Compute </h1>
            <img src="product-images/mouse/mouse2.jpeg">
            <h3>Description:</h3>
            <p>Experience the comfort, control and reliability that could only come from a Philips®-designed USB mouse, crafted with a focus on precision and accuracy. Whether you’re researching, writing, responding or working, the SPK9314 performs with the reliability you demand — all with plug-and-play convenience. No additional software required. Fully compatible with Windows XP, Vista, 7, 8 and 10, as well as Linux and most game consoles.</p>
            <button class="button" id="close2">Close</button>
        </dialog>

    </div>
    <div class="top-products">
        <img src="product-images/Keyboard/keyboard1.jpg">
        <p class="item_title">Steelseries Apex Gaming Keyboard</p>
        <p>Price: ₱400</p>
        <button class="button" id="btn3">Show Description</button>   


             <dialog class="modal3">
            <h1>Steelseries Apex Gaming Keyboard </h1>
            <img src="product-images/Keyboard/keyboard1.jpg">
            <h3>Description:</h3>
            <p>The Steelseries engine allows the user to go beyond simple lighting and allows choosing from 16.8 Million colors. The Apex features SteelSeries ActiveZone lighting, a visual support tool allowing the user to independently customize each of its 5 zones and in multiple macro layers.</p>
            <button class="button" id="close3">Close</button>
        </dialog>


    </div>
     <div class="top-products">
        <img src="product-images/Keyboard/keyboard2.jpg">
        <p class="item_title">
HP Omen Spacer Wireless TKL Keyboar</p>
        <p>Price: ₱500</p> 
        <button class="button" id="btn4">Show Description</button>  


             <dialog class="modal4">
            <h1>
HP Omen Spacer Wireless TKL Keyboar</h1>
             <img src="product-images/Keyboard/keyboard2.jpg">
            <h3>Description:</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <button class="button" id="close4">Close</button>
        </dialog>




    </div>
     <div class="top-products">
        <img src="product-images/headset/headset1.jpg">
        <p class="item_title">Nyko Core Wired Stereo Gaming Headset</p>
        <p>Price: ₱1113.17</p>
         <button class="button" id="btn5">Show Description</button>



            <dialog class="modal5">
            <h1>Nyko Core Wired Stereo Gaming Headset</h1>
            <img src="product-images/headset/headset1.jpg">
            <h3>Description:</h3>
            <p><li> 40mm Drivers</li>
           <li> Omnidirectional Retractable Microphone</li>
               <li> Adjustable Headband & Cushioned Earcups </li>
           <li>Inline Volume and Mute Controls</li>
       <li> LED Lights</li>
 <li> 3.5mm Audio Connector</li>
 <li> USB Connector for LED Power.</li></p>
            <button class="button" id="close5">Close</button>
        </dialog>
    </div>
     <div class="top-products">
        <img src="product-images/headset/headset2.jpg">
        <p class="item_title">Pacrate Gaming Headset for PS4 PC Xbox</p>
        <p>Price: ₱1355.85</p>
         <button class="button" id="btn6">Show Description</button>  


            <dialog class="modal6">
            <h1>Pacrate Gaming Headset for PS4 PC Xbox </h1>
            <img src="product-images/headset/headset2.jpg">
            <h3>Description:</h3>
            <p><li>【Multi-platform Compatibility】Our Gaming Headset with Microphone supports PS4, PS5, PS4 Pro / Slim, Xbox One, Xbox One X controller, Nintendo Switch/3DS, PSP, PC, laptop, tablet, mobile phone and most other devices with 3.5 mm audio jack. NOTE: Xbox One s needs an additional adapter(NOT INCLUDED) to support. USB interface is used for LED lights ONLY. For mic setting tips, please contact our Customer Support Team and we will offer help within 24 hours.</li>
        <li>【True Surround Sound Experience】Our PS4 Headset offers excellent 40 mm audio drivers in combination with advanced audio technology. It delivers high quality simulated surround sound to make the gaming experience even more intense. With the responsive audio drivers, you can better see the direction the sound is coming from, such as the fire, your opponent's steps, and scenario indicators.</li>
    <li>【Noise Cancelling and Sensitive Microphone for Real-time Clear Chat】Our Headset has a sensitive, adjustable microphone with noise-canceling techniques. It filters out most of the ambient noise in your area and enables real-time conversations without delay. Anti-static technology in gaming headphones prevents static noise from occurring.</li>
<li>【Ergonomic Fit】Our Xbox One Headset with Microphone has an ergonomically optimized fit. The padded headband, the soft and resistant ear pads and the individually adjustable microphone ensure maximum comfort. Even after intensive use for hours, the faux leather padding and headband sit comfortably firmly without hurting.</li>
<li>【12-Month Customer Service】Each of our gaming headphones has gone through a strict quality test before shipping. If there are any problems with our headset within 12 months, please do not hesitate to contact us seller and we are always here to offer you a satisfying solution.</li></p>
            <button class="button" id="close6">Close</button>
        </dialog>

    </div> -->
</section>
<!-- TOP SELLING PRODUCTS ENDS HERE-->

<style>
    #feedbacks {
        display: flex;
        flex-direction: column;
        gap: 2em;
    }
    #feedbacks h3{
        font-size: 40px;
        color: #999;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        font-style: italic;
        border-top: 2px solid #777;
        z-index: 999;
    }

    .feedbacks {
        border: 2px solid #0089BA;
        border-radius: 10px;
        max-height: 240px;
        overflow: hidden;
		overflow-y: scroll;
        background: #0089BA;
        text-align: center;
        width: 65%;
        transform: translate(30%,-10%);
        transition: 0.4s;
    }
    .feedbacks:hover{
        box-shadow: 0px 0px 30px #0089BA;
    }
    .feedbacks p{
        color: #fff;
    }
.feedbacks  .name{
    font-size: 30px;
    font-weight: 600;
    font-style: italic;
    text-transform: capitalize;

}
.feedbacks .comments{


}
    .profile_img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }

    #feedback-button {
        margin-left: 30%;
        padding: 15px;
        border: none;
        background: #2C73D2;
        color: #fff;
        border-radius: 30px;
        width: 50%;
        font-size: 15px;
        transition: 0.5s;
        outline: none;
    }

    #feedback-button:hover {
        cursor: pointer;
        opacity: 0.5;
    }
</style>

<div id="feedbacks">
        <?php
            $sql = "SELECT users.f_name, users.l_name, users.email, users.profile_img, feedback.* FROM users INNER JOIN feedback USING (user_id) WHERE feedback.is_deleted != 1 ORDER BY feedback_id DESC LIMIT 3;";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $f_name = $row['f_name'];
                    $l_name = $row['l_name'];
                    $email = $row['email'];
                    $profile_img = $row['profile_img'];
                    $feedback = $row['feedback'];
                    $date_added = $row['date_added'];
                    $user_id = $row['user_id'];

                    echo '<div class="feedbacks">';
                    if($profile_img == 1) {
                        $fileName = 'profile-pictures/profile' .$user_id. '.*';
                        $fileInfo = glob($fileName);
                        $fileExt = explode(".", $fileInfo[0]);
                        $fileActualExt = $fileExt[1];
                        echo '<img src="profile-pictures/profile' .$user_id. '.' .$fileActualExt. '?' .mt_rand(). '" alt="" class="profile_img">';

                    }else {
                        echo '<img src="profile-pictures/profile-picture-default.png" alt="" class="profile_img">';
                        echo '<br><br>';
                    }
                    echo '<p class="name">' .$f_name.  ' ' .$l_name. '</p>';
                    echo '<p class="comments">' .$feedback. '</p>';
                    echo '</div>';
                }
            }else{
                echo 'There are no feedbacks!';
            }
        ?>
</div><br>
<button id="feedback-button">Show more feedbacks</button>







<!-- CTA start here -->
<section class="cta" id="cta">
    <h1>
       Come Visit our Store 
    </h1>
    <a href="contact.php" class="button">Contact Us</a>
</section>
<!-- CTA ends here -->


<!-- footer starts here -->
<?php
require_once 'footer.php'
?>

<!-- footer ends here -->
    
    <!-- ajax feedback -->
    <script>
        $(document).ready(function() {
            var feedbackCount = 3;
            $("#feedback-button").click(function() {
                feedbackCount = feedbackCount + 3;
                $("#feedbacks").load("load-feedbacks.php", {
                    feedbackNewCount: feedbackCount
                });
            });
        });
    </script>
    <!-- ajax feedback end -->

    <!-- JAVASCRIPT FOR TOGGLE BUTTON -->
    <script>
    var navLinks = document.getElementById("navLinks");
    function showMenu(){
        navLinks.style.right = "0";
    }
    function hideMenu(){
        navLinks.style.right = "-200px";
    }

    const modal = document.querySelector('.modal1');
    const modal2 = document.querySelector('.modal2');
    const modal3 = document.querySelector('.modal3');
    const modal4 = document.querySelector('.modal4');
    const modal5 = document.querySelector('.modal5');
    const modal6 = document.querySelector('.modal6');
    const openModal = document.querySelector('#btn1');
    const openModal2 = document.querySelector('#btn2');
    const openModal3 = document.querySelector('#btn3');
    const openModal4= document.querySelector('#btn4');
    const openModal5= document.querySelector('#btn5');
    const openModal6= document.querySelector('#btn6');
    const closeModal = document.querySelector('#close1');
    const closeModal2 = document.querySelector('#close2');
    const closeModal3 = document.querySelector('#close3');
    const closeModal4 = document.querySelector('#close4');
    const closeModal5 = document.querySelector('#close5');
    const closeModal6 = document.querySelector('#close6')

    openModal.addEventListener('click' ,() =>{
    modal.showModal();
    })
    closeModal.addEventListener('click',()=>{
    modal.close();
    })

    openModal2.addEventListener('click',()=>{
    modal2.showModal();
    })
    closeModal2.addEventListener('click',()=>{
    modal2.close();
    })
    openModal3.addEventListener('click',()=>{
    modal3.showModal();
    })
    closeModal3.addEventListener('click',()=>{
    modal3.close();
    })
     openModal4.addEventListener('click',()=>{
    modal4.showModal();
    })
      closeModal4.addEventListener('click',()=>{
        modal4.close();
    })
   openModal5.addEventListener('click',()=>{
        modal5.showModal();
    })
      closeModal5.addEventListener('click',()=>{
        modal5.close();
    })
     openModal6.addEventListener('click',()=>{
        modal6.showModal();
    })
      closeModal6.addEventListener('click',()=>{
        modal6.close();
    })
    

// let counter = 1
//     // get the Button
// var mybutton = document.getElementById('#myBtn');


// // When the user scrolls down 20px from the top of the document, show the button
// window.onscroll = function() {scrollFunction()};


// function scrollFunction(){
//     if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20){
//         mybutton.style.display ="block";
//     }else{
//         mybutton.style.display ="none";
//     }
// }
// // When the user clicks on the button, scroll to the top of the document
// function topFunction(argument) {
//     // body...
//     document.body.scrollTop =0;
//     document.documentElement.scrollTop=0;
// }
</script>




<!-- SCRIPTS FOR CHATBOT -->
<script type="text/javascript">
		function getCurrentTime(){
            var now = new Date();
			var hh = now.getHours();
			var min = now.getMinutes();
			var ampm = (hh>=12)?'PM':'AM';
			hh = hh%12;
			hh = hh?hh:12;
			hh = hh<10?'0'+hh:hh;
			min = min<10?'0'+min:min;
			var time = hh+":"+min+" "+ampm;
			return time;
        }

        function send_msg(){
            jQuery('.start_chat').hide();
			var txt=jQuery('#input-me').val();
			var html='<li class="messages-me clearfix"><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">Me</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'+getCurrentTime()+'</span></small> </div><p class="messages-p">'+txt+'</p></div></li>';
			jQuery('.messages-list').append(html);
			jQuery('#input-me').val('');
			if(txt){
				jQuery.ajax({
					url:'bot-message.php',
					type:'post',
					data:'txt='+txt,
					success:function(result){
						var html='<li class="messages-you clearfix"><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">Chatbot</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'+getCurrentTime()+'</span></small> </div><p class="messages-p">'+result+'</p></div></li>';
						jQuery('.messages-list').append(html);
						jQuery('.messages-box').scrollTop(jQuery('.messages-box')[0].scrollHeight);
					}
				});
			}
		}
</script>
<!-- END OF CHATBOT SCRIPTS -->


<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
       var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
      
</script>

<!-- mga import ni alarcon -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>