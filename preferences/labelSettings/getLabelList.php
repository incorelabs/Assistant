<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 16/09/15
 * Time: 5:09 PM
 */
namespace Assistant\Preferences\Label;
require 'LabelAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//Do validation if required
$validate = true;

if($validate){
    $settings = new LabelSettings();
    $response = $settings->getLabelList();
}

echo json_encode($response);