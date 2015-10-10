<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 10/10/15
 * Time: 11:16 AM
 */
session_start();
define("ROOT", "../");

require_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';


function NavBarAutoload($className)
{
    $lastNsPos = strrpos($className, '\\');
    $className = substr($className, $lastNsPos + 1);
    $fileName = $className.'.php';
    require $fileName;
}

spl_autoload_register('NavBarAutoload');