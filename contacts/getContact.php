<?php
define("ROOT", "../");

require_once ROOT.'db/Connection.php';
$mysqli = getConnection();

$contact = array();

if (isset($_GET['id'])) {
	$id  = $_GET['id'];

	if ($id == 0) {
		$sql = "SELECT * FROM contact ORDER BY fullName LIMIT 1";
		if ($result = $mysqli->query($sql)) {
			$contact = $result->fetch_assoc();
		}
	}
	else{
		$sql = "SELECT * FROM contact WHERE contactCode = ".$id;
		if ($result = $mysqli->query($sql)) {
			$contact = $result->fetch_assoc();
		}
	}
}

if (isset($_GET['list'])) {
	$sql = "SELECT contactCode,fullName FROM contact ORDER BY fullName;";
	if ($result = $mysqli->query($sql)) {
		$contact = $result->fetch_all();
		//print_r($contact);
	}
}

echo json_encode($contact);
?>