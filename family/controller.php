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
$sFamilyCode = intval($_SESSION['familyCode']); //Session family code
$pFamilyCode = 0; // Post Family code
$name = "";
$relationCode = 0;
$relationName = "";
$dob = "";
$email = "";
$mobile = "";
$password = "";
$gender = 0;
$access = 0;
$parentFlag = 0;
$forgotFlag = 2; //default is no
$loginFlag = 2; //default is no
$activeFlag = 1; //default is active
$mode = 0;

function createResponse($status,$message){
	return array('status' => $status, 'message' => $message);
}

function validatePassword(){
	global $response;
	$validate = null;
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

	//Password validation
	if ($validate && intval($_POST['access']) == 1 && $_POST["mode"] == "A") {
		$validate = true;

		if (validatePassword()) {
			$validate = true;
		}
		else{
			$validate = false;
			break;
		}
	}
	

} while (0);


//Business Validation
if ($validate && $_POST["mode"] != "D") {
	do {
		//User validation
		if($_POST["mode"] == "A" || $_POST["mode"] == "M"){

			//Condition for add mode
			if ($_POST["mode"] == "A") {
				if (intval($_SESSION["familyCode"]) == 1001) {
					$validate = true;
				}
				else{
					$validate = false;
					$response = createResponse(0,"You are not allowed add a member");
					break;
				}
			}

			//Condition for edit mode
			if ($_POST["mode"] == "M") {
				if ((intval($_SESSION["familyCode"]) == intval($_POST["familyCode"])) || (intval($_SESSION["familyCode"]) == 1001)) {
					$validate = true;
				}
				else{
					$validate = false;
					$response = createResponse(0,"Permission Denied");
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
		$sFamilyCode = intval($_SESSION['familyCode']);

		//Delete
		if ($_POST["mode"] == "D") {
			$pFamilyCode = intval($_POST['familyCode']);
			
			if ($sFamilyCode == $pFamilyCode || $sFamilyCode != 1001) {
				$validate = false;
				$response = createResponse(0,"You cannot delete this person");
				break;
			}
			else{
                $mode = 3;
                $sql .= "call spTable109(
                    ".$regCode.",
                    ".$name.",
                    ".$email.",
                    ".$password.",
                    ".$mobile.",
                    ".$pFamilyCode.",
                    ".$parentFlag.",
                    ".$activeFlag.",
                    ".$forgotFlag.",
                    ".$mode.",
                 );";
				//$sql .= "DELETE FROM Table107 WHERE RegCode = ".$_SESSION['s_id']." AND FamilyCode = ".$pFamilyCode.";";
				//$sql .= "DELETE FROM Table109 WHERE RegCode = ".$_SESSION['s_id']." AND FamilyCode = ".$pFamilyCode.";";
			}

		}

		//Modify
		if ($_POST["mode"] == "M") {

			$pFamilyCode = intval($_POST['familyCode']);

			if ($sFamilyCode > 1001 && $sFamilyCode != $pFamilyCode) {
				$validate = false;
				$response = createResponse(0,"You cannot edit this person");
				break;
			}
			else{
                $mode = 2;
                $name = $_POST['name'];
                $relationCode = $_POST['relation'];
                $dob = $_POST['dob'];
                $email = $_POST['email'];
                $mobile = $_POST['mobile'];
                $password = ((intval($_POST["access"]) == 1) ? hash("sha256", $_POST['password']) : "");
                $gender = intval($_POST['gender']);
                $loginFlag = ((intval($_POST["access"]) == 1) ? 1 : 2);
                $activeFlag = 1;
				//$sql .= "DELETE FROM Table107 WHERE RegCode = ".$_SESSION['s_id']." AND FamilyCode = ".$pFamilyCode.";";
			}
		}

		//Add
		if ($_POST["mode"] == "A") {
            //If not parent break
            if($sFamilyCode != 1001){
                $validate = false;
                $response = createResponse(0,"You cannot add a person");
                break;
            }

            //On access check for mail id
            if(intval($_POST["access"]) == 1){
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
            }

            $mode = 2;
            $name = $_POST['name'];
            $relationCode = $_POST['relation'];
            $dob = $_POST['dob'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $password = ((intval($_POST["access"]) == 1) ? hash("sha256", $_POST['password']) : "");
            $gender = intval($_POST['gender']);
            $loginFlag = ((intval($_POST["access"]) == 1) ? 1 : 2);
            $activeFlag = 1;
        }

        $sql .=  "call spTable107(
					".$regCode.",
					".$pFamilyCode.",
					".$name.",
					".$relationCode.",
					".$dob.",
					".$email.",
					".$mobile.",
					".$password.",
					".$gender.",
					".$loginFlag.",
					".$activeFlag.",
					".$mode."
				);";
		//echo $sql;
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