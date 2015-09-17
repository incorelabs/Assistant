<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 17/09/15
 * Time: 11:51 AM
 */
namespace Assistant\Preferences\Cheque;
require 'ChequeAutoload.php';

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

    if(empty($_POST['mode']) || empty($_POST["chequeCode"]) ) {
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    //Delete mode
    if ($_POST["mode"] == "D") {
        break;
    }

    if(empty($_POST['chequeCode']) || empty($_POST['chequeName']) || empty($_POST['dateTop']) || empty($_POST['dateLeft']) || empty($_POST['dateSplit']) || empty($_POST['nameTop']) || empty($_POST['nameLeft']) || empty($_POST['nameWidth']) || empty($_POST['rupee1Top']) || empty($_POST['rupee1Left']) || empty($_POST['rupee1Width']) || empty($_POST['rupee2Top']) || empty($_POST['rupee2Left']) || empty($_POST['rupee2Width']) || empty($_POST['rsTop']) || empty($_POST['rsLeft']) || empty($_POST['chequeFeed']) || empty($_POST['continousFeed'])){
        $validate = false;
        $response = createResponse(0,"Required Fields are empty");
        break;
    }

    if((!empty($_POST['bearerTop']) && !empty($_POST['bearerLeft']) && !empty($_POST['bearerWidth'])) || (empty($_POST['bearerTop']) && empty($_POST['bearerLeft']) && empty($_POST['bearerWidth']) )){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Please fill all the details in Bearer row");
        break;
    }

    if((empty($_POST['acPayeeTop']) && empty($_POST['acPayeeLeft'])) || (!empty($_POST['acPayeeTop']) && !empty($_POST['acPayeeLeft']))){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Please fill all the details in A/C Payee row");
        break;
    }

    if((empty($_POST['notExceedTop']) && empty($_POST['notExceedLeft'])) || (!empty($_POST['notExceedTop']) && !empty($_POST['notExceedLeft']))){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Please fill all the details in Not Exceeding row");
        break;
    }

    if((empty($_POST['forAcName']) && empty($_POST['forAcNameTop']) && empty($_POST['forAcNameLeft'])) || (!empty($_POST['forAcName']) && !empty($_POST['forAcNameTop']) && !empty($_POST['forAcNameLeft']))){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Please fill all the details in For Holder field");
        break;
    }

    if((empty($_POST['signatoryName']) && empty($_POST['signatoryNameTop']) && empty($_POST['signatoryNameLeft'])) || (!empty($_POST['signatoryName']) && !empty($_POST['signatoryNameTop']) && !empty($_POST['signatoryNameLeft']))){
        $validate = true;
    }
    else{
        $validate = false;
        $response = createResponse(0,"Please fill all the details in Signatory field");
        break;
    }

}while(0);

if($validate){
    $settings = new ChequeSettings();
    $settings->setData($_POST);
    $response = $settings->getResponse();
}

echo json_encode($response);