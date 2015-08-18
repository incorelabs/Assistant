<?php
	$root_location = "http://localhost/Assist/";
	//$root_location = "http://incorelabs.com/Assistant/";
	
	$navbar_str = "<div id='page'>
	<div class='header'>
		<a href='#menu' class='menu_img'></a>".PAGE_TITLE."
		<p><a href='#' class='logout'><span class='fa fa-power-off fa-lg'></span></a></p>
	</div>
		<nav id='menu'>
		<ul>
			<li>
				<a href='".$root_location."'>Home</a>
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
			<li><a href='#'>Password</a></li>
			<li><a href='#'>Reminder</a></li>
			<li><a href='#'>Consolidate</a></li>
			<li><a href='#mm-8' data-target='#mm-8'>Preferences</a>
				<ul>
					<li><a href='".$root_location."family'>Family</a></li>
					<li><a href='#'>Change Password</a></li>
					<li><a href='#'>Setings</a></li>
					<li><a href='#'>Import Contacts</a></li>
					<li><a href='#'>Synchronize Contacts</a></li>
				</ul>
			</li>
			<li><a href='#' class='logout'>Sign Out</a></li>
		</ul>
	</nav>
</div>";
?>