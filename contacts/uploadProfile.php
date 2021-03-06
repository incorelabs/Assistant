<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 19/09/15
 * Time: 12:01 PM
 */

session_start();
define("ROOT", "../");

require ROOT.'dist/authenticate.php';
require ROOT.'db/Connection.php';
require 'ContactController.php';
include(ROOT."external/class.upload.php");

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");
$validate = true;
do{
    if(empty($_POST['contactCode'])){
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
        $logo->file_new_name_body = $_POST["contactCode"];
        $logo->image_convert = 'jpg';
        $logo->file_overwrite = true;
        $path = ROOT."../Assistant_Users/".$_SESSION['s_id']."/contacts/";
        $logo->Process($path);
        if($logo->processed){
            $path = "contacts/".$logo->file_dst_name;
            $data = array("mode"=>"AI", "contactCode"=>$_POST["contactCode"],"imagePath"=>$path);
            $settings = new \Assistant\Contacts\ContactController($data);
            $response = createResponse(1,"Contact image uploaded successfully");
            $response["location"] = $path;
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