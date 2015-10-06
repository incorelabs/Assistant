<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 06/10/15
 * Time: 10:57 AM
 */

namespace Assistant\Assets;


class AssetController
{

    var $mode;
    var $data;
    var $regCode;
    var $familyCode;
    var $response;
    var $mysqli;
    var $active;
    var $landing;
    var $assetCode;

    function __construct($data){
        $this->mysqli = getConnection();
        $this->data = $data;
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']); //Session family code

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
                $this->addAsset();
                break;
            case 2:
                $this->editAsset();
                break;
            case 3:
                $this->deleteAsset();
                break;
        }
    }

    function getDeleteQuery(){
        $assetCode = intval($this->data["assetCode"]);

        $sql = "DELETE FROM Table168 WHERE RegCode = ".$this->regCode." AND AssetCode = ".$assetCode." AND InsertedBy = ".$this->familyCode.";DELETE FROM Table164 WHERE RegCode = ".$this->regCode." AND AssetCode = ".$assetCode.";";

        return $sql;
    }

    function deleteAsset(){
        $assetCode = intval($this->data["assetCode"]);
        $qry = "SELECT InsertedBy FROM Table168 WHERE RegCode = ".$this->regCode." AND AssetCode = ".$assetCode.";";

        $valid = false;

        //Record can only be deleted by whom it was inserted
        if($result = $this->mysqli->query($qry)){
            if($result->num_rows == 0){
                $this->response = $this->createResponse(0,"This record unavailable");
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

        if($valid){
            $this->runMultipleQuery($this->getDeleteQuery());
            if($this->countAssetList() == 0){
                $this->landing = null;
            }
            else{
                $this->setFirstRecordAsLanding();
            }
            $this->response['landing'] = $this->landing;
        }
    }

    function editAsset(){

        $this->assetCode = intval($this->data["assetCode"]);
        $this->runMultipleQuery($this->getSpTable168Query());
        $count = $this->countAssetList();
        if($count == 0){
            $this->landing = null;
        }
        elseif($this->active == 2){
            $this->setFirstRecordAsLanding();
        }
        else{
            $this->landing = $this->assetCode;
        }
        $this->response['landing'] = $this->landing;
    }

    function addAsset(){
        $this->assetCode = $this->generateAssetCode();
        $this->landing = $this->assetCode;
        $this->runMultipleQuery($this->getSpTable168Query());
        $this->response['landing'] = $this->assetCode;
    }

    function splitName($name){
        $nameArr = array();
        $tempArr = explode(" ",$name);
        switch(count($tempArr)){
            case 2:
                $nameArr[0] = "'".$name."'";
                $nameArr[1] = "'".$tempArr[0]."'";
                $nameArr[2] = "'".$tempArr[1]."'";
                $nameArr[3] = "null";
                break;

            case 3:
                $nameArr[0] = "'".$name."'";
                $nameArr[1] = "'".$tempArr[0]."'" ;
                $nameArr[2] = "'".$tempArr[1]."'";
                $nameArr[3] = "'".$tempArr[2]."'";
                break;

            default:
                $nameArr[0] = "'".$name."'";
                $nameArr[1] = "'".$name."'" ;
                $nameArr[2] = "null";
                $nameArr[3] = "null";
        }

        return $nameArr;
    }

    function getSpTable168Query(){
        // change date format yyyy-mm-dd
        if(!empty($this->data['billDate'])){
            $dob = explode("/", $this->data['billDate']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['billDate'] = implode("-", $dob);
        }

        if(!empty($this->data['warrantyUpto'])){
            $dob = explode("/", $this->data['warrantyUpto']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['warrantyUpto'] = implode("-", $dob);
        }

        $serviceCentreName = ((!empty($this->data["serviceCentreName"])) ? $this->data['serviceCentreName'] : array("null","null", "null"));

        if(!empty($this->data["serviceCentreName"])){
            $serviceCentreName = $this->splitName($serviceCentreName);
        }

        $broughtFromName = ((!empty($this->data["broughtFromName"])) ? $this->data['broughtFromName'] : array("null","null", "null"));

        if(!empty($this->data["broughtFromName"])){
            $broughtFromName = $this->splitName($broughtFromName);
        }

        $assetCode = $this->assetCode;
        $assetTypeCode = ((!empty($this->data["assetTypeCode"])) ? intval($this->data['assetTypeCode']) : 1);
        $assetTypeName = "'".$this->data["assetTypeName"]."'";
        $holderCode = intval($this->data['holderCode']);
        $assetName = "'".$this->data["assetName"]."'";
        $jointHolder = ((!empty($this->data["jointHolder"])) ? "'".$this->data["jointHolder"]."'" : "NULL");
        $broughtFrom = $this->data["broughtFrom"];
        //$broughtFromName = "'".$this->data["broughtFromName"]."'";
        $serviceCentre = ((!empty($this->data["serviceCentre"])) ? intval($this->data['serviceCentre']) : "NULL");
        $locationCode = ((!empty($this->data["locationCode"])) ? intval($this->data['locationCode']) : 1);
        $locationName = "'".$this->data["locationName"]."'";
        $serialNo = (!empty($this->data['serialNo']) ? "'".$this->data['serialNo']."'" : "NULL");
        $modelName = (!empty($this->data['modelName']) ? "'".$this->data['modelName']."'" : "NULL");
        $remarks = ((!empty($this->data["remarks"])) ? "'".$this->data["remarks"]."'" : "NULL");
        $billNo = (!empty($this->data['billNo']) ? "'".$this->data['billNo']."'" : "NULL");
        $billDate = ((!empty($this->data["billDate"])) ? "'".$this->data["billDate"]."'" : "NULL");
        $warrantyUpto = (!empty($this->data['warrantyUpto']) ? "'".$this->data['warrantyUpto']."'" : "NULL");
        $purchaseAmount = (!empty($this->data['purchaseAmount']) ? "'".$this->data['purchaseAmount']."'" : "NULL");
        $inserted = $this->familyCode;
        $private = (empty($this->data["privateFlag"]) ? 2 : 1);
        $active = (empty($this->data["activeFlag"]) ? 2 : 1);
        $this->active = $active;

        $sql = "set @assetCode = ".$assetCode.";";
        $sql .= "set @assetTypeCode = ".$assetTypeCode.";";
        $sql .= "set @locationCode = ".$locationCode.";";

        if($assetTypeCode < 1001){
            $sql .= "call spTable127(@assetTypeCode, ".$assetTypeName.", ".$this->regCode.", 1);";
        }

        if($locationCode < 1001){
            $sql .= "call spTable132(@locationCode, ".$locationName.", ".$this->regCode.", 1);";
        }

        $sql .= "call spTable168(".$this->regCode.", @assetCode, @assetTypeCode, ".$holderCode.", ".$assetName.", ".$jointHolder.", ".$broughtFrom.", ".$broughtFromName[0].", ".$broughtFromName[1].", ".$broughtFromName[2].", ".$broughtFromName[3].", ".$serviceCentre.", ".$serviceCentreName[0].", ".$serviceCentreName[1].", ".$serviceCentreName[2].", ".$serviceCentreName[3].", @locationCode, ".$serialNo.", ".$modelName.", ".$remarks.", ".$billNo.", ".$billDate.", ".$warrantyUpto.", ".$purchaseAmount.", ".$inserted.", ".$private.", ".$active.", NOW(), ".$this->mode.");";

        //echo $sql;
        return $sql;
    }

    function countAssetList(){
        $limit = 250;
        $page = 1;
        $assetList = new AssetList($limit,$page);
        $assetList->setWhereConstraints();

        $qry = "SELECT count(*) AS 'count' FROM Table168 ".$assetList->whereConstraints;
        $count = 0;

        if($result = $this->mysqli->query($qry)){
            $count = intval($result->fetch_assoc()['count']);
        }

        return $count;
    }

    function setFirstRecordAsLanding(){
        $limit = 250;
        $page = 1;
        $assetList = new AssetList($limit,$page);
        $assetList->setWhereConstraints();

        $qry = "SELECT AssetCode FROM Table168 INNER JOIN Table107 ON Table107.FamilyCode = Table168.HolderCode ".$assetList->whereConstraints." ORDER BY Table107.FamilyName LIMIT 1";

        if($result = $this->mysqli->query($qry)){
            if($result->num_rows == 0){
                $this->landing = null;
            }
            else{
                $this->landing = $result->fetch_assoc()["AssetCode"];
            }
        }
        else{
            $this->response = $this->createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }
    }

    function generateAssetCode(){
        $assetCode = 1001;
        $sql = "SELECT MAX(AssetCode) AS 'AssetCode' FROM Table168 WHERE RegCode = ".$this->regCode;
        if($result = $this->mysqli->query($sql)){
            $assetCode = intval($result->fetch_assoc()['AssetCode']);
            $assetCode = (($assetCode == 0) ? 1001 : $assetCode + 1);
        }

        return $assetCode;
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