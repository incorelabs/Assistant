<?php
	//$root_location = "http://localhost/Assistant/";
	//$root_location = "http://43.225.52.206/~chetansanghvi/";
	
	$navbar_str = "<div id='page'>
	<div class='header' style='text-decoration:none;font-weight:200;font-size:20px'>
		<a href='#' id='backButton' class='pull-left hidden' style='margin-left: -35px;'><i class='fa fa-chevron-left fa-lg'></i></a>
		<a href='#menu' class='menu_img'></a>".PAGE_TITLE."
		<p><a href='#' class='logout'><span class='fa fa-power-off fa-lg'></span></a></p>
	</div>
		<nav id='menu'>
		<ul>
			<li>
				<a href='".$root_location."'>Dashboard</a>
			</li>
			<li><a href='#mm-2' data-target='#mm-2'>Contacts</a>
				<ul>
					<li><a href='".$root_location."contacts'>Contact Details</a></li>
					<li><a href='#'>Events</a></li><li><a href='#'>Event Allocation</a></li>
					<li><a href='#'>Labels</a></li>
					<li><a href='#'>Address Diary</a></li>
					<li><a href='#'>Telephone Index</a></li>
					<li><a href='#'>Birthday List</a></li>
					<li><a href='#'>Anniversary List</a></li>
					<li><a href='#'>Event Status</a></li>
				</ul>
			</li>
			<li><a href='#mm-3' data-target='#mm-3'>Investments</a>
				<ul>
					<li><a href='#'>Investment Details</a></li>
					<li><a href='#'>Investment Status</a></li>
				</ul>
			</li>
			<li><a href='#mm-4' data-target='#mm-4'>Assets</a>
				<ul>
					<li><a href='#'>Assets Details</a></li>
					<li><a href='#'>Assets Status</a></li>
				</ul>
			</li>
			<li><a href='#mm-5' data-target='#mm-5'>Documents</a>
				<ul>
					<li><a href='#'>Document Details</a></li>
					<li><a href='#'>Document Status</a></li>
				</ul>
			</li>
			<li><a href='#mm-6' data-target='#mm-6'>Expense</a>
				<ul>
					<li><a href='#'>Expense Details</a></li>
					<li><a href='#'>Expense Status</a></li>
				</ul>
			</li>
			<li><a href='#mm-7' data-target='#mm-7'>Income</a>
				<ul>
					<li><a href='#'>Income Details</a></li>
					<li><a href='#'>Income Status</a></li>
				</ul>
			</li>
			<li><a href='".$root_location."passwords'>Password</a></li>
			<li><a href='#'>Reminder</a></li>
			<li><a href='#'>Consolidate</a></li>
			<li><a href='#mm-8' data-target='#mm-8'>Preferences</a>
				<ul>
					<li><a href='".$root_location."family'>Family</a></li>
					<li><a href='".$root_location."preferences/changePassword.php'>Change Password</a></li>
					<li><a href='#'>Import Contacts</a></li>
					<li><a href='#'>General Settings</a></li>
					<li><a href='".$root_location."preferences/labelSettings/'>Label Settings</a></li>
					<li><a href='".$root_location."preferences/chequeSettings/'>Cheque Settings</a></li>
					<li><a href='".$root_location."preferences/envelopeSettings/'>Envelope Settings</a></li>
				</ul>
			</li>
			<li><a href='#' class='logout'>Sign Out</a></li>
		</ul>
	</nav>
</div>";
?>