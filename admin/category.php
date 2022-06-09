<?php
    require_once 'includes/session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
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
        margin-left: 25%;
        margin-right: 5%;
    }

    .edit-label {
        color: #fff;
    }
    
    .input-group {
        width: 40%;
    }

    .form-record {
        width: 40%;
    }
    .add-category-open-button{
        padding: 15px;
        border-radius: 5px;
        background:#6610f2;
        border: none;
        color: #fff;
        border: 1px solid #6610f2;
        transition: all 0.3s ease-in-out;
    }
    .add-category-open-button:hover{
        background: #673BB7;
        color: #fff;
        border: 1px solid #444;
    }
    /* .table {
        margin-left: 5%;
        width: 90%;
    } */
</style>
<!-- <a href="index.php" class="home"><i class="fa fa-home" aria-hidden="true"></i>Home</a> -->
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
                

                $name_error = " *";
                $name_val = "";
                $name_success = "";

                if(isset($_POST['submit'])){
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
            
                    if(empty($name)){
                        $name_error = ' This field is required';
                    }else{
                        $name_error = '';
                        $name_val = $name;
                        $name_success = ' <i class="fa fa-check-circle" aria-hidden="true" style="color: green;"></i>';
                    }


                    if(!empty($name)) {
                        $sql = "INSERT INTO product_category (name) VALUES('$name');";

                        if(mysqli_query($conn, $sql)){  
                            $nameDirectory = strtolower($name);
                            mkdir('product-images/' .$nameDirectory, 0777, true);
                            // header('location: category.php');
                            // Warning: Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\pc-med\admin\sidebar.php:1) in C:\xampp\htdocs\pc-med\admin\category.php on line 96
                        };
                    }
                }
                ?>
                <style>
                   .add-category-modal::backdrop{
                     background: linear-gradient(45deg,black,gray);
                     opacity: 0.5;
                        }
                        #name{
                            outline:none;
                            border:none;
                            border-bottom:2px solid #444;
                            width:60%;
                        }
                        #name:focus~#label1
                    {
                            color: red;
                            font-size: 15px;
                            transform: translateY(-20px);
                            position:absolute;
                        }
                        textarea:focus~#desc{
                            color: red;
                            font-size: 15px;
                            transform: translateX(-10px);
                        }
                        textarea{
                            outline:none;
                        }
                        dialog{
                            height: 20%;
                            width: 20%;
                            border: none;
                            box-shadow: 0px 0px 20px #6610f2;
                            border-radius: 10px;
                        }
                        form{  
                                                    
                        }
                        h3{
                            text-align: center;
                        }
                        input{
                            font-size: 20px;
                           
                        }
                        label{
                            font-size: 15px;
                        }
                        .dialog-btn{
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            gap:1.4em;
                        }
                        .submit{
                            padding: 12px;
                            background:#6610f2 ;
                            border: none;
                            width: 120px;
                            color: #fff;
                            border-radius: 10px;
                            transition: all 0.3s ease-in;
                        }
                        .description{
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            flex-direction: column;
                            margin-top: 12px;
                        }
                </style>

<style>
    
tr{
    color: black;
    font-size: 17px;
}

</style>
    <?php
        }
        // echo '<button class="button add-category-open-button">Add Category</button>';
        ?>
         <!-- Button edit trigger modal -->
         <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
                Add category
        </button>
    
        <!-- Modal Edit Start -->
        <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Edit Category</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    
                    <form action="includes/add-category.inc.php" method="post">
                        <h3>Add a Category</h3>
                        <div class="description">
                        <input type="text" name="name" id="name" value="<?php echo $name_val; ?>" placeholder="Category Name" required>
                   
                        <label for="name" id="label1"><span class="error" style="color:red"><?php echo $name_error ?></span><span class="success" style="color: green;"><?php echo $name_success ?></span></label>
                        </div>
                        <br>
                        <div class="dialog-btn">
                        
                        </div>
                    
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" id="submit" class="submit">Add</button><br><br>
                    </form><br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Edit End -->
    






<dialog class="add-category-modal" id="add-category-modal">
                    <form action="" method="post">
                        <h3>Add a Category</h3>
                        <div class="description">
                        <input type="text" name="name" id="name" value="<?php echo $name_val; ?>" placeholder="Category Name">
                   
                        <label for="name" id="label1"><span class="error" style="color:red"><?php echo $name_error ?></span><span class="success" style="color: green;"><?php echo $name_success ?></span></label>
                        </div>
                        <br>
                        <div class="dialog-btn">
                        <button type="submit" name="submit" id="submit" class="submit">Add</button><br><br>
                        <button class="button add-category-close-button submit">Close</button>
                        </div>
                    </form>
                   
                </dialog>
                <br><br>
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" name="search" value="<?php if(isset($_GET['search'])){
                            echo $_GET['search'];
                        }?>" class="form-control" placeholder="Search" required>
                        <button class="btn btn-primary">Search</button>
                    </div>
                </form>


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
        <?php
    }
    ?>
        <table class="table table-white">
        <thead style="background: #888;">
            <tr>
                <th scope="col">Product Category ID</th>
                <th scope="col">Category</th>
                <th scope="col">Date Added</th>
                <th scope="col">Last Updated</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <?php
            $limit = isset($_POST['form-select']) ? $_POST['form-select'] : 6;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;
            $sql = "SELECT * FROM product_category ORDER BY product_category_id DESC LIMIT $start, $limit;";

            

            if(isset($_GET['search'])){
                $search = $_GET['search'];
                $resultCount = $conn->query("SELECT count(product_category_id) AS product_category_id FROM product_category WHERE CONCAT(name) LIKE '%$search%';");
                $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                $total = $totalCount[0]['product_category_id'];
                $pages = ceil($total / $limit);
                
                $previousPage = $page - 1;
                $nextPage = $page + 1;
                
                $sql_search = "SELECT * FROM product_category WHERE CONCAT(name) LIKE '%$search%' ORDER BY product_category_id DESC;";
                $result_search = mysqli_query($conn, $sql_search);
                if(mysqli_num_rows($result_search) > 0){
                    while($row_search = mysqli_fetch_assoc($result_search)){
                        $product_category_id = $row_search['product_category_id'];
                        $name = $row_search['name'];
                        $date_added = $row_search['date_added'];
                        $last_updated = $row_search['last_updated'];

                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>' .$product_category_id. '</td>';
                        echo '<td style="text-transform: uppercase;">' .$name. '</td>';
                        echo '<td>' .$date_added. '</td>';
                        echo '<td>' .$last_updated. '</td>';
                        echo '<td>';
            ?>
                        <!-- Button edit trigger modal -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $product_category_id; ?>">
                        <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                        </button>
    
                            <!-- Modal Edit Start -->
                            <div class="modal fade" id="modal-edit<?php echo $product_category_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Edit Category</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
    
                                        <form action="includes/edit-category.inc.php?id=<?php echo $product_category_id; ?>" method="post">
                                            <label for="edit_name<?php echo $product_category_id ?>" class="edit-label">Category Name</label><br>
                                            <input type="text" name="edit_name" id="edit_name<?php echo $product_category_id; ?>" value="<?php echo $name; ?>" required><br><br>
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
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $product_category_id; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
    
                            <!-- Modal Delete Start -->
                            <div class="modal fade" id="modal-delete<?php echo $product_category_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Are you sure you want to delete this category?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger"><a href="includes/delete-category.inc.php?id=<?php echo $product_category_id; ?>" style="color: #fff;">Delete</a></button>
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
                }else {
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td colspan="5">No record found';
                    echo '</tr>';
                    echo '</tbody>';
                    echo '</table>';
                }//end of else if num rows search
            }else {
                $resultCount = $conn->query("SELECT count(product_category_id) AS product_category_id FROM product_category;");
                $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                $total = $totalCount[0]['product_category_id'];
                $pages = ceil($total / $limit);
                
                $previousPage = $page - 1;
                $nextPage = $page + 1;

                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)){
                        $product_category_id = $row['product_category_id'];
                        $name = $row['name'];
                        $date_added = $row['date_added'];
                        $last_updated = $row['last_updated'];
    
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>' .$product_category_id. '</td>';
                        echo '<td style="text-transform: uppercase;">' .$name. '</td>';
                        echo '<td>' .$date_added. '</td>';
                        echo '<td>' .$last_updated. '</td>';
                        echo '<td>';
            ?>
                        <!-- Button edit trigger modal -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $product_category_id; ?>">
                        <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                        </button>
    
                            <!-- Modal Edit Start -->
                            <div class="modal fade" id="modal-edit<?php echo $product_category_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Edit Category</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
    
                                        <form action="includes/edit-category.inc.php?id=<?php echo $product_category_id; ?>" method="post">
                                            <label for="edit_name<?php echo $product_category_id ?>" class="edit-label">Category Name</label><br>
                                            <input type="text" name="edit_name" id="edit_name<?php echo $product_category_id; ?>" value="<?php echo $name; ?>" required><br><br>
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
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $product_category_id; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
    
                            <!-- Modal Delete Start -->
                            <div class="modal fade" id="modal-delete<?php echo $product_category_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Are you sure you want to delete this category?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger"><a href="includes/delete-category.inc.php?id=<?php echo $product_category_id; ?>" style="color: #fff;">Delete</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete End -->
                <?php
                            echo '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                        }//end of while loop for category table
                }//end of if num rows for category table
                ?>
        </div>   
        <?php      
            }//end of else of if search
?>
</table>
            <br>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $page == 1 ? 'disabled':''; ?>"><a class="page-link" href="category.php?page=<?php echo $previousPage; ?>">Previous</a></li>
                    <?php for($i = 1; $i <= $pages; $i++) : ?>
    
                    <li class="page-item"><a class="page-link" href="category.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page == $pages ? 'disabled':''; ?>"><a class="page-link" href="category.php?page=<?php echo $nextPage; ?>">Next</a></li>
                </ul>
            </nav>
            

    
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
        const modalAdd = document.querySelector('#add-category-modal');
        const openModalAdd = document.querySelector('.add-category-open-button');
        const closeModalAdd = document.querySelector('.add-category-close-button');

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