<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 13/10/15
 * Time: 3:36 PM
 */
namespace Assistant\Document;
require 'DocumentAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General Validation
do{
    if(!empty($_GET["documentCode"])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }
}while(0);

//Business Logic
if($validate){
    $documentCode = intval($_GET["documentCode"]);
    $detailObj = new DocumentDetail($documentCode);
    $response = $detailObj->getResponse();
}
echo json_encode($response);