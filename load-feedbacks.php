<?php
require_once 'includes/db.inc.php';

    $feedbackNewCount = $_POST['feedbackNewCount'];


    $sql = "SELECT users.f_name, users.l_name, users.email, users.profile_img, feedback.* FROM users INNER JOIN feedback USING (user_id) WHERE feedback.is_deleted != 1 LIMIT $feedbackNewCount;";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $f_name = $row['f_name'];
            $l_name = $row['l_name'];
            $email = $row['email'];
            $profile_img = $row['profile_img'];
            $feedback = $row['feedback'];
            $date_added = $row['date_added'];
            $user_id = $row['user_id'];

            echo '<div class="feedbacks">';
            if($profile_img == 1) {
                $fileName = 'profile-pictures/profile' .$user_id. '.*';
                $fileInfo = glob($fileName);
                $fileExt = explode(".", $fileInfo[0]);
                $fileActualExt = $fileExt[1];
                echo '<img src="profile-pictures/profile' .$user_id. '.' .$fileActualExt. '?' .mt_rand(). '" alt="" class="profile_img">';

            }else {
                echo '<img src="profile-pictures/profile-picture-default.png" alt="" class="profile_img">';
                echo '<br><br>';
            }
            echo '<p>' .$f_name.  ' ' .$l_name. '</p>';
            echo '<p>' .$feedback. '</p>';
            echo '</div>';
        }
    }else{
        echo 'There are no feedbacks!';
    }