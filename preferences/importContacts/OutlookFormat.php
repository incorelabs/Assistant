<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 26/09/15
 * Time: 3:49 PM
 */

namespace Assistant\Preferences\ImportContacts;


class OutlookFormat
{
    var $fileLocation;
    var $name;
    var $numContacts;
    var $numContactsImport;
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $contactCode;
    var $data;
    var $mode;
    var $private;
    var $active;
    var $response;
    var $sql;

    function __construct($fileLocation){
       $this->fileLocation = $fileLocation;
        $this->numContactsImport = 0;
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']); //Session family code
        $this->setData();
    }

    function setData(){
        if(($handle = fopen($this->fileLocation, "r")) !== FALSE){

            $this->mysqli = getConnection();
            $this->contactCode = $this->generateContactCode();
            $this->private = 2;
            $this->active = 1;
            $this->mode = 1;
            $row = 0;
            $this->sql = "";
            while (($data = fgetcsv($handle)) !== FALSE) {
                $row++;
                if($row == 1){
                    continue;
                }
                $this->numContacts = count($data);
                $this->organizeData($data);
                $this->contactCode++;
            }
        }
    }

    function organizeData($data){
        if(!$this->organizeName(array($data[0],$data[1],$data[2]))){
            return;
        }

        $this->numContactsImport++;
        $this->data = $data;
        $this->sql = $this->getSpTable151Query();
        echo $this->sql;
        $this->runMultipleQuery($this->sql);
    }

    function organizeName($nameArr){
        if(empty($nameArr[0]) && empty($nameArr[1]) && empty($nameArr[2])){
            return false;
        }

        if(!empty($nameArr[0])){
            $this->name[0] = "'".$nameArr[0]."'";
            $this->name[1] = ((!empty($nameArr[1])) ? "'".$nameArr[1]."'" : "NULL");
            $this->name[2] = ((!empty($nameArr[2])) ? "'".$nameArr[2]."'" : "NULL");
        }
        elseif(!empty($nameArr[1])){
            $this->name[0] = "'".$nameArr[1]."'";
            $this->name[1] = "NULL";
            $this->name[2] = ((!empty($nameArr[2])) ? "'".$nameArr[2]."'" : "NULL");
        }
        elseif(!empty($nameArr[2])){
            $this->name[0] = "'".$nameArr[2]."'";
            $this->name[1] = "NULL";
            $this->name[2] = "NULL";
        }

        return true;
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
        $titleCode = "NULL";
        $groupCode = 1006;
        $emergencyCode = 1001;

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

        $fName = $this->name[0];
        $mName = $this->name[1];
        $lName = $this->name[2];
        $fullName = $this->name[0];
        $mobile1 = (!empty($this->data['20']) ? "'".$this->data['20']."'" : "NULL");
        $mobile2 = (!empty($this->data['17']) ? "'".$this->data['17']."'" : "NULL");
        $mobile3 = (!empty($this->data['mobile3']) ? "'".$this->data['mobile3']."'" : "NULL");
        $email1 = (!empty($this->data['14']) ? "'".$this->data['14']."'" : "NULL");
        $email2 = (!empty($this->data['15']) ? "'".$this->data['15']."'" : "NULL");
        $defaultAddress = (!empty($this->data['defaultAddress']) ? $this->data['defaultAddress'] : "NULL");
        $guardian = (!empty($this->data['32']) ? "'".$this->data['32']."'" : "NULL");
        $dob = (!empty($this->data['dob']) ? "'".$this->data['dob']."'" : "NULL");
        $dom = (!empty($this->data['dom']) ? "'".$this->data['dom']."'" : "NULL");
        $remarks = (!empty($this->data['remarks']) ? "'".$this->data['remarks']."'" : "NULL");
        $alias = (!empty($this->data['alias']) ? "'".$this->data['alias']."'" : "NULL");
        $company = (!empty($this->data['42']) ? "'".$this->data['42']."'" : "NULL");
        $designation = (!empty($this->data['43']) ? "'".$this->data['43']."'" : "NULL");
        $facebook = "NULL";
        $twitter = "NULL";
        $googlePlus = "NULL";
        $linkedin = "NULL";
        $website = (!empty($this->data['6']) ? "'".$this->checkAndReplaceLink($this->data['6'])."'" : "NULL");
        $private = $this->private;
        $active = $this->active;

        $sql = "set @contactCode = ".$contactCode.";";
        $sql .= "set @sTitleCode = ".$titleCode.";";
        $sql .= "set @sGroupCode = ".$groupCode.";";
        $sql .= "set @sEmergencyCode = ".$emergencyCode.";";


        //create title code
        if(intval(!empty($this->data['3']))){
            $title = "'".$this->data["3"]."'";
            $sql .= "call spTable114(@sTitleCode, ".$title.",NULL,".$this->regCode.",1);";
        }


        $sql .= "call spTable151(".$this->regCode.",@contactCode,".$fName.",".$mName.",".$lName.",".$fullName.",@sTitleCode,".$guardian.",".$company.",".$designation.",".$alias.",".$dob.",".$dom.",@sGroupCode,@sEmergencyCode,".$remarks.",".$mobile1.",".$mobile2.",".$mobile3.",".$email1.",".$email2.",".$facebook.",".$twitter.",".$googlePlus.",".$linkedin.",".$website.",1,1,0,".$defaultAddress.",".$this->familyCode.",".$private.",".$active.",NOW(),".$this->mode.");";

        //Home address
        if(!empty($this->data[23])){

            $areaCode = "NULL";
            $cityCode = "NULL";
            $stateCode = "NULL";
            $countryCode = "NULL";

            $sql .= "set @sAreaCode = ".$areaCode.";";
            $sql .= "set @sCityCode = ".$cityCode.";";
            $sql .= "set @sStateCode = ".$stateCode.";";
            $sql .= "set @sCountryCode = ".$countryCode.";";

            $address1 = (!empty($this->data[24]) ? "'".$this->data[24]."'" : "NULL");
            $address2 = (!empty($this->data[25]) ? "'".$this->data[25]."'" : "NULL");
            $address3 = (!empty($this->data[26]) ? "'".$this->data[26]."'" : "NULL");
            $address4 = (!empty($this->data[27]) ? "'".$this->data[27]."'" : "NULL");
            $address5 = "NULL";
            $city = (!empty($this->data[28]) ? "'".$this->data[28]."'" : "NULL");
            $state = (!empty($this->data[29]) ? "'".$this->data[29]."'" : "NULL");
            $country = (!empty($this->data[31]) ? "'".$this->data[31]."'" : "NULL");
            $pincode = (!empty($this->data[30]) ? "'".$this->data[30]."'" : "NULL");
            //$area = (!empty($this->data[27]) ? "'".$this->data[27]."'" : "NULL");
            $phone1 = (!empty($this->data[18]) ? "'".$this->data[18]."'" : "NULL");
            $phone2 = (!empty($this->data[19]) ? "'".$this->data[19]."'" : "NULL");

            //create codes
            if(!empty($this->data[31])){
                $sql .= "call spTable106(@sCountryCode, ".$country.", NULL, NULL, 1);";
            }
            if(!empty($this->data[29])){
                $sql .= "call spTable108(@sStateCode, ".$state.", @sCountryCode, ".$this->regCode.", 1);";
            }
            if(!empty($this->data[28])){
                $sql .= "call spTable110(@sCityCode, ".$city.", @sStateCode, @sCountryCode, ".$this->regCode.", 1);";
            }
            /*if(!empty($this->data['27'])){
                $sql .= "call spTable119(@sAreaCode, ".$area.", ".$this->regCode.", 1);";
            }*/

            $sql .= "call spTable153(".$this->regCode.", ".$contactCode.",".$address1.", ".$address2.", ".$address3.", ".$address4.", ".$address5.", ".$pincode.", @sCountryCode, @sStateCode, @sCityCode, @sAreaCode, ".$phone1.", ".$phone2.", NULL, $this->mode);";
        }

        if(!empty($this->data[49])){
            $areaCode = "NULL";
            $cityCode = "NULL";
            $stateCode = "NULL";
            $countryCode = "NULL";

            $sql .= "set @sAreaCode = ".$areaCode.";";
            $sql .= "set @sCityCode = ".$cityCode.";";
            $sql .= "set @sStateCode = ".$stateCode.";";
            $sql .= "set @sCountryCode = ".$countryCode.";";

            $address1 = (!empty($this->data[50]) ? "'".$this->data[50]."'" : "NULL");
            $address2 = (!empty($this->data[51]) ? "'".$this->data[51]."'" : "NULL");
            $address3 = (!empty($this->data[52]) ? "'".$this->data[52]."'" : "NULL");
            $address4 = (!empty($this->data[53]) ? "'".$this->data[53]."'" : "NULL");
            $address5 = "NULL";
            $city = (!empty($this->data[54]) ? "'".$this->data[54]."'" : "NULL");
            $state = (!empty($this->data[55]) ? "'".$this->data[55]."'" : "NULL");
            $country = (!empty($this->data[57]) ? "'".$this->data[57]."'" : "NULL");
            $pincode = (!empty($this->data[56]) ? "'".$this->data[56]."'" : "NULL");
            //$area = (!empty($this->data[27]) ? "'".$this->data[27]."'" : "NULL");
            $phone1 = (!empty($this->data[38]) ? "'".$this->data[38]."'" : "NULL");
            $phone2 = (!empty($this->data[39]) ? "'".$this->data[39]."'" : "NULL");

            //create codes
            if(!empty($this->data[57])){
                $sql .= "call spTable106(@sCountryCode, ".$country.", NULL, NULL, 1);";
            }
            if(!empty($this->data[55])){
                $sql .= "call spTable108(@sStateCode, ".$state.", @sCountryCode, ".$this->regCode.", 1);";
            }
            if(!empty($this->data[54])){
                $sql .= "call spTable110(@sCityCode, ".$city.", @sStateCode, @sCountryCode, ".$this->regCode.", 1);";
            }

            $sql .= "call spTable155(".$this->regCode.", ".$contactCode.",".$address1.", ".$address2.", ".$address3.", ".$address4.", ".$address5.", ".$pincode.", @sCountryCode, @sStateCode, @sCityCode, @sAreaCode, ".$phone1.", ".$phone2.", NULL, $this->mode);";
        }

        if(!empty($this->data["60"])){
            $areaCode = "NULL";
            $cityCode = "NULL";
            $stateCode = "NULL";
            $countryCode = "NULL";

            $sql .= "set @sAreaCode = ".$areaCode.";";
            $sql .= "set @sCityCode = ".$cityCode.";";
            $sql .= "set @sStateCode = ".$stateCode.";";
            $sql .= "set @sCountryCode = ".$countryCode.";";

            $address1 = (!empty($this->data[61]) ? "'".$this->data[61]."'" : "NULL");
            $address2 = (!empty($this->data[62]) ? "'".$this->data[62]."'" : "NULL");
            $address3 = (!empty($this->data[63]) ? "'".$this->data[63]."'" : "NULL");
            $address4 = (!empty($this->data[64]) ? "'".$this->data[64]."'" : "NULL");
            $address5 = "NULL";
            $city = (!empty($this->data[65]) ? "'".$this->data[65]."'" : "NULL");
            $state = (!empty($this->data[66]) ? "'".$this->data[66]."'" : "NULL");
            $country = (!empty($this->data[68]) ? "'".$this->data[68]."'" : "NULL");
            $pincode = (!empty($this->data[67]) ? "'".$this->data[67]."'" : "NULL");
            //$area = (!empty($this->data[27]) ? "'".$this->data[27]."'" : "NULL");
            $phone1 = (!empty($this->data[58]) ? "'".$this->data[58]."'" : "NULL");
            $phone2 = (!empty($this->data[69]) ? "'".$this->data[69]."'" : "NULL");

            //create codes
            if(!empty($this->data[68])){
                $sql .= "call spTable106(@sCountryCode, ".$country.", NULL, NULL, 1);";
            }
            if(!empty($this->data[66])){
                $sql .= "call spTable108(@sStateCode, ".$state.", @sCountryCode, ".$this->regCode.", 1);";
            }
            if(!empty($this->data[65])){
                $sql .= "call spTable110(@sCityCode, ".$city.", @sStateCode, @sCountryCode, ".$this->regCode.", 1);";
            }

            $sql .= "call spTable157(".$this->regCode.", ".$contactCode.",".$address1.", ".$address2.", ".$address3.", ".$address4.", ".$address5.", ".$pincode.", @sCountryCode, @sStateCode, @sCityCode, @sAreaCode, ".$phone1.", ".$phone2.", NULL, $this->mode);";
        }

        //echo $sql;
        return $sql;
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
    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }

    function __destruct(){
        $this->mysqli->close();
    }
}