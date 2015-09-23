<?php
	//$root_location = "http://localhost/Assistant/";
	//$root_location = "http://43.225.52.206/~chetansanghvi/";
	
	$navbar_str = "<div id='page'>
	<div class='header' style='text-decoration:none;font-weight:200;font-size:20px'>
		<a href='#' id='backButton' class='pull-left hidden' style='margin-left: -35px;'><i class='fa fa-chevron-left fa-lg'></i></a>
		<a href='#menu' class='menu_img'></a>".PAGE_TITLE."
    <div class='dropdown' style='float:right; right:-25px'>
    <a class='dropdown-toggle' data-toggle='dropdown'>
    <span class='fa fa-user fa-lg'></span><i class='fa fa-caret-down'></i></a>
    <ul class='dropdown-menu'>
      <li><a href='#' class='text-center' onclick='pageIndex.openProfilePictureModal()'><img class='img-rounded' width='100px' height='100px' id='navbarProfilePicture'/></a></li>
      <li><a href='#' style='pointer-events: none; cursor: default;'>".$_SESSION['name']."</a></li>
      <li class='divider'></li>
      <li><a href='#'>Account Info</a></li>
      <li><a href='#' class='logout'>Sign Out</a></li>
    </ul>
    </div>
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
					<li><a href='".$root_location."expense'>Expense Details</a></li>
					<li><a href='#'>Expense Status</a></li>
				</ul>
			</li>
			<li><a href='#mm-7' data-target='#mm-7'>Income</a>
				<ul>
					<li><a href='".$root_location."income'>Income Details</a></li>
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
</div>

<!-- Image Modal -->
<div class='modal fade' id='profilePictureModal' tabindex='-1' role='dialog' aria-labelledby='profilePictureModal' aria-hidden='true'
     data-backdrop='static'>
    <div class='modal-dialog modal-md'>
        <div class='modal-content'>

            <form class='form-horizontal' method='POST' action='upload.php' enctype='multipart/form-data' id='profilePictureForm'
                  runat='server'>

                <div class='modal-header'>

                    <div class='btn-group pull-left'>
                        <button class='btn btn-danger' data-dismiss='modal'>
                            <span class='glyphicon glyphicon-remove'></span>

                        </button>
                    </div>

                    <div class='btn-group pull-right'>
                        <button type='submit' class='btn btn-success'>
                            <span class='glyphicon glyphicon-ok'></span>

                        </button>
                    </div>

                    <h4 class='modal-title text-center'>
                        Edit Image
                    </h4>
                </div>

                <div class='modal-body'>
                    <input type='text' class='hidden' name='labelCode' id='photoId'/>

                    <div class='form-group row'>
                        <center>
                            <div class='col-sm-12 col-md-12'>
                                <div class='col-lg-6 col-md-6 col-sm-5'>
                                    <label class='control-label'>Select Image</label>
                                    <br>
                                    <br>
                                    <input type='file' id='profileImgInput' name='ProfileFileToUpload'
                                           style='padding-bottom:10px;' required/>

                                    <p id='imageErrorMsg' class='info'></p>

                                    <div class='delete-btn-padding'>
                                        <button type='button' class='btn btn-danger' id='deleteProfileImageBtn'>
                                            Delete Image
                                        </button>
                                    </div>
                                </div>
                                <div class='col-lg-6 col-md-6 col-sm-4'>
                                    <label class='control-label'>Image Preview</label>
                                    <br>
                                    <br>
                                    <img id='profileImagePreview'
                                         class='addImage'>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </form>
            <div class='progress'>
                <div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'
                     style='width: 0%;'>
                    <span class='sr-only' id='progressValue'>0% Complete</span>
                </div>
            </div>
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->
";
?>