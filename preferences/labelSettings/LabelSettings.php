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
}