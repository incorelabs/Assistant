<?php
session_start();
define("ROOT", "../");
//require_once ROOT.'db/Connection.php';

//$mysqli = getConnection();
include_once ROOT.'dist/authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Change Password</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    	include_once ROOT.'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="../dist/css/style.css" />
    <link rel="stylesheet" href="../dist/preferences/css/style.css" />
	<script>
		var root = "<?php echo ROOT; ?>";
	</script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script src="../dist/script/script.js"></script>
    <script src="../dist/preferences/script/script.js"></script>
    <link rel="stylesheet" href="../dist/css/sidebar.css" />
    <link rel="stylesheet" href="../dist/css/jquery_sidebar.css" />
    <script src="../dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
		$(function() {
			$('nav#menu').mmenu();
		});
	</script>
  </head>

<body>
<?php
	define('PAGE_TITLE', 'Change Password');
	$root_location = ROOT;
    include_once ROOT.'dist/navbar.php';
    echo $navbar_str;
?> 
	<div class="notification_outer">
	  <div class="notification_success" id="notification_success" style="display:none">
	    Added Successfully!
	  </div>
	</div>

	<div class="notification_outer">
	  <div class="notification_failure" id="notification_failure" style="display:none">
	    Something went wrong!
	  </div>
	</div>	
    <div class="outer">
        <div class="middle">
        	<div class="inner panel-top-padding"> 	
        		<div class="panel panel-border panel-background">
               		<div class="panel-heading panel-header-height">
                		<h1 class="panel-title text-center" style="font-size: 24px;font-weight:100">Change Password</h1>
               		</div>
               		<form action="passwordController.php" method="POST" id="change-password">
               			<div class="panel-body">
							<div class="form-group">
								<div class="inner-addon left-addon">
								    <i class="fa fa-key" style="font-size: 20px;"></i>
									<input type="password" class="form-control textbox-height" name="oldPassword" placeholder="Current Password" autofocus="true" required/>
									<div class="info"></div>
								</div>
							</div>
							<hr/>
							<div class="form-group">
								<div class="inner-addon left-addon">
								    <i class="fa fa-key" style="font-size: 20px;"></i>
									<input type="password" class="form-control textbox-height password" name="password" placeholder="New Password" required/>
									<div class="info"></div>
								</div>
							</div>
							<div class="form-group" style="margin-bottom:0px">
								<div class="inner-addon left-addon">
								    <i class="fa fa-key" style="font-size: 20px;"></i>
									<input type="password" class="form-control textbox-height c_password" name="confirmPassword" placeholder="Confirm New Password" required/>
									<div class="info"></div>
								</div>
							</div>
						</div>
						<div class="panel-footer panel-footer-height">
							<div class="form-group" style="padding-top:10px">
								<button type="submit" class="btn btn-primary form-control">Change Password</button>
							</div>
						</div><!--Footer-->
               		</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
