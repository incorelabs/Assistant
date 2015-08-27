<?php
$connection = mysqli_connect("localhost","root","incorelabs");
	if(!$connection)
	{
		die(mysqli_error($connection));
	}

$db_select = mysqli_select_db($connection,"assistant");
	if(!$db_select)
	{
		die(mysqli_errno($connection));	
	}

?>