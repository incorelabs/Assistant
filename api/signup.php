<?php
define("ROOT", "../");

require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection(); 

$response = array();
$validate;

function createResponse($status,$message){
	return array('status' => $status, 'message' => $message);
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

	//Required fields validation
	if ($validate && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmPassword']) && !empty($_POST['name']) && !empty($_POST['country']) && !empty($_POST['mobile'])) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Required fields are empty");
		break;
	}

	//Email validation
	if ($validate && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0, "Invalid email");
		break;
	}

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

	//Name validation
	if ($validate && preg_match("/^[a-zA-Z ]*$/",$_POST['name'])){
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Invalid Name");
		break;
	}

	//Date validation
	$dob = explode("/", $_POST['dob']);
	$dob = array($dob[2],$dob[1],$dob[0]);
	$_POST['dob'] = implode("-", $dob);

	if ($validate && strlen($dob[0]) == 4 && $dob[1] < 13 && $dob[2] < 32) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Invalid date");
		break;
	}
	
}while(0);

$_POST = safeStringForSQL($_POST);

//Business validation
if ($validate) {
	do {
		//Check if mail ID is already registered or not 
		$qry1 = "SELECT count(*) as 'count' FROM `Table109` WHERE `RegEmail` = '".$_POST['email']."';";
		if ($result = $mysqli->query($qry1)) {
			$row = $result->fetch_assoc();
			if (intval($row['count']) == 0) {
				$validate = true;
			}
			else{
				$validate = false;
				$response = createResponse(0,"This Mail ID is already registered");
				break;
			}
		}
	} while (0);
}

//Business Logic
if ($validate) {
	do {
		$id = 0;
		$familyCode = 1001;

		$sql = "SELECT MAX(RegCode) as 'RegCode' FROM Table109";

		//Assign ID
		if ($result = $mysqli->query($sql)) {	
	      while ($row = $result->fetch_assoc()) {
	        if (is_null($row['RegCode'])) {
	          $id = 10001;     
	        }
	        else{
	          $id = intval($row['RegCode']) + 1;
	        }
	      }
		}

		$sql = "";
		$sql .= build_insert_str('Table107',array(
			$id,
			$familyCode,
			$_POST['name'],
			1,
			(empty($_POST['dob']) ? "" : "'".$_POST['dob']."'"),
			$_POST['email'],
			$_POST['mobile'],
			hash("sha256", $_POST['password']),
			0,
			1,
			1
		));

		$nextYear = new DateTime("now");
		$nextYear->add(new DateInterval('P1Y'));
		$today = new DateTime("now");

		$sql .= build_insert_str('Table109',array(
			$id,
			$_POST['name'],
			$_POST['email'],
			hash("sha256", $_POST['password']),
			$_POST['mobile'],
			$familyCode,
			1, // => 1 for parent and 2 for child
			1 	// => 1 for active and 2 for inactive
		));

		$sql .= build_insert_str('Table120',array(
			$id,
			10000,	// => Contact Serial
			10000, 	// => Invest
			10000, 	// => Assets
			10000, 	// => Document
			10000, 	// => Expense
			10000, 	// => Income
			10000, 	// => Password
			10000, 	// => Extra1
			10000, 	// => Extra2
			10000, 	// => Extra3
			10000, 	// => Extra4
			10000, 	// => Extra5
			10000, 	// => Extra6
			10000, 	// => Extra7
			10000, 	// => Extra8
			10000 	// => Extra9
		));

		$sql .= build_insert_str('Table122',array(
			$id,
			"'".$today->format("Y-m-d")."'",
			$_POST["country"],
			1, 	// => Renewal Number
			"'".$today->format("Y-m-d")."'",
			"'".$nextYear->format("Y-m-d")."'",
			1,	// => Family Size
			0, 	// => Fees collected
			0, 	// => Data used
			0, 	// => Photo uploaded
			0, 	// => No of hits
			"'".$today->format("Y-m-d H:i:s")."'"
		));

		//echo $sql;
		if ($mysqli->multi_query($sql) === TRUE) {
			$response = createResponse(1,"Successfull");
		}
		else{
			$response = createResponse(0,"Error occured while uploading to the database: ".$mysqli->error);
			break;
		}

	} while (0);
}

echo json_encode($response);
$mysqli->close();
?>