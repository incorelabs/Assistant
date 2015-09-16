<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 16/09/15
 * Time: 2:56 PM
 */

namespace Assistant\Preferences\Envelope;
require 'EnvelopeAutoload.php';
require ROOT."external/class.upload.php";

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
    $logo = new \upload($_FILES["fileToUpload"]);
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
        $logo->process($path);
        if($logo->processed){
            $path = $logo->file_dst_pathname;
            $settings = new EnvelopeSettings();
            $settings->setImagePath($_POST['coverCode'],$path);
            print_r($settings->response);
            $response = createResponse(1,"Logo uploaded successfully");
            $logo->clean();
        }
        else{
            $response = createResponse(0,$logo->error);
        }
    }
}

echo json_encode($response);