<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 24/09/15
 * Time: 2:33 PM
 */

namespace Assistant\Income;


class IncomeMasters
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

    function getIncomeTypeList(){
        $sql = "SELECT IncomeTypeCode, IncomeTypeName FROM Table121 WHERE RegCode IN (".$this->defaultCode.",".$this->regCode.")";

        return $this->runQuery($sql);
    }

    function getContactsList(){
        $dueFromCode = 1006;
        $sql = "SELECT ContactCode, FullName FROM Table151 WHERE RegCode = ".$this->regCode." AND EmergencyCode = ".$dueFromCode;

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