<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 24/09/15
 * Time: 11:15 AM
 */

namespace Assistant\Expense;


class ExpenseMasters
{
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $defaultCode;

    function __construct(){
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
        $this->mysqli = getConnection();
        $this->defaultCode = 10000;
    }

    function getExpenseTypeList(){
        $sql = "SELECT ExpenseTypeCode, ExpenseTypeName FROM Table123 WHERE RegCode IN (".$this->defaultCode.",".$this->regCode.")";

        return $this->runQuery($sql);
    }

    function runQuery($sql){
        if($result = $this->mysqli->query($sql)){

            if($result->num_rows == 0){
                return null;
            }
            else{
                $i = 0;
                while($row = $result->fetch_assoc()){
                    $this->response[$i] = $row;
                    $i++;
                }
            }
        }
        else{
            $this->response = $this->mysqli->error;
        }

        return $this->response;
    }

    function __destruct(){
        $this->mysqli->close();
    }
}