<?php
define("ROOT", "../");

require_once ROOT . 'db/Connection.php';
require_once ROOT . 'modules/functions.php';
$mysqli = getConnection();

$response = array();
$validate;

function createResponse($status, $message)
{
    return array('status' => $status, 'message' => $message);
}

function createInitialFolders($regCode)
{
    $path = ROOT . "img/" . $regCode;
    if(!file_exists($path)){
        mkdir($path);
    }
    $path = ROOT . "img/" . $regCode . "/Contacts";
    if(!file_exists($path)){
        mkdir($path);
    }
    $path = ROOT . "img/" . $regCode . "/Investments";
    if(!file_exists($path)){
        mkdir($path);
    }
    $path = ROOT . "img/" . $regCode . "/Assets";
    if(!file_exists($path)){
        mkdir($path);
    }
    $path = ROOT . "img/" . $regCode . "/Documents";
    if(!file_exists($path)){
        mkdir($path);
    }
}

function generateRegCode(){
    global $mysqli;
    $regCode = 10001;
    $sql = "SELECT MAX(RegCode) AS 'regCode' FROM Table109;";
    if($result = $mysqli->query($sql)){
        $regCode = intval($result->fetch_assoc()["regCode"]);
        $regCode = (($regCode == 0) ? 10001 : $regCode + 1);
    }
    return $regCode;
}

//General Validation
do {
    if (isset($_POST)) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Invalid");
        break;
    }

    //Required fields validation
    if ($validate && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmPassword']) && !empty($_POST['name']) && !empty($_POST['country']) && !empty($_POST['mobile'])) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Required fields are empty");
        break;
    }

    //Email validation
    if ($validate && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Invalid email");
        break;
    }

    //Validate password length
    if (strlen($_POST['password']) > 7 && strlen($_POST['password']) < 17) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Password length should be between 8 to 16 characters");
        break;
    }

    //Validate confirm password and password
    if ($_POST['password'] == $_POST['confirmPassword']) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Password and confirm password are not similar");
        break;
    }

    //Name validation
    if ($validate && preg_match("/^[a-zA-Z ]*$/", $_POST['name'])) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Invalid Name");
        break;
    }

} while (0);

$_POST = safeStringForSQL($_POST);

//Business validation
if ($validate) {
    do {
        //Check if mail ID is already registered or not
        $qry1 = "SELECT count(*) as 'count' FROM `Table109` WHERE `RegEmail` = '" . $_POST['email'] . "';";
        if ($result = $mysqli->query($qry1)) {
            $row = $result->fetch_assoc();
            if (intval($row['count']) == 0) {
                $validate = true;
            } else {
                $validate = false;
                $response = createResponse(0, "This Mail ID is already registered");
                break;
            }
        }
    } while (0);
}

//Business Logic
if ($validate) {
    do {
        $regCode = generateRegCode();
        $familyCode = 1001;
        $name = "'" . $_POST['name'] . "'";
        $relationCode = 1; //Self
        $gender = 0; //initialize
        $dob = (empty($_POST['dob']) ? "NULL" : "'" . $_POST['dob'] . "'");
        $email = "'" . $_POST['email'] . "'";
        $password = "'" . hash("sha256", $_POST['password']) . "'";
        $mobile = "'" . $_POST['mobile'] . "'";
        $parentFlag = 1;
        $loginFlag = 1;
        $activeFlag = 1;
        $country = intval($_POST["country"]);
        $familySize = 1;
        $renewalNo = 1;
        $feesCollected = 0;
        $dataSizeUsed = 0;
        $photoUploaded = 0;
        $noOfHits = 0;
        $nextYear = new DateTime("now");
        $nextYear->add(new DateInterval('P1Y'));
        $today = new DateTime("now");

        $sql = "call createNewUser(
			" . $regCode . ",
			" . $familyCode . ",
			" . $name . ",
			" . $relationCode . ",
			" . $dob . ",
			" . $email . ",
			" . $mobile . ",
			" . $password . ",
			" . $gender . ",
			" . $parentFlag . ",
			" . $loginFlag . ",
			" . $activeFlag . ",
			CURDATE(),
			" . $country . ",
			" . $renewalNo . ",
			'". $today->format("Y-m-d") . "',
			'". $nextYear->format("Y-m-d") . "',
			" . $familySize . ",
			" . $feesCollected . ",
			" . $dataSizeUsed . ",
			" . $photoUploaded . ",
			" . $noOfHits . ",
			NOW()
		);";

        //echo $sql;
        if ($mysqli->multi_query($sql) === TRUE) {
            //echo $regCode;
            createInitialFolders($regCode);
            $response = createResponse(1, "Successful");
        } else {
            $response = createResponse(0, "Error occurred while uploading to the database: " . $mysqli->error);
            break;
        }

    } while (0);
}

echo json_encode($response);
$mysqli->close();
?>