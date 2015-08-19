<?php
session_start();
define("ROOT", "../");
include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
$mysqli = getConnection();

$family = array();

if (isset($_GET['list'])) {
	$sql = "SELECT `FamilyCode`, `FamilyName`, Table107.`RelationCode`, Table112.`RelationName`, DATE_FORMAT(`BirthDate`,'%d/%m/%Y') as 'BirthDate', `Email`, `Mobile`, Table107.`Gender`, `LoginFlag`, `ActiveFlag` 
			FROM `Table107`
			LEFT JOIN Table112 ON Table112.`RelationCode` = Table107.`RelationCode`
			WHERE Table107.`RegCode` = ".$_SESSION['s_id']."
			ORDER BY `FamilyName`;";
	//echo $sql;
	if ($result = $mysqli->query($sql)) {
		$i = 0;
		while ($row = $result->fetch_assoc()) {
			$family[$i] = $row;
			$i++;
		}
	}
}

if (isset($_GET['code'])) {
	$id = intval($_GET['code']);
	$sql = "SELECT `FamilyCode`, `FamilyName`, Table107.`RelationCode`, Table112.`RelationName`, DATE_FORMAT(`BirthDate`,'%d/%m/%Y') as 'BirthDate', `Email`, `Mobile`, Table107.`Gender`, `LoginFlag`, `ActiveFlag` 
			FROM `Table107`
			LEFT JOIN Table112 ON Table112.`RelationCode` = Table107.`RelationCode`
			WHERE Table107.`RegCode` = ".$_SESSION['s_id']." AND
			Table107.`FamilyCode` = ".$id."
			ORDER BY `FamilyName` LIMIT 1;";
	//echo $sql;
	if ($result = $mysqli->query($sql)) {
		$family = $result->fetch_assoc();
	}
}

echo json_encode($family);
$mysqli->close();
?>