<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 17/09/15
 * Time: 11:08 AM
 */
namespace Assistant\Preferences\Cheque;
require 'ChequeAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");

//Do validation if required
$validate = true;

if($validate){
    $settings = new ChequeSettings();
    $response = $settings->getChequeList();
}

echo json_encode($response);