<?php
/**
 * User: kbokdia
 * Date: 03/09/15
 * Time: 6:13 PM
 */
namespace Assistant\Contacts;

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
            DATE_FORMAT(`Table151`.`Dob`,'%d/%m/%Y') AS 'Dob',
            DATE_FORMAT(`Table151`.`Dom`,'%d/%m/%Y') AS 'Dom',
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
            `Table151`.`InsertedBy`,
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

                //Set Address
                $this->setAddressDetails();

                //Set Image URL
                if($this->detail["contact"]["PhotoUploaded"] == 1){
                    $this->setImagePath();
                }
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

    function getAddressDetailQuery($tableName){
        $sql = "SELECT ".$tableName.".`Address1`, ".$tableName.".`Address2`, ".$tableName.".`Address3`, ".$tableName.".`Address4`, ".$tableName.".`Address5`, ".$tableName.".`Pincode`, Table106.CountryName,".$tableName.".`CountryCode`, Table108.StateName,".$tableName.".`StateCode`, Table110.CityName,".$tableName.".`CityCode`, Table119.AreaName,".$tableName.".`AreaCode`, ".$tableName.".`Phone1`, ".$tableName.".`Phone2` FROM `".$tableName."` LEFT JOIN Table110 ON Table110.CityCode = ".$tableName.".CityCode LEFT JOIN Table108 ON Table108.StateCode = ".$tableName.".StateCode LEFT JOIN Table106 ON Table106.CountryCode = ".$tableName.".CountryCode LEFT JOIN Table119 ON Table119.AreaCode = ".$tableName.".AreaCode WHERE  ".$tableName.".`RegCode` = ".$this->regCode." AND ".$tableName.".`ContactCode` = ".$this->contactCode.";";
        return $sql;
    }

    function setAddressDetails(){
        $arr = array(array("objName"=>"home","tableName"=>"Table153"),array("objName"=>"work","tableName"=>"Table155"),array("objName"=>"other","tableName"=>"Table157"));
        foreach ($arr as $value) {
            $this->setAddressDetail($value);
        }
    }

    function setAddressDetail($tableArr){
        $sql = $this->getAddressDetailQuery($tableArr["tableName"]);
        if($result = $this->mysqli->query($sql)){
            $this->successful = true;
            if($result->num_rows == 0){
                $this->detail["address"][$tableArr["objName"]] = null;
            }
            else{
                $this->detail["address"][$tableArr["objName"]] = $result->fetch_assoc();
            }
        }
        else{
            $this->successful = false;
            $this->errMsg = $this->mysqli->error;
        }
    }

    function getImagePathQuery(){
        $sql = "SELECT `ImagePath`
                FROM `Table159`
                WHERE `RegCode` = ".$this->regCode." AND
                `ContactCode` = ".$this->contactCode." AND
                `SerialNo` = 1;";
        return $sql;
    }

    function setImagePath(){
        $sql = $this->getImagePathQuery();
        if($result = $this->mysqli->query($sql)){
            $this->successful = true;
            if($result->num_rows == 0){
                $this->detail["contact"]["PhotoUploaded"] = 0;
            }
            else{
                $this->detail["contact"]["ImageURL"] = $result->fetch_assoc()["ImagePath"];
            }
        }
        else{
            $this->successful = false;
            $this->errMsg = $this->mysqli->error;
        }
    }

    function getResponse(){
        if($this->successful){
            $this->response = $this->createResponse(1,"Success");
            $this->response["detail"] = $this->detail;
        }
        else{
            $this->response = $this->createResponse(0,$this->errMsg);
        }
        return $this->response;
    }

    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }

    function __destruct(){
        $this->mysqli->close();
    }
}
