<?php
	session_start();
	define("ROOT", "");
	
	if (isset($_SESSION['s_id'])) {
		exit(header("Location:index.php"));
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Sign In</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    	include_once ROOT.'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="dist/css/style.css" />
    <link rel="stylesheet" href="dist/homePage/css/style.css" />
	<script>
		var root = "<?php echo ROOT; ?>";
	</script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script src="dist/script/script.js"></script>
    <script src="dist/homePage/script/script.js"></script>
    <link rel="stylesheet" href="dist/css/sidebar.css" />
    <link rel="stylesheet" href="dist/css/jquery_sidebar.css" />
    <script src="dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
		$(function() {
			$('nav#menu').mmenu();
		});
	</script>
  </head>

<body>
<?php
    include_once ROOT.'dist/navbar_logout.php';
	$root_location = ROOT;
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
        	<div class="inner"> 	
        		<div class="panel panel-border panel-background">
               		<div class="panel-heading panel-header-height">
                		<h1 class="panel-title text-center" style="font-size: 24px;">Sign In</h1>
               		</div>
               		<form action="api/login.php" method="POST" id="form-login">
               			<div class="panel-body">
							<div class="form-group">
								<div class="inner-addon left-addon">
								    <i class="fa fa-user" style="font-size: 20px;"></i>
									<input type="email" class="form-control textbox_height" name="email" placeholder="Email" autofocus="true" required/>
								</div>
							</div>
							<div class="form-group">
								<div class="inner-addon left-addon">
								    <i class="fa fa-key" style="font-size: 20px;"></i>
									<input type="password" class="form-control textbox_height" name="password" placeholder="Password" required/>
								</div>
							</div>
						</div>
						<div class="panel-footer panel-footer-height">
							<div class="form-group">
								<button type="submit" class="btn btn-primary form-control">Sign In</button>
							</div>
							<div class="form-group clearfix clearfix-margin">
								<div class="pull-left">
									<i class="fa fa-key" style="margin-left: 3px;"></i>&nbsp;&nbsp;<a href="forgot/">Forgot Password</a>
								</div>
								<div class="pull-right">
									<i class="fa fa-pencil"></i>&nbsp;&nbsp;<a href="register.php">Sign Up</a>
								</div>
							</div>
						</div><!--Footer-->
               		</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
