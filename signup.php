<?php
define("ROOT", "");

$response = array();

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['c_password']) && !empty($_POST['name'])) {
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		if ($_POST['password'] == $_POST['c_password']) {
			if (strlen($_POST['password']) > 8 && strlen($_POST['password']) < 15) {
				if (preg_match("/^[a-zA-Z ]*$/",$_POST['name'])) {
				  
				}
				else{
					$response['status'] = 0;
					$response['message'] = "Enter valid name";
				}
			}
			else{
				$response['status'] = 0;
				$response['message'] = "Password length should be between 8 to 15";
			}
		}
		else{
			$response['status'] = 0;
			$response['message'] = "Entered password and confirm password are not equal";
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

//header('Content-Type: application/json');
echo json_encode($response);
?>