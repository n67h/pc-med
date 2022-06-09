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
    <title>CART | PC MED DATA SOLUTION</title>
    <!-- latest jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- latest bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- font awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- bootstrap js -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script><script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<?php
    require_once 'header.php';
?>
<br><br>
<br><br>
<br><br>
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
    <table>
    <tr>
    <!-- <th></th> -->
    <th>Product</th>
    <th>Quantity</th>
    <th>Unit price</th>
    <th>Amount</th>
    <th></th>
    </tr>

<?php
    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
        $totalPayment = 0;

        $limit = isset($_POST['form-select']) ? $_POST['form-select'] : 6;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        $sql = "SELECT * FROM cart_details WHERE user_id = $user_id LIMIT $start, $limit;";
        $resultCount = $conn->query("SELECT count(cart_id) AS cart_id FROM cart_details WHERE user_id = $user_id;");
        $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
        $total = $totalCount[0]['cart_id'];
        $pages = ceil($total / $limit);
        
        $previousPage = $page - 1;
        $nextPage = $page + 1;

        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $cart_id = $row['cart_id'];
                $product_id = $row['product_id'];
                $image = $row['image'];
                $name = $row['name'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                $total_price = $row['total_price'];

                echo '<tr>';
                echo '<td><img class="des-btn" src="admin/' .$image. '" height="120px" width="140px">';
                echo $name. '</td>';

                echo '<td>' .$quantity. '</td>';
                echo '<td>&#8369;' .$price. '</td>';
                echo '<td>&#8369;' .$total_price. '</td>';
                echo '<td>';
                ?>

                <!-- Button edit trigger modal -->
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $cart_id; ?>">
                <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                </button>

                <!-- Modal Edit Start -->
                <div class="modal fade" id="modal-edit<?php echo $cart_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3>Edit</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                            <form action="includes/edit-cart.inc.php?id=<?php echo $cart_id; ?>" method="post">
                                <label for="edit_qty<?php echo $cart_id ?>">Quantity</label><br>
                                <input type="number" name="edit_qty" id="edit_qty<?php echo $cart_id; ?>" value="<?php echo $quantity; ?>" required>
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
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $cart_id; ?>">
                <i class="fa fa-trash" aria-hidden="true"></i>
                </button>

                <!-- Modal Delete Start -->
                <div class="modal fade" id="modal-delete<?php echo $cart_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4>Are you sure you want to remove this product from your cart?</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger"><a href="includes/delete-cart.inc.php?id=<?php echo $cart_id; ?>" style="color: #fff;">Remove</a></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Delete End -->
                
                <?php
                echo '</td>';
                echo '</tr>';

                $totalPayment += $total_price;
            }
        }
    }
?>

<tr>
    <td></td>
    <td></td>
    <td></td>
    <td><?php echo 'TOTAL:  &#8369;'. $totalPayment; ?></td>
    <td></td>
</tr>
</table>


<button class="checkout-btn"><a href="checkout.php">Proceed to Checkout&nbsp;<i class="fa fa-angle-double-right"></i></a></button>
<br>
<br>
<br>
<br>
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
    <br><br>

 
<?php
    require_once 'footer.php';
?>