<?php
session_start();
define("ROOT", "../");
include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
$mysqli = getConnection();

$relation = array();

if (isset($_GET['list'])) {
	$sql = "SELECT `RelationCode`, `RelationName`, `Gender`
			FROM `Table112`
			ORDER BY `RelationName`;";
	//echo $sql;
	if ($result = $mysqli->query($sql)) {
		$i = 0;
		while ($row = $result->fetch_assoc()) {
			$relation[$i] = $row;
			$i++;
		}
	}
}

echo json_encode($relation);
$mysqli->close();
?>