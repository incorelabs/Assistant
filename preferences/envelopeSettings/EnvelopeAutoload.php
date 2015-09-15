<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 15/09/15
 * Time: 3:44 PM
 */
session_start();
define("ROOT", "../../");

require_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';


function EnvelopeAutoload($className)
{
    $lastNsPos = strrpos($className, '\\');
    $className = substr($className, $lastNsPos + 1);
    $fileName = $className.'.php';
    require $fileName;
}

spl_autoload_register('EnvelopeAutoload');