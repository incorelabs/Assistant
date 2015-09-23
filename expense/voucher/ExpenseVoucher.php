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
}