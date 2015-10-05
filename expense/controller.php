<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 19/09/15
 * Time: 4:41 PM
 */
namespace Assistant\Expense;

require 'ExpenseAutoload.php';

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

    if(empty($_POST['mode']) || empty($_POST["expenseCode"])) {
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    //Delete mode
    if ($_POST["mode"] == "D") {
        break;
    }

    //Validate required fields
    if (empty($_POST["holderCode"]) || empty($_POST["mode"]) || empty($_POST["expenseTypeName"]) || empty($_POST["expenseTypeCode"]) || empty($_POST["expenseName"]) || empty($_POST["contactCode"]) || empty($_POST["fullName"]) || empty($_POST["billingDay"]) || empty($_POST["dueDay"]) || empty($_POST["expenseFrequency"])) {
        $validate = false;
        $response = createResponse(0,"Required fields are empty");
        break;
    }

    if(intval($_POST["expenseTypeCode"]) == 1004 && empty($_POST["expiryDate"])){
        $validate = false;
        $response = createResponse(0,"Please enter expiry date.");
        break;
    }

} while (0);

//Business Logic
if ($validate) {
    $expenseController = new ExpenseController($_POST);
    $response = $expenseController->getResponse();
}

echo json_encode($response);