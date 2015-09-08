<?php
session_start();
define("ROOT", "../");

include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

$familyCode = 0;
$response = array();
$validate;
$oldPassword;
$passwordList = array();

function createResponse($status,$message){
	return array('status' => $status, 'message' => $message);
}

function validatePassword(){
	global $response,$validate;
	do {
		//Check if password is entered
		if(!empty($_POST['password']) && !empty($_POST['confirmPassword'])){

			//Validate password length
			if (strlen($_POST['password']) > 7 && strlen($_POST['password']) < 17 ) {
				$validate = true;
			}
			else{
				$validate = false;
				$response = createResponse(0,"Password length should be between 8 to 16 characters");
				break;
			}

			//Validate confirm password and password
			if ($_POST['password'] == $_POST['confirmPassword']) {
				$validate = true;
			}
			else{
				$validate = false;
				$response = createResponse(0,"Password and confirm password are not similar");
				break;
			}
		}
		else{
			$validate = false;
			$response = createResponse(0,"Enter password to provide access");
			break;
		}

	} while (0);
	return $validate;
}

//General Validation
do {
	if (isset($_POST)) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Invalid");
		break;
	}

	//Check required fields
	if ($validate && !empty($_POST["oldPassword"]) && !empty($_POST["password"]) && !empty($_POST["confirmPassword"])) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Required fields are empty");
		break;
	}

	//Validate password length
	if ($validate && strlen($_POST['oldPassword']) > 7 && strlen($_POST['oldPassword']) < 17 ) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Old password is incorrect");
		break;
	}

	if ($validate && validatePassword()) {
		$validate = true;
	}
	else{
		$validate = false;
		break;
	}

}while(0);

$_POST = safeStringForSQL($_POST);

//Business validation
if ($validate) {
	do {

		//check if current password is correct
		$oldPassword = hash("sha256", $_POST['oldPassword']);
		$sql = "SELECT count(*) as 'count' FROM Table109 WHERE RegCode = ".$_SESSION["s_id"]." AND FamilyCode = ".$_SESSION["familyCode"]." AND RegPassword = '".$oldPassword."';";
		
		if ($result = $mysqli->query($sql)) {
			$row = $result->fetch_assoc();
			//print_r($row);
			if (intval($row['count']) == 0) {
				$validate = false;
				$response = createResponse(0,"Old password is incorrect");
				break;
			}
			else{
				$validate = true;
			}
		}

		//check previous three password list
		if ($validate) {
			$sql = "SELECT PassDate1, Password1, PassDate2, Password2, PassDate3, Password3 FROM Table116 WHERE RegCode = ".$_SESSION["s_id"]." AND FamilyCode = ".$_SESSION["familyCode"]." LIMIT 1;";

			if ($result = $mysqli->query($sql)) {
				$row = $result->fetch_assoc();
				$password = hash("sha256", $_POST['password']);

				switch ($password) {
					
					case $row["Password1"]:
						$validate = false;
						$response = createResponse(0,"You cannot use your last three passwords");
						break;

					case $row["Password2"]:
						$validate = false;
						$response = createResponse(0,"You cannot use your last three passwords");
						break;

					case $row["Password3"]:
						$validate = false;
						$response = createResponse(0,"You cannot use your last three passwords");
						break;

					default:
						$validate = true;
						$passwordList[0] = array("date"=>$row["PassDate1"], "password"=>$row["Password1"]);
						$passwordList[1] = array("date"=>$row["PassDate2"], "password"=>$row["Password2"]);
						break;
				}
			}
		}
	} while (0);
}

//Business Logic
if ($validate) {
	do {
		//Update password history table
		$sql = "UPDATE Table116 SET PassDate1 = NOW(), Password1 = '".$oldPassword."', PassDate2= '".$passwordList[0]["date"]."', Password2='".$passwordList[0]["password"]."', PassDate3 = '".$passwordList[1]["date"]."', Password3 = '".$passwordList[1]["password"]."' WHERE RegCode = ".$_SESSION["s_id"]." AND FamilyCode = ".$_SESSION["familyCode"].";";

		//Set new password
		$password = hash("sha256", $_POST['password']);
		$sql .= "UPDATE Table109 SET RegPassword = '".$password."', ForgotFlag = 2 WHERE RegCode = ".$_SESSION["s_id"]." AND FamilyCode = ".$_SESSION["familyCode"].";";
		
		//echo $sql;
		if ($mysqli->multi_query($sql) === TRUE) {
			$validate = true;
			$response = createResponse(1,"Password updated");
		}
		else{
			$validate = false;
			$response = createResponse(0,"Error occured while uploading to the database: ".$mysqli->error);
			break;
		}
	} while (0);
}

echo json_encode($response);
$mysqli->close();
?>