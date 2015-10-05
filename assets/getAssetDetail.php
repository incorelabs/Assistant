<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 05/10/15
 * Time: 5:54 PM
 */
namespace Assistant\Assets;
require 'AssetAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General Validation
do{
    if(!empty($_GET["assetCode"])){
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
    $assetCode = intval($_GET["assetCode"]);
    $detailObj = new AssetDetail($assetCode);
    $response = $detailObj->getResponse();
}
echo json_encode($response);