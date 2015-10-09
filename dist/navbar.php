<?php
	$navbar_str = "<div id='page'>
	<div class='header' style='text-decoration:none;font-weight:200;font-size:20px'>
		<a href='#' id='backButton' class='pull-left hidden' style='margin-left: -60px;'><i class='fa fa-chevron-left fa-lg'></i></a>
		<a href='#menu' class='menu_img'></a>".PAGE_TITLE."
    <div class='dropdown' style='float:right; right:-25px'>
    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
    <span class='fa fa-user fa-lg'></span><i class='fa fa-caret-down'></i></a>
    <ul class='dropdown-menu dropdown-menu-custom'>
      <li><a href='#' class='text-center' onclick='app.openAccountProfilePictureModal()'><img class='img-rounded' width='100px' height='100px' id='navbarProfilePicture'/></a></li>
      <li><a href='#' style='pointer-events: none; cursor: default;'>".$_SESSION['name']."</a></li>
      <li class='divider'></li>
      <li><a href='#'>Account Info</a></li>
      <li><a href='#' onclick='app.logout();'>Sign Out</a></li>
    </ul>
    </div>
	</div>
		<nav id='menu'>
		<ul>
			<li>
				<a href='".$root_location."'>Dashboard</a>
			</li>
			<li><a href='".$root_location."contacts'>Contacts</a></li>
			<li><a href='#'>Investment</a></li>
			<li><a href='".$root_location."assets'>Assets</a></li>
			<li><a href='#'>Documents</a></li>
			<li><a href='".$root_location."expense'>Expense</a></li>
			<li><a href='".$root_location."income'>Income</a></li>
			<li><a href='".$root_location."passwords'>Passwords</a></li>
			<li><a href='".$root_location."events'>Events</a></li>
			<!--<li><a href='#'>Reminders</a></li>-->
			<li><a href='#mm-2' data-target='#mm-2'>Reports</a>
			    <ul>
			        <li><a href='#'>Labels</a></li>
					<li><a href='#'>Address Diary</a></li>
					<li><a href='#'>Telephone Index</a></li>
					<li><a href='#'>Birthday List</a></li>
					<li><a href='#'>Anniversary List</a></li>
					<li><a href='#'>Investment Status</a></li>
					<li><a href='#'>Assets Status</a></li>
					<li><a href='#'>Document Status</a></li>
					<li><a href='#'>Expense Status</a></li>
					<li><a href='#'>Income Status</a></li>
					<li><a href='#'>Consolidate</a></li>
			    </ul>
			</li>
			<li><a href='#mm-3' data-target='#mm-3'>Preferences</a>
				<ul>
					<li><a href='".$root_location."family'>Family</a></li>
					<li><a href='".$root_location."preferences/changePassword.php'>Change Password</a></li>
					<li><a href='".$root_location."preferences/importContacts/'>Import Contacts</a></li>
					<li><a href='".$root_location."preferences/generalSettings/'>General Settings</a></li>
					<li><a href='".$root_location."preferences/labelSettings/'>Label Settings</a></li>
					<li><a href='".$root_location."preferences/chequeSettings/'>Cheque Settings</a></li>
					<li><a href='".$root_location."preferences/envelopeSettings/'>Envelope Settings</a></li>
				</ul>
			</li>
			<li><a href='#' onclick='app.logout();' >Sign Out</a></li>
		</ul>
	</nav>
</div>

<!-- Image Modal -->
<div class='modal fade' id='accountProfilePictureModal' tabindex='-1' role='dialog' aria-labelledby='accountProfilePictureModal' aria-hidden='true'
     data-backdrop='static'>
    <div class='modal-dialog modal-md'>
        <div class='modal-content'>

            <form class='form-horizontal' method='POST' action='upload.php' enctype='multipart/form-data' id='accountProfilePictureForm'
                  runat='server'>

                <div class='modal-header'>

                    <div class='btn-group pull-left'>
                        <a class='btn btn-danger' data-dismiss='modal'>
                            <span class='glyphicon glyphicon-remove'></span>

                        </a>
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
                    <input type='text' class='hidden' name='labelCode' id='accountPhotoId'/>

                    <div class='form-group row account-img-modal'>
                        <center>
                            <div class='col-sm-12 col-md-12'>
                                <div class='col-lg-6 col-md-6 col-sm-5'>
                                    <label class='control-label'>Select Image</label>
                                    <br>
                                    <br>
                                    <div class='input-group'>
                                        <input id='accountImgInputPath' name='accountImgInputPath' class='form-control' placeholder='Choose File' disabled='disabled' />
                                        <div class='input-group-btn'>
                                            <div class='fileUpload btn btn-primary'>
                                                <span>Upload</span>
                                                <input type='file' id='accountProfileImgInput' name='ProfileFileToUpload' class='upload' style='padding-bottom:10px;' required />
                                            </div>
                                        </div>
                                    </div>
                                    <p id='accountProfileImageErrorMsg' class='info'></p>

                                    <div class='delete-btn-padding'>
                                        <button type='button' class='btn btn-danger' id='accountProfileDeleteImageBtn'>
                                            Delete Image
                                        </button>
                                    </div>
                                </div>
                                <div class='col-lg-6 col-md-6 col-sm-4'>
                                    <label class='control-label'>Image Preview</label>
                                    <br>
                                    <br>
                                    <img id='accountProfileImagePreview' class='addImage'>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </form>
            <div class='progress' id='navbarProgress'>
                <div class='progress-bar' id='navbarProgressBar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'
                     style='width: 0%;'>
                    <span class='sr-only' id='navbarProgressValue'>0% Complete</span>
                </div>
            </div>
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->
";
?>