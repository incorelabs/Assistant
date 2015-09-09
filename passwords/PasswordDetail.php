<?php

/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 09/09/15
 * Time: 7:21 PM
 */
class PasswordDetail
{

    var $passwordCode;
    var $detail;
    var $mysqli;
    var $regCode;
    var $response;
    var $successful; // if passwords retrieved then successful
    var $errMsg;

    function __construct($passwordCode){
        $this->passwordCode = $passwordCode;
        $this->regCode = intval($_SESSION['s_id']);
        $this->mysqli = getConnection();
        $this->setPasswordDetail();
    }

    function getPasswordDetailQuery(){
        $sql = "SELECT Table152.RegCode, Table152.PasswordCode, Table152.PasswordTypeCode, Table130.PasswordTypeName, Table152.HolderCode, Table107.FamilyName as 'HolderName',Table152.PasswordName, Table152.LoginID, Table152.LoginPassword1, Table152.LoginPassword2, Table152.InsertedBy, Table152.PrivateFlag, Table152.ActiveFlag FROM Table152 INNER JOIN Table130 ON Table130.PasswordTypeCode = Table152.PasswordTypeCode LEFT JOIN Table107 ON Table107.RegCode = Table152.RegCode AND Table107.FamilyCode = Table152.HolderCode WHERE Table152.RegCode = ".$this->regCode." AND Table152.PasswordCode = ".$this->passwordCode."  ORDER BY FamilyName  LIMIT 1;";
        return $sql;
    }

    function setPasswordDetail(){
        $sql = $this->getPasswordDetailQuery();
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 1){
                $this->successful = true;
                $this->detail["password"] = $result->fetch_assoc();
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