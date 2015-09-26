<?php
/**
 * User: kbokdia
 * Date: 02/09/15
 * Time: 12:12 PM
 */
namespace Assistant\Contacts;

require 'ContactAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = array(0,"Initialize");
//General Validation
do {
    if(isset($_POST)){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid request");
        break;
    }

    if(empty($_POST['mode']) && empty($_POST['contactCode'])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    if($_POST['mode'] == "D" || $_POST["mode"] == "DI"){
        break;
    }

    //Required Validation
    if(!empty($_POST['mode']) && !empty($_POST['firstName'])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Required fields are missing");
        break;
    }

} while (0);

//Business Logic
if ($validate) {
    $contactController = new ContactController($_POST);
    $response = $contactController->getResponse();
}
echo json_encode($response);
