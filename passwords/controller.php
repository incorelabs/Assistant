<?php
session_start();
define("ROOT", "../");

include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

$response = array();
$validate;

//Input variables
$regCode = intval($_SESSION['s_id']);
$passwordCode;
$passwordTypeCode = 0;
$passwordTypeName = "";
$holderCode = 0;
$passwordName = "";
$userID = "";
$password1 = "";
$password2 = "";
$inserted = 0;
$private = 1; // default private
$active = 1; // default active
$mode;

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
	//Delete mode
	if ($_POST["mode"] == "D") {
		$passwordTypeCode = 0;
		$holderCode = 0;
		break;
	}

	//Validate required fields
	if ($validate && !empty($_POST["name"]) && !empty($_POST["mode"]) && !empty($_POST["passwordCode"]) && !empty($_POST["passwordType"]) && !empty($_POST["description"]) && !empty($_POST["userID"]) && !empty($_POST["password"])) {
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
	$sql = "SET @passwordTypeCode = ".((isset($_POST["passwordTypeCode"])) ? intval($_POST['passwordTypeCode']) : 0).";";
	
	if ($_POST["mode"] == "D") {
		$passwordCode = $_POST["passwordCode"];
		$mode = 3;
		//$sql .= "DELETE FROM Table152 WHERE RegCode = ".$regCode." AND PasswordCode = ".$passwordCode.";";
	}
	elseif ($_POST["mode"] == "M" || $_POST["mode"] == "A") {
		do {
			$passwordCode = $_POST["passwordCode"];
			$passwordTypeCode = intval($_POST["passwordTypeCode"]);
			$passwordTypeName = $_POST["passwordType"];
			$holderCode = intval($_POST['name']);
			$passwordName = $_POST["description"];
			$userID = $_POST["userID"];
			$password1 = $_POST["password"];
			$password2 = $_POST["password1"];
			$inserted = intval($_SESSION["familyCode"]);
			$private = (isset($_POST["private"]) ? "1" : "2");
			$active = (isset($_POST["active"]) ? "1" : "2");
			
			if ($_POST["mode"] == "M") {
				$mode = 2;
			}
			elseif ($_POST["mode"] == "A") {
				$mode = 1;	
			}

			if (intval($_POST['passwordTypeCode']) < 1001) {
				$sql .= "call spTable130(
						    @passwordTypeCode,
						    '".$passwordTypeName."',
							".$regCode.",
						    1
						);";
			}

			//$sql .= "DELETE FROM Table152 WHERE RegCode = ".$regCode." AND PasswordCode = ".$passwordCode.";";
			

			//$sql .= "INSERT INTO `Table152`(`RegCode`, `PasswordCode`, `PasswordTypeCode`, `HolderCode`, `PasswordName`, `LoginID`, `LoginPassword1`, `LoginPassword2`, `InsertedBy`, `PrivateFlag`, `ActiveFlag`, `LastAccessDate`) VALUES (".$regCode.",".$passwordCode.",".$passwordTypeCode.",".intval($_POST["name"]).",'".$_POST["description"]."','".$_POST["userID"]."','".$_POST["password"]."','".$_POST["password1"]."',".intval($_SESSION["familyCode"]).",".$private.",".$active.",NOW());";
		} while (0);
	}

	$sql .= "call spTable152(
				".$regCode.",
			    ".$passwordCode.",
			    @passwordTypeCode,
			    '".$passwordTypeName."',
			    ".$holderCode.",
			    '".$passwordName."',
			    '".$userID."',
			    '".$password1."',
			    '".$password2."',
			    ".$inserted.",
			    ".$private.",
			    ".$active.",
			    now(),
			    ".$mode."
			);";
	//echo $sql;
	if ($mysqli->multi_query($sql) === TRUE) {
		$validate = true;
		$response = createResponse(1,"Successful");
	}
	else{
		$validate = false;
		$response = createResponse(0,"Error occurred while uploading to the database: ".$mysqli->error);
	}
		
}
echo json_encode($response);
$mysqli->close();
?>