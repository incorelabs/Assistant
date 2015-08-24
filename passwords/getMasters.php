<?php
session_start();
define("ROOT", "../");
include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
$mysqli = getConnection();

$response = array();
$validate;

//Validate Request
do {
	if (isset($_GET["passwordType"])) {
		$validate = true;
	}
	else{
		$validate = false;
		break;
	}
} while (0);

//Business Logic
if ($validate) {
	$sql = "SELECT `PasswordTypeCode`, `PasswordTypeName` FROM Table130 WHERE RegCode IN (".$_SESSION["s_id"].", 10000);";
	if ($result = $mysqli->query($sql)) {
		while ($row = $result->fetch_assoc()) {
			$data = $row["PasswordTypeCode"].",".$row["PasswordTypeName"];
			array_push($response, $data);
		}	
	}
}

echo json_encode($response);
$mysqli->close();
?>