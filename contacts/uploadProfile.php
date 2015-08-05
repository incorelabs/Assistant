<?php
define("ROOT", "../");
require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

$target_dir = ROOT."img/contacts/profile/";
$id = $_POST['photoId'];

$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$extension = end($temp);
$target_file = $target_dir . basename($id.".".$extension);

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
        $uploadStatus['check'] = 0;
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 1 * 1000 * 1000) {
    $uploadStatus["size"] = 0;
    $uploadOk = 0;
}
else{
    $uploadStatus["size"] = 1;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG"
&& $imageFileType != "GIF" ) {
    $uploadStatus["type"] = 0;
    $uploadOk = 0;
}
else{
    $uploadStatus["type"] = 1;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
    $uploadStatus['location'] = null;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $uploadStatus['location'] = $target_file;

        $regCode = substr(strval($id), 0,4);
        $contactCode = substr(strval($id), 4);

        $sql = "UPDATE `contact` SET `photoUploaded` = 1 WHERE contactCode = ".$contactCode." AND registerLicenceCode = ".$regCode.";";
        $sql .= "DELETE FROM images WHERE contactCode = ".intval($contactCode)." AND registeredLicenseCode =".intval($regCode).";";
    
        $sql .= build_insert_str("images",array(
            $regCode,
            $contactCode,
            1,
            $target_file,
            $extension));
        //echo $sql;

        $mysqli->multi_query($sql);
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        //echo "Sorry, there was an error uploading your file.";
        $uploadStatus['location'] = null;
    }
}
$mysqli->close();
$uploadStatus["status"] = $uploadOk;
echo json_encode($uploadStatus);
?>