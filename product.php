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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>PC-MED | PRODUCTS</title>
    <!-- ajax -->

<?php
    require_once 'header-product.php';
?>
<style>
.search-input{
    min-width: 20%;
    outline: none;
    border: 2px solid #999;
    padding: 7px;
}
.search-input[type=text]:focus{
    border-color: dodgerblue;
    box-shadow: 0 0 8px 0 dodgerblue;
}
.search-header-btn{
    padding: 7px;
    border: 2px solid dodgerblue;
    cursor: pointer;
    background: dodgerblue;
}

.search-bar{
    display: flex;
    justify-content: center;
    align-items: center;
    color:aliceblue
}
.search-bar ion-icon{
    color: #fff;
}

</style>
    <form action="product.php" method="get">
        <div class="search-bar">
            <input type="text" name="productsearch" placeholder="Search here" class="search-input">
            <button type="submit" class="search-header-btn"><ion-icon name="search-outline"></ion-icon></button>
        </div>
    </form>




<!-- HEADER ENDS -->
<style>
    .image-modal {
        height: 30%;
        width: 30%;
    }
</style>
<!-- PRODUCTS STARTS -->
<section class="products">
    <?php
    if(isset($_SESSION['id'])){
        $session_id = $_SESSION['id'];

        $sql_id = "SELECT * FROM users WHERE user_id = $session_id;";
        $result_id = mysqli_query($conn, $sql_id);
        if(mysqli_num_rows($result_id) > 0) {
            while($row_id = mysqli_fetch_assoc($result_id)) {
                $user_id = $row_id['user_id'];
            }
        }
        
    }
    ?>
    
    <div id="test-count">

    </div>

    <?php
        $limit = 9;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        $sql = "SELECT * FROM product ORDER BY product_id DESC LIMIT $start, $limit;";

        if(isset($_GET['productsearch'])){
            $product_search = $_GET['productsearch'];
            $resultCount = $conn->query("SELECT count(product_id) AS product_id FROM product WHERE CONCAT(name, specification, price) LIKE '%$product_search%';");
            $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
            $total = $totalCount[0]['product_id'];
            $pages = ceil($total / $limit);

            $previousPage = $page - 1;
            $nextPage = $page + 1;

            $sql_search = "SELECT * FROM product WHERE CONCAT(name, specification, price) LIKE '%$product_search%' ORDER BY product_id DESC LIMIT $start, $limit;";

            $result_search = mysqli_query($conn, $sql_search);
            if(mysqli_num_rows($result_search) > 0) {
                while($row_search = mysqli_fetch_assoc($result_search)) {
                    $product_id = $row_search['product_id'];
                    $name = $row_search['name'];
                    $image = $row_search['image'];
                    $price = $row_search['price'];
                    $specification = $row_search['specification'];
                    $quantity = $row_search['quantity'];

                    echo '<div class="top-products">';
                echo '<form action="" method="post">';
                echo '<img src="admin/' .$image. '">';
                echo '<p class="item_title">' .$name. '</p>';
                echo '<p class="price">&#8369;' .$price. '</p>';
                
                echo '<button type="button" name="" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit' .$product_id. '" id="description-btn">Show Description</button><br>';
                echo '<input type="number" name="quantity" id="" class="qty"><br><br>';
                if($quantity <= 10){
                    echo '<button type="submit" id="cart-button" name="' .$product_id. '" class="button" disabled>Add to cart</button><br><br>';
                    echo '<h6>Out of Stock</h6>';
                }else {
                    echo '<button type="submit" id="cart-button" name="' .$product_id. '" class="button">Add to cart</button><br><br>';
                }
                echo '</form>';
                
                echo '</div>';//div top-products


?>
                    <!-- Modal Edit Start -->
                    <div class="modal fade" tabindex= "-1" id="modal-edit<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%; ">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4><?php echo $name ?></h4>
                                </div>

                                <div class="modal-body">
                                    <img src="<?php echo $image; ?>" alt="" class="image-modal">
                                    <p>Price: <?php echo $price; ?></p>
                                    <p>Specifications: </p>
                                    <p><?php echo $specification; ?></p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php
                
                if(isset($_POST[$product_id])) {
                    if(!isset($_SESSION['id'])) {
                        echo '<script>swal("Please Log In!");</script>';
                    } else {
                        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
                        

                        function productExists($conn, $product_id, $user_id) {
                            $sql = "SELECT * FROM cart WHERE product_id = ? AND user_id = ?;";
                            $stmt = mysqli_stmt_init($conn);
                    
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                
                            }
                    
                            mysqli_stmt_bind_param($stmt, "ii", $product_id, $user_id);
                            mysqli_stmt_execute($stmt);
                    
                            $resultData = mysqli_stmt_get_result($stmt);
                    
                            if($row = mysqli_fetch_assoc($resultData)) {
                                return $row;
                            } else {
                                $result = false;
                                return $result;
                            }
                    
                            mysqli_stmt_close($stmt);
                        }

                        if(productExists($conn, $product_id, $user_id) !== false) {
                            $query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id;";
                            if(mysqli_query($conn, $query) === true) {
                                echo '<script>swal("Cart updated successfully!", "", "success");</script>';
                            }
                        } else {
                            $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity);";       
                            
                            if(mysqli_query($conn, $query) === true) {
                                echo '<script>swal("Product added successfully!", "", "success");</script>';
                            }    
                        }
                    }
                }  
                }//end of while loop fetch assoc search
            }else {
                echo '<h1>No result found</h1>';
            }
        }elseif(isset($_GET['category'])){
            $cat = $_GET['category'];

            $resultCount = $conn->query("SELECT count(product_id) AS product_id FROM product WHERE product_category_id = $cat;");
            $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
            $total = $totalCount[0]['product_id'];
            $pages = ceil($total / $limit);

            $previousPage = $page - 1;
            $nextPage = $page + 1;

            $sql_cat = "SELECT * FROM product WHERE product_category_id = $cat ORDER BY product_id DESC;";

            $result_cat = mysqli_query($conn, $sql_cat);
                if(mysqli_num_rows($result_cat) > 0) {
                    while($row_cat = mysqli_fetch_assoc($result_cat)) {
                        $product_id = $row_cat['product_id'];
                        $name = $row_cat['name'];
                        $image = $row_cat['image'];
                        $price = $row_cat['price'];
                        $specification = $row_cat['specification'];
                        $quantity = $row_cat['quantity'];

                        echo '<div class="top-products">';
                echo '<form action="" method="post">';
                echo '<img src="admin/' .$image. '">';
                echo '<p class="item_title">' .$name. '</p>';
                echo '<p class="price">&#8369;' .$price. '</p>';
                echo '<button type="button" name="" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit' .$product_id. '" id="description-btn">Show Description</button><br>';
                echo '<input type="number" name="quantity" id="" class="qty"><br><br>';
                if($quantity <= 10){
                    echo '<button type="submit" id="cart-button" name="' .$product_id. '" class="button" disabled>Add to cart</button><br><br>';
                    echo '<h6>Out of Stock</h6>';
                }else {
                    echo '<button type="submit" id="cart-button" name="' .$product_id. '" class="button">Add to cart</button><br><br>';
                }
                echo '</form>';
                
                echo '</div>';//div top-products


?>
                    <!-- Modal Edit Start -->
                    <div class="modal fade" tabindex= "-1" id="modal-edit<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%; ">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4><?php echo $name ?></h4>
                                </div>

                                <div class="modal-body">
                                    <img src="admin/<?php echo $image; ?>" alt="" class="image-modal">
                                    <p>Price: <?php echo $price; ?></p>
                                    <p>Specifications: </p>
                                    <p><?php echo $specification; ?></p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php
                
                if(isset($_POST[$product_id])) {
                    if(!isset($_SESSION['id'])) {
                        echo '<script>swal("Please Log In!");</script>';
                    } else {
                        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
                        

                        function productExists($conn, $product_id, $user_id) {
                            $sql = "SELECT * FROM cart WHERE product_id = ? AND user_id = ?;";
                            $stmt = mysqli_stmt_init($conn);
                    
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                
                            }
                    
                            mysqli_stmt_bind_param($stmt, "ii", $product_id, $user_id);
                            mysqli_stmt_execute($stmt);
                    
                            $resultData = mysqli_stmt_get_result($stmt);
                    
                            if($row = mysqli_fetch_assoc($resultData)) {
                                return $row;
                            } else {
                                $result = false;
                                return $result;
                            }
                    
                            mysqli_stmt_close($stmt);
                        }

                        if(productExists($conn, $product_id, $user_id) !== false) {
                            $query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id;";
                            if(mysqli_query($conn, $query) === true) {
                                echo '<script>swal("Cart updated successfully!", "", "success");</script>';
                            }
                        } else {
                            $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity);";       
                            
                            if(mysqli_query($conn, $query) === true) {
                                echo '<script>swal("Product added successfully!", "", "success");</script>';
                            }    
                        }
                    }
                }  
                    }
                }else {
                    echo '<h1>No result found</h1>';
                }
            
        }else{
            $resultCount = $conn->query("SELECT count(product_id) AS product_id FROM product;");
            $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
            $total = $totalCount[0]['product_id'];
            $pages = ceil($total / $limit);
            
            $previousPage = $page - 1;
            $nextPage = $page + 1;
    
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $product_id = $row['product_id'];
                    $name = $row['name'];
                    $image = $row['image'];
                    $price = $row['price'];
                    $specification = $row['specification'];
                    $quantity = $row['quantity'];
    
                    echo '<div class="top-products">';
                    echo '<form action="" method="post">';
                    echo '<img src="admin/' .$image. '">';
                    echo '<p class="item_title">' .$name. '</p>';
                    echo '<p class="price">&#8369;' .$price. '</p>';
                    echo '<button type="button" name="" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit' .$product_id. '" id="description-btn">Show Description</button><br>';
                    echo '<input type="number" name="quantity" id="" class="qty"><br><br>';
                    if($quantity <= 10){
                        echo '<button type="submit" id="cart-button" name="' .$product_id. '" class="button" disabled>Add to cart</button><br><br>';
                        echo '<h6>Out of Stock</h6>';
                    }else {
                        echo '<button type="submit" id="cart-button" name="' .$product_id. '" class="button">Add to cart</button><br><br>';
                    }
                    echo '</form>';
                    
                    echo '</div>';//div top-products
    
    
    ?>
                        <!-- Modal Edit Start -->
                        <div class="modal fade" tabindex= "-1" id="modal-edit<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%; ">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4><?php echo $name ?></h4>
                                    </div>
    
                                    <div class="modal-body">
                                        <img src="admin/<?php echo $image; ?>" alt="" class="image-modal">
                                        <p>Price: <?php echo $price; ?></p>
                                        <p>Specifications: </p>
                                        <p><?php echo $specification; ?></p>
                                    </div>
    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                <?php
                    
                    if(isset($_POST[$product_id])) {
                        if(!isset($_SESSION['id'])) {
                            echo '<script>swal("Please Log In!");</script>';
                        } else {
                            $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
                            
    
                            function productExists($conn, $product_id, $user_id) {
                                $sql = "SELECT * FROM cart WHERE product_id = ? AND user_id = ?;";
                                $stmt = mysqli_stmt_init($conn);
                        
                                if(!mysqli_stmt_prepare($stmt, $sql)) {
                                    
                                }
                        
                                mysqli_stmt_bind_param($stmt, "ii", $product_id, $user_id);
                                mysqli_stmt_execute($stmt);
                        
                                $resultData = mysqli_stmt_get_result($stmt);
                        
                                if($row = mysqli_fetch_assoc($resultData)) {
                                    return $row;
                                } else {
                                    $result = false;
                                    return $result;
                                }
                        
                                mysqli_stmt_close($stmt);
                            }
    
                            if(productExists($conn, $product_id, $user_id) !== false) {
                                $query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id;";
                                if(mysqli_query($conn, $query) === true) {
                                    echo '<script>swal("Cart updated successfully!", "", "success");</script>';
                                }
                            } else {
                                $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity);";       
                                
                                if(mysqli_query($conn, $query) === true) {
                                    echo '<script>swal("Product added successfully!", "", "success");</script>';
                                }    
                            }
                        }
                    }  
                }//end of while loop
            }//end of if num rows
        }

        
    ?>

                 <!-- Modal -->

                 <br><br><br>
                 <br>
                 
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $page == 1 ? 'disabled':''; ?>"><a class="page-link" href="product.php?page=<?php echo $previousPage; ?>">Previous</a></li>
                    <?php for($i = 1; $i <= $pages; $i++) : ?>
    
                    <li class="page-item"><a class="page-link" href="product.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page == $pages ? 'disabled':''; ?>"><a class="page-link" href="product.php?page=<?php echo $nextPage; ?>">Next</a></li>
                </ul>
            </nav>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



