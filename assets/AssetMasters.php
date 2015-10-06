<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 06/10/15
 * Time: 4:43 PM
 */

namespace Assistant\Assets;


class AssetMasters
{
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $defaultCode;

    function __construct(){
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
        $this->mysqli = getConnection();
        $this->defaultCode = 10000;
    }

    function getAssetTypeList(){
        $sql = "SELECT AssetTypeCode, AssetTypeName FROM Table127 WHERE RegCode IN (".$this->defaultCode.",".$this->regCode.")";

        return $this->runQuery($sql);
    }

    function getContactsList(){
        $dueToCode = 1004;
        $sql = "SELECT ContactCode, FullName FROM Table151 WHERE RegCode = ".$this->regCode." AND EmergencyCode = ".$dueToCode;

        return $this->runQuery($sql);
    }

    function getLocationList(){
        $sql = "SELECT LocationCode, LocationName FROM Table132 WHERE RegCode IN (".$this->defaultCode.",".$this->regCode.")";

        return $this->runQuery($sql);
    }

    function runQuery($sql){
        $this->response = array();
        if($result = $this->mysqli->query($sql)){
            $i = 0;
            while($row = $result->fetch_assoc()){
                $this->response[$i] = $row;
                $i++;
            }

        }
        else{
            $this->response = $this->mysqli->error;
        }

        return $this->response;
    }

    function __destruct(){
        $this->mysqli->close();
    }
}