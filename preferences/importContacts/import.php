<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 26/09/15
 * Time: 6:03 PM
 */

session_start();
define("ROOT", "../../");

require_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
require_once ROOT . 'modules/functions.php';
require_once 'OutlookFormat.php';
include(ROOT."external/class.upload.php");

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");
$validate = true;

do{
    if(empty($_FILES["fileToUpload"])){
        $validate = false;
        $response = createResponse(0,"File unavailable");
    }
}while(0);

if($validate) {
    $logo = new upload($_FILES["fileToUpload"]);
    if($logo->uploaded){

        //upload
        $logo->file_overwrite = true;
        $path = ROOT."../Assistant_Users/".$_SESSION['s_id']."/contacts/import/";
        $logo->Process($path);
        if($logo->processed){
            $path .= $logo->file_dst_name;
            $settings = new \Assistant\Preferences\ImportContacts\OutlookFormat($path);
            $response = $settings->getResponse();
        }
        else{
            $response = createResponse(0,$logo->error);
        }
        $logo->Clean();
    }
    else{
        $response = createResponse(0,"Please try some other file");
    }
}

echo json_encode($response);