<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 15/09/15
 * Time: 3:48 PM
 */
namespace Assistant\Preferences\Envelope;
require 'EnvelopeAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//Do validation if required
$validate = true;

if($validate){
    $settings = new EnvelopeSettings();
    $response = $settings->getEnvelopeList();
}

echo json_encode($response);