<?php
$url = "http://incorelabs.com";
header("Access-Control-Allow-Origin:".$url);
header("Access-Control-Request-Method: GET, POST");
header("Access-Control-Allow-Credentials: true");

define("ROOT", "../");

require_once ROOT.'db/Connection.php';
$mysqli = getConnection();

if (isset($_GET['type'])) {
	$data = array();
	$i = 0;
	//title
	if ($_GET['type'] == 'title') {
		$sql = "SELECT * FROM title ORDER BY description";
		if ($result = $mysqli->query($sql)) {
		  while ($row = $result->fetch_assoc()) {
		  	$data[$i] = $row;
		  	$i++;	 
		  }
		}
	}

	//group
	if ($_GET['type'] == 'group') {
		$sql = "SELECT * FROM ".DB_NAME.".group ORDER BY description";
		if ($result = $mysqli->query($sql)) {
		  while ($row = $result->fetch_assoc()) {
		  	$data[$i] = $row;
		  	$i++;	 
		  }
		}
	}

	echo json_encode($data);
}
?>