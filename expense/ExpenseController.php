<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 19/09/15
 * Time: 4:28 PM
 */
namespace Assistant\Expense;


class ExpenseController
{
    var $mode;
    var $data;
    var $regCode;
    var $familyCode;
    var $response;
    var $mysqli;
    var $active;
    var $landing;
    var $expenseCode;

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
                $this->addExpense();
                break;
            case 2:
                $this->editExpense();
                break;
            case 3:
                $this->deleteExpense();
                break;
        }
    }

    function getDeleteQuery(){
        $expenseCode = intval($this->data["expenseCode"]);
        return "DELETE FROM Table171 WHERE RegCode = ".$this->regCode." AND ExpenseCode = ".$expenseCode." AND InsertedBy = ".$this->familyCode;
    }

    function deleteExpense(){
        $expenseCode = intval($this->data["expenseCode"]);
        $qry = "SELECT InsertedBy FROM Table171 WHERE RegCode = ".$this->regCode." AND ExpenseCode = ".$expenseCode.";";

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

        if($valid){
            $this->runMultipleQuery($this->getDeleteQuery());
            if($this->countExpenseList() == 0){
                $this->landing = null;
            }
            else{
                $this->setFirstRecordAsLanding();
            }
            $this->response['landing'] = $this->landing;
        }
    }

    function editExpense(){

        $this->expenseCode = intval($this->data["expenseCode"]);
        $this->runMultipleQuery($this->getSpTable171Query());
        $count = $this->countExpenseList();
        if($count == 0){
            $this->landing = null;
        }
        elseif($this->active == 2){
            $this->setFirstRecordAsLanding();
        }
        else{
            $this->landing = $this->expenseCode;
        }
        $this->response['landing'] = $this->landing;
    }

    function addExpense(){
        $this->expenseCode = $this->generateExpenseCode();
        $this->landing = $this->expenseCode;
        $this->runMultipleQuery($this->getSpTable171Query());
        $this->response['landing'] = $this->expenseCode;
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

    function getSpTable171Query(){
        // change date format yyyy-mm-dd
        if(!empty($this->data['expiryDate'])){
            $dob = explode("/", $this->data['expiryDate']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['expiryDate'] = implode("-", $dob);
        }

        $expenseCode = $this->expenseCode;
        $expenseTypeCode = ((!empty($this->data["expenseTypeCode"])) ? intval($this->data['expenseTypeCode']) : 0);
        $expenseTypeName = "'".$this->data["expenseTypeName"]."'";
        $holderCode = intval($this->data['holderCode']);
        $expenseName = "'".$this->data["expenseName"]."'";
        $jointHolder = ((!empty($this->data["jointHolder"])) ? "'".$this->data["jointHolder"]."'" : "NULL");
        $expenseRemarks = ((!empty($this->data["expenseRemarks"])) ? "'".$this->data["expenseRemarks"]."'" : "NULL");
        $expenseFrequency = $this->data["expenseFrequency"];
        $contactCode = $this->data["contactCode"];
        $dueTo = "'".$this->data["fullName"]."'";
        $billingDay = $this->data["billingDay"];
        $dueDay = $this->data["dueDay"];
        $expiryDate = ((!empty($this->data["expiryDate"])) ? "'".$this->data["expiryDate"]."'" : "NULL");
        $payWebsite = (!empty($this->data['payWebsite']) ? "'".$this->checkAndReplaceLink($this->data['payWebsite'])."'" : "NULL");
        $inserted = $this->familyCode;
        $private = (empty($this->data["private"]) ? 2 : 1);
        $active = (empty($this->data["active"]) ? 2 : 1);
        $this->active = $active;

        $sql = "set @expenseCode = ".$expenseCode.";";
        $sql .= "set @expenseTypeCode = ".$expenseTypeCode.";";

        if($expenseTypeCode < 1001){
            $sql .= "call spTable123(@expenseTypeCode, ".$expenseTypeName.", ".$this->regCode.", 1);";
        }

        $sql .= "call spTable171(".$this->regCode.", @expenseCode, @expenseTypeCode, ".$holderCode.", ".$expenseName.", ".$jointHolder.", ".$expenseRemarks.", ".$expenseFrequency.", ".$contactCode.", ".$dueTo.", ".$billingDay.", ".$dueDay.", ".$expiryDate.", ".$payWebsite.", ".$inserted.", ".$private.", ".$active.", now(), ".$this->mode.");";

        return $sql;
    }

    function countExpenseList(){
        $limit = 250;
        $page = 1;
        $expenseList = new ExpenseList($limit,$page);
        $expenseList->setWhereConstraints();

        $qry = "SELECT count(*) AS 'count' FROM Table171 ".$expenseList->whereConstraints;
        $count = 0;

        if($result = $this->mysqli->query($qry)){
            $count = intval($result->fetch_assoc()['count']);
        }

        return $count;
    }

    function setFirstRecordAsLanding(){
        $limit = 250;
        $page = 1;
        $expenseList = new ExpenseList($limit,$page);
        $expenseList->setWhereConstraints();

        $qry = "SELECT ExpenseCode FROM Table171 INNER JOIN Table107 ON Table107.FamilyCode = Table171.HolderCode ".$expenseList->whereConstraints." ORDER BY Table107.FamilyName LIMIT 1";

        if($result = $this->mysqli->query($qry)){
            if($result->num_rows == 0){
                $this->landing = null;
            }
            else{
                $this->landing = $result->fetch_assoc()["ExpenseCode"];
            }
        }
        else{
            $this->response = $this->createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }
    }

    function generateExpenseCode(){
        $expenseCode = 1001;
        $sql = "SELECT MAX(ExpenseCode) AS 'ExpenseCode' FROM Table171 WHERE RegCode = ".$this->regCode;
        if($result = $this->mysqli->query($sql)){
            $expenseCode = intval($result->fetch_assoc()['ExpenseCode']);
            $expenseCode = (($expenseCode == 0) ? 1001 : $expenseCode + 1);
        }

        return $expenseCode;
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