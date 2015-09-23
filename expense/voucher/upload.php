<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 23/09/15
 * Time: 12:38 PM
 */
session_start();
define("ROOT", "../../");

require ROOT.'dist/authenticate.php';
require ROOT.'db/Connection.php';
require 'ExpenseVoucher.php';
include("../../external/class.upload.php");

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

$response = createResponse(0,"Initialize");
$validate = true;
do{
    if(empty($_POST['expenseCode']) && $_POST['voucherNo']){
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
        $path = ROOT."../Assistant_Users/".$_SESSION['s_id']."/expense/".$_POST["expenseCode"]."/";
        //echo $path;
        $logo->Process($path);
        if($logo->processed){
            $path = "expense/".$_POST["expenseCode"]."/".$logo->file_dst_name;
            $_POST["mode"] = "AI";
            $_POST["imagePath"] = $path;
            $_POST['voucherNo'] = intval($_POST['voucherNo']);
            $expenseCode = intval($_POST['expenseCode']);
            $settings = new \Assistant\Expense\Voucher\ExpenseVoucher($expenseCode);
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