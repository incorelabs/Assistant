<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 19/09/15
 * Time: 4:21 PM
 */
namespace Assistant\Expense;
require 'ExpenseAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General Validation
do{
    if(!empty($_GET["expenseCode"])){
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
    $expenseCode = intval($_GET["expenseCode"]);
    $detailObj = new ExpenseDetail($expenseCode);
    $response = $detailObj->getResponse();
}
echo json_encode($response);