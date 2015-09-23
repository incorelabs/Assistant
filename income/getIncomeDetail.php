<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 23/09/15
 * Time: 7:55 PM
 */
namespace Assistant\Income;
require 'IncomeAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General Validation
do{
    if(!empty($_GET["incomeCode"])){
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
    $incomeCode = intval($_GET["incomeCode"]);
    $detailObj = new IncomeDetail($incomeCode);
    $response = $detailObj->getResponse();
}
echo json_encode($response);