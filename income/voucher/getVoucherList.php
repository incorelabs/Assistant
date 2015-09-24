<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 24/09/15
 * Time: 2:48 PM
 */
namespace Assistant\Income\Voucher;
require 'VoucherAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//Do validation if required
$validate = true;
do{
    if(empty($_GET['incomeCode'])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }
}while(0);

if($validate){
    $incomeCode = intval($_GET['incomeCode']);
    $settings = new IncomeVoucher($incomeCode);
    $response = $settings->getVoucherList();
}

echo json_encode($response);