<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 08/10/15
 * Time: 11:15 AM
 */

namespace Assistant\Assets;


class ImageController
{
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $assetCode;

    function __construct($assetCode){
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
        $this->mysqli = getConnection();
        $this->assetCode = $assetCode;
    }

    function getImageList(){
        $sql = "SELECT RegCode, AssetCode, SerialNo, ImagePath FROM Table166 WHERE RegCode = ".$this->regCode." AND AssetCode = ".$this->assetCode." AND SerialNo < 1000";

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

    function deleteImage($serialNo=null){
        if(is_null($serialNo)){
            for($i=1; $i<6; $i++){
                //Delete Image file
                $fileName = "../../Assistant_Users/".$this->regCode."/assets/".$this->assetCode."/".$i.".jpg";
                $this->deleteImageFile($fileName);

                $sql = "DELETE FROM Table166 WHERE RegCode = ".$this->regCode." AND AssetCode = ".$this->assetCode." AND SerialNo = ".$i;
                $this->mysqli->query($sql) or die($this->mysqli->error);
            }
        }
        else{
            $fileName = "../../Assistant_Users/".$this->regCode."/assets/".$this->assetCode."/".$serialNo.".jpg";
            $this->deleteImageFile($fileName);

            $sql = "DELETE FROM Table166 WHERE RegCode = ".$this->regCode." AND AssetCode = ".$this->assetCode." AND SerialNo = ".$serialNo;
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