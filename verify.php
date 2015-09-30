<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 30/09/15
 * Time: 5:36 PM
 */
define("ROOT", "");

require_once ROOT . 'db/Connection.php';
require_once ROOT . 'modules/functions.php';
require_once ROOT . "mail/MailerAutoload.php";

$mysqli = getConnection();
$response = array();
$validate = true;

function createResponse($status, $message)
{
    return array('status' => $status, 'message' => $message);
}

do{
    if(empty($_GET['email']) && empty($_GET['hash'])){
        $validate = false;
        $response = createResponse(0,"Invalid approach, please use the link that has been send to your email.");
    }
}while(0);

if($validate){
    $email = $mysqli->escape_string($_GET['email']);
    $hash = $mysqli->escape_string($_GET['hash']);

    $sql = "SELECT RegEmail, Hash, ActiveFlag FROM Table109 WHERE RegEmail = '".$email."' AND Hash = '".$hash."' AND ActiveFlag = 0";

    if($result = $mysqli->query($sql)){
        if($result->num_rows > 0){
            $sql = "UPDATE Table109 SET ActiveFlag = 1 WHERE RegEmail = '".$email."' AND Hash = '".$hash."' AND ActiveFlag = 0";
            $mysqli->query($sql) or die($mysqli->error);
            $validate = true;
            $response = createResponse(1,"Your account has been activated, you can now login");
        }
        else{
            $validate = false;
            $response = createResponse(0,"The url is either invalid or you already have activated your account.");
        }
    }
}

print_r($response);