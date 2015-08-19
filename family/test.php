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

function createResponse($status,$message){
	return array('status' => $status, 'message' => $message);
}

//print_r($_POST);
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

	//check mode if its delete mode then skip input validation
	if ($validate && $_POST["mode"] == "D") {
		break;
	}

	//Required fields validation
	if ($validate && !empty($_POST["name"]) && !empty($_POST["relation"]) && !empty($_POST['dob']) && !empty($_POST['email']) && !empty($_POST['gender'])) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"Required fields are empty");
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

	//Email validation
	if ($validate && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0, "Invalid email");
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

	//Only parent can add the child users
	if($_POST["mode"] == "A" && intval($_SESSION['familyCode']) == 1001 || $_POST["mode"] == "M"){
		$validate = true;
	}
	else{
		$validate = false;
		$response = createResponse(0,"You are not allowed to add user");
		break;
	}

	//Password validation
	if ($validate && intval($_POST['access']) == 1 && $_POST["mode"] == "A") {
		$validate = true;

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
	}
	

} while (0);

//Business Validation
if ($validate && $_POST["mode"] != "D") {
	do {
		if (intval($_POST['access']) == 1 ) {
			$sql = "SELECT count(*) as 'count' FROM `Table109` WHERE `RegEmail` = '".$_POST['email']."' AND NOT RegName = '".$_POST['name']."';";
			if ($result = $mysqli->query($sql)) {
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
		}
		
	} while (0);
}

//Business logic
if ($validate) {
	do {
		$sql = "";
		$s_familyCode = intval($_SESSION['familyCode']);
		
		//Delete
		if ($_POST["mode"] == "D") {
			$p_familyCode = intval($_POST['familyCode']);
			
			if ($s_familyCode == $p_familyCode || $s_familyCode != 1001) {
				$validate = false;
				$response = createResponse(0,"You cannot delete this person");
				break;
			}
			else{
				$sql .= "DELETE FROM Table107 WHERE RegCode = ".$_SESSION['s_id']." AND FamilyCode = ".$p_familyCode.";";
				$sql .= "DELETE FROM Table109 WHERE RegCode = ".$_SESSION['s_id']." AND FamilyCode = ".$p_familyCode.";";
			}

		}

		//Modify
		if ($_POST["mode"] == "M") {
			$p_familyCode = intval($_POST['familyCode']);

			if ($s_familyCode > 1001 && $s_familyCode != $p_familyCode) {
				$validate = false;
				$response = createResponse(0,"You cannot edit this person");
				break;
			}
			else{
				$sql .= "DELETE FROM Table107 WHERE RegCode = ".$_SESSION['s_id']." AND FamilyCode = ".$p_familyCode.";";
			}
		}

		//Add or modify
		if ($_POST["mode"] == "M" || $_POST["mode"] == "A") {
			$familyCode = 0;
			//If add mode then generate code
			if ($_POST["mode"] == "A") {
				
				$qry = "SELECT MAX(FamilyCode) as 'FamilyCode' FROM Table107 WHERE RegCode = ".$_SESSION['s_id'];
				//echo $qry;
				if ($result = $mysqli->query($qry)) {	
			      while ($row = $result->fetch_assoc()) {
			        if (is_null($row['FamilyCode'])) {
			          $familyCode = 1001;     
			        }
			        else{
			        	$familyCode = intval($row['FamilyCode']) + 1;
			        }
			      }
			    
				}
			}

			$sql .= build_insert_str('Table107',array(
				intval($_SESSION['s_id']),
				(($_POST["mode"] == "A") ? $familyCode : intval($_POST["familyCode"])),
				$_POST['name'],
				$_POST['relation'],
				"'".$_POST['dob']."'",
				$_POST['email'],
				$_POST['mobile'],
				((intval($_POST["access"]) == 1) ? hash("sha256", $_POST['password']) : ""),
				intval($_POST['gender']),
				((intval($_POST["access"]) == 1) ? 1 : 0),
				1
			));	

			if ($s_familyCode == 1001) {
				
				$p_familyCode = intval($_POST['familyCode']);
				//if Access provided
				if ($_POST["access"] == 1) {
					$qry = "SELECT count(*) as 'count' FROM Table109 WHERE RegCode = ".$_SESSION['s_id']." AND FamilyCode = ".$p_familyCode.";";

					if ($result = $mysqli->query($qry)) {
						$row = $result->fetch_assoc();
						if (intval($row['count']) == 0) {
							
							$sql .= build_insert_str('Table109',array(
								intval($_SESSION['s_id']),
								$_POST['name'],
								$_POST['email'],
								hash("sha256", $_POST['password']),
								$_POST['mobile'],
								(($_POST["mode"] == "A") ? $familyCode : intval($_POST["familyCode"])),
								(($familyCode == 1001) ? 1 : 2), // => 1 for parent and 2 for child
								1 	// => 1 for active and 2 for inactive
							));
						}
						else{
							$sql .= "UPDATE `Table109` SET `RegName`= '".$_POST['name']."', `RegMobile`= '".$_POST['mobile']."', `ActiveFlag`= 1 WHERE `RegCode` = ".intval($_SESSION['s_id'])." AND `FamilyCode`= ".$p_familyCode.";";
						}
					}
				}
				//if no access
				else{
					//check if data is present in Table109
					$qry = "SELECT count(*) as 'count' FROM Table109 WHERE RegCode = ".$_SESSION['s_id']." AND FamilyCode = ".$p_familyCode.";";

					if ($result = $mysqli->query($qry)) {
						$row = $result->fetch_assoc();
						//if yes delete the record
						if (intval($row['count']) > 0) {
							$sql .= "DELETE FROM Table109 WHERE RegCode = ".$_SESSION['s_id']." AND FamilyCode = ".$p_familyCode.";";
						}
					}
				}
			}
			
		}

		echo $sql;
		if ($mysqli->multi_query($sql) === TRUE) {
			$response = createResponse(1,"Successfull");
		}
		else{
			$response = createResponse(0,"Error occured while uploading to the database: ".$mysqli->error);
		}
	} while (0);	
}
echo json_encode($response);
$mysqli->close();
?>