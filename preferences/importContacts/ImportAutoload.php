<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 26/09/15
 * Time: 6:02 PM
 */
session_start();
define("ROOT", "../../");

require_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';


function ImportAutoload($className)
{
    $lastNsPos = strrpos($className, '\\');
    $className = substr($className, $lastNsPos + 1);
    $fileName = $className.'.php';
    require $fileName;
}

spl_autoload_register('ImportAutoload');