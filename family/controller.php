<?php
session_start();
define("ROOT", "../");

include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

$response = array();
$validate;

class FamilyController
{
    var $mode;
    var $data;
    var $regCode;
    var $familyCode;
    var $isParent;
    var $response;
    var $mysqli;

    function __construct($data){
        $this->mysqli = getConnection();
        $this->data = $data;
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']); //Session family code
        $this->isParent = (($this->familyCode == 1001) ? true : false );

        //set mode
        if($this->data["mode"] == "A"){
            $this->mode = 1;
        }
        elseif($this->data["mode"] == "M"){
            $this->mode = 2;
        }
        elseif($this->data["mode"] == "D"){
            $this->mode = 3;
        }

        //call respect methods based on mode
        switch($this->mode){
            case 1:
                $this->addMember();
                break;
            case 2:
                $this->editMember();
                break;
            case 3:
                $this->deleteMember();
                break;
        }
    }

    function getDeleteQuery($dataFamilyCode){
        return "DELETE FROM Table109 WHERE RegCode = ".$this->regCode." AND FamilyCode = ".$dataFamilyCode.";"."DELETE FROM Table107 WHERE RegCode = ".$this->regCode." AND FamilyCode = ".$dataFamilyCode.";";
    }

    function deleteMember(){
        if(!$this->isParent){
            $this->response = createResponse(0,"You do not have permission to delete");
            return;
        }
        elseif($this->familyCode == intval($this->data["familyCode"])){
            $this->response = createResponse(0,"SELF cannot be deleted");
            return;
        }
        else{
            $this->runMultipleQuery($this->getDeleteQuery(intval($this->data["familyCode"])));
        }
    }

    function editMember(){
        if(!$this->isParent && intval($this->data["familyCode"]) != $this->familyCode){
            $this->response = createResponse(0,"You cannot edit this person");
            return;
        }

        $isChanged = true;
        $sql = "SELECT LoginFlag FROM Table107 WHERE RegCode = ".$this->regCode." AND FamilyCode =".intval($this->data["familyCode"]);
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 1){
                if(intval($result->fetch_assoc()['LoginFlag']) == intval($this->data["access"])){
                    $isChanged = false;
                }
            }
        }

        $validate = true;
        $sql = "";

        //if login access is changed then check the state
        if($isChanged && intval($this->data["familyCode"]) != $this->familyCode){
            if(intval($this->data["access"]) == 1){
                if($this->isMailIdAvailable() && validatePassword()){
                    $validate = true;
                }
                else{
                    $this->response = createResponse(0,"Mail ID is unavailable or Password details do not match the policy");
                    $validate = false;
                    return;
                }
            }
            elseif(intval($this->data["access"]) == 2){
                $sql .= "DELETE FROM Table109 WHERE RegCode = ".$this->regCode." AND FamilyCode = ".intval($this->data["familyCode"]).";";
                $sql .= "UPDATE Table107 SET Email = NULL WHERE RegCode = ".$this->regCode." AND FamilyCode = ".intval($this->data["familyCode"]).";";
            }
            $sql .= $this->getSpTable107Query();
        }
        else{
            $name = "'".$this->data['name']."'";
            $relationCode = $this->data['relation'];
            $dob = "'".$this->data['dob']."'";
            $mobile = ((!empty($this->data['mobile'])) ? "'".$this->data['mobile']."'" : "NULL");
            $gender = intval($this->data['gender']);

            $sql .= "UPDATE `Table107` SET `FamilyName` = ".$name.", `RelationCode` = ".$relationCode.",  `BirthDate` = ".$dob.", `Mobile` = ".$mobile.", `Gender` = ".$gender." WHERE `RegCode` = ".$this->regCode." AND `FamilyCode` = ".intval($this->data["familyCode"]).";";
            $sql .= "UPDATE `Table109` SET `RegName` = ".$name.", `RegMobile` = ".$mobile."
                    WHERE `RegCode` = ".$this->regCode." AND `FamilyCode` = ".intval($this->data["familyCode"]).";";
        }

        if($validate){
            $this->runMultipleQuery($sql);
        }
    }

    function addMember(){
        if(!$this->isParent){
            $this->response = createResponse(0,"You cannot add a member");
            return;
        }

        $validate = true;

        if(intval($this->data["access"]) == 1){
            if($this->isMailIdAvailable() && validatePassword()){
                $validate = true;
            }
            else{
                $this->response = createResponse(0,"Mail ID is unavailable or Password details do not match the policy");
                $validate = false;
                return;
            }
        }

        if($validate){
            $sql = $this->getSpTable107Query();
            $this->runMultipleQuery($sql);
        }
    }

    function isMailIdAvailable(){
        $qry1 = "SELECT count(*) as 'count' FROM Table109 WHERE RegEmail = '".$this->data['email']."';";
        if ($result = $this->mysqli->query($qry1)) {
            $row = $result->fetch_assoc();
            if (intval($row['count']) == 0) {
                return true;
            }
            else{
                return  false;
            }
        }
        else{
            return false;
        }
    }

    function getSpTable107Query(){
        $name = "'".$this->data['name']."'";
        $relationCode = $this->data['relation'];
        $dob = "'".$this->data['dob']."'";
        $email = ((intval($this->data["access"]) == 1) ? "'". $this->data['email']."'" : "NULL");
        $mobile = "'".$this->data['mobile']."'";
        $password = ((intval($this->data["access"]) == 1) ? "'".hash("sha256", $this->data['password'])."'" : "null");
        $gender = intval($this->data['gender']);
        $parentFlag = ((intval($this->data["familyCode"]) == 1001) ? 1 : 2);
        $loginFlag = ((intval($this->data["access"]) == 1) ? 1 : 2);
        $activeFlag = 1;

        $sql =  "call spTable107(
					".$this->regCode.",
					".intval($this->data["familyCode"]).",
					".$name.",
					".$relationCode.",
					".$dob.",
					".$email.",
					".$mobile.",
					".$password.",
					".$gender.",
					".$parentFlag.",
					".$loginFlag.",
					".$activeFlag.",
					".$this->mode."
				);";

        return $sql;
    }

    function runMultipleQuery($sql){
        if ($this->mysqli->multi_query($sql) === TRUE) {
            $this->response = createResponse(1,"Successful");
        }
        else{
            $this->response = createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }
    }

    function getResponse(){
        return $this->response;
    }

    function __destruct(){
        $this->mysqli->close();
    }
}

//Input variables
$regCode = intval($_SESSION['s_id']);
$sFamilyCode = intval($_SESSION['familyCode']); //Session family code
$pFamilyCode = 0; // Post Family code
$name = "null";
$relationCode = 0;
$relationName = "";
$dob = "null";
$email = "null";
$mobile = "null";
$password = "null";
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
	$validate = false;

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
	if ($validate && !empty($_POST["name"]) && !empty($_POST["relation"]) && !empty($_POST['dob']) && !empty($_POST['gender'])) {
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
    $familyController = new FamilyController($_POST);
    $response = $familyController->getResponse();
}
echo json_encode($response);
$mysqli->close();
?>