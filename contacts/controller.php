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

include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

$response = array();
$validate = false;
$landing;
//print_r($_POST);

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
$home;
$work;
$others;
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

    if(!empty($_POST['mode'])){
        $validate = true;
        if($_POST['mode'] == "D"){
            break;
        }
    }

    //Required Validation
    if(!empty($_POST['mode']) && !empty($_POST['title']) && !empty($_POST['firstName'])){
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

        if($_POST["mode"] == "M" || $_POST["mode"] == "A"){

            if($_POST["mode"] == "M"){
                $mode = 2;
                $contactCode = $_POST["contactCode"];
                $landing = $contactCode;
            }
            elseif($_POST["mode"] == "A"){
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
                    ".$emergency.",
                    ".$regCode.",
                    1);";
            }
        }

        $fName = (!empty($_POST['firstName']) ? "'".$_POST['firstName']."'" : "NULL");
        $mName = (!empty($_POST['middleName']) ? "'".$_POST['middleName']."'" : "NULL");
        $lName = (!empty($_POST['lastName']) ? "'".$_POST['lastName']."'" : "NULL");
        $fullName = "'".(!empty($_POST['firstName']) ? $_POST['firstName'] : "").(!empty($_POST['middleName']) ? " ".$_POST['middleName'] : "").(!empty($_POST['lastName']) ? " ".$_POST['lastName'] : "")."'";
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

        $sql .= "SET @contactCode = ".$contactCode.";";
        $sql .= "call spTable151(
            ".$regCode.",
            @contactCode,
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
        $sql .= "SELECT @contactCode as 'ContactCode';";

        if(!empty($_POST["address"]["home"])){
            $home = $_POST["address"]["home"];

            $areaCode = (!empty($home['areaCode']) ? "'".$home['areaCode']."'" : "NULL");
            $cityCode = (!empty($home['cityCode']) ? "'".$home['cityCode']."'" : "NULL");
            $stateCode = (!empty($home['stateCode']) ? "'".$home['stateCode']."'" : "NULL");
            $countryCode = (!empty($home['countryCode']) ? "'".$home['countryCode']."'" : "NULL");

            $sql .= "set @sAreaCode = ".$areaCode.";";
            $sql .= "set @sCityCode = ".$cityCode.";";
            $sql .= "set @sStateCode = ".$stateCode.";";
            $sql .= "set @sCountryCode = ".$countryCode.";";

            $address1 = (!empty($home['address1']) ? "'".$home['address1']."'" : "NULL");
            $address2 = (!empty($home['address2']) ? "'".$home['address2']."'" : "NULL");
            $address3 = (!empty($home['address3']) ? "'".$home['address3']."'" : "NULL");
            $address4 = (!empty($home['address4']) ? "'".$home['address4']."'" : "NULL");
            $address5 = (!empty($home['address5']) ? "'".$home['address5']."'" : "NULL");
            $city = (!empty($home['city']) ? "'".$home['city']."'" : "NULL");
            $state = (!empty($home['state']) ? "'".$home['state']."'" : "NULL");
            $country = (!empty($home['country']) ? "'".$home['country']."'" : "NULL");
            $pincode = (!empty($home['pincode']) ? "'".$home['pincode']."'" : "NULL");
            $area = (!empty($home['area']) ? "'".$home['area']."'" : "NULL");
            $phone1 = (!empty($home['phone1']) ? "'".$home['phone1']."'" : "NULL");
            $phone2 = (!empty($home['phone2']) ? "'".$home['phone2']."'" : "NULL");

            //create codes
            if(intval($home["countryCode"]) < 1000 && !empty($home["country"])){
                $sql .= "call spTable106(@sCountryCode, ".$country.", NULL, NULL, 1);";
            }
            if(intval($home["stateCode"]) < 1000 && !empty($home['state'])){
                $sql .= "call spTable108(@sStateCode, ".$state.", @sCountryCode, ".$regCode.", 1);";
            }
            if(intval($home["cityCode"]) < 1000 && !empty($home['city'])){
                $sql .= "call spTable110(@sCityCode, ".$city.", @sStateCode, @sCountryCode, ".$regCode.", 1);";
            }
            if(intval($home["areaCode"]) < 1000 && !empty($home['area'])){
                $sql .= "call spTable119(@sAreaCode, ".$area.", ".$regCode.", 1);";
            }

            $sql .= "call spTable153(".$regCode.", ".$contactCode.",".$address1.", ".$address2.", ".$address3.", ".$address4.", ".$address5.", ".$pincode.", @sCountryCode, @sStateCode, @sCityCode, @sAreaCode, ".$phone1.", ".$phone2.", NULL, $mode);";
        }

        if(!empty($_POST["address"]["work"])){
            $work = $_POST["address"]["work"];

            $areaCode = (!empty($work['areaCode']) ? "'".$work['areaCode']."'" : "NULL");
            $cityCode = (!empty($work['cityCode']) ? "'".$work['cityCode']."'" : "NULL");
            $stateCode = (!empty($work['stateCode']) ? "'".$work['stateCode']."'" : "NULL");
            $countryCode = (!empty($work['countryCode']) ? "'".$work['countryCode']."'" : "NULL");

            $sql .= "set @sAreaCode = ".$areaCode.";";
            $sql .= "set @sCityCode = ".$cityCode.";";
            $sql .= "set @sStateCode = ".$stateCode.";";
            $sql .= "set @sCountryCode = ".$countryCode.";";

            $address1 = (!empty($work['address1']) ? "'".$work['address1']."'" : "NULL");
            $address2 = (!empty($work['address2']) ? "'".$work['address2']."'" : "NULL");
            $address3 = (!empty($work['address3']) ? "'".$work['address3']."'" : "NULL");
            $address4 = (!empty($work['address4']) ? "'".$work['address4']."'" : "NULL");
            $address5 = (!empty($work['address5']) ? "'".$work['address5']."'" : "NULL");
            $city = (!empty($work['city']) ? "'".$work['city']."'" : "NULL");
            $state = (!empty($work['state']) ? "'".$work['state']."'" : "NULL");
            $country = (!empty($work['country']) ? "'".$work['country']."'" : "NULL");
            $pincode = (!empty($work['pincode']) ? "'".$work['pincode']."'" : "NULL");
            $area = (!empty($work['area']) ? "'".$work['area']."'" : "NULL");
            $phone1 = (!empty($work['phone1']) ? "'".$work['phone1']."'" : "NULL");
            $phone2 = (!empty($work['phone2']) ? "'".$work['phone2']."'" : "NULL");

            //create codes
            if(intval($work["countryCode"]) < 1000 && !empty($work["country"])){
                $sql .= "call spTable106(@sCountryCode, ".$country.", NULL, NULL, 1);";
            }
            if(intval($work["stateCode"]) < 1000 && !empty($work['state'])){
                $sql .= "call spTable108(@sStateCode, ".$state.", @sCountryCode, ".$regCode.", 1);";
            }
            if(intval($work["cityCode"]) < 1000 && !empty($work['city'])){
                $sql .= "call spTable110(@sCityCode, ".$city.", @sStateCode, @sCountryCode, ".$regCode.", 1);";
            }
            if(intval($work["areaCode"]) < 1000 && !empty($work['area'])){
                $sql .= "call spTable119(@sAreaCode, ".$area.", ".$regCode.", 1);";
            }

            $sql .= "call spTable155(".$regCode.", ".$contactCode.",".$address1.", ".$address2.", ".$address3.", ".$address4.", ".$address5.", ".$pincode.", @sCountryCode, @sStateCode, @sCityCode, @sAreaCode, ".$phone1.", ".$phone2.", NULL, $mode);";
        }

        if(!empty($_POST["address"]["other"])){
            $other = $_POST["address"]["other"];

            $areaCode = (!empty($other['areaCode']) ? "'".$other['areaCode']."'" : "NULL");
            $cityCode = (!empty($other['cityCode']) ? "'".$other['cityCode']."'" : "NULL");
            $stateCode = (!empty($other['stateCode']) ? "'".$other['stateCode']."'" : "NULL");
            $countryCode = (!empty($other['countryCode']) ? "'".$other['countryCode']."'" : "NULL");

            $sql .= "set @sAreaCode = ".$areaCode.";";
            $sql .= "set @sCityCode = ".$cityCode.";";
            $sql .= "set @sStateCode = ".$stateCode.";";
            $sql .= "set @sCountryCode = ".$countryCode.";";

            $address1 = (!empty($other['address1']) ? "'".$other['address1']."'" : "NULL");
            $address2 = (!empty($other['address2']) ? "'".$other['address2']."'" : "NULL");
            $address3 = (!empty($other['address3']) ? "'".$other['address3']."'" : "NULL");
            $address4 = (!empty($other['address4']) ? "'".$other['address4']."'" : "NULL");
            $address5 = (!empty($other['address5']) ? "'".$other['address5']."'" : "NULL");
            $city = (!empty($other['city']) ? "'".$other['city']."'" : "NULL");
            $state = (!empty($other['state']) ? "'".$other['state']."'" : "NULL");
            $country = (!empty($other['country']) ? "'".$other['country']."'" : "NULL");
            $pincode = (!empty($other['pincode']) ? "'".$other['pincode']."'" : "NULL");
            $area = (!empty($other['area']) ? "'".$other['area']."'" : "NULL");
            $phone1 = (!empty($other['phone1']) ? "'".$other['phone1']."'" : "NULL");
            $phone2 = (!empty($other['phone2']) ? "'".$other['phone2']."'" : "NULL");

            //create codes
            if(intval($other["countryCode"]) < 1000 && !empty($other["country"])){
                $sql .= "call spTable106(@sCountryCode, ".$country.", NULL, NULL, 1);";
            }
            if(intval($other["stateCode"]) < 1000 && !empty($other['state'])){
                $sql .= "call spTable108(@sStateCode, ".$state.", @sCountryCode, ".$regCode.", 1);";
            }
            if(intval($other["cityCode"]) < 1000 && !empty($other['city'])){
                $sql .= "call spTable110(@sCityCode, ".$city.", @sStateCode, @sCountryCode, ".$regCode.", 1);";
            }
            if(intval($other["areaCode"]) < 1000 && !empty($other['area'])){
                $sql .= "call spTable119(@sAreaCode, ".$area.", ".$regCode.", 1);";
            }

            $sql .= "call spTable157(".$regCode.", ".$contactCode.",".$address1.", ".$address2.", ".$address3.", ".$address4.", ".$address5.", ".$pincode.", @sCountryCode, @sStateCode, @sCityCode, @sAreaCode, ".$phone1.", ".$phone2.", NULL, $mode);";
        }

    }while(0);

    //echo $sql;
    if ($mysqli->multi_query($sql)) {
        do {
            /* store first result set */
            if ($result = $mysqli->use_result()) {
                while ($row = $result->fetch_row()) {
                    $landing = $row[0];
                }
                $result->close();
            }
        } while ($mysqli->next_result());

        $validate = true;
        $response = createResponse(1,"Successful");
        $response["landing"] = $landing;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Error occurred while uploading to the database: ".$mysqli->error);
    }

}
echo json_encode($response);
$mysqli->close();
?>