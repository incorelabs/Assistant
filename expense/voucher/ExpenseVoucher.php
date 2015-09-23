<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 23/09/15
 * Time: 10:59 AM
 */

namespace Assistant\Expense\Voucher;


class ExpenseVoucher
{
    var $count;
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $data;
    var $mode;
    var $where;
    var $expenseCode;

    function __construct($expenseCode){
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
        $this->mysqli = getConnection();
        $this->expenseCode = $expenseCode;
        $this->where = " WHERE RegCode = ".$this->regCode." AND ExpenseCode = ".$this->expenseCode;
    }

    function getSelectQuery(){
        return "SELECT * FROM Table175".$this->where;
    }

    function getVoucherList(){
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
        return "DELETE FROM Table175".$this->where." AND VoucherNo = ".$this->data['voucherNo'];
    }

    function deleteVoucher(){
        $this->runQuery($this->getDeleteQuery());
    }

    function getUpdateQuery(){
        $sql = "UPDATE Table175 SET VoucherDt = ".$this->data['voucherDt'].", PayMode = ".$this->data['payMode'].", ReferNo = ".$this->data['referNo'].", ReferDt = ".$this->data['referDt'].", DocNo = ".$this->data['docNo'].", DocAmount = ".$this->data['docAmount'].", Remarks = ".$this->data['remarks'].", LastAccessDate = now() WHERE RegCode = ".$this->regCode." AND ExpenseCode = ".$this->expenseCode." AND VoucherNo = ".$this->data['voucherNo'];

        return $sql;
    }

    function editVoucher(){
        $this->runQuery($this->getUpdateQuery());
    }

    function generateVoucherCode(){
        $voucherCode = 1001;
        $sql = "SELECT MAX(VoucherNo) AS 'voucherCode' FROM Table175".$this->where;
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
        $sql = "INSERT INTO Table175 VALUES (".$this->regCode.", ".$this->expenseCode.", ".$voucherCode.", ".$this->data['voucherDt'].", ".$this->data['payMode'].", ".$this->data['referNo'].", ".$this->data['referDt'].", ".$this->data['docNo'].", ".$this->data['docAmount'].", ".$this->data['remarks'].", 2, now())";

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
        } elseif ($this->data["mode"] == "DI") {
            $this->mode = 4;
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
            /*case 4:
                $this->deleteLabelLogo();
                break;*/
        }
    }

    function getResponse(){
        return $this->response;
    }

    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }
}