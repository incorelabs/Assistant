<?php

session_start();
define("ROOT", "../");

include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();
$regCode = intval($_SESSION['s_id']);

$response = array();

function getPasswordList($orderBy){
	global $response,$mysqli,$regCode;

	$sql = "SELECT Table152.`RegCode`, Table152.`PasswordCode`, Table152.`PasswordTypeCode`, Table130.PasswordTypeName, Table152.`HolderCode`, Table107.FamilyName as 'HolderName',Table152.`PasswordName`, Table152.`LoginID`, Table152.`LoginPassword1`, Table152.`LoginPassword2`, Table152.`InsertedBy`, Table152.`PrivateFlag`, Table152.`ActiveFlag` FROM `Table152` 
		INNER JOIN Table130 ON Table130.PasswordTypeCode = Table152.`PasswordTypeCode` 
		INNER JOIN Table107 ON Table107.RegCode = Table152.`RegCode` AND Table107.FamilyCode = Table152.`HolderCode` 
		WHERE Table152.`RegCode` = ".$regCode."
		ORDER BY ".$orderBy.";";
	//echo $sql;
	if ($result = $mysqli->query($sql)) {
		$i = 0;
		while ($row = $result->fetch_assoc()) {
			$response[$i] = $row;
			$i++;
		}
	}
}

if (isset($_GET['list'])) {
	$listType = intval($_GET['list']);
	getPasswordList("Table107.FamilyName");
}

echo json_encode($response);
$mysqli->close();
?>