<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 17/09/15
 * Time: 11:06 AM
 */

namespace Assistant\Preferences\Cheque;


class ChequeSettings
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
        return "SELECT * FROM Table137".$this->where;
    }

    function getChequeList(){
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
        return "DELETE FROM Table137".$this->where." AND ChequeCode = ".$this->data['chequeCode'];
    }

    function deleteCheque(){
        $this->runQuery($this->getDeleteQuery());
    }

    function getUpdateQuery(){
        $sql = "UPDATE `Table137` SET `ChequeCode` = ".$this->data['chequeCode'].", `ChequeName` = ".$this->data['chequeName'].", `DateTop` = ".$this->data['dateTop'].", `DateLeft` = ".$this->data['dateLeft'].", `DateSplit` = ".$this->data['dateSplit'].", `NameTop` = ".$this->data['nameTop'].", `NameLeft` = ".$this->data['nameLeft'].", `NameWidth` = ".$this->data['nameWidth'].", `BearerTop` = ".$this->data['bearerTop'].", `BearerLeft` = ".$this->data['bearerLeft'].", `BearerWidth` = ".$this->data['bearerWidth'].", `Rupee1Top` = ".$this->data['rupee1Top'].", `Rupee1Left` = ".$this->data['rupee1Left'].", `Rupee1Width` = ".$this->data['rupee1Width'].", `Rupee2Top` = ".$this->data['rupee2Top'].", `Rupee2Left` = ".$this->data['rupee2Left'].", `Rupee2Width` = ".$this->data['rupee2Width'].", `RsTop` = ".$this->data['rsTop'].", `RsLeft` = ".$this->data['rsLeft'].", `AcPayeeTop` = ".$this->data['acPayeeTop'].", `AcPayeeLeft` = ".$this->data['acPayeeLeft'].", `NotExceedTop` = ".$this->data['notExceedTop'].", `NotExceedLeft` = ".$this->data['notExceedLeft'].", `ForAcName` = ".$this->data['forAcName'].", `ForAcNameTop` = ".$this->data['forAcNameTop'].", `ForAcNameLeft` = ".$this->data['forAcNameLeft'].", `SignatoryName` = ".$this->data['signatoryName'].", `SignatoryNameTop` = ".$this->data['signatoryNameTop'].", `SignatoryNameLeft` = ".$this->data['signatoryNameLeft'].", `ChequeFeed` = ".$this->data['chequeFeed'].", `ContinousFeed` = ".$this->data['continousFeed']." WHERE `ChequeCode` = ".$this->data['chequeCode']." AND `RegCode` = ".$this->regCode;

        return $sql;
    }

    function editCheque(){
        $this->runQuery($this->getUpdateQuery());
    }

    function getInsertQuery(){
        $chequeCode = $this->generateChequeCode();
        $sql = "INSERT INTO `Table137` VALUES (".$chequeCode.", ".$this->data['chequeName'].", ".$this->data['dateTop'].", ".$this->data['dateLeft'].", ".$this->data['dateSplit'].", ".$this->data['nameTop'].", ".$this->data['nameLeft'].", ".$this->data['nameWidth'].", ".$this->data['bearerTop'].", ".$this->data['bearerLeft'].", ".$this->data['bearerWidth'].", ".$this->data['rupee1Top'].", ".$this->data['rupee1Left'].", ".$this->data['rupee1Width'].", ".$this->data['rupee2Top'].", ".$this->data['rupee2Left'].", ".$this->data['rupee2Width'].", ".$this->data['rsTop'].", ".$this->data['rsLeft'].", ".$this->data['acPayeeTop'].", ".$this->data['acPayeeLeft'].", ".$this->data['notExceedTop'].", ".$this->data['notExceedLeft'].", ".$this->data['forAcName'].", ".$this->data['forAcNameTop'].", ".$this->data['forAcNameLeft'].", ".$this->data['signatoryName'].", ".$this->data['signatoryNameTop'].", ".$this->data['signatoryNameLeft'].", ".$this->data['chequeFeed'].", ".$this->data['continousFeed'].", ".$this->regCode.")";

        return $sql;
    }

    function addCheque(){
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

    function generateChequeCode(){
        $chequeCode = 1001;
        $sql = "SELECT MAX(ChequeCode) AS 'chequeCode' FROM Table137".$this->where;
        if($result = $this->mysqli->query($sql)){
            $chequeCode = intval($result->fetch_assoc()['chequeCode']);
            $chequeCode = (($chequeCode == 0) ? 1001 : $chequeCode + 1);
        }
        else{
            $this->response = $this->createResponse(0,$this->mysqli->error);
        }

        return $chequeCode;
    }

    function cleanData(){
        $this->data['chequeCode'] = ((!empty($this->data['chequeCode'])) ? $this->data['chequeCode'] : NULL);
        $this->data['chequeName'] = ((!empty($this->data['chequeName'])) ? $this->data['chequeName'] : NULL);
        $this->data['dateTop'] = ((!empty($this->data['dateTop'])) ? $this->data['dateTop'] : NULL);
        $this->data['dateLeft'] = ((!empty($this->data['dateLeft'])) ? $this->data['dateLeft'] : NULL);
        $this->data['dateSplit'] = ((!empty($this->data['dateSplit'])) ? $this->data['dateSplit'] : NULL);
        $this->data['nameTop'] = ((!empty($this->data['nameTop'])) ? $this->data['nameTop'] : NULL);
        $this->data['nameLeft'] = ((!empty($this->data['nameLeft'])) ? $this->data['nameLeft'] : NULL);
        $this->data['nameWidth'] = ((!empty($this->data['nameWidth'])) ? $this->data['nameWidth'] : NULL);
        $this->data['bearerTop'] = ((!empty($this->data['bearerTop'])) ? $this->data['bearerTop'] : NULL);
        $this->data['bearerLeft'] = ((!empty($this->data['bearerLeft'])) ? $this->data['bearerLeft'] : NULL);
        $this->data['bearerWidth'] = ((!empty($this->data['bearerWidth'])) ? $this->data['bearerWidth'] : NULL);
        $this->data['rupee1Top'] = ((!empty($this->data['rupee1Top'])) ? $this->data['rupee1Top'] : NULL);
        $this->data['rupee1Left'] = ((!empty($this->data['rupee1Left'])) ? $this->data['rupee1Left'] : NULL);
        $this->data['rupee1Width'] = ((!empty($this->data['rupee1Width'])) ? $this->data['rupee1Width'] : NULL);
        $this->data['rupee2Top'] = ((!empty($this->data['rupee2Top'])) ? $this->data['rupee2Top'] : NULL);
        $this->data['rupee2Left'] = ((!empty($this->data['rupee2Left'])) ? $this->data['rupee2Left'] : NULL);
        $this->data['rupee2Width'] = ((!empty($this->data['rupee2Width'])) ? $this->data['rupee2Width'] : NULL);
        $this->data['rsTop'] = ((!empty($this->data['rsTop'])) ? $this->data['rsTop'] : NULL);
        $this->data['rsLeft'] = ((!empty($this->data['rsLeft'])) ? $this->data['rsLeft'] : NULL);
        $this->data['acPayeeTop'] = ((!empty($this->data['acPayeeTop'])) ? $this->data['acPayeeTop'] : NULL);
        $this->data['acPayeeLeft'] = ((!empty($this->data['acPayeeLeft'])) ? $this->data['acPayeeLeft'] : NULL);
        $this->data['notExceedTop'] = ((!empty($this->data['notExceedTop'])) ? $this->data['notExceedTop'] : NULL);
        $this->data['notExceedLeft'] = ((!empty($this->data['notExceedLeft'])) ? $this->data['notExceedLeft'] : NULL);
        $this->data['forAcName'] = ((!empty($this->data['forAcName'])) ? $this->data['forAcName'] : NULL);
        $this->data['forAcNameTop'] = ((!empty($this->data['forAcNameTop'])) ? $this->data['forAcNameTop'] : NULL);
        $this->data['forAcNameLeft'] = ((!empty($this->data['forAcNameLeft'])) ? $this->data['forAcNameLeft'] : NULL);
        $this->data['signatoryName'] = ((!empty($this->data['signatoryName'])) ? $this->data['signatoryName'] : NULL);
        $this->data['signatoryNameTop'] = ((!empty($this->data['signatoryNameTop'])) ? $this->data['signatoryNameTop'] : NULL);
        $this->data['signatoryNameLeft'] = ((!empty($this->data['signatoryNameLeft'])) ? $this->data['signatoryNameLeft'] : NULL);
        $this->data['chequeFeed'] = ((!empty($this->data['chequeFeed'])) ? $this->data['chequeFeed'] : NULL);
        $this->data['continousFeed'] = ((!empty($this->data['continousFeed'])) ? $this->data['continousFeed'] : NULL);

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
                $this->addCheque();
                break;
            case 2:
                $this->editCheque();
                break;
            case 3:
                $this->deleteCheque();
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