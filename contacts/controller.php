<?php
/**
 * User: kbokdia
 * Date: 02/09/15
 * Time: 12:12 PM
 */

spl_autoload_register(function ($class) {
    include $class . '.php';
});

session_start();
define("ROOT", "../");

//include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

$response = array();
$validate = false;

//Input variables
$regCode = intval($_SESSION['s_id']);
$contactCode = 0;
$title = "";
$titleCode = "NULL";
$fName = "";
$mName = "NULL";
$lName = "NULL";
$fullName = "";
$mobile1 = "NULL";
$mobile2 = "NULL";
$mobile3 = "NULL";
$email1 = "NULL";
$email2 = "NULL";
$defaultAddress = "NULL";
$guardian = "NULL";
$dob = "NULL";
$dom = "NULL";
$group = "NULL";
$groupCode = "NULL";
$emergency = "NULL";
$emergencyCode = "NULL";
$remarks = "NULL";
$alias = "NULL";
$company = "NULL";
$designation = "NULL";
$facebook = "NULL";
$twitter = "NULL";
$googlePlus = "NULL";
$linkedin = "NULL";
$website = "NULL";
$private = "NULL";
$active = "NULL";
$home = new Address();
$work = new Address();
$others = new Address();
//print_r($home->getAddress()["address1"]);
$mode = 0;

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

//General Validation
do {
    if(isset($_POST)){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid request");
        break;
    }

    //Required Validation
    if(!empty($_POST['mode']) && !empty($_POST['addTitle']) && !empty($_POST['firstName'])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Required fields are missing");
        break;
    }

} while (0);

//Business Logic
if ($validate) {
    $sql = "";

    $titleCode = ((!empty($_POST['titleCode'])) ? $_POST['titleCode'] : "NULL");
    $groupCode = ((!empty($_POST['groupCode'])) ? $_POST['groupCode'] : "NULL");
    $emergencyCode = ((!empty($_POST['emergencyCode'])) ? $_POST['emergencyCode'] : "NULL");

    $sql .= "set @sTitleCode = ".$titleCode.";";
    $sql .= "set @sGroupCode = ".$groupCode.";";
    $sql .= "set @sEmergencyCode = ".$emergencyCode.";";
    do{
        if($_POST["mode"] == "D"){
            $mode = 3;
            $contactCode = $_POST["contactCode"];
        }

        if($_POST["mode"] == "M"){
            $mode = 2;
            $contactCode = $_POST["contactCode"];
        }

        if($_POST["mode"] == "A"){
            $mode = 1;
            $contactCode = 0;
        }

        //create title code
        if(intval($_POST["titleCode"]) < 1000 && !empty($_POST['title'])){
            $title = "'".$_POST["title"]."'";
            $sql .= "call spTable114(@sTitleCode,
                    ".$title.",
                    NULL,
                    ".$regCode.",
                    1);";
        }

        //create group code
        if(intval($_POST["groupCode"]) < 1000 && !empty($_POST['group'])){
            $group = "'".$_POST['group']."'";
            $sql .= "call spTable126(@sGroupCode,
                    ".$group.",
                    ".$regCode.",
                    1);";
        }

        //create emergency code
        if(intval($_POST["emergencyCode"]) < 1000 && !empty($_POST['emergency'])){
            $emergency = "'".$_POST["emergency"]."'";
            $sql .= "call spTable128(@sEmergencyCode,
                    @sEmergencyName,
                    @sRegCode,
                    1);";
        }

//            //create city code
//            if(intval($_POST["cityCode"]) < 1000){
//
//            }
//
//            //create state code
//            if(intval($_POST["stateCode"]) < 1000){
//
//            }
//
//            //create country code
//            if(intval($_POST["countryCode"]) < 1000){
//
//            }

        $fName = "'".$_POST['firstName']."'";
        $mName = (!empty($_POST['middleName']) ? "'".$_POST['middleName']."'" : "NULL");
        $lName = (!empty($_POST['lastName']) ? "'".$_POST['lastName']."'" : "NULL");
        $fullName = "'".$_POST['firstName'].(!empty($_POST['middleName']) ? " ".$_POST['middleName'] : "").(!empty($_POST['lastName']) ? " ".$_POST['lastName'] : "")."'";
        $mobile1 = (!empty($_POST['mobile1']) ? "'".$_POST['mobile1']."'" : "NULL");
        $mobile2 = (!empty($_POST['mobile2']) ? "'".$_POST['mobile2']."'" : "NULL");
        $mobile3 = (!empty($_POST['mobile3']) ? "'".$_POST['mobile3']."'" : "NULL");
        $email1 = (!empty($_POST['email1']) ? "'".$_POST['email1']."'" : "NULL");
        $email2 = (!empty($_POST['email2']) ? "'".$_POST['email2']."'" : "NULL");
        $defaultAddress = (!empty($_POST['defaultAddress']) ? $_POST['defaultAddress'] : "NULL");
        $guardian = (!empty($_POST['guardianName']) ? "'".$_POST['guardianName']."'" : "NULL");
        $dob = (!empty($_POST['dob']) ? "'".$_POST['dob']."'" : "NULL");
        $dom = (!empty($_POST['dom']) ? "'".$_POST['dom']."'" : "NULL");
        $remarks = (!empty($_POST['remarks']) ? "'".$_POST['remarks']."'" : "NULL");
        $alias = (!empty($_POST['alias']) ? "'".$_POST['alias']."'" : "NULL");
        $company = (!empty($_POST['company']) ? "'".$_POST['company']."'" : "NULL");
        $designation = (!empty($_POST['designation']) ? "'".$_POST['designation']."'" : "NULL");
        $facebook = (!empty($_POST['facebook']) ? "'".$_POST['facebook']."'" : "NULL");
        $twitter = (!empty($_POST['twitter']) ? "'".$_POST['twitter']."'" : "NULL");
        $googlePlus = (!empty($_POST['google']) ? "'".$_POST['google']."'" : "NULL");
        $linkedin = (!empty($_POST['linkedin']) ? "'".$_POST['linkedin']."'" : "NULL");
        $website = (!empty($_POST['website']) ? "'".$_POST['website']."'" : "NULL");
        $private = (isset($_POST["private"]) ? "1" : "2");
        $active = (isset($_POST["active"]) ? "1" : "2");

        $sql .= "call spTable151(
            ".$regCode.",
            ".$contactCode.",
            ".$fName.",
            ".$mName.",
            ".$lName.",
            ".$fullName.",
            @sTitleCode,
            ".$guardian.",
            ".$company.",
            ".$designation.",
            ".$alias.",
            ".$dob.",
            ".$dom.",
            @sGroupCode,
            @sEmergencyCode,
            ".$remarks.",
            ".$mobile1.",
            ".$mobile2.",
            ".$mobile3.",
            ".$email1.",
            ".$email2.",
            ".$facebook.",
            ".$twitter.",
            ".$googlePlus.",
            ".$linkedin.",
            ".$website.",
            1,
            1,
            0,
            ".$defaultAddress.",
            ".$private.",
            ".$active.",
            NOW(),
            ".$mode.");";
    }while(0);

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