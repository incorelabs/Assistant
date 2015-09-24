<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 24/09/15
 * Time: 12:34 PM
 */
namespace Assistant\Income;

require 'IncomeAutoload.php';

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

    if(empty($_POST['mode']) || empty($_POST["incomeCode"])) {
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    //Delete mode
    if ($_POST["mode"] == "D") {
        break;
    }

    //Validate required fields
    if (empty($_POST["holderCode"]) || empty($_POST["mode"]) || empty($_POST["incomeTypeName"]) || empty($_POST["incomeTypeCode"]) || empty($_POST["incomeName"]) || empty($_POST["contactCode"]) || empty($_POST["fullName"]) || empty($_POST["billingDay"]) || empty($_POST["dueDay"]) || empty($_POST["incomeFrequency"])) {
        $validate = false;
        $response = createResponse(0,"Required fields are empty");
        break;
    }

} while (0);

//Business Logic
if ($validate) {
    $incomeController = new IncomeController($_POST);
    $response = $incomeController->getResponse();
}

echo json_encode($response);