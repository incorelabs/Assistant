<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 13/10/15
 * Time: 3:09 PM
 */

namespace Assistant\Document;


class DocumentList
{
    var $limit;
    var $pages;
    var $requestPage;
    var $documentList;
    var $count;
    var $mysqli;
    var $regCode;
    var $familyCode;
    var $response;
    var $successful; // if document retrieved then successful
    var $searchText;
    var $searchType;
    var $searchClause;
    var $countQuery;
    var $documentListQuery;
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

        $this->setDocumentListQuery();
        $this->setDocumentList();
        $this->setCountQuery();
        $this->setCount();
    }

    function getLimits(){
        $lower = $this->requestPage * $this->limit;
        $upper = $lower + $this->limit - 1;
        return array("lower"=>$lower, "upper" => $upper);
    }

    function setWhereConstraints($parameter = null){
        $where = " WHERE Table160.RegCode = ".$this->regCode." AND ((Table160.InsertedBy != ".$this->familyCode." and PrivateFlag = 2) or Table160.InsertedBy = ".$this->familyCode.") AND Table160.ActiveFlag = 1";
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
                $documentNameClause = $searchParameters->getDocumentNameClause($searchText);
                $this->searchClause = " ( ".$documentNameClause." OR ".$holderNameClause." ) ";
                break;
        }
    }

    function setDocumentListQuery(){
        $this->documentListQuery = "SELECT Table160.DocumentCode, Table107.FamilyName as 'HolderName', Table160.DocumentName FROM Table160 LEFT JOIN Table107 ON Table107.RegCode = Table160.RegCode AND Table107.FamilyCode = Table160.HolderCode".$this->whereConstraints." ORDER BY Table107.FamilyName LIMIT ".$this->limit." OFFSET ".$this->getLimits()["lower"].";";
    }

    function getDocumentListQuery(){
        return $this->documentListQuery;
    }

    function setDocumentList(){
        $sql = $this->getDocumentListQuery();
        if($result = $this->mysqli->query($sql)){

            if($result->num_rows == 0){
                $this->successful = false;
            }
            else{
                $i = 0;
                while($row = $result->fetch_assoc()){
                    $this->documentList[$i] = $row;
                    $i++;
                }
                $this->successful = true;
            }
        }
    }

    function setCountQuery(){
        $qry = "SELECT count(*) as 'count' FROM Table160";
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
            $this->response["result"] = $this->documentList;
        }
        else{
            $this->response = $this->createResponse(0,"No document");
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