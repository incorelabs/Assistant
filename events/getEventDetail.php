<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 16/10/15
 * Time: 11:16 AM
 */
namespace Assistant\Events;
require 'EventAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General Validation
do{
    if(!empty($_GET["eventCode"])){
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
    $eventCode = intval($_GET["eventCode"]);
    $detailObj = new EventDetail($eventCode);
    $response = $detailObj->getResponse();
}
echo json_encode($response);