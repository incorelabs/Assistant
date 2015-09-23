<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 23/09/15
 * Time: 11:08 AM
 */

namespace Assistant\Expense\Voucher;
require 'VoucherAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//Do validation if required
$validate = true;
do{
    if(empty($_GET['expenseCode'])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }
}while(0);

if($validate){
    $expenseCode = intval($_GET['expenseCode']);
    $settings = new ExpenseVoucher($expenseCode);
    $response = $settings->getVoucherList();
}

echo json_encode($response);