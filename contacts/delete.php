<?php
define("ROOT", "../");

require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();
$response = array();

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
	$landing = 0;
	$prev = 0;
	$sql = "SELECT contactCode FROM contact ORDER BY fullName;";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows == 0) {
		  $landing = 0;
		}
		else{
			while($row = $result->fetch_assoc()){
				if (intval($row['contactCode']) == $id) {
					$landing = $prev;
					break;
				}
				$prev = intval($row['contactCode']);
			}
		}
	}

	$sql = buildDeleteStr("contact",array('contactCode'=>intval($id)));
	$sql .= buildDeleteStr("address",array('contactCode'=>intval($id)));

	if ($mysqli->multi_query($sql) === TRUE) {
		$response["status"] = 1;
		$response["controller"] = "delete";
		$response["landing"] = $landing;
		$response["message"] = "Contact deleted successfully";
	}
	else{
		$response["status"] = 0;
		$response["controller"] = "delete";
		$response["landing"] = $id;
		$response["message"] = "Error occured while deleting the contact: ".$mysqli->error;
	}

	
	echo json_encode($response);

	$mysqli->close();
}
?>