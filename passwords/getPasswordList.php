<?php
spl_autoload_register(function ($class) {
    include $class . '.php';
});

session_start();
define("ROOT", "../");

require_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';

$validate;
$response;

//General validation
do{
    if(!empty($_GET['pageNo'])){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Invalid request");
        break;
    }
}while(0);

if($validate){
    $limit = 200; //should be greater than 1
    $requestPage = intval($_GET['pageNo']) - 1;
    $searchText = (!empty($_GET['searchText']) ? $_GET['searchText'] : null);
    $searchType = (!empty($_GET['searchType']) ? intval($_GET['searchType']) : null);

    $passwordListObj = new PasswordList($limit,$requestPage,$searchType,$searchText);
    //$response = $passwordListObj->getPasswordListQuery();
    $response = $passwordListObj->getResponse();
}

echo json_encode($response);

