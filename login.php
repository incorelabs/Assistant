<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assist</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="dist/homePage/style.css" />
    <!--Adding jquery file-->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="dist/homePage/script.js"></script>
  </head>

<body>	
    <div class="outer">
        <div class="middle">
        	<div class="inner"> 	
        		<div class="panel panel-primary">
               		<div class="panel-heading panel-header-height">
                		<h1 class="panel-title text-center" style="font-size: 24px;">Login</h1>
               		</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="inner-addon left-addon">
							    <i class="fa fa-user" style="font-size: 20px;"></i>
								<input type="text" class="form-control textbox_height" placeholder="Username" autofocus="true" />
							</div>
						</div>
						<div class="form-group">
							<div class="inner-addon left-addon">
							    <i class="fa fa-key" style="font-size: 20px;"></i>
								<input type="password" class="form-control textbox_height" placeholder="Password" />
							</div>
						</div>
					</div>
					<div class="panel-footer panel-footer-height">
						<div class="form-group">
							<button type="button" class="btn btn-primary form-control">Sign In</button>
						</div>
						<div class="form-group clearfix clearfix-margin">
							<div class="pull-left">
								<i class="fa fa-key" style="margin-left: 3px;"></i>&nbsp;&nbsp;<a href="#">Forgot Password</a>
							</div>
							<div class="pull-right">
								<i class="fa fa-pencil"></i>&nbsp;&nbsp;<a href="register.php">Sign Up</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
