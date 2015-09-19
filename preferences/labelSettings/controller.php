<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 16/09/15
 * Time: 6:36 PM
 */

namespace Assistant\Preferences\Label;
require 'LabelAutoload.php';

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

    if(empty($_POST['mode']) || empty($_POST["labelCode"]) ) {
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    //Delete mode
    if ($_POST["mode"] == "D" || $_POST["mode"] == "DI") {
        break;
    }

    if(empty($_POST["labelName"]) || empty($_POST["linesPerLabel"]) || empty($_POST["labelInRow"]) || empty($_POST["labelInColumn"]) || empty($_POST["labelHeight"]) || empty($_POST["labelWidth"]) || empty($_POST["labelStartLeft"]) || empty($_POST["labelNextLeft"]) || empty($_POST["labelStartTop"]) || empty($_POST["labelNextTop"]) || empty($_POST["singleContent"]) || empty($_POST["logoAvailable"]) || empty($_POST["labelOrientation"])){
        $validate = false;
        $response = createResponse(0,"Required Fields are empty");
        break;
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
    $settings = new LabelSettings();
    $settings->setData($_POST);
    $response = $settings->getResponse();
}

echo json_encode($response);