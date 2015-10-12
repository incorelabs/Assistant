<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 10/10/15
 * Time: 4:10 PM
 */

namespace Assistant\Events;


class EventList
{
    var $limit;
    var $pages;
    var $requestPage;
    var $eventList;
    var $count;
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $successful; // if event retrieved then successful
    var $searchText;
    var $searchType;
    var $searchClause;
    var $countQuery;
    var $eventListQuery;
    var $whereConstraints;

    function __construct($limit,$page,$searchType=null,$searchText=null){
        $this->limit = $limit;
        $this->requestPage = $page;
        $this->regCode = intval($_SESSION['s_id']);
        $this->familyCode = intval($_SESSION['familyCode']);
        $this->mysqli = getConnection();

        if(!is_null($searchType) && !is_null($searchText)){
            $this->searchText = $searchText;
            $this->searchType = $searchType;
            $this->setSearchClause($searchText);
            $this->setWhereConstraints($this->searchClause);
        }
        else{
            $this->setWhereConstraints();
        }

        $this->setEventListQuery();
        $this->setEventList();
        $this->setCountQuery();
        $this->setCount();
    }

    function getLimits(){
        $lower = $this->requestPage * $this->limit;
        $upper = $lower + $this->limit - 1;
        return array("lower"=>$lower, "upper" => $upper);
    }

    function setWhereConstraints($parameter = null){
        $where = " WHERE Table189.RegCode = ".$this->regCode." AND ((Table189.InsertedBy != ".$this->familyCode." and PrivateFlag = 2) or Table189.InsertedBy = ".$this->familyCode.") AND Table189.ActiveFlag = 1";
        if(!is_null($parameter)) {
            $where .= " AND".$parameter;
        }
        $this->whereConstraints = $where;
    }

    function setSearchClause($searchText){
        $searchParameters = new SearchParameters();
        switch($this->searchType){
            case 1:
                $eventNameClause = $searchParameters->getEventNameClause($searchText);
                $this->searchClause = " ( ".$eventNameClause." ) ";
                break;
        }
    }

    function setEventListQuery(){
        $this->eventListQuery = "SELECT Table189.EventCode, Table189.EventName FROM Table189".$this->whereConstraints." ORDER BY Table189.EventName LIMIT ".$this->limit." OFFSET ".$this->getLimits()["lower"].";";
    }

    function getEventListQuery(){
        return $this->eventListQuery;
    }

    function setEventList(){
        $sql = $this->getEventListQuery();
        if($result = $this->mysqli->query($sql)){

            if($result->num_rows == 0){
                $this->successful = false;
            }
            else{
                $i = 0;
                while($row = $result->fetch_assoc()){
                    $this->eventList[$i] = $row;
                    $i++;
                }
                $this->successful = true;
            }
        }
    }

    function setCountQuery(){
        $qry = "SELECT count(*) as 'count' FROM Table189";
        $this->countQuery = $qry . $this->whereConstraints;
    }

    function getCountQuery(){
        return $this->countQuery;
    }

    function setCount($count = null){
        if(is_null($count)){
            $sql = $this->getCountQuery();
            if($result = $this->mysqli->query($sql)) {
                $row = $result->fetch_assoc();
                $this->count = intval($row['count']);
            }
        }
        else{
            $this->count = $count;
        }
    }

    function setPages($pages=null){
        if(is_null($pages)){
            $pages = intval($this->count / $this->limit);
            $remainder = intval($this->count % $this->limit);
            $this->pages = $pages + (($remainder == 0) ? 0 : 1);
        }
        else{
            $this->pages = $pages;
        }
    }

    function getResponse(){
        if($this->successful){
            $this->setPages();
            $this->response = $this->createResponse(1,"Success");
            $this->response["pages"] = $this->pages;
            $this->response["result"] = $this->eventList;
        }
        else{
            $this->response = $this->createResponse(0,"No event");
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