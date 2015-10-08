<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 08/10/15
 * Time: 2:36 PM
 */
namespace Assistant\Assets;
require 'AssetAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General validation
do{
    if(!empty($_GET['assetCode'])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid request");
        break;
    }
}while(0);

if($validate){
    $assetCode = intval($_GET["assetCode"]);
    $imageController = new ImageController($assetCode);
    $response = $imageController->getImageList();
}
echo json_encode($response);
