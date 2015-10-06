<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 06/10/15
 * Time: 12:08 PM
 */
namespace Assistant\Assets;

require 'AssetAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//General Validation
do {
    if (isset($_POST)) {
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid");
        break;
    }

    if(empty($_POST['mode']) || empty($_POST["assetCode"])) {
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    //Delete mode
    if ($_POST["mode"] == "D") {
        break;
    }

    //Validate required fields
    if (empty($_POST["holderCode"]) || empty($_POST["assetTypeName"]) || empty($_POST["assetTypeCode"]) || empty($_POST["assetName"]) || empty($_POST["broughtFrom"]) || empty($_POST["broughtFromName"]) || empty($_POST["locationCode"]) || empty($_POST["locationName"]) || empty($_POST["billDate"])) {
        $validate = false;
        $response = createResponse(0,"Required fields are empty");
        break;
    }

} while (0);

//Business Logic
if ($validate) {
    $expenseController = new AssetController($_POST);
    $response = $expenseController->getResponse();
}

echo json_encode($response);