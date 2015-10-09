<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 09/10/15
 * Time: 12:51 PM
 */
class ProfileImageController{
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;

    function __construct(){
        $this->mysqli = getConnection();
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
    }

    function addImage($path){
        $sql = "DELETE FROM Table140 WHERE RegCode = ".$this->regCode." AND FamilyCode = ".$this->familyCode." AND SerialNo = 1;";
        $sql .= "INSERT INTO Table140 VALUES (".$this->regCode.",".$this->familyCode.",1,'".$path."',101,null,null);";
        $this->runMultipleQuery($sql);
        return $this->response;
    }

    function deleteImage(){
        $file = ROOT."../Assistant_Users/".$this->regCode."/".$this->familyCode.".jpg";
        if(file_exists($file)){
            unlink($file);
        }
        $sql = "DELETE FROM Table140 WHERE RegCode = ".$this->regCode." AND FamilyCode = ".$this->familyCode." AND SerialNo = 1;";
        $this->runMultipleQuery($sql);
        return $this->response;
    }

    function runMultipleQuery($sql){
        if ($this->mysqli->multi_query($sql) === TRUE) {
            $this->response = createResponse(1,"Successful");
            while($this->mysqli->more_results()){
                $this->mysqli->next_result();
                if($result = $this->mysqli->store_result()){
                    $result->free();
                }
            }
        }
        else{
            $this->response = createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }

    }

    function getResponse(){
        return $this->response;
    }
}