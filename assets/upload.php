<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 07/10/15
 * Time: 3:30 PM
 */
session_start();
define("ROOT", "../");

require ROOT.'dist/authenticate.php';
require ROOT.'db/Connection.php';
require 'AssetController.php';
include(ROOT."external/class.upload.php");

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

function getFileName($assetCode){
    global $mysqli, $regCode;
    $fileName = 1;
    $sql = "SELECT MAX(SerialNo) as 'SerialNo' FROM Table166 WHERE RegCode = ".$regCode." and AssetCode = ".$assetCode." and SerialNo < 1000";
    if($result = $mysqli->query($sql)){
        $fileName = intval($result->fetch_assoc()["SerialNo"]);
        $fileName = (($fileName == 0) ? 1 : $fileName + 1);
    }
    return $fileName;
}

function getFileCount($assetCode){
    global $mysqli, $regCode;
    $count = 0;
    $sql = "SELECT COUNT(*) as 'count' FROM Table166 WHERE RegCode = ".$regCode." and AssetCode = ".$assetCode." and SerialNo < 1000";

    if($result = $mysqli->query($sql)){
        $count = intval($result->fetch_assoc()["count"]);
    }
    return $count;
}

$mysqli = getConnection();
$regCode = intval($_SESSION['s_id']);
$assetCode = 1;
$limit = 5;
$response = createResponse(0,"Initialize");
$validate = true;
do{
    if(empty($_POST['assetCode']) || empty($_FILES["fileToUpload"])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    $assetCode = intval($_POST['assetCode']);
    $count = getFileCount($assetCode);
    if($count >= 5){
        $validate = false;
        $response = createResponse(0,"You cannot add more than five images");
        break;
    }
    echo "\nCOUNT : ".$count;
    echo "\nLimit : ".$limit;
    //update limit
    $limit = $limit - $count;
    echo "\n(A)Limit : ".$limit;

}while(0);

if($validate){
    $files = array();
    $counter = 0;
    foreach ($_FILES['fileToUpload'] as $k => $l) {
        if($counter == $limit)
            break;
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files))
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
        $counter++;
    }

    print_r($files);

    //upload files
    foreach ($files as $file) {
        $logo = new upload($file);
        if($logo->uploaded){
            //check upload size
            $logo->file_max_size = 1024 * 1024; // 1 MB

            //check mime type
            $logo->mime_check = true;
            $logo->allowed = array('image/*');
            $logo->forbidden = array('application/*');

            //upload
            $serialNo = getFileName($assetCode);
            $logo->file_new_name_body = $serialNo;
            $logo->image_convert = 'jpg';
            $logo->file_overwrite = true;
            $path = ROOT."../Assistant_Users/".$_SESSION['s_id']."/assets/".$_POST["assetCode"]."/";
            //echo $path;
            $logo->Process($path);
            if($logo->processed){
                $path = "assets/".$_POST["assetCode"]."/".$logo->file_dst_name;
                $data["mode"] = "AI";
                $data["imagePath"] = $path;
                $data['assetCode'] = intval($_POST['assetCode']);
                $data['serialNo'] = $serialNo;
                $settings = new \Assistant\Assets\AssetController($data);

                $response = createResponse(1,"Image uploaded successfully");
            }
            else{
                $response = createResponse(0,$logo->error);
            }
            $logo->Clean();
        }
        else{
            $response = createResponse(0,$logo->error);
        }
        unset($logo);
    }
}

echo json_encode($response);