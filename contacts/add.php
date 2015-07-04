<?php
define("ROOT", "../");

require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

if (isset($_POST['id'])) {
	$date = new DateTime();
	$timestamp = $date->getTimestamp();
	$sql = "";

	if (isset($_POST['title']) && strlen($_POST['title']) > 0) {
		$sql = build_insert_str('title',array(
			$timestamp,
			$_POST['title'],
			'1001'
			)).";";
	}
	
	
	if (isset($_POST['group']) && strlen($_POST['group']) > 0) {
		$sql .= build_insert_str(DB_NAME.'.group',array(
		$timestamp,
		$_POST['group'],
		'1001'
		)).";";
	}
	

	$sql .= build_insert_str('contact',array(
		1001,
		$_POST['id'],
		$_POST['firstName'],
		$_POST['middleName'],
		$_POST['lastName'],
		$_POST['firstName']." ".$_POST['middleName']." ".$_POST['lastName'],
		$timestamp,
		$_POST['guardianName'],
		$_POST['company'],
		$_POST['designation'],
		$_POST['alias'],
		$_POST['dob'],
		$_POST['dom'],
		$timestamp,
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
		exit(header("Location:index.php?status=1&controller=add"));
	}
	else{
		exit(header("Location:index.php?status=0&controller=add"));
	}

}
?>