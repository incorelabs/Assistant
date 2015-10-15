<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 15/10/15
 * Time: 6:38 PM
 */
namespace Assistant\Document;
require 'DocumentAutoload.php';

$response = array();
$validate = true;

//Validate Request
do {
    if (empty($_GET["type"])) {
        $validate = false;
        break;
    }

} while (0);

if($validate){
    $type = $_GET['type'];
    $documentMasters = new DocumentMasters();

    switch($type){
        case "documentType":
            $response = $documentMasters->getDocumentTypeList();
            break;

        case "contactList":
            $response = $documentMasters->getContactsList();
            break;

        case "locationList":
            $response = $documentMasters->getLocationList();
            break;
    }
}

echo json_encode($response);