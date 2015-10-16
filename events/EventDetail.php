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
        $sql = "SELECT Table189.RegCode, Table189.EventCode, Table189.EventName, Table189.VenueCode, DATE_FORMAT(Table189.EventStartDate,'%d/%m/%Y') as 'EventStartDate', DATE_FORMAT(Table189.EventEndDate, '%d/%m/%Y') as 'EventEndDate', Table189.EventStartTime, Table189.EventEndTime, Table189.SubEventFlag, Table189.SubEventCount, Table189.InsertedBy, Table107.FamilyName as 'InsertedByName', Table189.PrivateFlag, Table189.ActiveFlag, Table189.LastAccessDateTime FROM Table189 INNER JOIN Table107 ON Table107.RegCode = Table189.RegCode AND Table107.FamilyCode = Table189.InsertedBy WHERE Table189.RegCode = ".$this->regCode." AND Table189.EventCode = ".$this->eventCode." LIMIT 1";
        return $sql;
    }

    function setEventDetail(){
        $sql = $this->getEventDetailQuery();
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 1){
                $this->successful = true;
                $this->detail["event"] = $result->fetch_assoc();
                if(intval($this->detail["event"]["SubEventFlag"]) == 1){
                    $this->detail["event"]["SubEvents"] = array();
                    $sql = "SELECT  Table188.SubEventCode, Table188.SubEventName, Table188.SubEventAlias, Table188.VenueCode, Table151.FullName as 'VenueName', DATE_FORMAT(Table188.SubEventStartDate,'%d/%m/%Y') as 'SubEventStartDate', Table188.SubEventStartTime FROM Table188 LEFT JOIN Table151 ON Table151.RegCode = Table188.RegCode AND Table151.ContactCode = Table188.VenueCode WHERE Table188.RegCode = ".$this->regCode." AND Table188.EventCode = ".$this->eventCode;

                    if($result = $this->mysqli->query($sql)){
                        $i=0;
                        while($row = $result->fetch_assoc()){
                            $this->detail["event"]["SubEvents"][$i++] = $row;
                        }
                    }
                }
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