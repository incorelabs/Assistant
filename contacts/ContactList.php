<?php

namespace Assistant\Contacts;

class ContactList{
    var $limit;
    var $pages;
    var $requestPage;
    var $contactList;
    var $count;
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $successful; // if contacts retrieved then successful
    var $searchText;
    var $searchType;
    var $searchClause;
    var $countQuery;
    var $contactListQuery;
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

        $this->setContactListQuery();
        $this->setContactList();
        $this->setCountQuery();
        $this->setCount();
    }

    function getLimits(){
        $lower = $this->requestPage * $this->limit;
        $upper = $lower + $this->limit - 1;
        return array("lower"=>$lower, "upper" => $upper);
    }

    function getContactListQuery(){
        return $this->contactListQuery;
    }

    function setContactListQuery(){
        $this->contactListQuery = "SELECT Table151.ContactCode, Table151.FullName FROM Table151".$this->whereConstraints." ORDER BY LOWER(Table151.FullName) LIMIT ".$this->limit." OFFSET ".$this->getLimits()["lower"].";";
    }

    function setWhereConstraints($parameter = null){
        $where = " WHERE RegCode = ".$this->regCode." AND ((InsertedBy != ".$this->familyCode." and PrivateFlag = 2) or InsertedBy = ".$this->familyCode.") AND ActiveFlag = 1";
        if(!is_null($parameter)) {
            $where .= " AND".$parameter;
        }
        $this->whereConstraints = $where;
    }

    function setSearchClause($searchText){
        $searchParameters = new SearchParameters();
        switch($this->searchType){
            case 1:
                $this->searchClause = $searchParameters->getNameClause($searchText);
                break;
            case 2:
                $this->searchClause = $searchParameters->getMobileClause($searchText);
                break;
            case 3:
                $this->searchClause = $searchParameters->getEmailClause($searchText);
                break;
            case 4:
                $this->searchClause = $searchParameters->getCompanyClause($searchText);
                break;
            case 5:
                $this->searchClause = $searchParameters->getDesignationClause($searchText);
                break;
            case 6:
                $this->searchClause = $searchParameters->getGuardianNameClause($searchText);
                break;
            case 7:
                $this->searchClause = $searchParameters->getDobClause($searchText);
                break;
            case 8:
                $this->searchClause = $searchParameters->getDomClause($searchText);
                break;
            case 9:
                $this->searchClause = $searchParameters->getGroupClause($this->regCode,$searchText);
                break;
            case 10:
                $this->searchClause = $searchParameters->getHomeAreaClause($this->regCode,$searchText);
                break;
            case 11:
                $this->searchClause = $searchParameters->getHomeCityClause($this->regCode,$searchText);
                break;
            case 12:
                $this->searchClause = $searchParameters->getHomePhoneClause($this->regCode,$searchText);
                break;
            case 13:
                $this->searchClause = $searchParameters->getWorkAreaClause($this->regCode,$searchText);
                break;
            case 14:
                $this->searchClause = $searchParameters->getWorkCityClause($this->regCode,$searchText);
                break;
            case 15:
                $this->searchClause = $searchParameters->getWorkPhoneClause($this->regCode,$searchText);
                break;
            case 16:
                $this->searchClause = $searchParameters->getOtherAreaClause($this->regCode,$searchText);
                break;
            case 17:
                $this->searchClause = $searchParameters->getOtherCityClause($this->regCode,$searchText);
                break;
            case 18:
                $this->searchClause = $searchParameters->getOtherPhoneClause($this->regCode,$searchText);
                break;
        }
    }

    function getResponse(){
        if($this->successful){
            $this->setPages();
            $this->response = $this->createResponse(1,"Success");
            $this->response["pages"] = $this->pages;
            $this->response["result"] = $this->contactList;
        }
        else{
            $this->response = $this->createResponse(0,"No contacts");
        }

        return $this->response;
    }

    function setContactList(){
        $sql = $this->getContactListQuery();
        if($result = $this->mysqli->query($sql)){

            if($result->num_rows == 0){
                $this->successful = false;
            }
            else{
                $i = 0;
                while($row = $result->fetch_assoc()){
                    $this->contactList[$i] = $row;
                    $i++;
                }
                $this->successful = true;
            }
        }
    }

    function setMysqli($mysqli){
        $this->mysqli = $mysqli;
    }

    function setRegCode($regCode){
        $this->regCode = $regCode;
    }

    function setLimit($limit){
        $this->limit = $limit;
    }

    function setRequestPage($requestPage){
        $this->requestPage = $requestPage;
    }

    function setCountQuery(){
        $qry = "SELECT count(*) as 'count' FROM Table151";
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

    function __destruct(){
        $this->mysqli->close();
    }

    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }
}
