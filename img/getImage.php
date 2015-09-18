<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 18/09/15
 * Time: 12:42 PM
 */
session_start();
define("ROOT", "../");
require ROOT.'dist/authenticate.php';

$regCode = intval($_SESSION['s_id']);

$file = urldecode($_GET['file']);
$fileDir = '../../Assistant_Users/'.$regCode."/";

if (file_exists($fileDir . $file))
{
    $fileName = $fileDir . $file;

    $contents = file_get_contents($fileName);

    $fileInfo = new finfo(FILEINFO_MIME_TYPE);
    $contentType = $fileInfo->file($fileName);

    header("Content-type: ".$contentType);

    echo $contents;
}