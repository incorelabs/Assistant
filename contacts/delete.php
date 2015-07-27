<?php
define("ROOT", "../");

require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';
$mysqli = getConnection();

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
	$sql = buildDeleteStr("contact",array('contactCode'=>$id));
	//echo $sql;

	$id--;
	if ($mysqli->multi_query($sql)) {
		exit(header("Location:index.php?status=1&controller=delete&landing=".$id));
	}
	else{
		exit(header("Location:index.php?status=0&controller=delete&landing=".$id));
	}
}
?>