<?php
/**
 * User: kbokdia
 * Date: 10/09/15
 * Time: 11:21 AM
 */

namespace Assistant\Passwords;


class PasswordController
{
    var $mode;
    var $data;
    var $regCode;
    var $familyCode;
    var $response;
    var $mysqli;

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
                $this->addPassword();
                break;
            case 2:
                $this->editPassword();
                break;
            case 3:
                $this->deletePassword();
                break;
        }
    }

    function getDeleteQuery(){
        $passwordCode = intval($this->data["passwordCode"]);
        return "DELETE FROM Table152 WHERE RegCode = ".$this->regCode." AND PasswordCode = ".$passwordCode." AND InsertedBy = ".$this->familyCode.";";
    }

    function deletePassword(){
        $passwordCode = intval($this->data["passwordCode"]);
        $qry = "SELECT InsertedBy FROM Table152 WHERE RegCode = ".$this->regCode." AND PasswordCode = ".$passwordCode.";";

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
        }
    }

    function editPassword(){
        $this->runMultipleQuery($this->getSpTable152Query());
    }

    function addPassword(){
        $this->runMultipleQuery($this->getSpTable152Query());
    }

    function getSpTable152Query(){
        $passwordCode = intval($this->data["passwordCode"]);
        $passwordTypeCode = ((isset($this->data["passwordTypeCode"])) ? intval($this->data['passwordTypeCode']) : 0);
        $passwordTypeName = "'".$this->data["passwordType"]."'";
        $holderCode = intval($this->data['name']);
        $passwordName = "'".$this->data["description"]."'";
        $userID = "'".$this->data["userID"]."'";
        $password1 = ((isset($this->data["password"])) ? "'".$this->data["password"]."'" : "NULL");
        $password2 = ((isset($this->data["password1"])) ? "'".$this->data["password1"]."'" : "NULL");
        $inserted = $this->familyCode;
        $private = (isset($this->data["private"]) ? 1 : 2);
        $active = (isset($this->data["active"]) ? 1 : 2);

        $sql = "SET @passwordTypeCode = ".$passwordTypeCode.";";

        if($passwordTypeCode < 1001){
            $sql .= "call spTable130(
						    @passwordTypeCode,
						    '".$passwordTypeName."',
							".$this->regCode.",
						    1
						);";
        }

        $sql .= "call spTable152(
				".$this->regCode.",
			    ".$passwordCode.",
			    @passwordTypeCode,
			    ".$passwordTypeName.",
			    ".$holderCode.",
			    ".$passwordName.",
			    ".$userID.",
			    ".$password1.",
			    ".$password2.",
			    ".$inserted.",
			    ".$private.",
			    ".$active.",
			    now(),
			    ".$this->mode."
			);";

        return $sql;
    }

    function runMultipleQuery($sql){
        if ($this->mysqli->multi_query($sql) === TRUE) {
            $this->response = $this->createResponse(1,"Successful");
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