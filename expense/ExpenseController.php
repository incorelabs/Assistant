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
    var $passwordCode;

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
            /*case 1:
                $this->addPassword();
                break;
            case 2:
                $this->editPassword();
                break;*/
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

    function countExpenseList(){
        $limit = 250;
        $page = 1;
        $expenseList = new ExpenseList($limit,$page);
        $expenseList->setWhereConstraints();

        $qry = "SELECT count(*) AS 'count' FROM Table171 INNER JOIN Table107 ON Table107.FamilyCode = Table171.HolderCode ".$expenseList->whereConstraints;
        $count = 0;

        if($result = $this->mysqli->query($qry)){
            $count = intval($result->fetch_assoc()['count']);
            return $count;
        }
        else{
            return $count;
        }
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