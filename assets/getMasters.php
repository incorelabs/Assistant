<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 06/10/15
 * Time: 4:45 PM
 */
namespace Assistant\Assets;
require 'AssetAutoload.php';

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
    $assetMasters = new AssetMasters();

    switch($type){
        case "assetType":
            $response = $assetMasters->getAssetTypeList();
            break;

        case "contactList":
            $response = $assetMasters->getContactsList();
            break;

        case "locationList":
            $response = $assetMasters->getLocationList();
            break;
    }
}

echo json_encode($response);