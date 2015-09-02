<?php
$url = "http://incorelabs.com";
header("Access-Control-Allow-Origin:".$url);
header("Access-Control-Request-Method: GET, POST");
header("Access-Control-Allow-Credentials: true");

define("ROOT", "../");

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
		$data = createDataAPI("title","description");
	}

	//group
	if ($_GET['type'] == 'group') {
		$data = createDataAPI(DB_NAME.".group","description");
	}

	//country
	if ($_GET['type'] == 'country') {
		$data = createDataAPI("country","description");
	}

	//state
	if ($_GET['type'] == 'state') {
		$data = createDataAPI("state", "description");
	}

	//city
	if ($_GET['type'] == 'city') {
		$data = createDataAPI("city","description");
	}

	//area
	if ($_GET['type'] == 'area') {
		$data = createDataAPI("area","description");
	}

	echo json_encode($data);
	$mysqli->close();
}
?>