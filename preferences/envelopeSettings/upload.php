<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 16/09/15
 * Time: 2:56 PM
 */

session_start();
define("ROOT", "../../");

require ROOT.'dist/authenticate.php';
require ROOT.'db/Connection.php';
require 'EnvelopeSettings.php';
include("../../external/class.upload.php");

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");
$validate = true;
do{
    if(empty($_POST['coverCode'])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
    }
}while(0);

if($validate) {
    $logo = new upload($_FILES["fileToUpload"]);
    if($logo->uploaded){
        //check upload size
        $logo->file_max_size = 1024 * 1024; // 1 MB
        //check mime type
        $logo->mime_check = true;
        $logo->allowed = array('image/*');
        $logo->forbidden = array('application/*');

        //upload
        $logo->file_new_name_body = $_POST["coverCode"];
        $logo->image_convert = 'jpg';
        $logo->file_overwrite = true;
        $path = ROOT."../Assistant_Users/".$_SESSION['s_id']."/preferences/envelope";
        $logo->Process($path);
        if($logo->processed){
            $path = "preferences/envelope/".$logo->file_dst_name;
            $settings = new \Assistant\Preferences\Envelope\EnvelopeSettings();
            $settings->setImagePath($_POST['coverCode'],$path);
            $response = createResponse(1,"Logo uploaded successfully");
        }
        else{
            $response = createResponse(0,$logo->error);
        }
        $logo->Clean();
    }
    else{
        $response = createResponse(0,"Please try some other image");
    }
}

echo json_encode($response);