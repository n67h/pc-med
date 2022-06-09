<?php
	session_start();
	date_default_timezone_set('Asia/Singapore');
	require_once 'includes/db.inc.php';

	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];

		$txt = mysqli_real_escape_string($conn, $_POST['txt']);
		$sql = "SELECT reply FROM chatbot WHERE question LIKE '%$txt%'";
		$res = mysqli_query($conn,$sql);
		if(mysqli_num_rows($res) > 0){
			$row = mysqli_fetch_assoc($res);
			$html=$row['reply'];
		}else {
			$html = "Sorry I can't understand you. You can directly contact us through phone or email. (+63) 9057083882 / 9914166456, marvindelosreyes1126@yahoo.com, marvindelosreyes1126@gmail.com";
		}
		$currDate = date('Y-m-d H:i:s');
		$sqlRole = "SELECT * FROM users WHERE user_id = $id;";
		$result = mysqli_query($conn, $sqlRole);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
				$user_role_id = $row['user_role_id'];
				mysqli_query($conn, "INSERT INTO messages(message, user_id, user_role_id, date_added) VALUES ('$txt', $id, $user_role_id, '$currDate');");
		
				mysqli_query($conn, "INSERT INTO messages(message, user_id, user_role_id, date_added) VALUES ('$html', 1, 4, '$currDate');");
				echo $html;
			}
		}
	}