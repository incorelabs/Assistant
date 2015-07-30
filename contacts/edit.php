<?php
$url = "http://incorelabs.com";
header("Access-Control-Allow-Origin:".$url);
header("Access-Control-Request-Method: GET, POST");
header("Access-Control-Allow-Credentials: true");

define("ROOT", "../");

require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
	
	$date = new DateTime();
	$timestamp = $date->getTimestamp();
	$titleValue = 0;
	$groupValue = 0;
	$sql = "";

	if (isset($_POST['titleId'])) {
		$titleID = intval($_POST['titleId']);
		if ($titleID == -1) {
			$titleValue = $timestamp;

			$sql .= build_insert_str('title',array(
				$timestamp,
				$_POST['title'],
				'1001'
				)).";";
		}
		elseif ($titleID == 0) {
			$titleValue = "titleCode";
		}
		else{
			$titleValue = $titleID;
		}
	}

	if (isset($_POST['groupId'])) {
		$groupId = intval($_POST['groupId']);
		if ($groupId == -1) {
			$groupValue = $timestamp;

			$sql .= build_insert_str(DB_NAME.'.group',array(
				$timestamp,
				$_POST['group'],
				'1001'
			)).";";
		}
		elseif ($groupId == 0) {
			$groupValue = "groupCode";
		}
		else{
			$groupValue = $groupId;
		}
	}

	$data = array(
			"firstName" => $_POST['firstName'],
			"middleName" => $_POST['middleName'],
			"lastName" => $_POST['lastName'],
			"fullName" => $_POST['firstName']." ".$_POST['middleName']." ".$_POST["lastName"],
			"titleCode" => $titleValue,
			"guardianName" => $_POST['guardianName'],
			"company" => $_POST['company'],
			"designation" => $_POST['designation'],
			"alias" => $_POST['alias'],
			"dob" => $_POST['dob'],
			"dom" => $_POST['dom'],
			"groupCode" => $groupValue,
			"remarks" => $_POST['remarks'],
			"activeStatus" => (isset($_POST['activeStatus']) ? 1 : 0),
			"mobile" => $_POST["mobile"],
			"email" => $_POST["email"],
			"facebook" => $_POST["facebook"],
			"twitter" => $_POST["twitter"],
			"google" => $_POST["google"],
			"linkedin" => $_POST["linkedin"],
			"website" => $_POST["website"],
			"privacy" => (isset($_POST['privacy']) ? 1 : 0),
			"lastAccessedDate" => $timestamp
			);

	$sql .= buildUpdateStr("contact",$data,array('contactCode'=>$id));
	//echo $sql;

	if ($mysqli->multi_query($sql)) {
		$response["status"] = 1;
		$response["controller"] = "edit";
		$response["landing"] = $id;

		echo json_encode($response);
		//exit(header("Location:index.php?status=1&controller=edit&landing=".$id));
	}
	else{
		$response["status"] = 1;
		$response["controller"] = "edit";
		$response["landing"] = $id;

		echo json_encode($response);
		//exit(header("Location:index.php?status=0&controller=edit&landing=".$id));
	}
}
?>