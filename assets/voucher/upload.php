<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 06/10/15
 * Time: 6:54 PM
 */
session_start();
define("ROOT", "../../");

require ROOT.'dist/authenticate.php';
require ROOT.'db/Connection.php';
require 'AssetVoucher.php';
include("../../external/class.upload.php");

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");
$validate = true;
do{
    if(empty($_POST['assetCode']) || empty($_POST['voucherNo']) || empty($_FILES["fileToUpload"])){
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
        $logo->file_new_name_body = $_POST["voucherNo"];
        $logo->image_convert = 'jpg';
        $logo->file_overwrite = true;
        $path = ROOT."../Assistant_Users/".$_SESSION['s_id']."/assets/".$_POST["assetCode"]."/";
        //echo $path;
        $logo->Process($path);
        if($logo->processed){
            $path = "assets/".$_POST["assetCode"]."/".$logo->file_dst_name;
            $_POST["mode"] = "AI";
            $_POST["imagePath"] = $path;
            $_POST['voucherNo'] = intval($_POST['voucherNo']);
            $assetCode = intval($_POST['assetCode']);
            $settings = new \Assistant\Assets\Voucher\AssetVoucher($assetCode);
            $settings->setData($_POST);
            $response = createResponse(1,"Image uploaded successfully");
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