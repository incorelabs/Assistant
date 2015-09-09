<?php
/**
 * User: kbokdia
 * Date: 09/09/15
 * Time: 7:30 PM
 */

spl_autoload_register(function ($class) {
    include $class . '.php';
});

session_start();
define("ROOT", "../");

require_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';

$validate;
$response;

//General Validation
do{
    if(!empty($_GET["passwordCode"])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }
}while(0);

//Business Logic
if($validate){
    $passwordCode = intval($_GET["passwordCode"]);
    $detailObj = new PasswordDetail($passwordCode);
    $response = $detailObj->getResponse();
}
echo json_encode($response);