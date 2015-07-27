<?php
define("ROOT", "../");

require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();


if (isset($_POST['id'])) {
	$date = new DateTime();
	$timestamp = $date->getTimestamp();
	$titleCode = 0;
	$groupCode = 0;
	$sql = "";

	//Title ID manipulations
	if (isset($_POST['titleId'])) {
		if (intval($_POST['titleId']) > 0) {
			$titleCode = $_POST['titleId'];
		}
		elseif (isset($_POST['title']) && strlen($_POST['title']) > 0) {
			$sql = build_insert_str('title',array(
				$timestamp,
				$_POST['title'],
				'1001'
				)).";";
			$titleCode = $timestamp;
		}
	}
		
	
	//Group ID manipulation
	if (isset($_POST["groupId"])) {
		if (intval($_POST['groupId']) > 0) {
			$groupCode = $_POST['group'];
		}
		elseif (isset($_POST['group']) && strlen($_POST['group']) > 0) {
			$sql .= build_insert_str(DB_NAME.'.group',array(
			$timestamp,
			$_POST['group'],
			'1001'
			)).";";

			$groupCode =  $timestamp;
		}
	}


	$sql .= build_insert_str('contact',array(
		1001,
		$_POST['id'],
		$_POST['firstName'],
		$_POST['middleName'],
		$_POST['lastName'],
		$_POST['firstName']." ".$_POST['middleName']." ".$_POST['lastName'],
		$titleCode,
		$_POST['guardianName'],
		$_POST['company'],
		$_POST['designation'],
		$_POST['alias'],
		$_POST['dob'],
		$_POST['dom'],
		$groupCode,
		null,
		$_POST['remarks'],
		(isset($_POST['activeStatus']) ? 1 : 0),
		$_POST['mobile'],
		$_POST['email'],
		$_POST['facebook'],
		$_POST['twitter'],
		$_POST['google'],
		$_POST['linkedin'],
		$_POST['website'],
		null,
		null,
		null,
		1001,
		(isset($_POST['privacy']) ? 1 : 0),
		$timestamp
		)).";";


	
	//echo $sql;

	if ($mysqli->multi_query($sql)) {
		exit(header("Location:index.php?status=1&controller=add&landing=".$_POST['id']));
	}
	else{
		exit(header("Location:index.php?status=0&controller=add&landing=".$_POST['id']));
	}

}
?>