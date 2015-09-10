<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 10/09/15
 * Time: 9:15 AM
 */

session_start();
define("ROOT", "../");

require_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';


function PasswordAutoload($className)
{
    $lastNsPos = strrpos($className, '\\');
    $className = substr($className, $lastNsPos + 1);
    $fileName = $className.'.php';
    require $fileName;
}

spl_autoload_register('PasswordAutoload');
