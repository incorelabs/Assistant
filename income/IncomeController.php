<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 24/09/15
 * Time: 12:01 PM
 */

namespace Assistant\Income;


class IncomeController
{
    var $mode;
    var $data;
    var $regCode;
    var $familyCode;
    var $response;
    var $mysqli;
    var $active;
    var $landing;
    var $incomeCode;

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
                $this->addIncome();
                break;
            case 2:
                $this->editIncome();
                break;
            case 3:
                $this->deleteIncome();
                break;
        }
    }

    function getDeleteQuery(){
        $incomeCode = intval($this->data["incomeCode"]);
        return "DELETE FROM Table179 WHERE RegCode = ".$this->regCode." AND IncomeCode = ".$incomeCode." AND InsertedBy = ".$this->familyCode;
    }

    function deleteIncome(){
        $incomeCode = intval($this->data["incomeCode"]);
        $qry = "SELECT InsertedBy FROM Table179 WHERE RegCode = ".$this->regCode." AND IncomeCode = ".$incomeCode.";";

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
            if($this->countIncomeList() == 0){
                $this->landing = null;
            }
            else{
                $this->setFirstRecordAsLanding();
            }
            $this->response['landing'] = $this->landing;
        }
    }

    function editIncome(){

        $this->incomeCode = intval($this->data["incomeCode"]);
        $this->runMultipleQuery($this->getSpTable179Query());
        $count = $this->countIncomeList();
        if($count == 0){
            $this->landing = null;
        }
        elseif($this->active == 2){
            $this->setFirstRecordAsLanding();
        }
        else{
            $this->landing = $this->incomeCode;
        }
        $this->response['landing'] = $this->landing;
    }

    function addIncome(){
        $this->incomeCode = $this->generateIncomeCode();
        $this->landing = $this->incomeCode;
        $this->runMultipleQuery($this->getSpTable179Query());
        $this->response['landing'] = $this->incomeCode;
    }

    function countIncomeList(){
        $limit = 250;
        $page = 1;
        $incomeList = new IncomeList($limit,$page);
        $incomeList->setWhereConstraints();

        $qry = "SELECT count(*) AS 'count' FROM Table179 ".$incomeList->whereConstraints;
        $count = 0;

        if($result = $this->mysqli->query($qry)){
            $count = intval($result->fetch_assoc()['count']);
        }

        return $count;
    }

    function setFirstRecordAsLanding(){
        $limit = 250;
        $page = 1;
        $incomeList = new IncomeList($limit,$page);
        $incomeList->setWhereConstraints();

        $qry = "SELECT IncomeCode FROM Table179 INNER JOIN Table107 ON Table107.FamilyCode = Table179.HolderCode ".$incomeList->whereConstraints." ORDER BY Table107.FamilyName LIMIT 1";

        if($result = $this->mysqli->query($qry)){
            if($result->num_rows == 0){
                $this->landing = null;
            }
            else{
                $this->landing = $result->fetch_assoc()["IncomeCode"];
            }
        }
        else{
            $this->response = $this->createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }
    }

    function generateIncomeCode(){
        $incomeCode = 1001;
        $sql = "SELECT MAX(IncomeCode) AS 'IncomeCode' FROM Table179 WHERE RegCode = ".$this->regCode;
        if($result = $this->mysqli->query($sql)){
            $incomeCode = intval($result->fetch_assoc()['IncomeCode']);
            $incomeCode = (($incomeCode == 0) ? 1001 : $incomeCode + 1);
        }

        return $incomeCode;
    }

    function getSpTable179Query(){
        // change date format yyyy-mm-dd
        if(!empty($this->data['expiryDate'])){
            $dob = explode("/", $this->data['expiryDate']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['expiryDate'] = implode("-", $dob);
        }

        $incomeCode = $this->incomeCode;
        $incomeTypeCode = ((!empty($this->data["incomeTypeCode"])) ? intval($this->data['incomeTypeCode']) : 0);
        $incomeTypeName = "'".$this->data["incomeTypeName"]."'";
        $holderCode = intval($this->data['holderCode']);
        $incomeName = "'".$this->data["incomeName"]."'";
        $jointHolder = ((!empty($this->data["jointHolder"])) ? "'".$this->data["jointHolder"]."'" : "NULL");
        $incomeRemarks = ((!empty($this->data["incomeRemarks"])) ? "'".$this->data["incomeRemarks"]."'" : "NULL");
        $incomeFrequency = $this->data["incomeFrequency"];
        $contactCode = $this->data["contactCode"];
        $dueFrom = "'".$this->data["fullName"]."'";
        $billingDay = $this->data["billingDay"];
        $dueDay = $this->data["dueDay"];
        $expiryDate = ((!empty($this->data["expiryDate"])) ? "'".$this->data["expiryDate"]."'" : "NULL");
        $inserted = $this->familyCode;
        $private = (empty($this->data["privateFlag"]) ? 2 : 1);
        $active = (empty($this->data["activeFlag"]) ? 2 : 1);
        $this->active = $active;

        $sql = "set @incomeCode = ".$incomeCode.";";
        $sql .= "set @incomeTypeCode = ".$incomeTypeCode.";";

        if($incomeTypeCode < 1001){
            $sql .= "call spTable121(@incomeTypeCode, ".$incomeTypeName.", ".$this->regCode.", 1);";
        }

        $sql .= "call spTable179(".$this->regCode.", @incomeCode, @incomeTypeCode, ".$holderCode.", ".$incomeName.", ".$jointHolder.", ".$incomeRemarks.", ".$incomeFrequency.", ".$contactCode.", ".$dueFrom.", ".$billingDay.", ".$dueDay.", ".$expiryDate.", ".$inserted.", ".$private.", ".$active.", now(), ".$this->mode.");";
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