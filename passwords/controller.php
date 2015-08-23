<?php

session_start();
define("ROOT", "../");

include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

$response = array();
$validate;
$passwordCode;
$regCode = intval($_SESSION['s_id']);

function createResponse($status,$message){
	return array('status' => $status, 'message' => $message);
}

function getPasswordTypeCode(){
	global $mysqli;
	$passwordTypeCode;

	$qry = "SELECT MAX(PasswordTypeCode) as 'PasswordTypeCode' FROM Table130;";
	//echo $qry;
	if ($result = $mysqli->query($qry)) {	
      while ($row = $result->fetch_assoc()) {
        if (is_null($row['PasswordTypeCode'])) {
          $passwordTypeCode = 1001;     
        }
        else{
        	$passwordTypeCode = intval($row['PasswordTypeCode']) + 1;
        }
      }
    
	}
	return $passwordTypeCode;
}

function getPasswordCode(){
	global $mysqli,$regCode;
	$passwordCode;

	$qry = "SELECT MAX(PasswordCode) as 'PasswordCode' FROM Table152 WHERE RegCode = ".$regCode;
	if ($result = $mysqli->query($qry)) {	
      while ($row = $result->fetch_assoc()) {
        if (is_null($row['PasswordCode'])) {
          $passwordCode = 1001;     
        }
        else{
        	$passwordCode = intval($row['PasswordCode']) + 1;
        }
      }
    
	}

	return $passwordCode;
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

	//Validate required fields
	if ($validate && !empty($_POST["name"]) && !empty($_POST["passwordType"]) && !empty($_POST["description"]) && !empty($_POST["userID"]) && !empty($_POST["password"])) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Required fields are empty");
		break;
	}

} while (0);

//Business Logic
if ($validate) {
	do {
		$sql = "";

		$passwordTypeCode = intval($_POST["passwordTypeCode"]);
		$passwordCode = getPasswordCode();
		
		$qry = "SELECT count(*) as 'count' FROM Table130 WHERE PasswordTypeCode = ".$passwordTypeCode." AND RegCode = ".$regCode.";";

		//Create new entry in password master list
		if ($result = $mysqli->query($qry)) {
			$row = $result->fetch_assoc();
			//print_r($row);
			if (intval($row["count"]) == 0) {
				$passwordTypeCode = getPasswordTypeCode();
				$sql .= build_insert_str('Table130',array(
					intval($passwordTypeCode),
					$_POST["passwordType"],
					$regCode
				));	
			}
		}

		$sql .= "INSERT INTO `Table152`(`RegCode`, `PasswordCode`, `PasswordTypeCode`, `HolderCode`, `PasswordName`, `LoginID`, `LoginPassword1`, `LoginPassword2`, `InsertedBy`, `PrivateFlag`, `ActiveFlag`, `LastAccessDate`) VALUES (".$regCode.",".$passwordCode.",".$passwordTypeCode.",".intval($_POST["name"]).",'".$_POST["description"]."','".$_POST["userID"]."','".$_POST["password"]."','".$_POST["password1"]."',".intval($_SESSION["familyCode"]).",1,1,NOW());";

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