<?php
/**
 * User: kbokdia
 * Date: 03/09/15
 * Time: 6:13 PM
 */
session_start();
define("ROOT", "../");
include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$validate;
$response;

class ContactDetail
{
    var $contactCode;
    var $detail;
    var $mysqli;
    var $regCode;
    var $response;
    var $successful; // if contacts retrieved then successful
    var $errMsg;

    function __construct($contactCode){
        $this->contactCode = $contactCode;
        $this->regCode = intval($_SESSION['s_id']);
        $this->mysqli = getConnection();
        $this->setContactDetail();
    }

    function getContactDetailQuery(){
        $sql = "SELECT `Table151`.`ContactCode`,
            `Table114`.`TitleName`,
            `Table151`.`FirstName`,
            `Table151`.`MiddleName`,
            `Table151`.`LastName`,
            `Table151`.`FullName`,
            `Table151`.`TitleCode`,
            `Table151`.`GuardianName`,
            `Table151`.`Company`,
            `Table151`.`Designation`,
            `Table151`.`Alias`,
            `Table151`.`Dob`,
            `Table151`.`Dom`,
            `Table126`.`GroupName`,
            `Table151`.`GroupCode`,
            `Table128`.`EmergencyName`,
            `Table151`.`EmergencyCode`,
            `Table151`.`Remarks`,
            `Table151`.`Mobile1`,
            `Table151`.`Mobile2`,
            `Table151`.`Mobile3`,
            `Table151`.`Email1`,
            `Table151`.`Email2`,
            `Table151`.`Facebook`,
            `Table151`.`Twitter`,
            `Table151`.`Google`,
            `Table151`.`Linkedin`,
            `Table151`.`Website`,
            `Table151`.`TotalAddresses`,
            `Table151`.`TotalFamilyMembers`,
            `Table151`.`PhotoUploaded`,
            `Table151`.`CommunicateAddress`,
            `Table151`.`PrivateFlag`,
            `Table151`.`ActiveFlag`,
            `Table151`.`LastAccessDateTime`
        FROM `assistant`.`Table151`
        LEFT JOIN Table114 ON Table114.TitleCode = Table151.TitleCode
        LEFT JOIN Table126 ON Table126.GroupCode = Table151.GroupCode
        LEFT JOIN Table128 ON Table128.EmergencyCode = Table151.EmergencyCode
        WHERE Table151.`RegCode` = ".$this->regCode." AND Table151.`ContactCode` = ".$this->contactCode.";
        ";
        return $sql;
    }

    function setContactDetail(){
        $sql = $this->getContactDetailQuery();
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 1){
                $this->successful = true;
                $this->detail["contact"] = $result->fetch_assoc();
            }
            else{
                $this->successful = false;
                $this->errMsg = "No detail";
            }

        }
        else{
            $this->successful = false;
            $this->errMsg = $this->mysqli->error;
        }
    }

    function getResponse(){
        if($this->successful){
            $this->response = createResponse(1,"Success");
            $this->response["detail"] = $this->detail;
        }
        else{
            $this->response = createResponse(0,$this->errMsg);
        }
        return $this->response;
    }

    function __destruct(){
        $this->mysqli->close();
    }
}

//General Validation
do{
    if(!empty($_GET["contactCode"])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }
}while(0);

//Business Logic
if($validate){
    $contactCode = intval($_GET["contactCode"]);
    $detailObj = new ContactDetail($contactCode);
    $response = $detailObj->getResponse();
}
echo json_encode($response);