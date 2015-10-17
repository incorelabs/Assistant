<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 13/10/15
 * Time: 3:48 PM
 */

namespace Assistant\Document;


class DocumentController
{
    var $mode;
    var $data;
    var $regCode;
    var $familyCode;
    var $response;
    var $mysqli;
    var $active;
    var $landing;
    var $documentCode;

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
                $this->addDocument();
                break;
            case 2:
                $this->editDocument();
                break;
            case 3:
                $this->deleteDocument();
                break;
        }
    }

    function getDeleteQuery(){
        $documentCode = intval($this->data["documentCode"]);
        return "DELETE FROM Table160 WHERE RegCode = ".$this->regCode." AND DocumentCode = ".$documentCode." AND InsertedBy = ".$this->familyCode;
    }

    function deleteDocument(){
        $documentCode = intval($this->data["documentCode"]);
        $qry = "SELECT InsertedBy FROM Table160 WHERE RegCode = ".$this->regCode." AND DocumentCode = ".$documentCode.";";

        $valid = false;

        //Record can only be deleted by whom it was inserted
        if($result = $this->mysqli->query($qry)){
            if($result->num_rows == 0){
                $this->response = $this->createResponse(0,"This Record Unavailable");
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
            if($this->countDocumentList() == 0){
                $this->landing = null;
            }
            else{
                $this->setFirstRecordAsLanding();
            }
            $this->response['landing'] = $this->landing;
        }
    }

    function editDocument(){

        $this->documentCode = intval($this->data["documentCode"]);
        $this->runMultipleQuery($this->getSpTable160Query());
        $count = $this->countDocumentList();
        if($count == 0){
            $this->landing = null;
        }
        elseif($this->active == 2){
            $this->setFirstRecordAsLanding();
        }
        else{
            $this->landing = $this->documentCode;
        }
        $this->response['landing'] = $this->landing;
    }

    function addDocument(){
        $this->documentCode = $this->generateDocumentCode();
        $this->landing = $this->documentCode;
        $this->runMultipleQuery($this->getSpTable160Query());
        $this->response['landing'] = $this->documentCode;
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

    function getSpTable160Query(){

        // change date format yyyy-mm-dd
        if(!empty($this->data['issueDate'])){
            $dob = explode("/", $this->data['issueDate']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['issueDate'] = implode("-", $dob);
        }

        if(!empty($this->data['expiryDate'])){
            $dob = explode("/", $this->data['expiryDate']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['expiryDate'] = implode("-", $dob);
        }

        $issuedByName = ((!empty($this->data["issuedByName"])) ? $this->data['issuedByName'] : array("null","null", "null","null"));

        if(!empty($this->data["issuedByName"])){
            $issuedByName = $this->splitName($issuedByName);
        }

        $documentCode = $this->documentCode;
        $documentTypeCode = ((!empty($this->data["documentTypeCode"])) ? intval($this->data['documentTypeCode']) : 0);
        $documentTypeName = "'".$this->data["documentTypeName"]."'";
        $holderCode = intval($this->data['holderCode']);
        $documentName = "'".$this->data["documentName"]."'";
        $jointHolder = ((!empty($this->data["jointHolder"])) ? "'".$this->data["jointHolder"]."'" : "NULL");
        $issuedBy = $this->data["issuedBy"];
        $locationCode = ((!empty($this->data["locationCode"])) ? intval($this->data['locationCode']) : 1);
        $locationName = "'".$this->data["locationName"]."'";
        $remarks = ((!empty($this->data["remarks"])) ? "'".$this->data["remarks"]."'" : "NULL");
        $issueDate = ((!empty($this->data["issueDate"])) ? "'".$this->data["issueDate"]."'" : "NULL");
        $expiryDate = ((!empty($this->data["expiryDate"])) ? "'".$this->data["expiryDate"]."'" : "NULL");
        $inserted = $this->familyCode;
        $private = (empty($this->data["privateFlag"]) ? 2 : 1);
        $active = (empty($this->data["activeFlag"]) ? 2 : 1);
        $this->active = $active;

        $sql = "set @documentCode = ".$documentCode.";";
        $sql .= "set @documentTypeCode = ".$documentTypeCode.";";
        $sql .= "set @locationCode = ".$locationCode.";";

        if($documentTypeCode < 1001){
            $sql .= "call spTable125(@documentTypeCode, ".$documentTypeName.", ".$this->regCode.", 1);";
        }

        if($locationCode < 1001){
            $sql .= "call spTable132(@locationCode, ".$locationName.", ".$this->regCode.", 1);";
        }

        $sql .= "call spTable160(".$this->regCode.", ".$documentCode.", @documentTypeCode, ".$holderCode.", ".$documentName.", ".$jointHolder.", ".$issuedBy.", ".$issuedByName[0].", ".$issuedByName[1].", ".$issuedByName[2].", ".$issuedByName[3].", @locationCode, ".$remarks.", ".$issueDate.", ".$expiryDate.", ".$inserted.", ".$private.", ".$active.", NOW(), ".$this->mode.");";

        //echo $sql;

        return $sql;
    }

    function countDocumentList(){
        $limit = 250;
        $page = 1;
        $documentList = new DocumentList($limit,$page);
        $documentList->setWhereConstraints();

        $qry = "SELECT count(*) AS 'count' FROM Table160 ".$documentList->whereConstraints;
        $count = 0;

        if($result = $this->mysqli->query($qry)){
            $count = intval($result->fetch_assoc()['count']);
        }

        return $count;
    }

    function setFirstRecordAsLanding(){
        $limit = 250;
        $page = 1;
        $documentList = new DocumentList($limit,$page);
        $documentList->setWhereConstraints();

        $qry = "SELECT DocumentCode FROM Table160 INNER JOIN Table107 ON Table107.FamilyCode = Table160.HolderCode ".$documentList->whereConstraints." ORDER BY Table107.FamilyName LIMIT 1";

        if($result = $this->mysqli->query($qry)){
            if($result->num_rows == 0){
                $this->landing = null;
            }
            else{
                $this->landing = $result->fetch_assoc()["DocumentCode"];
            }
        }
        else{
            $this->response = $this->createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }
    }

    function generateDocumentCode(){
        $documentCode = 1001;
        $sql = "SELECT MAX(DocumentCode) AS 'DocumentCode' FROM Table160 WHERE RegCode = ".$this->regCode;
        if($result = $this->mysqli->query($sql)){
            $documentCode = intval($result->fetch_assoc()['DocumentCode']);
            $documentCode = (($documentCode == 0) ? 1001 : $documentCode + 1);
        }

        return $documentCode;
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