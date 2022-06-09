<!-- dropdown starts here -->
<div class="maindrop">  
        <ul class="dropdown">
            <h4>PERIPHERALS<i class="fa fa-angle-down"></i></h4>
            <div class="list1">
            <ul>
                <li><a href="product.php">ALL</a></li>
                <li><a href="mouse.php">MOUSE</a></li>
                <li><a href="keyboard.php">KEYBOARD</a></li>
                <li><a href="headset.php">HEADSET</a></li>
                <li><a href="printer.php">PRINTERS</a></li>
            </ul>
        
            </div>
        </ul>
               <ul class="dropdown">
            <h4>PC COMPONENTS <i class="fa fa-angle-down"></i></h4>
            <div class="list1">
            <ul>
                <li><a href="motherboard.php">MOTHERBOARD</a></li>
                <li><a href="cpu.php">CPU</a></li>
                <li><a href="#">RAM</a></li>
                <li><a href="#">ROM</a></li>
            </ul>
        
            </div>
        </ul>
                <ul class="dropdown">
            <h4>DISPLAY<i class="fa fa-angle-down"></i></h4>
            <div class="list1">
            <ul>
                <li><a href="#">MONITORS</a></li>
                <li><a href="laptop.php">LAPTOP</a></li>
                <li><a href="#">PC SET</a></li>
            </ul>
            </div>
        </ul>
                <ul class="dropdown">
            <h4>STORAGE<i class="fa fa-angle-down"></i></h4>
            <div class="list1">
            <ul>
                <li><a href="#">SSDs - solid state drive</a></li>
                <li><a href="#">HDDs for computers</a></li>
                <li><a href="#">Memory Card</a></li>
                <li><a href="#">Flash drive</a></li>
            </ul>
        
            </div>
        </ul>
    
             <ul class="dropdown">
            <h4>ACCOUNTS<i class="fa fa-angle-down"></i></h4>
            <div class="list1">
            <ul>
                

                <?php
                    if(isset($_SESSION['id'])){
                        echo '<li><a href="profile.php"">PROFILE</a></li>';
                    } else {
                        echo '<li><a href="login.php" >LOG IN</a></li>';
                    }

                    if(isset($_SESSION['id'])){
                        echo '<li><a href="includes/logout.inc.php">LOG OUT</a></li>';
                    } else {
                        echo '<li><a href="register.php" >REGISTER</a></li>';
                    }

                ?>
                
                
                
            </ul>
        
            </div>
          
        </ul>
        <ul class="dropdown">
        <div class="search-box">
                   <input type="text" class="search-txt" name="" placeholder="Type to search">
                   <a class="search-btn" href="#" ><i class="fa fa-search"></i></a>
                   
               </div> 
                </ul>  
</div>
<!-- dropdown ends here -->