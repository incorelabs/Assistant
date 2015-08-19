<?php
session_start();
define("ROOT", "../../");

include_once ROOT.'dist/authenticate.php';
$response = array();

if (isset($_POST['familyCode'])) {
	require_once ROOT.'db/Connection.php';
	require_once ROOT.'modules/functions.php';
	$mysqli = getConnection();

	$regCode = $_SESSION['s_id'];
	$_POST = safeStringForSQL($_POST);

	$sql = build_insert_str('Table107',$_POST);

	if ($mysqli->query($sql) === TRUE) {
		$response["status"] = 1;
		$response["message"] = "Success";
	}
	else{
		$response["status"] = 0;
		$response["message"] = "Error occured while uploading to the database: ".$mysqli->error;
	}
}
else{
	$response["status"] = 0;
	$response["message"] = "Invalid";
}
echo json_encode($response);
?>
