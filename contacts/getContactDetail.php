<?php

namespace Assistant\Contacts;
require 'ContactAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General Validation
do{
    if(!empty($_GET["contactCode"])){
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
    $contactCode = intval($_GET["contactCode"]);
    $detailObj = new ContactDetail($contactCode);
    $response = $detailObj->getResponse();
}
echo json_encode($response);