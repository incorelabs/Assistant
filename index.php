<?php
	session_start();
	define("ROOT", "");

	$str = "";
	if (isset($_SESSION['s_id'])) {
		$str .= "Hi ".$_SESSION['name']." <br />";
		$str .= "Email : ".$_SESSION['email']."<br />";
		$str .= "<a href='#' id='logout'>Logout</a>";
	}
	else{
		$str .=  "<a href='login.php' onclick=''>Login</a>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php
    	include_once ROOT.'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="dist/css/style.css" />
    <link rel="stylesheet" href="dist/homePage/style.css" />
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script src="dist/script/script.js"></script>
    <script src="dist/homePage/script.js"></script>
</head>
<body>
	<?php 
		echo $str;
	?>
</body>
</html>