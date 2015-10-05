<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 23/09/15
 * Time: 7:44 PM
 */

namespace Assistant\Income;


class IncomeDetail
{
    var $incomeCode;
    var $detail;
    var $mysqli;
    var $regCode;
    var $response;
    var $successful; // if income retrieved then successful
    var $errMsg;

    function __construct($expenseCode){
        $this->incomeCode = $expenseCode;
        $this->regCode = intval($_SESSION['s_id']);
        $this->mysqli = getConnection();
        $this->setIncomeDetail();
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

    function getIncomeDetailQuery(){
        $sql = "SELECT Table179.RegCode, Table179.IncomeCode, Table179.IncomeTypeCode, Table121.IncomeTypeName, Table179.HolderCode, Table107.FamilyName as 'HolderName', Table179.IncomeName, Table179.JointHolder, Table179.IncomeRemarks, Table179.IncomeFrequency, Table179.ContactCode ,Table151.FullName, Table179.BillingDay, Table179.DueDay, DATE_FORMAT(Table179.ExpiryDate,'%d/%m/%Y') AS 'ExpiryDate', Table179.InsertedBy, Table179.PrivateFlag, Table179.ActiveFlag, Table179.LastAccessDate FROM Table179 INNER JOIN Table121 ON Table121.IncomeTypeCode = Table179.IncomeTypeCode INNER JOIN Table107 ON Table107.RegCode = Table179.RegCode AND Table107.FamilyCode = Table179.HolderCode LEFT JOIN Table151 ON Table151.RegCode = Table179.RegCode AND Table151.ContactCode = Table179.ContactCode WHERE Table179.RegCode = ".$this->regCode." AND Table179.IncomeCode = ".$this->incomeCode." ORDER BY Table107.FamilyName LIMIT 1";
        return $sql;
    }

    function setIncomeDetail(){
        $sql = $this->getIncomeDetailQuery();
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 1){
                $this->successful = true;
                $this->detail["income"] = $result->fetch_assoc();
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

    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }

    function __destruct(){
        $this->mysqli->close();
    }
}