<?php
	session_start();
	define("ROOT", "");

	$str = "";
	if (isset($_SESSION['s_id'])) {
		include_once ROOT.'dist/navbar.php';
		$str .= $navbar_str."<div class='pull-right' style='padding-top:60px; padding-right:10%;'>
							<button class='btn btn-danger'>
								<a href='#' id='logout'>Logout</a>
							</button>
						</div>
				<div class='container' style='padding-top:100px'>
						<div class='col-lg-6 col-md-12'>
						<div class='panel panel-primary'>
							<div class='panel-heading'>Shortcuts</div>
							<div class='panel-body'>
								<div class='col-md-4'>
									<div class='panel panel-default'>
										<div class='panel-heading'>
											<a href='contacts/'>Contacts</a>
											<span class='badge pull-right'>102</span>
										</div>
										<div class='panel-body'>
											<div class='text-center'>
												<a href='contacts/'>
													<span class='glyphicon glyphicon-user' style='font-size:50px'></span>
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class='col-md-4'>
									<div class='panel panel-default'>
										<div class='panel-heading'>
											<a href='contacts/'>Family</a>
											<span class='badge pull-right'>3</span>
										</div>
										<div class='panel-body'>
											<div class='text-center'>
												<a href='family/'>
													<span class='glyphicon glyphicon-home' style='font-size:50px'></span>
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class='col-md-4'>
									<div class='panel panel-default'>
										<div class='panel-heading'>
											<a href='contacts/'>Investments</a>
											<span class='badge pull-right'>41</span>
										</div>
										<div class='panel-body'>
											<div class='text-center'>
												<a href='#/'>
													<span class='glyphicon glyphicon-briefcase' style='font-size:50px'></span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='col-lg-6 col-md-12'>
						<div class='panel panel-danger'>
							<div class='panel-heading'>Upcoming Events</div>
							<!-- Table -->
								<table class='table'>
									<thead>
										<tr>
											<th>#</th>
											<th>Event</th>
											<th>Date</th>
											<th>Desc</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><i class='fa fa-birthday-cake'></i></td>
											<td>Birthday</td>
											<td>23/03/2015</td>
											<td>My Bday</td>
										</tr>
										<tr>
											<td><i class='fa fa-birthday-cake'></i></td>
											<td>Marriage</td>
											<td>07/12/2015</td>
											<td>Vishal's Marriage</td>
										</tr>
										<tr>
											<td><i class='fa fa-envelope-o'></i></td>
											<td>Meeting&nbsp;<span class='badge badge-red'>!</span></td>
											<td>01/12/2015</td>
											<td>Client Meeting</td>
										</tr>
										<tr>
											<td><i class='fa fa-envelope-o'></i></td>
											<td>Meeting&nbsp;<span class='badge badge-green'>!</span></td>
											<td>15/12/2015</td>
											<td>Client Meeting</td>
										</tr>
									</tbody>
								</table>
						</div>
					</div>
						<div class='col-lg-6 col-md-12'>
						<div class='panel panel-success'>
							<div class='panel-heading'>Reminders</div>
							<!-- Table -->
								<table class='table'>
									<thead>
										<tr>
											<th>#</th>
											<th>Event</th>
											<th>Date</th>
											<th>Name</th>
											<th class='hidden-sm hidden-xs'>Desc</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><i class='fa fa-calendar'></i></td>
											<td>Airtel Bill</td>
											<td>23/03/2015</td>
											<td>Darshan</td>
											<td class='hidden-sm hidden-xs'>Phone</td>
											<td>254 Rs</td>
										</tr>
										<tr>
											<td><i class='fa fa-plane'></i></td>
											<td>Goa Flight</td>
											<td>28/12/2015</td>
											<td>Kamlesh</td>
											<td class='hidden-sm hidden-xs'>New Year</td>
											<td>5000 Rs</td>
										</tr>
										<tr>
											<td><i class='fa fa-calendar'></i></td>
											<td>Client Bill</td>
											<td>23/10/2015</td>
											<td>ABC</td>
											<td class='hidden-sm hidden-xs'>Settlement</td>
											<td>25400 Rs</td>
										</tr>
										<tr>
											<td><i class='fa fa-calendar'></i></td>
											<td>Airtel Bill</td>
											<td>23/03/2015</td>
											<td>Darshan</td>
											<td class='hidden-sm '>Phone</td>
											<td>254 Rs</td>
										</tr>
									</tbody>
								</table>
						</div>
					</div>
						<div class='col-lg-6 col-md-12'>
						<div class='panel panel-warning'>
							<div class='panel-heading'>Upcoming Events</div>
							<!-- Table -->
								<table class='table'>
									<thead>
										<tr>
											<th>#</th>
											<th>Event</th>
											<th>Date</th>
											<th>Desc</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><i class='fa fa-birthday-cake'></i></td>
											<td>Birthday</td>
											<td>23/03/2015</td>
											<td>My Bday</td>
										</tr>
										<tr>
											<td><i class='fa fa-birthday-cake'></i></td>
											<td>Marriage</td>
											<td>07/12/2015</td>
											<td>Vishal's Marriage</td>
										</tr>
										<tr>
											<td><i class='fa fa-envelope-o'></i></td>
											<td>Meeting&nbsp;<span class='badge badge-red'>!</span></td>
											<td>01/12/2015</td>
											<td>Client Meeting</td>
										</tr>
										<tr>
											<td><i class='fa fa-envelope-o'></i></td>
											<td>Meeting&nbsp;<span class='badge badge-green'>!</span></td>
											<td>15/12/2015</td>
											<td>Client Meeting</td>
										</tr>
									</tbody>
								</table>
						</div>
					</div>
				</div>";
						
		//$str .= "<label style='padding:150px'>Hi ".$_SESSION['name']." <br />";
		//$str .= "Email : ".$_SESSION['email']."<br />";
		//$str .= "<a href='".ROOT."contacts/'>Contacts</a><br>";
		//$str .= "<a href='".ROOT."family/'>Family</a><br>";
		//$str .= "<a href='#' id='logout'>Logout</a>";
	}
	else{
		$str .=  "<div class='text-center' style='margin-top:300px'><a href='login.php' onclick=''><button class='btn btn-success btn-lg'>Login</button></a></div>";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title></title>
	<?php
    	include_once ROOT.'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="dist/css/style.css" />
    <link rel="stylesheet" href="dist/homePage/css/style.css" />
    <link rel="stylesheet" href="dist/css/sidebar.css" />
    <link rel="stylesheet" href="dist/css/jquery_sidebar.css" />
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script src="dist/script/script.js"></script>
    <script src="dist/homePage/script/script.js"></script>
    <script src="dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
		$(function() {
			$('nav#menu').mmenu();
		});
	</script>
</head>
<body>
	<?php 
		echo $str;
	?>
</body>
</html>