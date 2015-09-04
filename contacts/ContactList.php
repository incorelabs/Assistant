<?php
session_start();
define("ROOT", "../");
include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';

class ContactList{
    var $limit;
    var $pages;
    var $requestPage;
    var $contactList;
    var $count;
    var $mysqli;
    var $regCode;
    var $response;
    var $successful; // if contacts retrieved then successful

    function __construct($limit,$page){
        $this->limit = $limit;
        $this->requestPage = $page;
        $this->regCode = intval($_SESSION['s_id']);
        $this->mysqli = getConnection();
        $this->setCount();
    }

    function getLimits(){
        $lower = $this->requestPage * $this->limit;
        $upper = $lower + $this->limit - 1;
        return array("lower"=>$lower, "upper" => $upper);
    }

    function getContactListQuery($parameter = null){
        $where = " WHERE RegCode = ".$this->regCode." ";
        if(!is_null($parameter)){
            $where .= " AND ".$parameter["key"]." LIKE %".$parameter["value"]."% ";
        }

        $sql = "SELECT Table151.ContactCode,
                Table151.FullName
            FROM Table151
            ORDER BY Table151.FullName ".$where."
            LIMIT ".$this->limit." OFFSET ".$this->getLimits()["lower"].";";
        return $sql;
    }

    function getResponse(){
        if($this->successful){
            $this->setPages();
            $this->response = createResponse(1,"Success");
            $this->response["pages"] = $this->pages;
            $this->response["result"] = $this->contactList;
        }
        else{
            $this->response = createResponse(0,"No contacts");
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

    function setCount($count = null){
        if(is_null($count)){
            $sql = "SELECT count(*) as 'count' FROM Table151 WHERE Table151.RegCode = ".$this->regCode;
            if($result = $this->mysqli->query($sql)) {
                $row = $result->fetch_assoc();
                $this->count = intval($row['count']);
                $this->setContactList();
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
}

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$validate;
$response;

//General validation
do{
    if(!empty($_GET['pageNo'])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid request");
        break;
    }
}while(0);

if($validate){
    $limit = 2; //should be greater than 1
    $requestPage = intval($_GET['pageNo']) - 1;

    $contactListObj = new ContactList($limit,$requestPage);
    $response = $contactListObj->getResponse();
}

echo json_encode($response);
?>