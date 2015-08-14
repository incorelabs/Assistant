<?php
session_start();
define("ROOT", "../");

if (!isset($_SESSION['s_id'])) {
	header('HTTP/1.1 401 Unauthorized');
	exit();
}
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

echo json_encode($family);
$mysqli->close();
?>