<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 15/09/15
 * Time: 3:29 PM
 */

namespace Assistant\Preferences\Envelope;


class EnvelopeSettings
{
    var $count;
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $data;
    var $mode;
    var $where;

    function __construct(){
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
        $this->mysqli = getConnection();
        $this->where = " WHERE RegCode = ".$this->regCode;
    }

    function getSelectQuery(){
        return "SELECT * FROM TABLE135".$this->where;
    }

    function getEnvelopeList(){
        $sql = $this->getSelectQuery();
        $response = array();
        if ($result = $this->mysqli->query($sql)) {
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $response[$i] = $row;
                $i++;
            }
        }
        else{
            $response = $this->mysqli->error;
        }
        return $response;
    }

    function getDeleteQuery(){
        return "DELETE FROM Table135".$this->where." AND CoverCode = ".$this->data['coverCode'];
    }

    function deleteEnvelope(){
        $this->runQuery($this->getDeleteQuery());
    }

    function getUpdateQuery(){
        $sql = "UPDATE `Table135` SET `CoverName` = ".$this->data['coverName'].", `FromRequired` = ".$this->data['fromRequired'].", `FromTop` = ".$this->data['fromTop'].", `FromLeft` = ".$this->data['fromLeft'].", `ToTop` = ".$this->data['toTop'].", `ToLeft` = ".$this->data['toLeft'].", `FromName` = ".$this->data['fromName'].", `FromAdd1` = ".$this->data['fromAdd1'].", `FromAdd2` = ".$this->data['fromAdd2'].", `FromAdd3` = ".$this->data['fromAdd3'].", `FromAdd4` = ".$this->data['fromAdd4'].", `LogoAvailable` = ".$this->data['logoAvailable'].", `LogoPath` = ".$this->data['logoPath'].", `LogoTop` = ".$this->data['logoTop'].", `LogoLeft` = ".$this->data['logoLeft'].", `LogoWidth` = ".$this->data['logoWidth'].", `Caption` = ".$this->data['caption'].", `CoverFeed` = ".$this->data['coverFeed']." WHERE `CoverCode` = ".$this->data['coverCode']." AND `RegCode` = ".$this->regCode;

        return $sql;
    }

    function editEnvelope(){
        $this->runQuery($this->getUpdateQuery());
    }

    function setImagePath($coverCode,$path){
        $sql = "UPDATE `Table135` SET `LogoPath` = '".$path."' WHERE `CoverCode` = ".$coverCode." AND `RegCode` = ".$this->regCode.";";
        $this->runQuery($sql);
    }

    function getInsertQuery(){
        $coverCode = $this->generateCoverCode();
        $sql = "INSERT INTO Table135 (`CoverCode`,`CoverName`,`FromRequired`,`FromTop`,`FromLeft`,`ToTop`,`ToLeft`,`FromName`,`FromAdd1`,`FromAdd2`,`FromAdd3`,`FromAdd4`,`LogoAvailable`,`LogoPath`,`LogoTop`,`LogoLeft`,`LogoWidth`,`Caption`,`CoverFeed`,`RegCode`) VALUES (".$coverCode.",".$this->data['coverName'].",".$this->data['fromRequired'].",".$this->data['fromTop'].",".$this->data['fromLeft'].",".$this->data['toTop'].",".$this->data['toLeft'].",".$this->data['fromName'].",".$this->data['fromAdd1'].",".$this->data['fromAdd2'].",".$this->data['fromAdd3'].",".$this->data['fromAdd4'].",".$this->data['logoAvailable'].",".$this->data['logoPath'].",".$this->data['logoTop'].",".$this->data['logoLeft'].",".$this->data['logoWidth'].",".$this->data['caption'].",".$this->data['coverFeed'].",".$this->regCode.")";

        return $sql;
    }

    function addEnvelope(){
        $this->runQuery($this->getInsertQuery());
    }

    function cleanData(){
        $this->data['coverName'] = ((!empty($this->data['coverName'])) ? $this->data['coverName'] : NULL);
        $this->data['fromRequired'] = ((!empty($this->data['fromRequired'])) ? $this->data['fromRequired'] : NULL);
        $this->data['fromTop'] = ((!empty($this->data['fromTop'])) ? $this->data['fromTop'] : NULL);
        $this->data['fromLeft'] = ((!empty($this->data['fromLeft'])) ? $this->data['fromLeft'] : NULL);
        $this->data['toTop'] = ((!empty($this->data['toTop'])) ? $this->data['toTop'] : NULL);
        $this->data['toLeft'] = ((!empty($this->data['toLeft'])) ? $this->data['toLeft'] : NULL);
        $this->data['fromName'] = ((!empty($this->data['fromName'])) ? $this->data['fromName'] : NULL);
        $this->data['fromAdd1'] = ((!empty($this->data['fromAdd1'])) ? $this->data['fromAdd1'] : NULL);
        $this->data['fromAdd2'] = ((!empty($this->data['fromAdd2'])) ? $this->data['fromAdd2'] : NULL);
        $this->data['fromAdd3'] = ((!empty($this->data['fromAdd3'])) ? $this->data['fromAdd3'] : NULL);
        $this->data['fromAdd4'] = ((!empty($this->data['fromAdd4'])) ? $this->data['fromAdd4'] : NULL);
        $this->data['logoAvailable'] = ((!empty($this->data['logoAvailable'])) ? $this->data['logoAvailable'] : NULL);
        $this->data['logoPath'] = ((!empty($this->data['logoPath'])) ? $this->data['logoPath'] : NULL);
        $this->data['logoTop'] = ((!empty($this->data['logoTop'])) ? $this->data['logoTop'] : NULL);
        $this->data['logoLeft'] = ((!empty($this->data['logoLeft'])) ? $this->data['logoLeft'] : NULL);
        $this->data['logoWidth'] = ((!empty($this->data['logoWidth'])) ? $this->data['logoWidth'] : NULL);
        $this->data['caption'] = ((!empty($this->data['caption'])) ? $this->data['caption'] : NULL);
        $this->data['coverFeed'] = ((!empty($this->data['coverFeed'])) ? $this->data['coverFeed'] : NULL);
        $this->data['coverCode'] = ((!empty($this->data['coverCode'])) ? $this->data['coverCode'] : NULL);

        foreach ($this->data as $key=>$value) {
            if(is_numeric($value)){
                $this->data[$key] = $value;
            }
            elseif(is_string($value)){
                if($value == ''){
                    $this->data[$key] = "null";
                }
                else{
                    $this->data[$key] = "'".$value."'";
                }
            }
            elseif(is_null($value)){
                $this->data[$key] = "null";
            }
        }

        //print_r($this->data);

    }

    function generateCoverCode(){
        $coverCode = 1001;
        $sql = "SELECT MAX(CoverCode) AS 'coverCode' FROM Table135".$this->where;
        if($result = $this->mysqli->query($sql)){
            $coverCode = intval($result->fetch_assoc()['coverCode']);
            $coverCode = (($coverCode == 0) ? 1001 : $coverCode + 1);
        }
        else{
            $this->response = $this->createResponse(0,$this->mysqli->error);
        }

        return $coverCode;
    }

    function runQuery($sql){
        if ($this->mysqli->query($sql) === TRUE) {
            $this->response = $this->createResponse(1,"Successful");
        }
        else{
            $this->response = $this->createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }
    }

    function setData($data){
        $this->data = $data;

        //set mode
        if ($this->data["mode"] == "A") {
            $this->mode = 1;
        } elseif ($this->data["mode"] == "M") {
            $this->mode = 2;
        } elseif ($this->data["mode"] == "D") {
            $this->mode = 3;
        }

        $this->cleanData();

        //call respect methods based on mode
        switch($this->mode){
            case 1:
                $this->addEnvelope();
                break;
            case 2:
                $this->editEnvelope();
                break;
            case 3:
                $this->deleteEnvelope();
                break;
        }
    }

    function getResponse(){
        return $this->response;
    }

    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }
}