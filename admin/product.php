<?php
    require_once 'includes/session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- latest jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- latest bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- font awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- bootstrap js -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script><script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<?php
    require_once 'sidebar.php';
?>
<style>
    .content-body {
        margin-left: 20%;
        margin-right: 5%;
    }

    .form-label {
        color: black;
    }
    
    .input-group {
        width: 40%;
    }

    .form-record {
        width: 40%;
    }

    .add-product-open-button{
        padding: 15px;
        border-radius: 5px;
        background:#6610f2;
        border: none;
        color: #fff;
        border: 1px solid #6610f2;
        transition: all 0.3s ease-in-out;
    }
    .add-product-open-button:hover{
        background: #673BB7;
        color: #fff;
        border: 1px solid #444;
    }
    table{
        background: #fff;
    }

    /* .table {
        margin-left: 5%;
        width: 90%;
    } */
</style>
<div class="content-body">
    <?php
        $sql = "SELECT * FROM users WHERE user_id = $idSession AND user_role_id = 3 OR user_role_id = 2 AND is_deleted = 0;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){

                $f_name = $row['f_name'];
                echo '<br><br>';


                // icon for add user, tinanggal ko muna, ibalik mo nalang
                // <i class="fa fa-user-circle-o" aria-hidden="true"></i>

                $product_category_error = " *";
                    $product_category_val = "";
                    $product_category_success = "";

                    $image_error = " *";
                    $image_val = "";
                    $image_success = "";

                    $product_name_error = " *";
                    $product_name_val = "";
                    $product_name_success = "";

                    $category_error = " *";
                    $category_val = "";
                    $category_success = "";

                    $specification_error = " *";
                    $specification_val = "";
                    $specification_success = "";

                    $price_error = " *";
                    $price_val = "";
                    $price_success = "";

                    $quantity_error = " *";
                    $quantity_val = "";
                    $quantity_success = "";

                    $warranty_error = " *";
                    $warranty_val = "";
                    $warranty_success = "";

                    if(isset($_POST['submit'])) {
                        $product_category = mysqli_real_escape_string($conn, $_POST['product_category']);
                        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
                        $specification = mysqli_real_escape_string($conn, $_POST['specification']);
                        $price = mysqli_real_escape_string($conn, $_POST['price']);
                        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
                        $warranty = mysqli_real_escape_string($conn, $_POST['warranty']);

                        if($product_category == 'none') {
                            $product_category_error = ' This field is required';
                        }else {
                            $product_category_error = '';
                            $product_category_val = $product_category;
                            $product_category_success = ' <i class="fa fa-check-circle" aria-hidden="true" style="color: green;"></i>';
                        }

                        if(empty($product_name)) {
                            $product_name_error = ' This field is required';
                        }else {
                            $product_name_error = '';
                            $product_name_val = $product_name;
                            $product_name_success = ' <i class="fa fa-check-circle" aria-hidden="true" style="color: green;"></i>';
                        }

                        if(empty($specification)){
                            $specification_error = ' This field is required';
                        }else{
                            $specification_error = '';
                            $specification_val = $specification;
                            $specification_success = ' <i class="fa fa-check-circle" aria-hidden="true"></i>';
                        }

                        if(empty($price)) {
                            $produc_error = ' This field is required';
                        }else {
                            $price_error = '';
                            $price_val = $price;
                            $price_success = ' <i class="fa fa-check-circle" aria-hidden="true" style="color: green;"></i>';
                        }

                        if(empty($quantity)) {
                            $quantity_error = ' This field is required';
                        }else {
                            $quantity_error = '';
                            $quantity_val = $quantity;
                            $quantity_success = ' <i class="fa fa-check-circle" aria-hidden="true" style="color: green;"></i>';
                        }

                        if(empty($warranty)) {
                            $warranty_error = ' This field is required';
                        }else {
                            $warranty_error = '';
                            $warranty_val = $warranty;
                            $warranty_success = ' <i class="fa fa-check-circle" aria-hidden="true" style="color: green;"></i>';
                        }

                        if($product_category !== 'none' && !empty($product_name) && !empty($specification) && !empty($price) && !empty($quantity) && !empty($warranty)) {
                            
                            $file = $_FILES['image'];
                            $fileName = $_FILES['image']['name'];
                            $fileTmpName = $_FILES['image']['tmp_name'];
                            $fileSize = $_FILES['image']['size'];
                            $fileError = $_FILES['image']['error'];
                            $fileType = $_FILES['image']['type'];
                    
                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));
                    
                            $allowed = array('jpg', 'jpeg', 'png');
                    
                            if(in_array($fileActualExt, $allowed)) {
                                if($fileError === 0) {
                                    if($fileSize < 5000000) {
                                        
                                        $sql_category = "SELECT * FROM product_category WHERE product_category_id = $product_category;";
                                        $result_category = mysqli_query($conn, $sql_category);
                                        if(mysqli_num_rows($result_category) > 0) {
                                            while($row_category = mysqli_fetch_assoc($result_category)) {
                                                $category_name = $row_category['name'];

                                                $six_digit_random_number = random_int(100000, 999999);

                                                $fileNameNew = $six_digit_random_number. "." .$fileActualExt;
                                                $fileDestination = "product-images/" .$category_name. "/" .$fileNameNew;
                                                move_uploaded_file($fileTmpName, $fileDestination);
                                                                        
                                                $sql = "INSERT INTO product (product_category_id, name, image, specification, price, quantity, warranty) VALUES ($product_category, '$product_name', '$fileDestination','$specification', $price, $quantity, '$warranty');";
                                                $result = mysqli_query($conn, $sql);

                                                
                                                // header('location: product-admin.php?addedsuccessfully');
                                                // die();
                                            }
                                        }


                                    }else {
                                        echo 'Your file is too big.';
                                    }
                                }else {
                                    echo 'There was an error uploading your file.';
                                }
                            }else {
                                echo 'You cannot upload files of this type.';
                            }
                        }
                    }//end of isset submit add product
                    ?>

                        <!-- Button edit trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-user">
                        Add Product
                        </button>

                        <!-- Modal Add Start -->
                        <div class="modal fade" id="modal-add-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 1%;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>Add Product</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>


                                    <div class="modal-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                        
                                        <!-- product category -->
                                        <label for="form-select-category" class="form-label">Category<span class="error" style="color:red"><?php echo $product_category_error ?></span><span class="success" style="color: green;"><?php echo $product_category_success ?></span></label>
                                        <select class="form-select" name="product_category" id="form-select-category" aria-label="Default select example">
                                        <option value="none" selected="selected">-- Select --</option>
                                    <?php
                                        $sql = "SELECT * FROM product_category";
                                        $result = mysqli_query($conn, $sql);
                                        if(mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $product_category_id = $row['product_category_id'];
                                                $product_category_name = $row['name'];

                                                echo '<option value="' .$product_category_id. '">' .$product_category_name. '</option>';

                                                if(isset($_POST['product_category'])) {
                                                    if($_POST['product_category'] == $product_category_id) {
                                                        echo '<option value="' .$product_category_id. '" selected="selected">' .$product_category_name. '</option>';
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                        </select>
                                        <br>

                                        <!-- product name -->
                                        <div class="mb-3">
                                            <label for="product_name" class="form-label">Product name<span class="error" style="color:red"><?php echo $product_name_error ?></span><span class="success" style="color: green;"><?php echo $product_name_success ?></span></label>
                                            <input type="text" name="product_name" class="form-control" id="product_name" placeholder="" value="<?php echo $product_name_val; ?>">
                                        </div>

                                        <!-- image -->
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Image</label>
                                            <input type="file" name="image" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                        </div>

                                        <!-- specification -->
                                        <div class="mb-3">
                                            <label for="specification" class="form-label">Specification<span class="error" style="color:red"><?php echo $specification_error ?></span><span class="success" style="color: green;"><?php echo $specification_success ?></span></label>
                                            <textarea class="form-control" name="specification" id="specification" rows="3" style="resize: none;"><?php echo $specification_val; ?></textarea>
                                        </div>

                                        <!-- price -->
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price<span class="error" style="color:red"><?php echo $price_error ?></span><span class="success" style="color: green;"><?php echo $price_success ?></span></label>
                                            <input type="number" name="price" class="form-control" id="price" placeholder="" value="<?php echo $price_val; ?>">
                                        </div>

                                        <!-- quantity -->
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity<span class="error" style="color:red"><?php echo $quantity_error ?></span><span class="success" style="color: green;"><?php echo $quantity_success ?></span></label>
                                            <input type="number" name="quantity" class="form-control" id="quantity" placeholder="" value="<?php echo $quantity_val; ?>">
                                        </div>

                                        <!-- warranty -->
                                        <div class="mb-3">
                                            <label for="warranty" class="form-label">Warranty<span class="error" style="color:red"><?php echo $warranty_error ?></span><span class="success" style="color: green;"><?php echo $warranty_success ?></span></label>
                                            <input type="text" name="warranty" class="form-control" id="warranty" placeholder="" value="<?php echo $warranty_val; ?>">
                                        </div>
                                    </div><!-- end of div modal body -->

                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary" name="edit_submit">Add</button>
                                    </form><br>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Modal Add End -->

                <?php
                }//end of while loop for user
                echo '<br>';
                echo '<br>';
                ?>

                    <form action="" method="get">
                        <div class="input-group mb-3">
                            <input type="text" name="search" value="<?php if(isset($_GET['search'])){
                                echo $_GET['search'];
                            }?>" class="form-control" placeholder="Search" required>
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <form action="" method="get">

                        <?php
                        $category_filter = "SELECT * FROM product_category";
                        $category_filter_run = mysqli_query($conn, $category_filter);
                        
                        if(mysqli_num_rows($category_filter_run) > 0){
                            foreach($category_filter_run as $category_list){

                                $checked = [];
                                if(isset($_GET['categories'])){
                                    $checked = $_GET['categories'];
                                }
                                ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="categories[]" type="checkbox" value="<?php echo $category_list['product_category_id']; ?>" id="flexCheckDefault<?php echo $category_list['product_category_id']; ?>"
                                        <?php if(in_array($category_list['product_category_id'], $checked)){
                                            echo 'checked';
                                        }
                                        ?>
                                    />

                                    <label class="form-check-label" for="flexCheckDefault<?php echo $category_list['product_category_id']; ?>">
                                        <?php echo $category_list['name']; ?>
                                    </label>
                                </div>
                                <?php
                            }
                        }else {
                            echo 'No Category found';
                        }
                        
                        ?>
                    <button type="submit" class="btn btn-primary">Filter by Category</button>
                </form>


                    
                    <br><br>
                    <form action="" method="post" id="form-record" class="form-record">
                        <select class="form-select" name="form-select" aria-label="Default select example" id="form-select">
                            <option selected disabled>-- Limit Records --</option>
                            <?php
                                foreach([6, 10, 15, 20] as $recordlimit):
                            ?>
                                <option <?php if(isset($_POST['form-select']) && $_POST['form-select'] == $recordlimit) {
                                    echo 'selected';
                                }?> value="<?php echo $recordlimit; ?>"><?php echo $recordlimit; ?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </form><br>

                    <table class="table table-default">
                        <thead>
                            <tr>
                                <th scope="col">Product ID</th>
                                <th scope="col">Category</th>
                                <th scope="col">Product name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Specification</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Sold</th>
                                <th scope="col">Available</th>
                                <th scope="col">Warranty</th>
                                <th scope="col">Date Added</th>
                                <th scope="col">Last Updated</th>
                                <th scope="col">Operations</th>
                            </tr>
                        </thead>
                        <style>
                            tr{
                            color: black;
                            font-size: 13px;
                            }
                            thead,th{
                                background: #444;
                                color: #fff;
                            }
                        </style>
                <?php
                    $limit = isset($_POST['form-select']) ? $_POST['form-select'] : 6;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $limit;
                    $sql = "SELECT product.product_id, product_category.name AS category, product.name, product.image, product.specification, product.price, product.quantity, product.sold, product.available, product.warranty, product.date_added, product.last_updated FROM product INNER JOIN product_category ON product_category.product_category_id = product.product_category_id ORDER BY product.product_id DESC LIMIT $start, $limit;";
                    // SELECT product.product_id, product_category.name AS category, product.name, product.image, product.description, product.specification, product.price, product.quantity, product.sold, product.available, product.warranty, product.date_added, product.last_updated FROM product INNER JOIN product_category ON product_category.product_category_id = product.product_category_id OR product.product_category_id = IS NULL ORDER BY product.product_id


                    if(isset($_GET['search'])){
                        $search = $_GET['search'];
                        $resultCount = $conn->query("SELECT count(product_id) AS product_id FROM product WHERE CONCAT(name, specification, price, quantity, warranty) LIKE '%$search%';");
                        $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                        $total = $totalCount[0]['product_id'];
                        $pages = ceil($total / $limit);
                        
                        $previousPage = $page - 1;
                        $nextPage = $page + 1;

                        $sql_search = "SELECT product.product_id, product_category.name AS category, product.name, product.image, product.specification, product.price, product.quantity, product.sold, product.available, product.warranty, product.date_added, product.last_updated FROM product INNER JOIN product_category ON product_category.product_category_id = product.product_category_id WHERE CONCAT(product.name, product.specification, product.price, product.quantity, product.warranty) LIKE '%$search%' ORDER BY product.product_id DESC LIMIT $start, $limit;";
                        $result_search = mysqli_query($conn, $sql_search);
                        if(mysqli_num_rows($result_search) > 0){
                            while($row_search = mysqli_fetch_assoc($result_search)){
                                $product_id = $row_search['product_id'];
                                $category = $row_search['category'];
                                $name = $row_search['name'];
                                $image = $row_search['image'];
                                $specification = $row_search['specification'];
                                $price = $row_search['price'];
                                $quantity = $row_search['quantity'];
                                $sold = $row_search['sold'];
                                $available = $row_search['available'];
                                $warranty = $row_search['warranty'];
                                $date_added = $row_search['date_added'];
                                $last_updated = $row_search['last_updated'];

                                echo '<tbody>';
                                echo '<tr>';
                                echo '<td>' .$product_id. '</td>';
                                echo '<td style="text-transform: uppercase;">' .$category. '</td>';
                                echo '<td>' .$name. '</td>';
                                echo '<td><img src="' .$image. '" alt="" height="80px" width="120px"></td>';
                                echo '<td>' .$specification. '</td>';
                                echo '<td>&#8369;' .$price. '</td>';
                                echo '<td>' .$quantity. '</td>';
                                echo '<td>' .$sold. '</td>';
                                echo '<td>' .$available. '</td>';
                                echo '<td>' .$warranty. '</td>';
                                echo '<td>' .$date_added. '</td>';
                                echo '<td>' .$last_updated. '</td>';
                                echo '<td>';
                            ?>



                        <!-- Button edit trigger modal -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $product_id; ?>">
                        <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                        </button>

                        <!-- Modal Edit Start -->
                        <div class="modal fade" id="modal-edit<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>Edit Product</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>


                                    <div class="modal-body">
                                    <form action="includes/edit-product.inc.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">

                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1<?php echo $product_id; ?>" class="form-label">Product Name</label>
                                        <input type="text" name="edit_name" class="form-control" id="exampleFormControlInput1<?php echo $product_id; ?>" placeholder="" value="<?php echo $name; ?>" required>
                                    </div>

                                        <div class="mb-3">
                                            <label for="formFileSm<?php echo $product_id; ?>" class="form-label">Image</label>
                                            <input class="form-control form-control-sm" name="edit_image" id="formFileSm<?php echo $product_id; ?>" type="file">
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1<?php echo $product_id; ?>" class="form-label">Specification</label>
                                            <textarea class="form-control" name="edit_specs" id="exampleFormControlTextarea1<?php echo $product_id; ?>" rows="3" style="resize: none;" required><?php echo $specification; ?></textarea>
                                        </div>

                                        <label for="input-price<?php echo $product_id; ?>" class="form-label">Price</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">&#8369;</span>
                                            <input type="number" name="edit_price" id="input-price<?php echo $product_id; ?>" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" value="<?php echo $price; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleFormControlInput2<?php echo $product_id; ?>" class="form-label">Quantity</label>
                                            <input type="number" name="edit_quantity" class="form-control" id="exampleFormControlInput2<?php echo $product_id; ?>" placeholder="" value="<?php echo $quantity; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleFormControlInput3<?php echo $product_id; ?>" class="form-label">Warranty</label>
                                            <input type="text" class="form-control" name="edit_warranty" id="exampleFormControlInput3<?php echo $product_id; ?>" placeholder="" value="<?php echo $warranty; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="edit_submit">Save changes</button>
                                    </form><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Edit End -->


                        <!-- Button delete trigger modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $product_id; ?>">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>

                        <!-- Modal Delete Start -->
                        <div class="modal fade" id="modal-delete<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Are you sure you want to delete this product?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger"><a href="includes/delete-product.inc.php?id=<?php echo $product_id; ?>" style="color: #fff;">Delete</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Delete End -->
                <?php
                        echo '</td>';
                        echo '</tr>';
                        echo '</tbody>';
                        }//end of while assoc search
                        } else {
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td colspan="13">No record found';
                            echo '</tr>';
                            echo '</tbody>';
                            echo '</table>';
                        }//end of else if num rows search

                    }elseif(isset($_GET['categories'])){
                        $category_checked = [];
                        $category_checked = $_GET['categories'];

                        foreach($category_checked as $row_cat){
                            $resultCount = $conn->query("SELECT count(product_id) AS product_id FROM product WHERE product_category_id IN ($row_cat) ;");
                            $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                            $total = $totalCount[0]['product_id'];
                            $pages = ceil($total / $limit);
                            
                            $previousPage = $page - 1;
                            $nextPage = $page + 1;
    
                            $sql_filter = "SELECT product.product_id, product_category.name AS category, product.name, product.image, product.specification, product.price, product.quantity, product.sold, product.available, product.warranty, product.date_added, product.last_updated FROM product INNER JOIN product_category ON product_category.product_category_id = product.product_category_id WHERE product.product_category_id IN ($row_cat) ORDER BY product.product_id DESC LIMIT $start, $limit;";

                            $result_filter = mysqli_query($conn, $sql_filter);
                            if(mysqli_num_rows($result_filter) > 0){
                                while($row_filter = mysqli_fetch_assoc($result_filter)){
                                    $product_id = $row_filter['product_id'];
                                    $category = $row_filter['category'];
                                    $name = $row_filter['name'];
                                    $image = $row_filter['image'];
                                    $specification = $row_filter['specification'];
                                    $price = $row_filter['price'];
                                    $quantity = $row_filter['quantity'];
                                    $sold = $row_filter['sold'];
                                    $available = $row_filter['available'];
                                    $warranty = $row_filter['warranty'];
                                    $date_added = $row_filter['date_added'];
                                    $last_updated = $row_filter['last_updated'];

                                    echo '<tbody>';
                                    echo '<tr>';
                                    echo '<td>' .$product_id. '</td>';
                                    echo '<td style="text-transform: uppercase;">' .$category. '</td>';
                                    echo '<td>' .$name. '</td>';
                                    echo '<td><img src="' .$image. '" alt="" height="80px" width="120px"></td>';
                                    echo '<td>' .$specification. '</td>';
                                    echo '<td>&#8369;' .$price. '</td>';
                                    echo '<td>' .$quantity. '</td>';
                                    echo '<td>' .$sold. '</td>';
                                    echo '<td>' .$available. '</td>';
                                    echo '<td>' .$warranty. '</td>';
                                    echo '<td>' .$date_added. '</td>';
                                    echo '<td>' .$last_updated. '</td>';
                                    echo '<td>';
                            ?>
                        <!-- Button edit trigger modal -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $product_id; ?>">
                        <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                        </button>

                        <!-- Modal Edit Start -->
                        <div class="modal fade" id="modal-edit<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>Edit Product</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>


                                    <div class="modal-body">
                                    <form action="includes/edit-product.inc.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">

                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1<?php echo $product_id; ?>" class="form-label">Product Name</label>
                                        <input type="text" name="edit_name" class="form-control" id="exampleFormControlInput1<?php echo $product_id; ?>" placeholder="" value="<?php echo $name; ?>" required>
                                    </div>

                                        <div class="mb-3">
                                            <label for="formFileSm<?php echo $product_id; ?>" class="form-label">Image</label>
                                            <input class="form-control form-control-sm" name="edit_image" id="formFileSm<?php echo $product_id; ?>" type="file">
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1<?php echo $product_id; ?>" class="form-label">Specification</label>
                                            <textarea class="form-control" name="edit_specs" id="exampleFormControlTextarea1<?php echo $product_id; ?>" rows="3" style="resize: none;" required><?php echo $specification; ?></textarea>
                                        </div>

                                        <label for="input-price<?php echo $product_id; ?>" class="form-label">Price</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">&#8369;</span>
                                            <input type="number" name="edit_price" id="input-price<?php echo $product_id; ?>" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" value="<?php echo $price; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleFormControlInput2<?php echo $product_id; ?>" class="form-label">Quantity</label>
                                            <input type="number" name="edit_quantity" class="form-control" id="exampleFormControlInput2<?php echo $product_id; ?>" placeholder="" value="<?php echo $quantity; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleFormControlInput3<?php echo $product_id; ?>" class="form-label">Warranty</label>
                                            <input type="text" class="form-control" name="edit_warranty" id="exampleFormControlInput3<?php echo $product_id; ?>" placeholder="" value="<?php echo $warranty; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="edit_submit">Save changes</button>
                                    </form><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Edit End -->


                        <!-- Button delete trigger modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $product_id; ?>">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>

                        <!-- Modal Delete Start -->
                        <div class="modal fade" id="modal-delete<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Are you sure you want to delete this product?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger"><a href="includes/delete-product.inc.php?id=<?php echo $product_id; ?>" style="color: #fff;">Delete</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Delete End -->
                        <?php
                        echo '</td>';
                        echo '</tr>';
                        echo '</tbody>';
                                }
                            }

                        }

                    }else{
                        $resultCount = $conn->query("SELECT count(product_id) AS product_id FROM product");
                        $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                        $total = $totalCount[0]['product_id'];
                        $pages = ceil($total / $limit);
                        
                        $previousPage = $page - 1;
                        $nextPage = $page + 1;
    
    
    
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){
                                $product_id = $row['product_id'];
                                $category = $row['category'];
                                $name = $row['name'];
                                $image = $row['image'];
                                $specification = $row['specification'];
                                $price = $row['price'];
                                $quantity = $row['quantity'];
                                $sold = $row['sold'];
                                $available = $row['available'];
                                $warranty = $row['warranty'];
                                $date_added = $row['date_added'];
                                $last_updated = $row['last_updated'];
    
                                echo '<tbody>';
                                echo '<tr>';
                                echo '<td>' .$product_id. '</td>';
                                echo '<td style="text-transform: uppercase;">' .$category. '</td>';
                                echo '<td>' .$name. '</td>';
                                echo '<td><img src="' .$image. '" alt="" height="80px" width="120px"></td>';
                                echo '<td>' .$specification. '</td>';
                                echo '<td>&#8369;' .$price. '</td>';
                                echo '<td>' .$quantity. '</td>';
                                echo '<td>' .$sold. '</td>';
                                echo '<td>' .$available. '</td>';
                                echo '<td>' .$warranty. '</td>';
                                echo '<td>' .$date_added. '</td>';
                                echo '<td>' .$last_updated. '</td>';
                                echo '<td>';
                                ?>
                            <!-- Button edit trigger modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $product_id; ?>">
                            <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                            </button>
    
                            <!-- Modal Edit Start -->
                            <div class="modal fade" id="modal-edit<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Edit Product</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
    
    
                                        <div class="modal-body">
                                        <form action="includes/edit-product.inc.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
    
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1<?php echo $product_id; ?>" class="form-label">Product Name</label>
                                            <input type="text" name="edit_name" class="form-control" id="exampleFormControlInput1<?php echo $product_id; ?>" placeholder="" value="<?php echo $name; ?>" required>
                                        </div>
    
                                            <div class="mb-3">
                                                <label for="formFileSm<?php echo $product_id; ?>" class="form-label">Image</label>
                                                <input class="form-control form-control-sm" name="edit_image" id="formFileSm<?php echo $product_id; ?>" type="file">
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1<?php echo $product_id; ?>" class="form-label">Specification</label>
                                                <textarea class="form-control" name="edit_specs" id="exampleFormControlTextarea1<?php echo $product_id; ?>" rows="3" style="resize: none;" required><?php echo $specification; ?></textarea>
                                            </div>
    
                                            <label for="input-price<?php echo $product_id; ?>" class="form-label">Price</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">&#8369;</span>
                                                <input type="number" name="edit_price" id="input-price<?php echo $product_id; ?>" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" value="<?php echo $price; ?>" required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput2<?php echo $product_id; ?>" class="form-label">Quantity</label>
                                                <input type="number" name="edit_quantity" class="form-control" id="exampleFormControlInput2<?php echo $product_id; ?>" placeholder="" value="<?php echo $quantity; ?>" required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput3<?php echo $product_id; ?>" class="form-label">Warranty</label>
                                                <input type="text" class="form-control" name="edit_warranty" id="exampleFormControlInput3<?php echo $product_id; ?>" placeholder="" value="<?php echo $warranty; ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit_submit">Save changes</button>
                                        </form><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Edit End -->
    
    
                            <!-- Button delete trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $product_id; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
    
                            <!-- Modal Delete Start -->
                            <div class="modal fade" id="modal-delete<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Are you sure you want to delete this product?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger"><a href="includes/delete-product.inc.php?id=<?php echo $product_id; ?>" style="color: #fff;">Delete</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete End -->
                    <?php
                            echo '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                            }//end of while loop product table
                        }//end of if num rows product table
                    }//end of first if num rows
    
                    }//end of else of if search
                    
                ?>
    </table>
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
</div>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- limit records script -->
    <script>
        $(document).ready(function(){
            $('#form-select').change(function(){
                $('#form-record').submit();
            })
        })
    </script>

    <!-- modal -->
    <script>
        const modalAdd = document.querySelector('#add-product-modal');
        const openModalAdd = document.querySelector('.add-product-open-button');
        const closeModalAdd = document.querySelector('.add-product-close-button');

        openModalAdd.addEventListener('click', () => {
            modalAdd.showModal();
        })

        closeModalAdd.addEventListener('click', () => {
            modalAdd.close();
        })
    </script>
<?php
    require_once 'footer.php';
?>