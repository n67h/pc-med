<!-- footer starts here -->


<section class="footer">
    <?php
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
    ?>
            <div class="footer-form">
                <form action="" method="post">
                    <?php
                        $sql = "SELECT * FROM users WHERE user_id = $id;";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $email = $row['email'];
                            }
                        }
                    ?>
                    <p style="font-style:italic; font-size:13px;">*Fill the all fields for your feeback! Thank you.</p>
                    <input type="text" name="email" placeholder="Enter your Email" required class="footer-input" style="color: #fff;" value="<?php echo $email; ?>" required disabled>
                    <textarea rows="8" name="feedback" placeholder="Write your feedback here..."  class="footer-input" style="resize: none;" required></textarea>
                    <button type="submit" name="submit" class="footer-btn">Send Feedback</button>
                </form>
            </div>
    <?php

            if(isset($_POST['submit'])){
                $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

                if(empty($feedback)){
                    header('location: index.php');
                    die();
                }

                $sql = "INSERT INTO feedback (user_id, feedback) VALUES ($id, '$feedback');";
                mysqli_query($conn, $sql);

            }


        }
    ?>

   <div class="footer_sub">
    <p><a href="index.php">HOME</a>&nbsp;&nbsp;<a href="product.php">PRODUCT</a>&nbsp;&nbsp;<a href="contact.php">CONTACT</a>&nbsp;&nbsp;<a href="about.php">ABOUTUS</a>&nbsp;&nbsp;<a href="service.php">SERVICES</a>&nbsp;&nbsp;<a href="terms.php">TERMS</a></p>

    <div class="icons">
    <i class="fa fa-facebook"></i>
    <i class="fa fa-twitter"></i>
    <i class="fa fa-instagram"></i>
    <i class="fa fa-linkedin"></i>
</div>
<p class="dev">Made with <i class="fa fa-heart-o"></i> by SFIT-2A</p>
</div>
</section>







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