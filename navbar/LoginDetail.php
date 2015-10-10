<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 10/10/15
 * Time: 11:26 AM
 */

namespace Assistant\NavBar;


class LoginDetail
{
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;

    function __construct(){
        $this->mysqli = getConnection();
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
    }

    function getDetails(){
        $sql = "SELECT Table109.RegCode, Table109.FamilyCode, Table109.RegName, Table109.RegEmail, Table109.RegMobile, Table109.PhotoUploaded, Table140.ImagePath FROM Table109 LEFT JOIN Table140 ON Table140.RegCode = Table109.RegCode AND Table140.FamilyCode = Table109.FamilyCode AND Table140.SerialNo = 1 WHERE Table109.RegCode = ".$this->regCode." AND Table109.FamilyCode = ".$this->familyCode." LIMIT 1";

        if ($result = $this->mysqli->query($sql)) {
            $this->response = $result->fetch_assoc();
        }
        else{
            $this->response = $this->mysqli->error;
        }
        return $this->response;
    }
}