<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 23/09/15
 * Time: 12:07 PM
 */
namespace Assistant\Expense\Voucher;
require 'VoucherAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//Do validation if required
do{
    if (isset($_POST)) {
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid");
        break;
    }

    if(empty($_POST['mode']) || empty($_POST["expenseCode"]) || empty($_POST["voucherNo"]) ) {
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    //Delete mode
    if ($_POST["mode"] == "D" || $_POST["mode"] == "DI") {
        break;
    }

    if(empty($_POST["voucherDt"]) || empty($_POST["payMode"]) || empty($_POST["docAmount"])){
        $validate = false;
        $response = createResponse(0,"Required Fields are empty");
        break;
    }

}while(0);

if($validate){
    $expenseCode = intval($_POST['expenseCode']);
    $settings = new ExpenseVoucher($expenseCode);
    $settings->setData($_POST);
    $response = $settings->getResponse();
}

echo json_encode($response);