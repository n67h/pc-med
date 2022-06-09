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
    <title>Users</title>
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
    <?php
        $sql = "SELECT * FROM users WHERE user_id = $idSession AND user_role_id = 3 AND is_deleted = 0;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $f_name = $row['f_name'];
                echo '<br><br>';

                // icon for add user, tinanggal ko muna, ibalik mo nalang
                // <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                echo '<!-- Button edit trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-user">
                Add User
                </button>';
                $firstname_error = " *";
                $lastname_error = " *";
                $phone_error = " *";
                $address_error = " *";
                $email_error = " *";
                $password_error = " *";
                $password_repeat_error = " *";
                

                $firstname_val = "";
                $lastname_val = "";
                $phone_val = "";
                $address_val = "";
                $email_val = "";
                $password_val = "";
                $password_repeat_val = "";
                $role_val = "";

                $firstname_success = "";
                $lastname_success = "";
                $phone_success = "";
                $address_success = "";
                $email_success = "";
                $password_success = "";
                $password_repeat_success = "";


                if(isset($_POST['submit'])) {
                    require_once 'includes/db.inc.php';
                    require_once 'includes/functions.inc.php';

                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
                    $lastname = mysqli_real_escape_string($conn, $_POST['last_name']);
                    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
                    $address = mysqli_real_escape_string($conn, $_POST['address']);
                    $password = mysqli_real_escape_string($conn, $_POST['password']);
                    $password_repeat = mysqli_real_escape_string($conn, $_POST['password_repeat']);
                    $role = mysqli_real_escape_string($conn, $_POST['role']);

                    //FIRST NAME
                    if(firstnameEmpty($firstname) !== false) {
                        $firstname_error = " This field is required";
                    } else {
                        if(firstnameInvalid($firstname) !== false) {
                            $firstname_error = " Invalid first name";
                        } else {
                            $firstname_error = "";
                            $firstname_success = ' <i class="fa fa-check-circle" aria-hidden="true"></i>';
                            $firstname_val = $firstname;
                        }
                    }


                    //LAST NAME
                    if(lastnameEmpty($lastname) !== false) {
                        $lastname_error = " This field is required";
                    } else {
                        if(lastnameInvalid($lastname) !== false) {
                            $lastname_error = " Invalid last name";
                        } else {
                            $lastname_error = "";
                            $lastname_success = ' <i class="fa fa-check-circle" aria-hidden="true"></i>';
                            $lastname_val = $lastname;
                        }
                    }

                    //PHONE
                    if(phoneEmpty($phone) !== false) {
                        $phone_error = " This field is required";
                    } else {
                        if(phoneInvalid($phone) !== false) {
                            $phone_error = " Invalid phone number";
                        } else {
                            $phone_error = "";
                            $phone_success = ' <i class="fa fa-check-circle" aria-hidden="true"></i>';
                            $phone_val = $phone;
                        }
                    }

                    //ADDRESS
                    if(addressEmpty($address) !== false) {
                        $address_error = " This field is required";
                    } else {
                        if(addressInvalid($address) !== false) {
                            $address_error = " Address must be at least 10 characters";
                        } else {
                            $address_error = "";
                            $address_success = ' <i class="fa fa-check-circle" aria-hidden="true"></i>';
                            $address_val = $address;
                        }
                    }
                    
                    //EMAIL
                    if(emailEmpty($email) !== false) {
                        $email_error = " This field is required";
                    } else {
                        if(emailInvalid($email) !== false) {
                            $email_error = " Invalid email";
                        } elseif(emailExists($conn, $email) !== false) {
                            $email_error = " Email/Username is already taken";
                        } else {
                            $email_error = "";
                            $email_success = ' <i class="fa fa-check-circle" aria-hidden="true"></i>';
                            $email_val = $email;
                        }
                    }

                    if(emailExists($conn, $email) !== false) {
                        $email_error = " Email/Username is already taken";
                    }
                    
                    //PASSWORD
                    if(passwordEmpty($password) !== false) {
                        $password_error = " This field is required";
                    } else {
                        if(passwordInvalid($password)  !== false) {
                            $password_error = " Must be  8 to 16 characters";
                        } else {
                            $password_error = "";
                            $password_success = ' <i class="fa fa-check-circle" aria-hidden="true"></i>';
                            $password_val = $password;
                        }
                    }

                    //PASSWORD REPEAT
                    if(passwordRepeatEmpty($password_repeat) !== false) {
                        $password_repeat_error = " This field is required";
                    } else {
                        if(passwordRepeatInvalid($password_repeat) !== false) {
                            $password_repeat_error = " Must be 8 to 16 characters";
                        } elseif(passwordMatch($password, $password_repeat) !== false) {
                            $password_repeat_error = " Password does not match";
                        } else {
                            $password_repeat_error = "";
                            $password_repeat_success = ' <i class="fa fa-check-circle" aria-hidden="true"></i>';
                            $password_repeat_val = $password_repeat;
                        }
                    }

                    //GENERATE VERIFICATION KEY
                    $vkey = md5(time());
                    $verified = 1;



                    if(!empty($firstname) && !empty($lastname) && !empty($address) && !empty($email) && !empty($phone)  && !empty($password)  && !empty($password_repeat) && firstnameInvalid($firstname) === false && lastnameInvalid($lastname) === false && addressInvalid($address) === false && emailInvalid($email) === false && emailExists($conn, $email) === false &&  phoneInvalid($phone) === false && passwordInvalid($password) === false && passwordRepeatInvalid($password_repeat) === false && passwordMatch($password, $password_repeat) === false && $vkey != "" && $verified == 1) {

                   
                        createUser($conn, $email, $firstname, $lastname, $phone, $address, $password, $role, $vkey, $verified);

                        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        // $sql = "INSERT INTO users (email, f_name, l_name, phone_no, address, password, user_role_id, verification_key, is_verified) VALUES ('$email', '$firstname', '$lastname', '$phone', '$address', '$hashedPassword', $role, '$vkey', $verified)";
                        // mysqli_query($conn, $sql);

                        
                    }//end of create user if
                    //echo $vkey;
                }//end of submit if
?>
                    <!-- Modal Add User Start -->
                    <div class="modal fade" id="modal-add-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 1%;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>Add User</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                    <form action="" method="post">
                                        <!-- email -->
                                        <div class="mb-3">
                                        <label for="email" class="form-label">Username/Email<span class="error" style="color:red;"><?php echo $email_error ?></span><span class="success" style="color:green;"><?php echo $email_success ?></span></label>
                                        <input type="text" name="email" class="form-control" id="email" placeholder="" value="<?php echo $email_val ?>">
                                        </div>

                                        <!-- first name -->
                                        <div class="mb-3">
                                        <label for="first_name" class="form-label">First name<span class="error" style="color:red"> <?php echo $firstname_error ?></span><span class="success" style="color:green;"><?php echo $firstname_success ?></span></label>
                                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="" value="<?php echo $firstname_val ?>">
                                        </div>

                                        <!-- last name -->
                                        <div class="mb-3">
                                        <label for="last_name" class="form-label">Last name<span class="error" style="color:red"><?php echo $lastname_error ?></span><span class="success" style="color:green;"><?php echo $lastname_success ?></span></label>
                                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="" value="<?php echo $lastname_val ?>">
                                        </div>

                                        <!-- phone -->
                                        <div class="mb-3">
                                        <label for="phone" class="form-label">Phone<span class="error" style="color:red"><?php echo $phone_error ?></span><span class="success" style="color:green;"><?php echo $phone_success ?></span></label>
                                        <input type="text" name="phone" class="form-control" id="phone" placeholder="" value="<?php echo $phone_val ?>">
                                        </div>

                                        <!-- address -->
                                        <div class="mb-3">
                                        <label for="address" class="form-label">Address<span class="error" style="color:red"><?php echo $address_error ?></span><span class="success" style="color:green;"><?php echo $address_success ?></span></label>
                                        <input type="text" name="address" class="form-control" id="address" placeholder="" value="<?php echo $address_val ?>">
                                        </div>

                                        <!-- role -->
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-control" name="role" id="role" aria-label="Default select example">
                                            <option value="3" selected>Admin</option>
                                            <option value="2">Staff</option>
                                            <?php
                                                if(isset($_POST['role'])){
                                                    if($_POST['role'] == 3){
                                                        echo '<option value="3" selected>Admin</option>';
                                                    }elseif($_POST['role'] == 2){
                                                        echo '<option value="2" selected>Staff</option>';
                                                    }
                                                }
                                            ?>
                                        </select><br>

                                        <!-- password -->
                                        <div class="mb-3">
                                        <label for="password" class="form-label">Password<span class="error" style="color:red"><?php echo $password_error ?></span><span class="success" style="color:green;"><?php echo $password_success ?></span></label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="" value="<?php echo $password_val ?>">
                                        </div>

                                        <!-- password_repeat -->
                                        <div class="mb-3">
                                        <label for="address" class="form-label">Repeat Password<span class="error" style="color:red"><?php echo $password_repeat_error ?></span><span class="success" style="color:green;"><?php echo $password_repeat_success ?></span></label>
                                        <input type="password" name="password_repeat" class="form-control" id="password_repeat" placeholder="" value="<?php echo $password_repeat_val ?>">
                                        </div>

                                    </div>
                                            
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="submit">Add</button>
                                    </form><br>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <!-- Modal Add User End -->

                <br><br>

                    <form action="" method="get">
                        <div class="input-group mb-3">
                            <input type="text" name="search" value="<?php if(isset($_GET['search'])){
                                echo $_GET['search'];
                            }?>" class="form-control" placeholder="Search" required>
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </form>

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
                        </form><br><br>

                        <button type="button" class="btn btn-primary" style="margin-left: 50px;"><a href="users.php?archive" style="color: white;">Show Archived Records</a></button><br>

                    </div>
                    <br>
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
                    
                <table class="table table-default">
                    <thead>
                        <tr>
                            <th scope="col">User ID</th>
                            <th scope="col">Email/Username</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Address</th>
                            <th scope="col">Role</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Last Updated</th>
                            <th scope="col">Last Login</th>
                            <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <?php
                        $limit = isset($_POST['form-select']) ? $_POST['form-select'] : 6;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($page - 1) * $limit;
                        $sql = "SELECT users.user_id, users.email, users.f_name, users.l_name, users.phone_no, users.address, users.date_added, users.last_updated, users.last_login, user_roles.role FROM users INNER JOIN user_roles ON user_roles.user_role_id = users.user_role_id WHERE users.user_role_id != 4 AND users.is_deleted != 1 ORDER BY users.user_id DESC LIMIT $start, $limit;";
                        
                        if(isset($_GET['search'])){
                            $search = $_GET['search'];
                            $resultCount = $conn->query("SELECT count(user_id) AS user_id FROM users WHERE users.user_role_id != 4 AND users.is_deleted != 1 AND CONCAT(email, f_name, l_name, phone_no, address) LIKE '%$search%';");
                            $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                            $total = $totalCount[0]['user_id'];
                            $pages = ceil($total / $limit);

                            $previousPage = $page - 1;
                            $nextPage = $page + 1;

                            $sql_search = "SELECT users.user_id, users.email, users.f_name, users.l_name, users.phone_no, users.address, users.date_added, users.last_updated, users.last_login, user_roles.role FROM users INNER JOIN user_roles ON user_roles.user_role_id = users.user_role_id WHERE users.user_role_id != 4 AND users.is_deleted != 1 AND CONCAT(email, f_name, l_name, phone_no, address) LIKE '%$search%' ORDER BY users.user_id DESC LIMIT $start, $limit;";
                            $result_search = mysqli_query($conn, $sql_search);
                            if(mysqli_num_rows($result_search) > 0){
                                while($row_search = mysqli_fetch_assoc($result_search)){
                                    $user_id = $row_search['user_id'];
                                    $email = $row_search['email'];
                                    $f_name = $row_search['f_name'];
                                    $l_name = $row_search['l_name'];
                                    $phone_no = $row_search['phone_no'];
                                    $address = $row_search['address'];
                                    $role = $row_search['role'];
                                    $date_added = $row_search['date_added'];
                                    $last_updated = $row_search['last_updated'];
                                    $last_login = $row_search['last_login'];

                                    echo '<tbody>';
                                echo '<tr>';
                                echo '<td>' .$user_id. '</td>';
                                echo '<td>' .$email. '</td>';
                                echo '<td>' .$f_name. '</td>';
                                echo '<td>' .$l_name. '</td>';
                                echo '<td>' .$phone_no. '</td>';
                                echo '<td>' .$address. '</td>';
                                echo '<td>' .$role. '</td>';
                                echo '<td>' .$date_added. '</td>';
                                echo '<td>' .$last_updated. '</td>';
                                echo '<td>' .$last_login. '</td>';
                                echo '<td>';
                                ?>
                            <!-- Button edit trigger modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $user_id; ?>">
                            <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                            </button>

                            <!-- Modal Edit Start -->
                            <div class="modal fade" id="modal-edit<?php echo $user_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form action="includes/edit-user.inc.php?id=<?php echo $user_id; ?>" method="post" id="edit-form">
                                        
                                            <h4>Edit User</h4>
                                            <label class="edit-label" for="edit_email<?php echo $user_id; ?>">Email<span class="error"></span><span class="success"></span></label><br>
                                            <input type="text" name="edit_email" id="edit_email<?php echo $user_id; ?>" placeholder="Email" value="<?php echo $email; ?>"><br><br>

                                            <label class="edit-label" for="edit_first_name<?php echo $user_id; ?>">First name<span class="error"></span><span class="success"></span></label><br>
                                            <input type="text" name="edit_first_name" id="edit_first_name<?php echo $user_id; ?>" placeholder="First name" value="<?php echo $f_name; ?>"><br><br>

                                            <label class="edit-label" for="edit_last_name<?php echo $user_id; ?>">Last name<span class="error"></span><span class="success"></span></label><br>
                                            <input type="text" name="edit_last_name" id="edit_last_name<?php echo $user_id; ?>" placeholder="Last name" value="<?php echo $l_name; ?>"><br><br> 

                                            <label class="edit-label" for="edit_phone<?php echo $user_id; ?>">Phone no.<span class="error"></span><span class="success"></span></label><br>
                                            <input type="text" name="edit_phone" id="edit_phone<?php echo $user_id; ?>" placeholder="Phone no." value="<?php echo $phone_no; ?>"><br><br>

                                            <label class="edit-label" for="edit_address<?php echo $user_id; ?>">Address<span class="error"></span><span class="success"></span></label><br>
                                            <input type="text" name="edit_address" id="edit_address<?php echo $user_id; ?>" placeholder="Address" value="<?php echo $address; ?>"><br><br>

                                            <label class="edit-label" for="edit_role<?php echo $user_id; ?>">Role<span class="error"></span><span class="success"></span></label><br>
                                            <select name="edit_role" id="edit_role<?php echo $user_id; ?>">
                                                <option value="none" selected="selected">-- Select --</option>
                                                <option value="1">Customer</option>
                                                <option value="2">Staff</option>
                                                <option value="3">Admin</option>

                                            <?php
                                                if($role === 'Customer') {
                                                    echo '<option value="1" selected="selected">Customer</option>';
                                                }elseif($role === 'Staff') {
                                                    echo '<option value="2" selected="selected">Staff</option>';
                                                }elseif($role === 'Admin') {
                                                    echo '<option value="3" selected="selected">Admin</option>';
                                                }
                                            ?>
                                            </select><br><br>

                                           
                                            
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
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $user_id; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>

                            <!-- Modal Delete Start -->
                            <div class="modal fade" id="modal-delete<?php echo $user_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Are you sure you want to delete this user?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger"><a href="includes/delete-user.inc.php?id=<?php echo $user_id; ?>" style="color: #fff;">Delete</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete End -->


                    <?php
                            echo '</td>';
                            echo '</tr>';
                            echo '</tbody>';

                                }//end of while fetch assoc search
                            }else {
                                echo '<tbody>';
                                echo '<tr>';
                                echo '<td colspan="11">No record found';
                                echo '</tr>';
                                echo '</tbody>';
                                echo '</table>';

                            }//end of else if num rows search

                        }elseif(isset($_GET['archive'])){
                            $resultCount = $conn->query("SELECT count(user_id) AS user_id FROM users WHERE users.user_role_id != 4 AND users.is_deleted = 1;");
                            $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                            $total = $totalCount[0]['user_id'];
                            $pages = ceil($total / $limit);

                            $previousPage = $page - 1;
                            $nextPage = $page + 1;

                            $sql_search = "SELECT users.user_id, users.email, users.f_name, users.l_name, users.phone_no, users.address, users.date_added, users.last_updated, users.last_login, user_roles.role FROM users INNER JOIN user_roles ON user_roles.user_role_id = users.user_role_id WHERE users.user_role_id != 4 AND users.is_deleted = 1 ORDER BY users.user_id DESC LIMIT $start, $limit;";
                            $result_search = mysqli_query($conn, $sql_search);
                            if(mysqli_num_rows($result_search) > 0){
                                while($row_search = mysqli_fetch_assoc($result_search)){
                                    $user_id = $row_search['user_id'];
                                    $email = $row_search['email'];
                                    $f_name = $row_search['f_name'];
                                    $l_name = $row_search['l_name'];
                                    $phone_no = $row_search['phone_no'];
                                    $address = $row_search['address'];
                                    $role = $row_search['role'];
                                    $date_added = $row_search['date_added'];
                                    $last_updated = $row_search['last_updated'];
                                    $last_login = $row_search['last_login'];

                                    echo '<tbody>';
                                echo '<tr>';
                                echo '<td>' .$user_id. '</td>';
                                echo '<td>' .$email. '</td>';
                                echo '<td>' .$f_name. '</td>';
                                echo '<td>' .$l_name. '</td>';
                                echo '<td>' .$phone_no. '</td>';
                                echo '<td>' .$address. '</td>';
                                echo '<td>' .$role. '</td>';
                                echo '<td>' .$date_added. '</td>';
                                echo '<td>' .$last_updated. '</td>';
                                echo '<td>' .$last_login. '</td>';
                                echo '<td>';
                                ?>
                            <!-- Button restore trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-restore<?php echo $user_id; ?>">
                            Restore
                            </button>

                            <!-- Modal restore Start -->
                            <div class="modal fade" id="modal-restore<?php echo $user_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Are you sure you want to restore this user?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success"><a href="includes/restore-user.inc.php?id=<?php echo $user_id; ?>" style="color: #fff;">Yes</a></button>
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
                                echo '<td colspan="11">No record found';
                                echo '</tr>';
                                echo '</tbody>';
                                echo '</table>';
                            }//end of else if num rows
                        }else{
                            $resultCount = $conn->query("SELECT count(user_id) AS user_id FROM users WHERE user_role_id != 4 AND is_deleted != 1;");
                            $totalCount = $resultCount->fetch_all(MYSQLI_ASSOC);
                            $total = $totalCount[0]['user_id'];
                            $pages = ceil($total / $limit);
                            
                            $previousPage = $page - 1;
                            $nextPage = $page + 1;
    
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                                    $user_id = $row['user_id'];
                                    $email = $row['email'];
                                    $f_name = $row['f_name'];
                                    $l_name = $row['l_name'];
                                    $phone_no = $row['phone_no'];
                                    $address = $row['address'];
                                    $role = $row['role'];
                                    $date_added = $row['date_added'];
                                    $last_updated = $row['last_updated'];
                                    $last_login = $row['last_login'];
    
                                    echo '<tbody>';
                                    echo '<tr>';
                                    echo '<td>' .$user_id. '</td>';
                                    echo '<td>' .$email. '</td>';
                                    echo '<td>' .$f_name. '</td>';
                                    echo '<td>' .$l_name. '</td>';
                                    echo '<td>' .$phone_no. '</td>';
                                    echo '<td>' .$address. '</td>';
                                    echo '<td>' .$role. '</td>';
                                    echo '<td>' .$date_added. '</td>';
                                    echo '<td>' .$last_updated. '</td>';
                                    echo '<td>' .$last_login. '</td>';
                                    echo '<td>';
                                    ?>
                                <!-- Button edit trigger modal -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit<?php echo $user_id; ?>">
                                <i class="fa fa-pencil" aria-hidden="true" style="color: #fff;"></i>
                                </button>
    
                                <!-- Modal Edit Start -->
                                <div class="modal fade" id="modal-edit<?php echo $user_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="includes/edit-user.inc.php?id=<?php echo $user_id; ?>" method="post" id="edit-form">
                                            
                                                <h4>Edit User</h4>
                                                <label class="edit-label" for="edit_email<?php echo $user_id; ?>">Email<span class="error"></span><span class="success"></span></label><br>
                                                <input type="text" name="edit_email" id="edit_email<?php echo $user_id; ?>" placeholder="Email" value="<?php echo $email; ?>"><br><br>
    
                                                <label class="edit-label" for="edit_first_name<?php echo $user_id; ?>">First name<span class="error"></span><span class="success"></span></label><br>
                                                <input type="text" name="edit_first_name" id="edit_first_name<?php echo $user_id; ?>" placeholder="First name" value="<?php echo $f_name; ?>"><br><br>
    
                                                <label class="edit-label" for="edit_last_name<?php echo $user_id; ?>">Last name<span class="error"></span><span class="success"></span></label><br>
                                                <input type="text" name="edit_last_name" id="edit_last_name<?php echo $user_id; ?>" placeholder="Last name" value="<?php echo $l_name; ?>"><br><br> 
    
                                                <label class="edit-label" for="edit_phone<?php echo $user_id; ?>">Phone no.<span class="error"></span><span class="success"></span></label><br>
                                                <input type="text" name="edit_phone" id="edit_phone<?php echo $user_id; ?>" placeholder="Phone no." value="<?php echo $phone_no; ?>"><br><br>
    
                                                <label class="edit-label" for="edit_address<?php echo $user_id; ?>">Address<span class="error"></span><span class="success"></span></label><br>
                                                <input type="text" name="edit_address" id="edit_address<?php echo $user_id; ?>" placeholder="Address" value="<?php echo $address; ?>"><br><br>
    
                                                <label class="edit-label" for="edit_role<?php echo $user_id; ?>">Role<span class="error"></span><span class="success"></span></label><br>
                                                <select name="edit_role" id="edit_role<?php echo $user_id; ?>">
                                                    <option value="none" selected="selected">-- Select --</option>
                                                    <option value="1">Customer</option>
                                                    <option value="2">Staff</option>
                                                    <option value="3">Admin</option>
    
                                                <?php
                                                    if($role === 'Customer') {
                                                        echo '<option value="1" selected="selected">Customer</option>';
                                                    }elseif($role === 'Staff') {
                                                        echo '<option value="2" selected="selected">Staff</option>';
                                                    }elseif($role === 'Admin') {
                                                        echo '<option value="3" selected="selected">Admin</option>';
                                                    }
                                                ?>
                                                </select><br><br>
    
                                               
                                                
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
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $user_id; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
    
                                <!-- Modal Delete Start -->
                                <div class="modal fade" id="modal-delete<?php echo $user_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this user?</h4>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger"><a href="includes/delete-user.inc.php?id=<?php echo $user_id; ?>" style="color: #fff;">Delete</a></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Delete End -->
    
    
                        <?php
                                echo '</td>';
                                echo '</tr>';
                                echo '</tbody>';
                                }//end of user table while loop
                            }//end of user table if num rows
    
                        }//end of else of if isset search
                }//end of first while loop
                echo '</table>';
                ?>
                <br>

    <?php
            }//end of first if
?>
<br>
<nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?php echo $page == 1 ? 'disabled':''; ?>"><a class="page-link" href="users.php?page=<?php echo $previousPage; ?>">Previous</a></li>
            <?php for($i = 1; $i <= $pages; $i++) : ?>

            <li class="page-item"><a class="page-link" href="users.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            
            <?php endfor; ?>
            <li class="page-item <?php echo $page == $pages ? 'disabled':''; ?>"><a class="page-link" href="users.php?page=<?php echo $nextPage; ?>">Next</a></li>
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