<?php
session_start();
define("ROOT", "../");
include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';

$mysqli = getConnection();
$regCode = intval($_SESSION['s_id']);

class ContactList{
    var $limit;
    var $requestPage;
    var $contactList;
    var $count;
    var $mysqli;
    var $regCode;

    function __construct($limit,$page){
        $this->limit = $limit;
        $this->requestPage = $page;
        $this->regCode = intval($_SESSION['s_id']);
        $this->mysqli = getConnection();
    }

    function getLimits(){
        $lower = $this->requestPage * $this->limit;
        $upper = $lower + $this->limit - 1;
        return array("lower"=>$lower, "upper" => $upper);
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

            }
        }
    }
}

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$validate;
$response;

//General validation
do{
    if(isset($_GET['pageNo'])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid request");
        break;
    }
}while(0);

if($validate){

    $limit = 250;
    $requestPage = intval($_GET['pageNo']);

    $logicObj = new ContactList($limit,$requestPage);
    $contactList = array();

    $sql = "SELECT Table151.ContactCode,
                Table151.FullName
            FROM Table151
            ORDER BY Table151.FullName
            LIMIT ".$limit." OFFSET ".$logicObj->getLimits()["lower"].";";

    //echo $sql;
    if($result = $mysqli->query($sql)){

        if($result->num_rows == 0){
            $validate = false;
            $response = createResponse(0,"No contacts");
        }
        else{
            $i = 0;
            while($row = $result->fetch_assoc()){
                $contactList[$i] = array($row['ContactCode'],$row['FullName']);
                $i++;
            }
            $validate = true;
        }
    }

    if($validate){
        $sql = "SELECT count(*) as 'count' FROM Table151 WHERE Table151.RegCode = ".$regCode;
        if($result = $mysqli->query($sql)){
            $row = $result->fetch_assoc();
            $noOfContacts = intval($row['count']);
            $pages = round($noOfContacts/$limit);
            $response = createResponse(1,"Success");
            $response["pages"] = $pages;
            $response["result"] = $contactList;
            $validate = true;
        }
    }
}

echo json_encode($response);
?>