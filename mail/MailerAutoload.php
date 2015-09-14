<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 14/09/15
 * Time: 11:30 AM
 */

require "../PHPMailer/PHPMailerAutoload.php";
require "config.php";

function MailerAutoload($className)
{
    $lastNsPos = strrpos($className, '\\');
    $className = substr($className, $lastNsPos + 1);
    $fileName = $className.'.php';
    require $fileName;
}

spl_autoload_register('MailerAutoload');