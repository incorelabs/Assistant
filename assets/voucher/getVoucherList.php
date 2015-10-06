<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 06/10/15
 * Time: 5:42 PM
 */
namespace Assistant\Assets\Voucher;
require 'VoucherAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//Do validation if required
$validate = true;
do{
    if(empty($_GET['assetCode'])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }
}while(0);

if($validate){
    $assetCode = intval($_GET['assetCode']);
    $settings = new AssetVoucher($assetCode);
    $response = $settings->getVoucherList();
}

echo json_encode($response);