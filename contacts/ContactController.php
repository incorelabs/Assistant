<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 10/09/15
 * Time: 4:53 PM
 */

namespace Assistant\Contacts;


class ContactController
{
    var $mode;
    var $data;
    var $regCode;
    var $familyCode;
    var $response;
    var $mysqli;
    var $active;
    var $landing;
    var $contactCode;

    function __construct($data)
    {
        $this->mysqli = getConnection();
        $this->data = $data;
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']); //Session family code

        //set mode
        if ($this->data["mode"] == "A") {
            $this->mode = 1;
        } elseif ($this->data["mode"] == "M") {
            $this->mode = 2;
        } elseif ($this->data["mode"] == "D") {
            $this->mode = 3;
        } elseif ($this->data["mode"] == "AI") {
            $this->mode = 4;
        } elseif ($this->data["mode"] == "DI") {
            $this->mode = 5;
        }

        //call respect methods based on mode
        switch($this->mode){
            case 1:
                $this->addContact();
                break;
            case 2:
                $this->editContact();
                break;
            case 3:
                $this->deleteContact();
                break;
            case 4:
                $this->setContactImagePath();
                break;
            case 5:
                $this->deleteContactImage();
                break;
        }
    }

    function getDeleteQuery(){
        $contactCode = intval($this->data["contactCode"]);
        $sql = "DELETE FROM Table151 WHERE RegCode = ".$this->regCode." AND ContactCode = ".$contactCode." AND InsertedBy = ".$this->familyCode.";";
        $sql .= "DELETE FROM Table153 WHERE RegCode = ".$this->regCode." AND ContactCode = ".$contactCode.";";
        $sql .= "DELETE FROM Table155 WHERE RegCode = ".$this->regCode." AND ContactCode = ".$contactCode.";";
        $sql .= "DELETE FROM Table157 WHERE RegCode = ".$this->regCode." AND ContactCode = ".$contactCode.";";
        $sql .= "DELETE FROM Table159 WHERE RegCode = ".$this->regCode." AND ContactCode = ".$contactCode." AND SerialNo = 1 ;";
        $sql .= "DELETE FROM Table187 WHERE RegCode = ".$this->regCode." AND ContactCode = ".$contactCode.";";

        return $sql;
    }

    function deleteContact(){
        $contactCode = intval($this->data["contactCode"]);

        $qry = "SELECT InsertedBy FROM Table151 WHERE RegCode = ".$this->regCode." AND ContactCode = ".$contactCode.";";

        $valid = false;

        //Record can only be deleted by whom it was inserted
        if($result = $this->mysqli->query($qry)){
            if($result->num_rows == 0){
                $this->response = $this->createResponse(0,"This is Record Unavailable");
                return;
            }
            else{
                $row = $result->fetch_assoc();
                if(intval($row["InsertedBy"]) != $this->familyCode){
                    $this->response = $this->createResponse(0,"You cannot delete this record");
                    return;
                }
                else{
                    $valid = true;
                }
            }
        }

        //Delete Contact Image
        $qry = "SELECT ImagePath FROM Table159 WHERE RegCode = ".$this->regCode." AND ContactCode = ".$contactCode." AND SerialNo = 1 LIMIT 1;";

        $doImageExist = true;
        $filePath = "";

        if($result = $this->mysqli->query($qry)){
            if($result->num_rows == 0){
                $doImageExist = false;
            }
            else{
                $filePath = $result->fetch_assoc()["ImagePath"];
            }
        }

        if($doImageExist){
            if(file_exists($filePath)){
                unlink($filePath);
            }
        }

        if($valid){
            $this->deleteContactImageFile();
            $this->runMultipleQuery($this->getDeleteQuery());
            if($this->countContactList() == 0){
                $this->landing = null;
            }
            else{
                $this->setFirstRecordAsLanding();
            }
            $this->response['landing'] = $this->landing;
        }
    }

    function deleteContactImageFile(){
        $fileName = "../../Assistant_Users/".$this->regCode."/contacts/".$this->data['contactCode'].".jpg";
        if(file_exists($fileName)){
            unlink($fileName);
        }
    }

    function deleteContactImage(){
        $this->deleteContactImageFile();
        $sql = "UPDATE Table151 SET PhotoUploaded = 2 WHERE ContactCode = ".$this->data['contactCode']." AND RegCode = ".$this->regCode.";";
        $sql .= "DELETE FROM Table159 WHERE ContactCode = ".$this->data["contactCode"]." AND RegCode =".$this->regCode." AND SerialNo = 1;";
        $this->runMultipleQuery($sql);
    }

    function setContactImagePath(){
        $sql = "UPDATE Table151 SET PhotoUploaded = 1 WHERE RegCode = ".$this->regCode." AND ContactCode = ".$this->data["contactCode"].";";
        $sql .= "DELETE FROM Table159 WHERE ContactCode = ".$this->data["contactCode"]." AND RegCode =".$this->regCode." AND SerialNo = 1;";
        $sql .= "INSERT INTO Table159 VALUES (".$this->regCode.",".$this->data["contactCode"].",1,'".$this->data["imagePath"]."',101,null,null);";
        $this->runMultipleQuery($sql);
    }

    function editContact(){
        $this->contactCode = intval($this->data["contactCode"]);
        if($this->validateAddress("home") && $this->validateAddress("work") && $this->validateAddress("other")) {
            $this->runMultipleQuery($this->getSpTable151Query());
            $count = $this->countContactList();
            if ($count == 0) {
                $this->landing = null;
            } elseif ($this->active == 2) {
                $this->setFirstRecordAsLanding();
            } else {
                $this->landing = $this->contactCode;
            }
            $this->response['landing'] = $this->landing;
        }
    }

    function addContact(){
        $this->contactCode = $this->generateContactCode();
        $this->landing = $this->contactCode;
        if($this->validateAddress("home") && $this->validateAddress("work") && $this->validateAddress("other")){
            $this->runMultipleQuery($this->getSpTable151Query());
            $this->response['landing'] = $this->contactCode;
        }
    }

    function validateAddress($type){
        $status = true;
        if(!empty($this->data["address"][$type])) {
            $address = $this->data["address"][$type];

            if(!empty($address['state'])){
                if(!empty($address['country'])){
                    $status = true;
                }
                else{
                    $status = false;
                    $this->response = $this->createResponse(0,"To add state it's important to country");
                }
            }

            if(!empty($address['city'])){
                if(!empty($address['state']) && !empty($address['country'])){
                    $status = true;
                }
                else{
                    $status = false;
                    $this->response = $this->createResponse(0,"To add city it's important to add state and country");
                }
            }
        }
        return $status;
    }

    function checkAndReplaceLink($link){
        $subString = substr($link,0,4);
        if($subString == "http" || $subString == "HTTP"){
            return $link;
        }
        else{
            $link = "http://".$link;
            return $link;
        }
    }

    function getSpTable151Query(){
        $contactCode = $this->contactCode;
        $titleCode = ((!empty($this->data['titleCode'])) ? (($this->data['titleCode'] == "1") ? "NULL" : $this->data['titleCode']) : "NULL");
        $groupCode = ((!empty($this->data['groupCode'])) ? $this->data['groupCode'] : "NULL");
        $emergencyCode = ((!empty($this->data['emergencyCode'])) ? $this->data['emergencyCode'] : "NULL");

        // change date format yyyy-mm-dd
        if(!empty($this->data['dob'])){
            $dob = explode("/", $this->data['dob']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['dob'] = implode("-", $dob);
        }

        // change date format yyyy-mm-dd
        if(!empty($this->data['dom'])) {
            $dob = explode("/", $this->data['dom']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['dom'] = implode("-", $dob);
        }

        $fName = (!empty($this->data['firstName']) ? "'".$this->data['firstName']."'" : "NULL");
        $mName = (!empty($this->data['middleName']) ? "'".$this->data['middleName']."'" : "NULL");
        $lName = (!empty($this->data['lastName']) ? "'".$this->data['lastName']."'" : "NULL");
        $fullName = "'".(!empty($this->data['firstName']) ? $this->data['firstName'] : "").(!empty($this->data['middleName']) ? " ".$this->data['middleName'] : "").(!empty($this->data['lastName']) ? " ".$this->data['lastName'] : "")."'";
        $mobile1 = (!empty($this->data['mobile1']) ? "'".$this->data['mobile1']."'" : "NULL");
        $mobile2 = (!empty($this->data['mobile2']) ? "'".$this->data['mobile2']."'" : "NULL");
        $mobile3 = (!empty($this->data['mobile3']) ? "'".$this->data['mobile3']."'" : "NULL");
        $email1 = (!empty($this->data['email1']) ? "'".$this->data['email1']."'" : "NULL");
        $email2 = (!empty($this->data['email2']) ? "'".$this->data['email2']."'" : "NULL");
        $defaultAddress = (!empty($this->data['defaultAddress']) ? $this->data['defaultAddress'] : "NULL");
        $guardian = (!empty($this->data['guardianName']) ? "'".$this->data['guardianName']."'" : "NULL");
        $dob = (!empty($this->data['dob']) ? "'".$this->data['dob']."'" : "NULL");
        $dom = (!empty($this->data['dom']) ? "'".$this->data['dom']."'" : "NULL");
        $remarks = (!empty($this->data['remarks']) ? "'".$this->data['remarks']."'" : "NULL");
        $alias = (!empty($this->data['alias']) ? "'".$this->data['alias']."'" : "NULL");
        $company = (!empty($this->data['company']) ? "'".$this->data['company']."'" : "NULL");
        $designation = (!empty($this->data['designation']) ? "'".$this->data['designation']."'" : "NULL");
        $facebook = (!empty($this->data['facebook']) ? "'".$this->checkAndReplaceLink($this->data['facebook'])."'" : "NULL");
        $twitter = (!empty($this->data['twitter']) ? "'".$this->checkAndReplaceLink($this->data['twitter'])."'" : "NULL");
        $googlePlus = (!empty($this->data['google']) ? "'".$this->checkAndReplaceLink($this->data['google'])."'" : "NULL");
        $linkedin = (!empty($this->data['linkedin']) ? "'".$this->checkAndReplaceLink($this->data['linkedin'])."'" : "NULL");
        $website = (!empty($this->data['website']) ? "'".$this->checkAndReplaceLink($this->data['website'])."'" : "NULL");
        $private = (isset($this->data["private"]) ? 1 : 2);
        $active = (isset($this->data["active"]) ? 1 : 2);
        $this->active = $active;

        $homePhone1 = (!empty($this->data["address"]["home"]['phone1']) ? "'".$this->data["address"]["home"]['phone1']."'" : "NULL");
        $homePhone2 = (!empty($this->data["address"]["home"]['phone2']) ? "'".$this->data["address"]["home"]['phone2']."'" : "NULL");

        $workPhone1 = (!empty($this->data["address"]["work"]['phone1']) ? "'".$this->data["address"]["work"]['phone1']."'" : "NULL");
        $workPhone2 = (!empty($this->data["address"]["work"]['phone2']) ? "'".$this->data["address"]["work"]['phone2']."'" : "NULL");

        $otherPhone1 = (!empty($this->data["address"]["other"]['phone1']) ? "'".$this->data["address"]["other"]['phone1']."'" : "NULL");
        $otherPhone2 = (!empty($this->data["address"]["other"]['phone2']) ? "'".$this->data["address"]["other"]['phone2']."'" : "NULL");

        $sql = "set @contactCode = ".$contactCode.";";
        $sql .= "set @sTitleCode = ".$titleCode.";";
        $sql .= "set @sGroupCode = ".$groupCode.";";
        $sql .= "set @sEmergencyCode = ".$emergencyCode.";";


        //create title code
        if(intval($this->data["titleCode"]) < 1001 && !empty($this->data['title'])){
            $title = "'".$this->data["title"]."'";
            $sql .= "call spTable114(@sTitleCode, ".$title.",NULL,".$this->regCode.",1);";
        }

        //create group code
        if(intval($this->data["groupCode"]) < 1001 && !empty($this->data['group'])){
            $group = "'".$this->data['group']."'";
            $sql .= "call spTable126(@sGroupCode,".$group.",".$this->regCode.",1);";
        }

        //create emergency code
        if(intval($this->data["emergencyCode"]) < 1001 && !empty($this->data['emergency'])){
            $emergency = "'".$this->data["emergency"]."'";
            $sql .= "call spTable128(@sEmergencyCode,".$emergency.",".$this->regCode.",1);";
        }

        $sql .= "call spTable151(".$this->regCode.",@contactCode,".$fName.",".$mName.",".$lName.",".$fullName.",@sTitleCode,".$guardian.",".$company.",".$designation.",".$alias.",".$dob.",".$dom.",@sGroupCode,@sEmergencyCode,".$remarks.",".$facebook.",".$twitter.",".$googlePlus.",".$linkedin.",".$website.",1,1,0,".$defaultAddress.",".$this->familyCode.",".$private.",".$active.",NOW(),".$this->mode.");";

        $sql .= "call spTable187(".$this->regCode.", @contactCode, ".$mobile1.", ".$mobile2.", ".$mobile3.", ".$email1.", ".$email2.", ".$homePhone1.", ".$homePhone2.", ".$workPhone1.", ".$workPhone2.", ".$otherPhone1.", ".$otherPhone2.", ".$this->mode.");";

        $sql .= "SELECT @contactCode as 'ContactCode';";

        if(!empty($this->data["address"]["home"])){
            $home = $this->data["address"]["home"];

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

            //create codes
            if(intval($home["countryCode"]) < 1000 && !empty($home["country"])){
                $sql .= "call spTable106(@sCountryCode, ".$country.", NULL, NULL, 1);";
            }
            if(intval($home["stateCode"]) < 1000 && !empty($home['state'])){
                $sql .= "call spTable108(@sStateCode, ".$state.", @sCountryCode, ".$this->regCode.", 1);";
            }
            if(intval($home["cityCode"]) < 1000 && !empty($home['city'])){
                $sql .= "call spTable110(@sCityCode, ".$city.", @sStateCode, @sCountryCode, ".$this->regCode.", 1);";
            }
            if(intval($home["areaCode"]) < 1000 && !empty($home['area'])){
                $sql .= "call spTable119(@sAreaCode, ".$area.", ".$this->regCode.", 1);";
            }

            $sql .= "call spTable153(".$this->regCode.", ".$contactCode.",".$address1.", ".$address2.", ".$address3.", ".$address4.", ".$address5.", ".$pincode.", @sCountryCode, @sStateCode, @sCityCode, @sAreaCode,".$this->mode.");";
        }

        if(!empty($this->data["address"]["work"])){
            $work = $this->data["address"]["work"];

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

            //create codes
            if(intval($work["countryCode"]) < 1000 && !empty($work["country"])){
                $sql .= "call spTable106(@sCountryCode, ".$country.", NULL, NULL, 1);";
            }
            if(intval($work["stateCode"]) < 1000 && !empty($work['state'])){
                $sql .= "call spTable108(@sStateCode, ".$state.", @sCountryCode, ".$this->regCode.", 1);";
            }
            if(intval($work["cityCode"]) < 1000 && !empty($work['city'])){
                $sql .= "call spTable110(@sCityCode, ".$city.", @sStateCode, @sCountryCode, ".$this->regCode.", 1);";
            }
            if(intval($work["areaCode"]) < 1000 && !empty($work['area'])){
                $sql .= "call spTable119(@sAreaCode, ".$area.", ".$this->regCode.", 1);";
            }

            $sql .= "call spTable155(".$this->regCode.", ".$contactCode.",".$address1.", ".$address2.", ".$address3.", ".$address4.", ".$address5.", ".$pincode.", @sCountryCode, @sStateCode, @sCityCode, @sAreaCode,".$this->mode.");";
        }

        if(!empty($this->data["address"]["other"])){
            $other = $this->data["address"]["other"];

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

            //create codes
            if(intval($other["countryCode"]) < 1000 && !empty($other["country"])){
                $sql .= "call spTable106(@sCountryCode, ".$country.", NULL, NULL, 1);";
            }
            if(intval($other["stateCode"]) < 1000 && !empty($other['state'])){
                $sql .= "call spTable108(@sStateCode, ".$state.", @sCountryCode, ".$this->regCode.", 1);";
            }
            if(intval($other["cityCode"]) < 1000 && !empty($other['city'])){
                $sql .= "call spTable110(@sCityCode, ".$city.", @sStateCode, @sCountryCode, ".$this->regCode.", 1);";
            }
            if(intval($other["areaCode"]) < 1000 && !empty($other['area'])){
                $sql .= "call spTable119(@sAreaCode, ".$area.", ".$this->regCode.", 1);";
            }

            $sql .= "call spTable157(".$this->regCode.", ".$contactCode.",".$address1.", ".$address2.", ".$address3.", ".$address4.", ".$address5.", ".$pincode.", @sCountryCode, @sStateCode, @sCityCode, @sAreaCode, ".$this->mode.");";
        }

        //echo $sql;
        return $sql;
    }

    function generateContactCode(){
        $contactCode = 1001;
        $sql = "SELECT MAX(ContactCode) AS 'ContactCode' FROM Table151 WHERE RegCode = ".$this->regCode.";";
        if($result = $this->mysqli->query($sql)){
            $contactCode = intval($result->fetch_assoc()['ContactCode']);
            $contactCode = (($contactCode == 0) ? 1001 : $contactCode + 1);
        }
        else{
            echo $this->mysqli->error;
        }

        return $contactCode;
    }

    function setFirstRecordAsLanding(){
        $limit = 250;
        $page = 1;
        $contactList = new ContactList($limit,$page);
        $contactList->setWhereConstraints();

        $qry = "SELECT Table151.ContactCode FROM Table151 ".$contactList->whereConstraints." ORDER BY Table151.FullName LIMIT 1;";

        if($result = $this->mysqli->query($qry)){
            if($result->num_rows == 0){
                $this->landing = null;
            }
            else{
                $this->landing = $result->fetch_assoc()["ContactCode"];
            }
        }
        else{
            $this->response = $this->createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }
    }

    function countContactList(){
        $limit = 250;
        $page = 1;
        $contactList = new ContactList($limit,$page);
        $contactList->setWhereConstraints();

        $qry = "SELECT count(*) AS 'count' FROM Table151 ".$contactList->whereConstraints;
        $count = 0;

        if($result = $this->mysqli->query($qry)){
            $count = intval($result->fetch_assoc()['count']);
            return $count;
        }
        else{
            return $count;
        }
    }

    function runDeleteQuery($sql){
        if ($this->mysqli->multi_query($sql) === TRUE) {
            $this->response = $this->createResponse(1,"Successful");
        }
        else{
            $this->response = $this->createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }
    }

    function runMultipleQuery($sql){
        if ($this->mysqli->multi_query($sql) === TRUE) {
            $this->response = $this->createResponse(1,"Successful");
            while($this->mysqli->more_results()){
                $this->mysqli->next_result();
                if($result = $this->mysqli->store_result()){
                    $result->free();
                }
            }
        }
        else{
            $this->response = $this->createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }

    }

    function getResponse(){
        return $this->response;
    }

    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }

    function __destruct(){
        $this->mysqli->close();
    }
}