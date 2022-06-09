<?php
    require_once 'includes/session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
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
                    <thead style="background: #888;">
                        <tr>
                            <th scope="col">Service ID</th>
                            <th scope="col">Service</th>
                            <th scope="col">Price</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Last Updated</th>
                            <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <?php
                    $limit = isset($_POST['form-select']) ? $_POST['form-select'] : 6;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $limit;
                    $sql = "SELECT * FROM service ORDER BY service_id DESC LIMIT $start, $limit;"; 

                    $resultCount = $conn->query("SELECT count(service_id) AS service_id FROM service");
                    $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                    $total = $totalCount[0]['service_id'];
                    $pages = ceil($total / $limit);
    
                    $previousPage = $page - 1;
                    $nextPage = $page + 1;

                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $service_id = $row['service_id'];
                            $service = $row['service'];
                            $price = $row['price'];
                            $date_added = $row['date_added'];
                            $last_updated = $row['last_updated'];

                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' .$service_id. '</td>';
                            echo '<td>' .$service. '</td>';
                            echo '<td>' .$price. '</td>';
                            echo '<td>' .$date_added. '</td>';
                            echo '<td>' .$last_updated. '</td>';
                            echo '<td>';
                            ?>
                            <!-- Button edit trigger modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $service_id; ?>">
                            <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                            </button>

                            <!-- Modal Edit Start -->
                            <div class="modal fade" id="modal-edit<?php echo $service_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Edit Service</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>


                                        <div class="modal-body">
                                        <form action="includes/edit-service.inc.php?id=<?php echo $service_id; ?>" method="post">

                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1<?php echo $service_id; ?>" class="form-label">Service</label>
                                            <input type="text" name="edit_service" class="form-control" id="exampleFormControlInput1<?php echo $service_id; ?>" placeholder="" value="<?php echo $service; ?>" required>

                                        </div>

                                            <label for="input-price<?php echo $service_id; ?>" class="form-label">Price</label>
                                            <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">&#8369;</span>
                                            <input type="number" name="edit_price" id="input-price<?php echo $service_id; ?>" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" value="<?php echo $price; ?>" required>
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
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $service_id; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>

                            <!-- Modal Delete Start -->
                            <div class="modal fade" id="modal-delete<?php echo $service_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Are you sure you want to delete this service?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger"><a href="includes/delete-service.inc.php?id=<?php echo $service_id; ?>" style="color: #fff;">Delete</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete End -->
                        <?php
                        echo '</td>';
                        echo '</tr>';
                        echo '</tbody>';
                        }//end of while fetch assoc service
                    }//end of if num rows service
                ?>

</div>
</table>
            <br>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $page == 1 ? 'disabled':''; ?>"><a class="page-link" href="service-offered.php?page=<?php echo $previousPage; ?>">Previous</a></li>
                    <?php for($i = 1; $i <= $pages; $i++) : ?>
    
                    <li class="page-item"><a class="page-link" href="service-offered.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page == $pages ? 'disabled':''; ?>"><a class="page-link" href="service-offered.php?page=<?php echo $nextPage; ?>">Next</a></li>
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

<?php
    require_once 'footer.php';
?>