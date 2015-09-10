<?php

namespace Assistant\Passwords;

require 'PasswordAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = array(0,"Initialize");
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

    if(empty($_POST['mode']) && empty($_POST["passwordCode"])) {
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

	//Delete mode
	if ($_POST["mode"] == "D") {
		break;
	}

	//Validate required fields
        if (empty($_POST["name"]) &&
            empty($_POST["mode"]) &&
            empty($_POST["passwordType"]) &&
            empty($_POST["passwordTypeCode"]) &&
            empty($_POST["description"]) &&
            empty($_POST["userID"]) &&
            empty($_POST["password"])) {
        $validate = false;
        $response = createResponse(0,"Required fields are empty");
        break;
	}

} while (0);

//Business Logic
if ($validate) {
    $passwordController = new PasswordController($_POST);
    $response = $passwordController->getResponse();
}

echo json_encode($response);