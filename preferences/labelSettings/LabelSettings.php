<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 16/09/15
 * Time: 4:51 PM
 */

namespace Assistant\Preferences\Label;


class LabelSettings
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
        return "SELECT * FROM TABLE139".$this->where;
    }

    function getLabelList(){
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
        return "DELETE FROM Table139".$this->where." AND LabelCode = ".$this->data['labelCode'];
    }

    function deleteLabel(){
        $this->runQuery($this->getDeleteQuery());
    }

    function getUpdateQuery(){
        $sql = "UPDATE `Table139` SET `LabelName` = ".$this->data["labelName"].", `LinesPerLabel` = ".$this->data["linesPerLabel"].", `LabelInRow` = ".$this->data["labelInRow"].", `LabelInColumn` = ".$this->data["labelInColumn"].", `LabelHeight` = ".$this->data["labelHeight"].", `LabelWidth` = ".$this->data["labelWidth"].", `LabelStartLeft` = ".$this->data["labelStartLeft"].", `LabelNextLeft` = ".$this->data["labelNextLeft"].", `LabelStartTop` = ".$this->data["labelStartTop"].", `LabelNextTop` = ".$this->data["labelNextTop"].", `SingleContent` = ".$this->data["singleContent"].", `LogoAvailable` = ".$this->data["logoAvailable"].", `LogoTop` = ".$this->data["logoTop"].", `LogoLeft` = ".$this->data["logoLeft"].", `LogoHeight` = ".$this->data["logoHeight"].", `LogoWidth` = ".$this->data["logoWidth"].", `LabelOrientation` = ".$this->data["labelOrientation"]." WHERE `LabelCode` = ".$this->data["labelCode"]." AND `RegCode` = ".$this->regCode;
        return $sql;
    }

    function editLabel(){
        $this->runQuery($this->getUpdateQuery());
    }

    function generateLabelCode(){
        $labelCode = 1001;
        $sql = "SELECT MAX(LabelCode) AS 'labelCode' FROM Table139".$this->where;
        if($result = $this->mysqli->query($sql)){
            $labelCode = intval($result->fetch_assoc()['labelCode']);
            $labelCode = (($labelCode == 0) ? 1001 : $labelCode + 1);
        }
        else{
            $this->response = $this->createResponse(0,$this->mysqli->error);
        }

        return $labelCode;
    }

    function getInsertQuery(){
        $labelCode = $this->generateLabelCode();
        $sql = "INSERT INTO `Table139` VALUES (".$labelCode.", ".$this->data['labelName'].", ".$this->data['linesPerLabel'].", ".$this->data['labelInRow'].", ".$this->data['labelInColumn'].", ".$this->data['labelHeight'].", ".$this->data['labelWidth'].", ".$this->data['labelStartLeft'].", ".$this->data['labelNextLeft'].", ".$this->data['labelStartTop'].", ".$this->data['labelNextTop'].", ".$this->data['singleContent'].", ".$this->data['logoAvailable'].", ".$this->data['logoPath'].", ".$this->data['logoTop'].", ".$this->data['logoLeft'].", ".$this->data['logoHeight'].", ".$this->data['logoWidth'].", ".$this->data['labelOrientation'].", ".$this->regCode.")";

        return $sql;
    }

    function addLabel(){
        $this->runQuery($this->getInsertQuery());
    }

    function runQuery($sql){
        if ($this->mysqli->query($sql) === TRUE) {
            $this->response = $this->createResponse(1,"Successful");
        }
        else{
            $this->response = $this->createResponse(0,"Error occurred while uploading to the database: ".$this->mysqli->error);
        }
    }

    function cleanData(){
        $this->data["labelName"] = ((!empty($this->data["labelName"])) ? $this->data["labelName"] : NULL);
        $this->data["linesPerLabel"] = ((!empty($this->data["linesPerLabel"])) ? $this->data["linesPerLabel"] : NULL);
        $this->data["labelInRow"] = ((!empty($this->data["labelInRow"])) ? $this->data["labelInRow"] : NULL);
        $this->data["labelInColumn"] = ((!empty($this->data["labelInColumn"])) ? $this->data["labelInColumn"] : NULL);
        $this->data["labelHeight"] = ((!empty($this->data["labelHeight"])) ? $this->data["labelHeight"] : NULL);
        $this->data["labelWidth"] = ((!empty($this->data["labelWidth"])) ? $this->data["labelWidth"] : NULL);
        $this->data["labelStartLeft"] = ((!empty($this->data["labelStartLeft"])) ? $this->data["labelStartLeft"] : NULL);
        $this->data["labelNextLeft"] = ((!empty($this->data["labelNextLeft"])) ? $this->data["labelNextLeft"] : NULL);
        $this->data["labelStartTop"] = ((!empty($this->data["labelStartTop"])) ? $this->data["labelStartTop"] : NULL);
        $this->data["labelNextTop"] = ((!empty($this->data["labelNextTop"])) ? $this->data["labelNextTop"] : NULL);
        $this->data["singleContent"] = ((!empty($this->data["singleContent"])) ? $this->data["singleContent"] : NULL);
        $this->data["logoAvailable"] = ((!empty($this->data["logoAvailable"])) ? $this->data["logoAvailable"] : NULL);
        $this->data["logoPath"] = ((!empty($this->data["logoPath"])) ? $this->data["logoPath"] : NULL);
        $this->data["logoTop"] = ((!empty($this->data["logoTop"])) ? $this->data["logoTop"] : NULL);
        $this->data["logoLeft"] = ((!empty($this->data["logoLeft"])) ? $this->data["logoLeft"] : NULL);
        $this->data["logoHeight"] = ((!empty($this->data["logoHeight"])) ? $this->data["logoHeight"] : NULL);
        $this->data["logoWidth"] = ((!empty($this->data["logoWidth"])) ? $this->data["logoWidth"] : NULL);
        $this->data["labelOrientation"] = ((!empty($this->data["labelOrientation"])) ? $this->data["labelOrientation"] : NULL);

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
                $this->addLabel();
                break;
            case 2:
                $this->editLabel();
                break;
            case 3:
                $this->deleteLabel();
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