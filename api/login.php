<?php
session_start();
define("ROOT", "../");

$response = array();
if (!empty($_POST['email']) && !empty($_POST['password'])) {
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		if (strlen($_POST['password']) > 7 && strlen($_POST['password']) < 17) {
			
			require_once ROOT.'db/Connection.php';
			require_once ROOT.'modules/functions.php';

			$mysqli = getConnection(); 
			$_POST = safeStringForSQL($_POST);
			$password = hash("sha256", $_POST['password']);

			$sql = "SELECT RegCode, RegName, RegEmail, RegPassword, RegMobile FROM Table109 WHERE RegEmail = '".$_POST['email']."' AND RegPassword = '".$password."' LIMIT 1";

			if ($result = $mysqli->query($sql)) {
				if ($result->num_rows == 0) {
				  	$response['status'] = 0;
					$response['message'] = "Invalid email or password";
				}
			    else{
			      	$row = $result->fetch_assoc();
			        session_regenerate_id();
					$_SESSION['email'] = $row['RegEmail'];
					$_SESSION['name'] = $row['RegName'];
					$_SESSION['s_id'] = $row['RegCode'];
					$_SESSION['mobile'] = $row['RegMobile'];
					
					$response['status'] = 1;
					$response['message'] = "Login Successfull";
			    }
			}
		}
		else{
			$response['status'] = 0;
			$response['message'] = "Incorrect Password";
		}
	}
	else{
		$response['status'] = 0;
		$response['message'] = "Enter valid email id";
	}
}
else{
	$response['status'] = 0;
	$response['message'] = "Required fields are empty";
}
$mysqli->close();
echo json_encode($response);
?>