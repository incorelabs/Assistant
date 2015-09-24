<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 24/09/15
 * Time: 11:27 AM
 */
namespace Assistant\Expense;
require 'ExpenseAutoload.php';

$response = null;
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
    $expenseMasters = new ExpenseMasters();

    switch($type){
        case "expenseType":
            $response = $expenseMasters->getExpenseTypeList();
            break;

        case "contactList":
            $response = $expenseMasters->getContactsList();
            break;
    }
}

echo json_encode($response);