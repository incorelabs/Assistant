<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 08/10/15
 * Time: 6:45 PM
 */
session_start();
define("ROOT", "");

require ROOT.'dist/authenticate.php';
require ROOT.'db/Connection.php';
require ROOT.'ProfileImageController.php';
include(ROOT."external/class.upload.php");

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");
$validate = true;
do{
    if(empty($_POST["mode"])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
    }

    if($_POST["mode"] == "D"){
        break;
    }

    if($_POST["mode"] != "A" || empty($_FILES["fileToUpload"])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
    }
}while(0);

if($validate && $_POST["mode"] == "D"){
    $imageController = new ProfileImageController();
    $response = $imageController->deleteImage();
}

if($validate && $_POST["mode"] == "A") {
    $logo = new upload($_FILES["fileToUpload"]);
    if($logo->uploaded){
        //check upload size
        $logo->file_max_size = 1024 * 1024; // 1 MB

        //check mime type
        $logo->mime_check = true;
        $logo->allowed = array('image/*');
        $logo->forbidden = array('application/*');

        //upload
        $logo->file_new_name_body = $_SESSION["familyCode"];
        $logo->image_convert = 'jpg';
        $logo->file_overwrite = true;
        $path = ROOT."../Assistant_Users/".$_SESSION['s_id']."/";
        //echo $path;
        $logo->Process($path);
        if($logo->processed){
            $path = $logo->file_dst_name;
            $imageController = new ProfileImageController();
            $response = $imageController->addImage($path);
            $response = ($response["status"] == 1 ) ? createResponse(1,"Image uploaded successfully") : $response;
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