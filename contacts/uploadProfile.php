<?php
session_start();
define("ROOT", "../");
include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
//require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

$regCode = $_SESSION['s_id'];
$contactCode;
$uploadOk = 1;
$response = array();
$target_dir = ROOT."img/".$regCode."/Contacts/";

function createResponse($status,$message){
    return array('status' => $status, 'message' => $message);
}

//General Validation
do{
    if (!empty($_POST["contactCode"])){
        $uploadOk = 1;
        $contactCode = $_POST['contactCode'];
    }
    else{
        $uploadOk = 0;
        $response = createResponse(0,"Invalid Request");
        break;
    }

    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $extension = end($temp);
    $target_file = $target_dir . basename($contactCode.".".$extension);

    $uploadStatus = array();
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadStatus['check'] = 1;
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $response = createResponse(0,"No an actual Image");
            break;
        }
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 1 * 1000 * 1000) {
        $uploadOk = 0;
        $response = createResponse(0,"File size is greater than 1MB");
        break;
    }
    else{
        $uploadOk = 1;
        $uploadStatus["size"] = 1;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG"
        && $imageFileType != "GIF" ) {
        $uploadOk = 0;
        $response = createResponse(0,"Invalid Image Format");
        break;
    }
    else{
        $uploadOk = 1;
    }

}while(0);



// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
    $uploadStatus['location'] = null;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        $sql = "UPDATE `Table151` SET `PhotoUploaded` = 1 WHERE ContactCode = ".$contactCode." AND RegCode = ".$regCode.";";
        $sql .= "DELETE FROM Table159 WHERE ContactCode = ".$contactCode." AND RegCode =".$regCode." AND SerialNo = 1;";
        $sql .= "INSERT INTO `Table159`
                VALUES
                (".$regCode.",
                ".$contactCode.",
                1,
                '".$target_file."',
                101,
                null,
                null);
";

       //echo $sql;

        if($mysqli->multi_query($sql)){
            $response = createResponse(1,"File uploaded successfully");
            $response["location"] = $target_file;
        }
        else{
            $response = createResponse(0,"Error occurred while uploading to the database: ".$mysqli->error);
        }
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        //echo "Sorry, there was an error uploading your file.";
        $response = createResponse(0,"Error occurred while uploading to the server");
    }
}
$mysqli->close();
echo json_encode($response);
?>