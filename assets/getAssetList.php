<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 05/10/15
 * Time: 5:07 PM
 */
namespace Assistant\Assets;
require 'AssetAutoload.php';

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");
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

    $expenseListObj = new AssetList($limit,$requestPage,$searchType,$searchText);
    //$response = $passwordListObj->getPasswordListQuery();
    $response = $expenseListObj->getResponse();
}

echo json_encode($response);