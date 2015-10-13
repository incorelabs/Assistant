<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 13/10/15
 * Time: 6:52 PM
 */
namespace Assistant\Document;
require 'DocumentAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General validation
do{
    if(!empty($_POST['documentCode'])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid request");
        break;
    }
}while(0);

if($validate){
    $documentCode = intval($_POST["documentCode"]);
    $serialCode = (empty($_POST["serialNo"]) ? null : intval($_POST["serialNo"]));
    $imageController = new ImageController($documentCode);
    $response = $imageController->deleteImage($serialCode);
}
echo json_encode($response);
