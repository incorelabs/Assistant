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

function getFileName(){
    global $mysqli;
    $fileName = 1;
    $sql = "SELECT MAX(SerialNo) as 'SerialNo' FROM Table166 WHERE RegCode = 10001 and AssetCode = 1002 and SerialNo < 1000";
    if($result = $mysqli->query($sql)){
        $fileName = intval($result->fetch_assoc()["SerialNo"]);
        echo "\n(Before)Serial No : ".$fileName;
        $fileName = (($fileName == 0) ? 1 : $fileName + 1);
        echo "\n(After) Serial No : ".$fileName."\n";
    }
    return $fileName;
}

$mysqli = getConnection();
$response = createResponse(0,"Initialize");
$validate = true;
do{
    if(empty($_POST['assetCode']) || empty($_FILES["fileToUpload"])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
    }
}while(0);

if($validate){
    $files = array();
    $counter = 0;
    foreach ($_FILES['fileToUpload'] as $k => $l) {
        if($counter == 5)
            break;
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files))
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
        $counter++;
    }

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
            $serialNo = getFileName();
            $logo->file_new_name_body = $serialNo;
            $logo->image_convert = 'jpg';
            $logo->file_overwrite = true;
            $path = ROOT."../Assistant_Users/".$_SESSION['s_id']."/assets/".$_POST["assetCode"]."/";
            //echo $path;
            $logo->Process($path);
            if($logo->processed){
                $path = "asset/".$_POST["assetCode"]."/".$logo->file_dst_name;
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