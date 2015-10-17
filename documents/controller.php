<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 13/10/15
 * Time: 4:40 PM
 */
namespace Assistant\Document;

require 'DocumentAutoload.php';

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

    if(empty($_POST['mode']) || empty($_POST["documentCode"])) {
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    //Delete mode
    if ($_POST["mode"] == "D") {
        break;
    }

    //Validate required fields
    if (empty($_POST["holderCode"]) || empty($_POST["documentTypeName"]) || empty($_POST["documentTypeCode"]) || empty($_POST["documentName"]) || empty($_POST["issuedBy"]) || empty($_POST["issuedByName"]) || empty($_POST["locationCode"]) || empty($_POST["locationName"])) {
        $validate = false;
        $response = createResponse(0,"Required fields are empty");
        break;
    }

} while (0);

//Business Logic
if ($validate) {
    $documentController = new DocumentController($_POST);
    $response = $documentController->getResponse();
}

echo json_encode($response);