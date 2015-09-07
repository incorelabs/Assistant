<?php
session_start();
define("ROOT", "../");

include_once ROOT.'dist/authenticate.php';
require_once ROOT.'db/Connection.php';
$mysqli = getConnection();

function createDataAPI($tableName, $orderColumn){
	global $mysqli;
	$i = 0;
	$data = array();
	$sql = "SELECT * FROM ".$tableName." ORDER BY ".$orderColumn;
	if ($result = $mysqli->query($sql)) {
	  while ($row = $result->fetch_assoc()) {
	  	$data[$i] = $row;
	  	$i++;	 
	  }
	}
	return $data;
}

if (isset($_GET['type'])) {
	$data = array();
	$i = 0;
	//title
	if ($_GET['type'] == 'title') {
		$data = createDataAPI("Table114","TitleName");
	}

	//group
	if ($_GET['type'] == 'group') {
		$data = createDataAPI("Table126","GroupName");
	}

	//group
	if ($_GET['type'] == 'emergency') {
		$data = createDataAPI("Table128","EmergencyName");
	}

	//country
	if ($_GET['type'] == 'country') {
		$data = createDataAPI("Table106","CountryName");
	}

	//state
	if ($_GET['type'] == 'state') {
		$data = createDataAPI("Table108", "StateName");
	}

	//city
	if ($_GET['type'] == 'city') {
		$data = createDataAPI("Table110","CityName");
	}

	//area
	if ($_GET['type'] == 'area') {
		$data = createDataAPI("Table119","AreaName");
	}

	echo json_encode($data);
	$mysqli->close();
}
?>