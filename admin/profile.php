<?php
    require_once 'includes/session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
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

    .profile_img{
                border-radius: 50%;
                width: 15%;
                max-height: 20%;
                cursor: pointer;
                position: relative;

            }

            .choose-image{
        text-align: center;
    }
    .custome-file{
        border:2px solid #ccc;
        border-radius:16px;
        padding: 2px;
        float: left;
    }
    .custome-file::-webkit-file-upload-button{
        background:#444;
        color:#fff;
        padding:12px;
        border:none;
        border-radius:16px;
        cursor: url("images/cursor1.png"),auto;
    }

            @media(max-width: 780px){
                .profile_img{
                    width: 50%;
                    height: 40%;
                }
            }
            @media(max-width:700px){
                nav a{
                    font-size:17px;
                }
                button{
                    padding:4px;
                }
            }


            .form-control {
                width: 40%;
            }

            .btn {
                width: 40%;
            }
</style>


<div class="content-body">
    <h1>Profile</h1><br>
        <?php
            if(isset($_SESSION)){
                $idSession = $_SESSION['id'];
                $emailSession = $_SESSION['email'];
                $roleSession = $_SESSION['user_role_id'];
                $sql = "SELECT * FROM users WHERE user_id = $idSession;";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $email = $row['email'];
                        $f_name = $row['f_name'];
                        $l_name = $row['l_name'];
                        $phone_no = $row['phone_no'];
                        $address = $row['address'];
                        $profile_img = $row['profile_img'];
                    }
                }
                ?>
                <form action="includes/edit-profile.inc.php?id=<?php echo $idSession; ?>" method="post">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1<?php echo $email; ?>" class="form-label">Email address/Username</label>
                        <input type="text" name="email" class="form-control" id="exampleFormControlInput1<?php echo $email; ?>" placeholder="" value="<?php echo $email; ?>">
                    </div>
        
                    <div class="mb-3">
                        <label for="exampleFormControlInput1<?php echo $f_name; ?>" class="form-label">First name</label>
                        <input type="text" name="firstname" class="form-control" id="exampleFormControlInput1<?php echo $f_name; ?>" placeholder="" value="<?php echo $f_name; ?>">
                    </div>
        
                    <div class="mb-3">
                        <label for="exampleFormControlInput1 <?php echo $l_name; ?>" class="form-label">Last name</label>
                        <input type="text" name="lastname" class="form-control" id="exampleFormControlInput1 <?php echo $l_name; ?>" placeholder="" value="<?php echo $l_name; ?>">
                    </div>
        
                    <div class="mb-3">
                        <label for="exampleFormControlInput1<?php echo $phone_no; ?>" class="form-label">Phone No.</label>
                        <input type="text" name="phone_no" class="form-control" id="exampleFormControlInput1<?php echo $phone_no; ?>" placeholder="" value="<?php echo $phone_no; ?>">
                    </div>
        
                    <div class="mb-3">
                        <label for="exampleFormControlInput1<?php echo $address; ?>" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="exampleFormControlInput1<?php echo $address; ?>" placeholder="" value="<?php echo $address; ?>">
                    </div>
        
                    <button type="submit" name="edit_submit" class="btn btn-primary">Save Changes</button>
                </form>
                <br><br><br><br>
                
                <button type="button" class="btn btn-info"><a href="change-password.php" style="color: black;">Change password</a></button>
        <?php
            }
        ?>


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