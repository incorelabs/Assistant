<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 10/10/15
 * Time: 11:12 AM
 */
namespace Assistant\NavBar;

require 'NavBarAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}
$validate = true;
$response = createResponse(0,"Initialize");
if($validate){
    $settings = new LoginDetail();
    $response = $settings->getDetails();
}

echo json_encode($response);