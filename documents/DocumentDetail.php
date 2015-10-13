<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 13/10/15
 * Time: 3:24 PM
 */

namespace Assistant\Document;


class DocumentDetail
{
    var $documentCode;
    var $detail;
    var $mysqli;
    var $regCode;
    var $response;
    var $successful; // if document retrieved then successful
    var $errMsg;

    function __construct($documentCode){
        $this->documentCode = $documentCode;
        $this->regCode = intval($_SESSION['s_id']);
        $this->mysqli = getConnection();
        $this->setDocumentDetail();
    }

    function getDocumentDetailQuery(){
        $sql = "SELECT Table160.RegCode, Table160.DocumentCode, Table160.DocumentTypeCode, Table125.DocumentTypeName, Table160.HolderCode, Table107.FamilyName as 'HolderName',  Table160.DocumentName, Table160.JointHolder, Table160.IssuedBy, Table151.FullName, Table160.LocationCode, Table160.Remarks, DATE_FORMAT(Table160.IssueDate,'%d/%m/%Y') AS 'IssueDate', DATE_FORMAT(Table160.ExpiryDate,'%d/%m/%Y') AS 'ExpiryDate', Table160.PhotoUploaded, Table160.PhotoCount, Table160.InsertedBy, Table160.PrivateFlag, Table160.ActiveFlag, Table160.LastAccessDate FROM Table160 INNER JOIN Table125 ON Table125.DocumentTypeCode = Table160.DocumentTypeCode INNER JOIN Table107 ON Table107.RegCode = Table160.RegCode AND Table107.FamilyCode = Table160.HolderCode LEFT JOIN Table151 ON Table151.RegCode = Table160.RegCode AND Table151.ContactCode = Table160.IssuedBy WHERE Table160.RegCode = ".$this->regCode." AND Table160.DocumentCode = ".$this->documentCode." ORDER BY Table107.FamilyName LIMIT 1;";
        return $sql;
    }

    function setDocumentDetail(){
        $sql = $this->getDocumentDetailQuery();
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 1){
                $this->successful = true;
                $this->detail["document"] = $result->fetch_assoc();
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