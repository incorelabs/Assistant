<?php
	define("ROOT", "");
	require_once ROOT.'db/Connection.php';
 	require_once ROOT.'modules/functions.php';
	
	$mysqli = getConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Sign Up</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    	include_once ROOT.'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="dist/css/style.css" />
	<link rel="stylesheet" href="dist/homePage/css/style.css" />
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script src="dist/date/script.js"></script>
	<script src="dist/script/script.js"></script>
    <script src="dist/homePage/script/script.js"></script>
</head>

<body>
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
        		<div class="panel panel-primary">    			
               		<div class="panel-heading panel-header-height">
                		<h1 class="panel-title text-center" style="font-size: 24px;">Sign Up</h1>
               		</div>
               		<form action="api/signup.php" method="POST" id="form-signup">
						<div class="panel-body">
							<div class="form-group">
								<div class="inner-addon right-addon">
								    <i class="fa fa-user" style="font-size: 20px;"></i>
									<input type="text" class="form-control textbox_height email" name="email" id="email" placeholder="Email ID" />
								</div>
								<div class="info"></div>
							</div>
							<div class="form-group">
								<div class="inner-addon right-addon">
								    <i class="fa fa-key" style="font-size: 20px;"></i>
									<input type="password" class="form-control textbox_height password" name="password" id="password" placeholder="Password" />
								</div>
								<div class="info"></div>
							</div>
							<div class="form-group">
								<div class="inner-addon right-addon">
								    <i class="fa fa-key" style="font-size: 20px;"></i>
									<input type="password" class="form-control textbox_height c_password" name="c_password" id="c_password" placeholder="Confirm Password" />
								</div>
								<div class="info"></div>
							</div>
							<hr />
							<div class="form-group">
								<div class="inner-addon right-addon">
								    <i class="fa fa-user" style="font-size: 20px;"></i>
									<input type="text" class="form-control textbox_height name" name="name" id="name" placeholder="Name" />
								</div>
								<div class="info"></div>
							</div>
							<div class="form-group">
							        <div class="inner-addon right-addon">
							        <i class="fa fa-globe" style="font-size: 20px;"></i>
							            <select name="country" id="country" class="form-control textbox_height">
							                <option value="">Select Country</option>
							                <!--<option value="1046">India</option>-->
							                <?php 
							                	$sql = "SELECT CountryCode, CountryName FROM Table106 ORDER BY CountryName;";
							                	if ($result = $mysqli->query($sql)) {
							                		while ($row = $result->fetch_assoc()) {
							                			echo "<option value='".$row['CountryCode']."'>".$row['CountryName']."</option>";
							                		}
							                	}
							                ?>
							            </select>
							            <div class="info"></div>
							        </div>
							    </div>
							<div class="form-group">
								
								<div class="inner-addon right-addon">
								    <i class="glyphicon glyphicon-phone" style="font-size: 20px;"></i>
									<input type="text" class="form-control textbox_height mobile" id="mobile" name="mobile" placeholder="Mobile" />
									<div class="info"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="inner-addon right-addon">
								    <i class="fa fa-calendar" style="font-size: 20px;"></i>
									<input type="" class="form-control textbox_height date" name="dob" id="dob" placeholder="Date of Birth" />
									<div class="info"></div>
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<div class="form-group" style="padding-top: 10px;">
								<button type="submit" class="btn btn-primary form-control" id="register">Register</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>
