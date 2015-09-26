<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 24/09/15
 * Time: 2:45 PM
 */
namespace Assistant\Income\Voucher;


class IncomeVoucher
{
    var $count;
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $data;
    var $mode;
    var $where;
    var $incomeCode;

    function __construct($incomeCode){
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
        $this->mysqli = getConnection();
        $this->incomeCode = $incomeCode;
        $this->where = " WHERE RegCode = ".$this->regCode." AND IncomeCode = ".$this->incomeCode;
    }

    function getSelectQuery(){
        return "SELECT RegCode, IncomeCode, VoucherNo, DATE_FORMAT(VoucherDt,'%d/%m/%Y') as 'VoucherDt', PayMode, ReferNo, DATE_FORMAT(ReferDt,'%d/%m/%Y') as 'ReferDt', DocNo, DocAmount, Remarks, PhotoUploaded, LastAccessDate FROM Table183".$this->where;
    }

    function getVoucherList(){
        $sql = $this->getSelectQuery();
        $response = array();
        if ($result = $this->mysqli->query($sql)) {
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                if(intval($row["PhotoUploaded"]) == 1){
                    $row["ImagePath"] = $this->getImagePath($row["VoucherNo"]);
                }
                $response[$i] = $row;
                $i++;
            }
        }
        else{
            $response = $this->mysqli->error;
        }
        return $response;
    }

    function getImagePath($voucherNo){
        $sql = "SELECT ImagePath FROM Table185 ".$this->where." AND VoucherNo = ".$voucherNo." LIMIT 1";
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 0){
                return null;
            }
            else{
                return $result->fetch_assoc()["ImagePath"];
            }
        }
    }

    function getDeleteQuery(){
        return "DELETE FROM Table183".$this->where." AND VoucherNo = ".$this->data['voucherNo'];
    }

    function deleteVoucher(){
        $this->deleteVoucherImage();
        $this->runQuery($this->getDeleteQuery());
    }

    function getUpdateQuery(){
        $sql = "UPDATE Table183 SET VoucherDt = ".$this->data['voucherDt'].", PayMode = ".$this->data['payMode'].", ReferNo = ".$this->data['referNo'].", ReferDt = ".$this->data['referDt'].", DocNo = ".$this->data['docNo'].", DocAmount = ".$this->data['docAmount'].", Remarks = ".$this->data['remarks'].", LastAccessDate = now() WHERE RegCode = ".$this->regCode." AND IncomeCode = ".$this->incomeCode." AND VoucherNo = ".$this->data['voucherNo'];

        return $sql;
    }

    function editVoucher(){
        $this->runQuery($this->getUpdateQuery());
    }

    function setVoucherImagePath(){
        $sql = "UPDATE Table183 SET PhotoUploaded = 1 WHERE RegCode = ".$this->regCode." AND IncomeCode = ".$this->incomeCode." AND VoucherNo = ".$this->data["voucherNo"].";";
        $sql .= "DELETE FROM Table185 WHERE RegCode = ".$this->regCode." AND IncomeCode = ".$this->incomeCode." AND VoucherNo = ".$this->data["voucherNo"].";";
        $sql .= "INSERT INTO Table185 VALUES (".$this->regCode.",".$this->incomeCode.",".$this->data["voucherNo"].",".$this->data["imagePath"].",101,null,null);";
        $this->runMultipleQuery($sql);
    }

    function deleteVoucherImage(){
        $fileName = "../../../Assistant_Users/".$this->regCode."/income/".$this->incomeCode."/".$this->data["voucherNo"].".jpg";
        if(file_exists($fileName)){
            unlink($fileName);
        }
    }

    function deleteVoucherImagePath(){
        $this->deleteVoucherImage();
        $sql = "UPDATE Table183 SET PhotoUploaded = 2 WHERE RegCode = ".$this->regCode." AND IncomeCode = ".$this->incomeCode." AND VoucherNo = ".$this->data["voucherNo"].";";
        $sql .= "DELETE FROM Table185 WHERE RegCode = ".$this->regCode." AND IncomeCode = ".$this->incomeCode." AND VoucherNo = ".$this->data["voucherNo"].";";
        $this->runMultipleQuery($sql);
    }

    function generateVoucherCode(){
        $voucherCode = 1001;
        $sql = "SELECT MAX(VoucherNo) AS 'voucherCode' FROM Table183".$this->where;
        if($result = $this->mysqli->query($sql)){
            $voucherCode = intval($result->fetch_assoc()['voucherCode']);
            $voucherCode = (($voucherCode == 0) ? 1001 : $voucherCode + 1);
        }
        else{
            $this->response = $this->createResponse(0,$this->mysqli->error);
        }

        return $voucherCode;
    }

    function getInsertQuery(){
        $voucherCode = $this->generateVoucherCode();
        $sql = "INSERT INTO Table183 VALUES (".$this->regCode.", ".$this->incomeCode.", ".$voucherCode.", ".$this->data['voucherDt'].", ".$this->data['payMode'].", ".$this->data['referNo'].", ".$this->data['referDt'].", ".$this->data['docNo'].", ".$this->data['docAmount'].", ".$this->data['remarks'].", 2, now())";

        return $sql;
    }

    function addVoucher(){
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

    function cleanData(){
        // change date format yyyy-mm-dd
        if(!empty($this->data['voucherDt'])){
            $dob = explode("/", $this->data['voucherDt']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['voucherDt'] = implode("-", $dob);
        }
        if(!empty($this->data['referDt'])){
            $dob = explode("/", $this->data['referDt']);
            $dob = array($dob[2],$dob[1],$dob[0]);
            $this->data['referDt'] = implode("-", $dob);
        }
        $this->data['voucherDt'] = ((!empty($this->data['voucherDt'])) ? $this->data['voucherDt'] : NULL);
        $this->data['payMode'] = ((!empty($this->data['payMode'])) ? $this->data['payMode'] : NULL);
        $this->data['referNo'] = ((!empty($this->data['referNo'])) ? $this->data['referNo'] : NULL);
        $this->data['referDt'] = ((!empty($this->data['referDt'])) ? $this->data['referDt'] : NULL);
        $this->data['docNo'] = ((!empty($this->data['docNo'])) ? $this->data['docNo'] : NULL);
        $this->data['docAmount'] = ((!empty($this->data['docAmount'])) ? $this->data['docAmount'] : NULL);
        $this->data['remarks'] = ((!empty($this->data['remarks'])) ? $this->data['remarks'] : NULL);

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
        } elseif ($this->data["mode"] == "AI") {
            $this->mode = 4;
        } elseif ($this->data["mode"] == "DI") {
            $this->mode = 5;
        }


        $this->cleanData();

        //call respect methods based on mode
        switch($this->mode){
            case 1:
                $this->addVoucher();
                break;
            case 2:
                $this->editVoucher();
                break;
            case 3:
                $this->deleteVoucher();
                break;
            case 4:
                $this->setVoucherImagePath();
                break;
            case 5:
                $this->deleteVoucherImagePath();
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