<?php
/**
 * User: kbokdia
 * Date: 09/09/15
 * Time: 7:30 PM
 */

namespace Assistant\Passwords;
require 'PasswordAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General Validation
do{
    if(!empty($_GET["passwordCode"])){
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
    $passwordCode = intval($_GET["passwordCode"]);
    $detailObj = new PasswordDetail($passwordCode);
    $response = $detailObj->getResponse();
}
echo json_encode($response);