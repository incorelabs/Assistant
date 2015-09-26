<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 19/09/15
 * Time: 4:01 PM
 */

namespace Assistant\Expense;


class ExpenseDetail
{
    var $expenseCode;
    var $detail;
    var $mysqli;
    var $regCode;
    var $response;
    var $successful; // if expense retrieved then successful
    var $errMsg;

    function __construct($expenseCode){
        $this->expenseCode = $expenseCode;
        $this->regCode = intval($_SESSION['s_id']);
        $this->mysqli = getConnection();
        $this->setExpenseDetail();
    }

    function getExpenseDetailQuery(){
        $sql = "SELECT Table171.RegCode, Table171.ExpenseCode, Table171.ExpenseTypeCode, Table123.ExpenseTypeName, Table171.HolderCode, Table107.FamilyName as 'HolderName', Table171.ExpenseName, Table171.JointHolder, Table171.ExpenseRemarks, Table171.ExpenseFrequency, Table171.ContactCode ,Table151.FullName, Table171.BillingDay, Table171.DueDay, Table171.ExpiryDate, Table171.PayWebsite, Table171.InsertedBy, Table171.PrivateFlag, Table171.ActiveFlag, Table171.LastAccessDate FROM Table171 INNER JOIN Table123 ON Table123.ExpenseTypeCode = Table171.ExpenseTypeCode INNER JOIN Table107 ON Table107.RegCode = Table171.RegCode AND Table107.FamilyCode = Table171.HolderCode LEFT JOIN Table151 ON Table151.RegCode = Table171.RegCode AND Table151.ContactCode = Table171.ContactCode WHERE Table171.RegCode = ".$this->regCode." AND Table171.ExpenseCode = ".$this->expenseCode." ORDER BY Table107.FamilyName LIMIT 1";
        return $sql;
    }

    function setExpenseDetail(){
        $sql = $this->getExpenseDetailQuery();
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 1){
                $this->successful = true;
                $this->detail["expense"] = $result->fetch_assoc();
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