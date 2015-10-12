<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 10/10/15
 * Time: 4:46 PM
 */

namespace Assistant\Events;


class EventDetail
{
    var $eventCode;
    var $detail;
    var $mysqli;
    var $regCode;
    var $response;
    var $successful; // if event retrieved then successful
    var $errMsg;

    function __construct($eventCode){
        $this->eventCode = $eventCode;
        $this->regCode = intval($_SESSION['s_id']);
        $this->mysqli = getConnection();
        $this->setEventDetail();
    }

    function getEventDetailQuery(){
        $sql = " SELECT `Table189`.`RegCode`, `Table189`.`EventCode`, `Table189`.`EventName`, `Table189`.`VenueCode`, `Table151`.`FullName`, `Table189`.`EventStartDate`, `Table189`.`EventEndDate`, `Table189`.`EventStartTime`, `Table189`.`EventEndTime`, `Table189`.`SubEventFlag`, `Table189`.`SubEventCount`, `Table189`.`InsertedBy`, `Table189`.`PrivateFlag`, `Table189`.`ActiveFlag`, `Table189`.`LastAccessDateTime` FROM `Table189` LEFT JOIN Table151 ON Table151.RegCode = Table189.RegCode AND Table151.ContactCode = Table189.VenueCode WHERE Table189.RegCode = ".$this->regCode." AND Table189.EventCode = ".$this->eventCode;
        return $sql;
    }

    function setEventDetail(){
        $sql = $this->getEventDetailQuery();
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 1){
                $this->successful = true;
                $this->detail["event"] = $result->fetch_assoc();
            }
            else{
                $this->successful = false;
                $this->errMsg = "No detail";
            }
        }
        else{
            $this->successful = false;
            $this->errMsg = $this->mysqli->error;
        }
    }


    function getResponse(){
        if($this->successful){
            $this->response = $this->createResponse(1,"Success");
            $this->response["detail"] = $this->detail;
        }
        else{
            $this->response = $this->createResponse(0,$this->errMsg);
        }
        return $this->response;
    }

    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }

    function __destruct(){
        $this->mysqli->close();
    }
}