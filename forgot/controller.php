<?php
session_start();
define("ROOT", "../");

require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

$response = array();
$validate;
$regCode;
$name;
$email;
$familyCode;

function createResponse($status,$message){
	return array('status' => $status, 'message' => $message);
}

do {
	if (isset($_POST)) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Invalid");
		break;
	}

	//Required fields
	if ($validate && (!empty($_POST["email"]) || !empty($_POST["mobile"])) ) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Required fields are empty");
		break;
	}

	if (!empty($_POST["email"])) {
		//Email validation
		if ($validate && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$validate = true;
		}
		else{
			$validate = false;
			$response = createResponse(0, "Invalid email");
			break;
		}
	}

	/*Mobile Validation
	if (!empty($_POST["mobile"])) {
		//Email validation
		if ($validate && strlen($_POST['email']) == 10) {
			$validate = true;
		}
		else{
			$validate = false;
			$response = createResponse(0, "Invalid email");
			break;
		}
	}*/
} while (0);

$_POST = safeStringForSQL($_POST);

//Business logic
if ($validate) {
	do {
		$sql = "SELECT RegCode, RegName, RegEmail, FamilyCode FROM Table109 WHERE RegEmail = '".$_POST['email']."' LIMIT 1;";
		if ($result = $mysqli->query($sql)) {
			if ($result->num_rows == 0) {
				$validate = false;
				$response = createResponse(0, "Invalid email");
				break;
			}
			else{
				$user = $result->fetch_assoc();
				$regCode = intval($user["RegCode"]);
				$name = $user["RegName"];
				$email = $user["RegEmail"];
				$familyCode = $user["FamilyCode"];
			}
		}
	} while (0);
}

//Business Logic
if ($validate) {
	require ROOT."mail/MailerAutoload.php";
	include_once ROOT.'modules/random_string_generator.php';

	do {
		$password = "as".random_string(2)."sis".random_string(3)."t";

		$sql = "UPDATE Table109 SET RegPassword= '".hash("sha256", $password)."', ForgotFlag = 1 WHERE RegCode = ".$regCode." AND FamilyCode = ".$familyCode.";";
		if ($result = $mysqli->query($sql)) {
			$validate = true;
		}
		else{
			$validate = false;
			$response = createResponse(0,"Error occured while uploading to the database: ".$mysqli->error);
			break;
		}

		$mail = new \Assistant\Mail\Mailer();
		$mail->addAddress($email, $name);
		
		$mail->Subject = "[ASSISTANT] Your new password";
		$mail->Body    = "Hi ".$name."\n\n New Password : ".$password;

		if(!$mail->send()) {
			$validate = false;
			$response = createResponse(0,"Mailer Error: " . $mail->ErrorInfo);
			break;
		} else {
		    $validate = true;
		    $response = createResponse(1,"Message has been sent");
		}
	} while (0);
}
echo json_encode($response);
$mysqli->close();
?>