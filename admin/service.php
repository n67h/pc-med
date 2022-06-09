<?php
    require_once 'includes/session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Reservation</title>
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
                        <style>
                        .container {
                            display: flex;
                        }
                        </style>

                <div class="container">
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

                    <button type="button" class="btn btn-primary" style="margin-left: 50px;"><a href="service.php?archive" style="color: white;">Show Archived Records</a></button><br>
                </div>
<br>
                <table class="table table-default">
                <thead style="background: #888;">
                    <tr>
                        <th scope="col">Service ID</th>
                        <th scope="col">Service</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date Schedule</th>
                        <th scope="col">Time Schedule</th>
                        <th scope="col">Date Added</th>
                        <th scope="col">Last Updated</th>
                        <th scope="col">Operations</th>
                    </tr>
                </thead>           
                <?php
                $limit = isset($_POST['form-select']) ? $_POST['form-select'] : 6;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($page - 1) * $limit;
                $sql = "SELECT users.f_name, users.l_name, users.email, users.phone_no, service.service, service.price, service_reservation.* FROM service_reservation INNER JOIN users USING (user_id) INNER JOIN service USING (service_id) WHERE service_reservation.is_deleted != 1 ORDER BY sr_id DESC LIMIT $start, $limit;"; 

                if(isset($_GET['archive'])){
                    $resultCount = $conn->query("SELECT count(sr_id) AS sr_id FROM service_reservation;");
                    $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                    $total = $totalCount[0]['sr_id'];
                    $pages = ceil($total / $limit);

                    $previousPage = $page - 1;
                    $nextPage = $page + 1;

                    $sql_search = "SELECT users.f_name, users.l_name, users.email, users.phone_no, service.service, service.price, service_reservation.* FROM service_reservation INNER JOIN users USING (user_id) INNER JOIN service USING (service_id) WHERE service_reservation.is_deleted = 1 ORDER BY sr_id DESC LIMIT $start, $limit;";

                    $result_search = mysqli_query($conn, $sql_search);
                    if(mysqli_num_rows($result_search) > 0){
                        while($row_search = mysqli_fetch_assoc($result_search)){
                            $sr_id = $row_search['sr_id'];
                            $user_id = $row_search['user_id'];
                            $f_name = $row_search['f_name'];
                            $l_name = $row_search['l_name'];
                            $email = $row_search['email'];
                            $phone = $row_search['phone_no'];
                            $address = $row_search['address'];
                            $zipcode = $row_search['zipcode'];
                            $service_id = $row_search['service_id'];
                            $service = $row_search['service'];
                            $price = $row_search['price'];
                            $service_date = $row_search['service_date'];
                            $service_time = $row_search['service_time'];
                            $instructions = $row_search['instructions'];
                            $status = $row_search['status'];
                            $date_added = $row_search['date_added'];
                            $last_updated = $row_search['last_updated'];

                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' .$sr_id. '</td>';
                            echo '<td>' .$service. '</td>';
                            echo '<td>' .$price. '</td>';
                            echo '<td>' .$status. '</td>';
                            echo '<td>' .$service_date. '</td>';
                            echo '<td>' .$service_time. '</td>';
                            echo '<td>' .$date_added. '</td>';
                            echo '<td>' .$last_updated. '</td>';
                            echo '<td>';
                            ?>
                                <!-- Button restore trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-restore<?php echo $sr_id; ?>">
                            Restore
                            </button>

                            <!-- Modal restore Start -->
                            <div class="modal fade" id="modal-restore<?php echo $sr_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Are you sure you want to restore this record?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success"><a href="includes/restore-reservation.inc.php?id=<?php echo $sr_id; ?>" style="color: #fff;">Yes</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal restore End -->
                            <?php
                            echo '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                        }//end of while fetch assoc archive
                    }else{
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td colspan="9">No record found';
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';
                    }//end of else if num rows
                }else{
                    $resultCount = $conn->query("SELECT count(sr_id) AS sr_id FROM service_reservation WHERE is_deleted != 1;");
                    $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                    $total = $totalCount[0]['sr_id'];
                    $pages = ceil($total / $limit);
    
                    $previousPage = $page - 1;
                    $nextPage = $page + 1;
    
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $sr_id = $row['sr_id'];
                            $user_id = $row['user_id'];
                            $f_name = $row['f_name'];
                            $l_name = $row['l_name'];
                            $email = $row['email'];
                            $phone = $row['phone_no'];
                            $address = $row['address'];
                            $zipcode = $row['zipcode'];
                            $service_id = $row['service_id'];
                            $service = $row['service'];
                            $price = $row['price'];
                            $service_date = $row['service_date'];
                            $service_time = $row['service_time'];
                            $instructions = $row['instructions'];
                            $status = $row['status'];
                            $date_added = $row['date_added'];
                            $last_updated = $row['last_updated'];
    
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' .$sr_id. '</td>';
                            echo '<td>' .$service. '</td>';
                            echo '<td>' .$price. '</td>';
                            echo '<td>' .$status. '</td>';
                            echo '<td>' .$service_date. '</td>';
                            echo '<td>' .$service_time. '</td>';
                            echo '<td>' .$date_added. '</td>';
                            echo '<td>' .$last_updated. '</td>';
                            echo '<td>';
    ?>
                            <!-- Button view trigger modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-view<?php echo $sr_id; ?>">
                            View Details
                            </button>
        
                                <!-- Modal view Start -->
                                <div class="modal fade" id="modal-view<?php echo $sr_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3>Service Reservation ID <?php echo $sr_id; ?></h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
    
                                            <div class="modal-body">
                                                <h3>User details</h3>
                                                <h4>Full Name: <?php echo $f_name. ' ' . $l_name; ?></h4>
                                                <h4>Email: <?php echo $email; ?></h4>
                                                <h4>Phone No.: <?php echo $phone; ?></h4>
                                                <h4>Address: <?php echo $address; ?></h4>
                                                <h4>Zipcode: <?php echo $zipcode; ?></h4>
                                                <br><br>
    
                                                <h3>Service details</h3>
                                                <h4>Status: <?php echo $status; ?></h4>
                                                <h4>Service: <?php echo $service; ?></h4>
                                                <h4>Price: <?php echo $price; ?></h4>
                                                <h4>Date Schedule: <?php echo $service_date; ?></h4>
                                                <h4>Date Time: <?php echo $service_time; ?></h4>
                                                <h4>Instructions: <?php echo $instructions; ?></h4>
                                            </div>
        
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal view End -->
    
                            <!-- Button edit trigger modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $sr_id; ?>">
                            <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                            </button>
        
                                <!-- Modal Edit Start -->
                                <div class="modal fade" id="modal-edit<?php echo $sr_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3>Service Reservation ID <?php echo $sr_id; ?></h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
        
                                            <form action="includes/edit-reservation.inc.php?sr_id=<?php echo $sr_id; ?>&email=<?php echo $email; ?>" method="post">
                                            <select class="form-select" name="status" aria-label="Default select example">
                                                    <?php 
                                                        if($status == 'Pending'){
                                                    ?>
                                                            <option value="Confirmed">Confirmed</option>
                                                            <!-- <option value="Done">Done</option> -->
                                                            <option value="Cancelled">Cancelled</option>
                                                    <?php
                                                        }elseif($status == 'Confirmed'){
                                                    ?>
                                                            <!-- <option value="Pending">Pending</option> -->
                                                            <option value="Done">Done</option>
                                                            <option value="Cancelled">Cancelled</option>
                                                    <?php
                                                        }elseif($status == 'Done'){
                                                    ?>
                                                            <!-- <option value="Pending">Pending</option> -->
                                                            <!-- <option value="Done">Done</option> -->
                                                            <!-- <option value="Cancelled">Cancelled</option> -->
                                                    <?php
                                                        }elseif($status == 'Cancelled'){
                                                    ?>
                                                            <!-- <option value="Pending">Pending</option> -->
                                                            <!-- <option value="Done">Done</option> -->
                                                            <!-- <option value="Cancelled">Cancelled</option> -->
                                                    <?php
                                                        }
                                                    ?>
    
    
                                            </select>
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
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $sr_id; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
        
                                <!-- Modal Delete Start -->
                                <div class="modal fade" id="modal-delete<?php echo $sr_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this order?</h4>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger"><a href="includes/delete-reservation.inc.php?id=<?php echo $sr_id; ?>" style="color: #fff;">Delete</a></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Delete End -->
    <?php
                            echo '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                        }//end of while fetch assoc     
                    }//end of if num rows
                }
    ?>
                
</div>
            </table>
            <br>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $page == 1 ? 'disabled':''; ?>"><a class="page-link" href="service.php?page=<?php echo $previousPage; ?>">Previous</a></li>
                    <?php for($i = 1; $i <= $pages; $i++) : ?>
    
                    <li class="page-item"><a class="page-link" href="service.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page == $pages ? 'disabled':''; ?>"><a class="page-link" href="service.php?page=<?php echo $nextPage; ?>">Next</a></li>
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