<?php

/**
 * User: kbokdia
 * Date: 09/09/15
 * Time: 4:21 PM
 */
namespace Assistant\Passwords;

class PasswordList
{
    var $limit;
    var $pages;
    var $requestPage;
    var $passwordList;
    var $count;
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $successful; // if passwords retrieved then successful
    var $searchText;
    var $searchType;
    var $searchClause;
    var $countQuery;
    var $passwordListQuery;
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

        $this->setPasswordListQuery();
        $this->setPasswordList();
        $this->setCountQuery();
        $this->setCount();
    }

    function getLimits(){
        $lower = $this->requestPage * $this->limit;
        $upper = $lower + $this->limit - 1;
        return array("lower"=>$lower, "upper" => $upper);
    }

    function getPasswordListQuery(){
        return $this->passwordListQuery;
    }

    function setPasswordListQuery(){
        $this->passwordListQuery = "SELECT Table152.PasswordCode, Table107.FamilyName as 'HolderName', Table152.PasswordName FROM Table152 INNER JOIN Table130 ON Table130.PasswordTypeCode = Table152.PasswordTypeCode LEFT JOIN Table107 ON Table107.RegCode = Table152.RegCode AND Table107.FamilyCode = Table152.HolderCode".$this->whereConstraints." ORDER BY Table107.FamilyName LIMIT ".$this->limit." OFFSET ".$this->getLimits()["lower"].";";
    }

    function setWhereConstraints($parameter = null){
        $where = " WHERE Table152.RegCode = ".$this->regCode." AND ((Table152.InsertedBy != ".$this->familyCode." and PrivateFlag = 2) or Table152.InsertedBy = ".$this->familyCode.") AND Table152.ActiveFlag = 1";
        if(!is_null($parameter)) {
            $where .= " AND".$parameter;
        }
        $this->whereConstraints = $where;
    }

    function setSearchClause($searchText){
        $searchParameters = new SearchParameters();
        switch($this->searchType){
            case 1:
                $holderNameClause = $searchParameters->getHolderNameClause($searchText);
                $passwordNameClause = $searchParameters->getPasswordNameClause($searchText);
                $this->searchClause = " ( ".$passwordNameClause." OR ".$holderNameClause." ) ";
                break;
        }
    }

    function getResponse(){
        if($this->successful){
            $this->setPages();
            $this->response = $this->createResponse(1,"Success");
            $this->response["pages"] = $this->pages;
            $this->response["result"] = $this->passwordList;
        }
        else{
            $this->response = $this->createResponse(0,"No passwords");
        }

        return $this->response;
    }

    function setPasswordList(){
        $sql = $this->getpasswordListQuery();
        if($result = $this->mysqli->query($sql)){

            if($result->num_rows == 0){
                $this->successful = false;
            }
            else{
                $i = 0;
                while($row = $result->fetch_assoc()){
                    $this->passwordList[$i] = $row;
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
        $qry = "SELECT count(*) as 'count' FROM Table152";
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


    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }

    function __destruct(){
        $this->mysqli->close();
    }
}

