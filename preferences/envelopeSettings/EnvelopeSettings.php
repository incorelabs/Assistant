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

    function __construct(){
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
        $this->mysqli = getConnection();
    }

    function getSelectQuery(){
        return "SELECT * FROM TABLE135";
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

    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }
}