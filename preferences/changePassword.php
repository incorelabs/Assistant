<?php
session_start();
define("ROOT", "../");
//require_once ROOT.'db/Connection.php';

//$mysqli = getConnection();

if (!isset($_SESSION['s_id'])) {
	header('Location:'.ROOT.'index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Family</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php 
    	include_once ROOT.'dist/bootstrap.php';
    ?>
    
	<link rel="stylesheet" href="../dist/css/style.css" />
    <script src="http://malsup.github.com/jquery.form.js"></script>
    
    <!-- Header Links -->
	<link type="text/css" rel="stylesheet" href="../dist/css/sidebar.css" />
	<link type="text/css" rel="stylesheet" href="../dist/css/jquery_sidebar.css" />
	<script type="text/javascript" src="../dist/script/jquery.mmenu.min.all.js"></script>
	<script type="text/javascript">
		$(function() {
			$('nav#menu').mmenu();
		});
	</script>
	<script src="../dist/script/script.js"></script>
	<script src="../dist/date/script.js"></script>
    <script src="../dist/family/script/script.js"></script>
    </head>
  <body>
    <!-- fixed top navbar -->
  <?php
  	define('PAGE_TITLE', 'Change Password');
    include_once ROOT.'dist/navbar.php';
    echo $navbar_str;
  ?>   
  <div class="container">
  	<form>
  		<div class="panel panel-danger" style="max-width:500px;margin:100px auto;">
  			<div class="panel-heading text-center">
  				<label>Change Password</label>
  			</div>
  			<div class="panel-body">
  				<div class="form-group">
					<div class="inner-addon right-addon">
					    <i class="fa fa-key" style="font-size: 20px;"></i>
						<input type="password" class="form-control password" name="password" id="password" placeholder="Current Password" style="height:40px" />
					</div>
					<div class="info"></div>
				</div>
				<div class="form-group">
					<div class="inner-addon right-addon">
					    <i class="fa fa-key" style="font-size: 20px;"></i>
						<input type="password" class="form-control password" name="newPassword" id="password" placeholder="New Password" style="height:40px" />
					</div>
					<div class="info"></div>
				</div>
				<div class="form-group">
					<div class="inner-addon right-addon">
					    <i class="fa fa-key" style="font-size: 20px;"></i>
						<input type="password" class="form-control c_password" name="confirmNewPassword" id="confirmNewPassword" placeholder="Confirm New Password" style="height:40px" />
					</div>
					<div class="info"></div>
				</div>
  			</div>
  			<div class="panel-footer text-center">
  				<button type="submit" class="btn btn-danger" id="changePwd">Change Password</button>
  			</div>
  		</div>
  	</form>
  </div>
</body>
</html>