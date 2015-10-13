<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 13/10/15
 * Time: 5:54 PM
 */
session_start();
define("ROOT", "../");

require ROOT.'dist/authenticate.php';
require ROOT.'db/Connection.php';
require 'ImageController.php';
include(ROOT."external/class.upload.php");

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

function getFileName($documentCode){
    global $mysqli, $regCode;
    $fileName = 1;
    $sql = "SELECT MAX(SerialNo) as 'SerialNo' FROM Table158 WHERE RegCode = ".$regCode." and DocumentCode = ".$documentCode;
    if($result = $mysqli->query($sql)){
        $fileName = intval($result->fetch_assoc()["SerialNo"]);
        $fileName = (($fileName == 0) ? 1 : $fileName + 1);
    }
    return $fileName;
}

$mysqli = getConnection();
$regCode = intval($_SESSION['s_id']);
$documentCode = 1;
//$limit = 5;
$response = createResponse(0,"Initialize");
$validate = true;
do{
    if(empty($_POST['documentCode']) || empty($_FILES["fileToUpload"])){
        $validate = false;
        $response = createResponse(0,"Invalid Request");
        break;
    }
    $documentCode = intval($_POST['documentCode']);

}while(0);

if($validate){

    $files = array();
    foreach ($_FILES['fileToUpload'] as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files))
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
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
            $serialNo = getFileName($documentCode);
            $logo->file_new_name_body = $serialNo;
            $logo->image_convert = 'jpg';
            $logo->file_overwrite = true;
            $path = ROOT."../Assistant_Users/".$_SESSION['s_id']."/documents/".$_POST["documentCode"]."/";
            //echo $path;
            $logo->Process($path);
            if($logo->processed){
                $path = "documents/".$_POST["documentCode"]."/".$logo->file_dst_name;
                $imagePath = $path;
                $settings = new \Assistant\Document\ImageController($documentCode);
                $response = $settings->addImage($imagePath,$serialNo);
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