<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 24/09/15
 * Time: 2:37 PM
 */
namespace Assistant\Income;
require 'IncomeAutoload.php';

$response = array();
$validate = true;

//Validate Request
do {
    if (empty($_GET["type"])) {
        $validate = false;
        break;
    }

} while (0);

if($validate){
    $type = $_GET['type'];
    $incomeMasters = new IncomeMasters();

    switch($type){
        case "incomeType":
            $response = $incomeMasters->getIncomeTypeList();
            break;

        case "contactList":
            $response = $incomeMasters->getContactsList();
            break;
    }
}

echo json_encode($response);