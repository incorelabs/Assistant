<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 13/10/15
 * Time: 6:10 PM
 */

namespace Assistant\Document;


class ImageController
{
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $documentCode;

    function __construct($documentCode){
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
        $this->mysqli = getConnection();
        $this->documentCode = $documentCode;
    }

    function getImageList(){
        $sql = "SELECT RegCode, DocumentCode, SerialNo, ImagePath FROM Table158 WHERE RegCode = ".$this->regCode." AND DocumentCode = ".$this->documentCode;

        $this->response = $this->createResponse(0,"No images");
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows > 0){
                $i = 0;
                unset($this->response);
                while($row = $result->fetch_assoc()){
                    $this->response[$i] = $row;
                    $i++;
                }
            }
        }
        return $this->response;
    }

    function addImage($imagePath,$serialNo){
        $sql = "DELETE FROM Table158 WHERE RegCode = ".$this->regCode." AND DocumentCode = ".$this->documentCode." AND SerialNo = ".$serialNo.";";

        $sql .= "INSERT INTO Table158 VALUES (".$this->regCode.",".$this->documentCode.",".$serialNo.",'".$imagePath."', 101,NULL,NULL);";

        //echo $sql;
        $this->runMultipleQuery($sql);
        return $this->response;
    }

    function deleteImage($serialNo=null){
        if(is_null($serialNo)){
            $sql = "SELECT SerialNo FROM Table158 WHERE RegCode = ".$this->regCode." AND DocumentCode = ".$this->documentCode;
            if($result = $this->mysqli->query($sql)){
                if($result->num_rows > 0){
                    while($serialNo = $result->fetch_assoc()["SerialNo"]){
                        $fileName = "../../Assistant_Users/".$this->regCode."/documents/".$this->documentCode."/".$serialNo.".jpg";
                        $this->deleteImageFile($fileName);

                        $sql = "DELETE FROM Table158 WHERE RegCode = ".$this->regCode." AND DocumentCode = ".$this->documentCode." AND SerialNo = ".$serialNo;
                        $this->mysqli->query($sql) or die($this->mysqli->error);
                    }
                }
            }
        }
        else{
            $fileName = "../../Assistant_Users/".$this->regCode."/documents/".$this->documentCode."/".$serialNo.".jpg";
            $this->deleteImageFile($fileName);

            $sql = "DELETE FROM Table158 WHERE RegCode = ".$this->regCode." AND DocumentCode = ".$this->documentCode." AND SerialNo = ".$serialNo;
            $this->mysqli->query($sql) or die($this->mysqli->error);
        }
        $this->response = $this->createResponse(1,"Successful");
        return $this->response;
    }

    private function deleteImageFile($fileName){
        if(file_exists($fileName)){
            unlink($fileName);
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