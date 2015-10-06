<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 06/10/15
 * Time: 5:41 PM
 */
session_start();
define("ROOT", "../../");

require_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';


function VoucherAutoload($className)
{
    $lastNsPos = strrpos($className, '\\');
    $className = substr($className, $lastNsPos + 1);
    $fileName = $className.'.php';
    require $fileName;
}

spl_autoload_register('VoucherAutoload');