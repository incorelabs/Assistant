<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 15/09/15
 * Time: 4:41 PM
 */

namespace Assistant\Preferences\Envelope;
require 'EnvelopeAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//Do validation if required
do{
    if (isset($_POST)) {
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid");
        break;
    }

    if(empty($_POST['mode']) || empty($_POST["coverCode"]) ) {
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    //Delete mode
    if ($_POST["mode"] == "D" || $_POST["mode"] == "L") {
        break;
    }

    if(empty($_POST["fromRequired"]) || empty($_POST["logoAvailable"]) || empty($_POST["coverFeed"]) || empty($_POST["coverName"])){
        $validate = false;
        $response = createResponse(0,"Required Fields are empty");
        break;
    }

    if(intval($_POST["fromRequired"]) == 1){
        if(empty($_POST["fromTop"]) || empty($_POST["fromLeft"]) || empty($_POST["fromName"])){
            $validate = false;
            $response = createResponse(0,"Please add From Top, Left and Name values");
            break;
        }
    }

    if(intval($_POST["logoAvailable"]) == 1){
        if(empty($_POST["logoTop"]) || empty($_POST["logoLeft"]) || empty($_POST["logoHeight"]) || empty($_POST["logoWidth"])){
            $validate = false;
            $response = createResponse(0,"Please add Logo Top, Left, Height and Width values");
            break;
        }
    }
}while(0);

if($validate){
    $settings = new EnvelopeSettings();
    $settings->setData($_POST);
    $response = $settings->getResponse();
}

echo json_encode($response);