<?php
    session_start();
    require_once 'includes/db.inc.php';
    if(isset($_SESSION['id'])){
        $idSession = $_SESSION['id'];
        $emailSession = $_SESSION['email'];
        $roleSession = $_SESSION['user_role_id'];

        if(($roleSession !== 2) && ($roleSession !== 3)) {
            header('location: login.php?error=invalidlogin');
            die();
        }elseif($roleSession === 2) {
            header('location: dashboard.php');
        }elseif($roleSession === 3) {
        }
    } else {
        header('location: login.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks</title>
    <!-- latest jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- latest bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- font awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- bootstrap js -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script><script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<?php
    require_once 'sidebar.php';
?>
<style>
    .content-body {
        margin-left: 20%;
        margin-right: 5%;
    }

    .edit-label {
        color: black;
    }
    
    .input-group {
        width: 40%;
    }

    .form-record {
        width: 40%;
    }
    
    .add-user-open-button{
        padding: 15px;
        border-radius: 5px;
        background:#6610f2;
        border: none;
        color: #fff;
        border: 1px solid #6610f2;
        transition: all 0.3s ease-in-out;
    }
    .add-user-open-button:hover{
        background: #673BB7;
        color: #fff;
        border: 1px solid #444;
    }
    /* .table {
        margin-left: 5%;
        width: 90%;
    } */
</style>

    <div class="content-body">
    <br><br><br><br>

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
            
            <button type="button" class="btn btn-primary" style="margin-left: 50px;"><a href="feedback.php?archive" style="color: white;">Show Archived Records</a></button><br>
            </div>
            <br>

            <style>
                tr{
                color: black;
                font-size: 17px;
                }
                thead,th{
                    background: #444;
                    color: #fff;
                    white-space: nowrap;
                }
            </style>

            <table class="table table-default">
            <thead>
                <tr>
                    <th scope="col">Feedback ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Feedback</th>
                    <th scope="col">Date Added</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <?php
                $limit = isset($_POST['form-select']) ? $_POST['form-select'] : 6;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($page - 1) * $limit;
                $sql = "SELECT users.f_name, users.l_name, users.email, feedback.* FROM users INNER JOIN feedback USING (user_id) WHERE feedback.is_deleted != 1 ORDER BY feedback.feedback_id DESC LIMIT $start, $limit;";

                if(isset($_GET['archive'])){
                    $resultCount = $conn->query("SELECT count(feedback_id) AS feedback_id FROM feedback WHERE is_deleted = 1;");
                    $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                    $total = $totalCount[0]['feedback_id'];
                    $pages = ceil($total / $limit);

                    $previousPage = $page - 1;
                    $nextPage = $page + 1;

                    $sql = "SELECT users.f_name, users.l_name, users.email, feedback.* FROM users INNER JOIN feedback USING (user_id) WHERE feedback.is_deleted = 1 ORDER BY feedback.feedback_id DESC LIMIT $start, $limit;";

                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $feedback_id = $row['feedback_id'];
                            $user_id = $row['user_id'];
                            $f_name = $row['f_name'];
                            $l_name = $row['l_name'];
                            $email = $row['email'];
                            $feedback = $row['feedback'];
                            $date_added = $row['date_added'];

                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' .$feedback_id. '</td>';
                            echo '<td>' .$f_name. ' ' .$l_name. '</td>';
                            echo '<td>' .$email. '</td>';
                            echo '<td>' .$feedback. '</td>';
                            echo '<td>' .$date_added. '</td>';
                            echo '<td>';
                            ?>
                            <!-- Button restore trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-restore<?php echo $feedback_id; ?>">
                            Restore
                            </button>

                            <!-- Modal restore Start -->
                            <div class="modal fade" id="modal-restore<?php echo $feedback_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Are you sure you want to restore this feedback?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success"><a href="includes/restore-feedback.inc.php?id=<?php echo $feedback_id; ?>" style="color: #fff;">Yes</a></button>
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
                    }else {
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td colspan="6">No record found';
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';
                    }//end of else if num rows archive
                }else{
                    $resultCount = $conn->query("SELECT count(feedback_id) AS feedback_id FROM feedback WHERE is_deleted != 1;");
                    $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                    $total = $totalCount[0]['feedback_id'];
                    $pages = ceil($total / $limit);
                    
                    $previousPage = $page - 1;
                    $nextPage = $page + 1;
    
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $feedback_id = $row['feedback_id'];
                            $user_id = $row['user_id'];
                            $f_name = $row['f_name'];
                            $l_name = $row['l_name'];
                            $email = $row['email'];
                            $feedback = $row['feedback'];
                            $date_added = $row['date_added'];
    
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' .$feedback_id. '</td>';
                            echo '<td>' .$f_name. ' ' .$l_name. '</td>';
                            echo '<td>' .$email. '</td>';
                            echo '<td>' .$feedback. '</td>';
                            echo '<td>' .$date_added. '</td>';
                            echo '<td>';
                        ?>
                                <!-- Button delete trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $feedback_id; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
        
                                <!-- Modal Delete Start -->
                                <div class="modal fade" id="modal-delete<?php echo $feedback_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this feedback?</h4>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger"><a href="includes/delete-feedback.inc.php?id=<?php echo $feedback_id; ?>" style="color: #fff;">Delete</a></button>
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
?>
</table>
            <br>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $page == 1 ? 'disabled':''; ?>"><a class="page-link" href="feedback.php?page=<?php echo $previousPage; ?>">Previous</a></li>
                    <?php for($i = 1; $i <= $pages; $i++) : ?>
    
                    <li class="page-item"><a class="page-link" href="feedback.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page == $pages ? 'disabled':''; ?>"><a class="page-link" href="feedback.php?page=<?php echo $nextPage; ?>">Next</a></li>
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
<?php
    require_once 'footer.php';
?>