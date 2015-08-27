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
    <title>Assistant - Password</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    	include_once ROOT.'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="../dist/css/style.css" />
    <link rel="stylesheet" href="../dist/passwords/css/style.css" />
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script>
	var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
	</script>
	<script src="../dist/script/script.js"></script>
    <script src="../dist/passwords/script/script.js"></script>
    <link rel="stylesheet" href="../dist/css/sidebar.css" />
    <link rel="stylesheet" href="../dist/css/jquery_sidebar.css" />
    <script src="../dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
		$(function() {
			$('nav#menu').mmenu();
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
		  $("#showPassword").click(function() {
		    if ($("#password").attr("type") == "password") {
		      $("#password").attr("type", "text");

		    } else {
		      $("#password").attr("type", "password");
		    }
		  });
		  $("#showOtherPassword").click(function() {
		    if ($("#otherPassword").attr("type") == "password") {
		      $("#otherPassword").attr("type", "text");

		    } else {
		      $("#otherPassword").attr("type", "password");
		    }
		  });
		var originalPassword = $(".textShow").html();
		var encryptedPassword = originalPassword.replace(/./gi, "*");  // replace each character by an *
		$(".textShow").text(encryptedPassword);
		$("#passwordEncrypt").click(function () {
            $(".textShow").text(function(original, encrypted){
               return encrypted == originalPassword ? encryptedPassword : originalPassword
            })
        });
        $("#notification_test").click(function(){
        	document.getElementById("notification_success").style.display = "block";
        	$("#notification_success").delay(2000).fadeOut("slow");
        });
        console.log(familyCode);
	});
	</script>
  </head>

<body>
	<?php
		define('PAGE_TITLE', 'Passwords');
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
	<div class="container-fluid navbar-padding">
	  <div class="row">
	    <div class="col-xs-12 col-md-5" style="padding-right:0px">
	      <div class="list-group list-margin">
	        <div class="list-group-item list-margin">
	          <div class="row">
	             <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
	              <div class="">
	              <input id="searchContact" type="text" class="form-control" placeholder="Search..." autofocus />
	              </div>
	            </div>
	            <div>
	                <button class="btn btn-primary btn-size" onclick="openAddModal();" ><span class="glyphicon glyphicon-plus"></span></button>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  
	    <div class="col-md-7 col-sm-10 hidden-sm hidden-xs">
	      <div class="panel panel-default scroll list-margin" id="style-3">
	        <div id="passwordDetailHeader" class="panel-heading text-center" >
	          
	        </div>
	           
	      </div><!--Panel-->
	    </div><!--COL-->
	  </div><!--row-->
	<div class="row">

	  <div class="col-md-5 col-sm-12 col-xs-12" style="padding-right:0px">
	    <div class="panel panel-default scroll panel-margin" id="style-3">
	    	<div class="panel-height">
	         <!-- List group -->
	          <div id="passwordsList" class="list-group force-scroll">
	              
	          </div><!--List close-->
	      </div>
	    </div><!--Panel-->
	  </div><!--COL-->

	  <div class="col-md-7 col-sm-10 hidden-sm hidden-xs">
	    <div id="password-Detail" class="panel panel-default scroll panel-margin" id="style-3">
			
	    </div><!--Panel-->
	  </div><!--COL-->
	</div><!--ROW-->
  </div><!--Container-->

  <!-- Add Password Modal -->
	<div class="modal fade" id="addPassword" tabindex="-1" role="dialog" aria-labelledby="addPassword" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" method="POST" action="controller.php" id="form-passwords" autocomplete="off">
				<div class="modal-header">
					<div class="form-group pull-left" style="margin-top:-5px">
						<button class="btn btn-danger button-top-remove" data-dismiss="modal">
							<span class='glyphicon glyphicon-remove'></span>
						</button>
					</div>
					<div class="form-group pull-right" style="margin-top:-5px">
						<button type="submit" class="btn btn-success button-top-remove">
							<span class='glyphicon glyphicon-ok'></span>
						</button>
					</div>
					<h4 id="modalHeading" class="modal-title text-center">
					</h4>   
				</div>
				<div class="modal-body">
					<input type="hidden" name="passwordTypeCode" id="passwordTypeCode" value="0" />
					<input type="hidden" name="mode" id="input-type" />
					<input type="hidden" name="passwordCode" id="passwordCode" value="1" />
					<div class="form-group form-group-margin">
		              <label class="col-xs-3 control-label">Private</label>
		                <div class="col-xs-3">
		                  <div class='switch switch-padding'>
		                  <input type='checkbox' name='private' id='addPrivacy' class='switch-input' >
		                  <label for='addPrivacy' class='switch-label'></label>
		                </div>
		                </div>
		              <label class="col-xs-3 control-label">Active</label>
		              <div class="col-xs-3">
		                <div class='switch switch-padding'>
		                  <input type='checkbox' name='active' id='addActiveStatus' class='switch-input' checked='checked'>
		                  <label for='addActiveStatus' class='switch-label'></label>
		                </div>
		              </div>
		            </div>
					<div class="form-group form-group-margin">
						<div class="input-group">
							<span class="input-group-addon input-group-addon-label">Holder's Name*</span>
							<div class="inner-addon right-addon">
							    <i class="fa fa-caret-down fa-size"></i>
					  			<select class="form-control select-field-left-border" id="holderName" name="name">
					  				<option>Select Holder Name</option>
					  			</select>
				  			</div>
						</div>
					</div>
					<div class="form-group form-group-margin">
						<div class="input-group">
						    <span class="input-group-addon input-group-addon-label">Password Type*</span>
						    <div class="inner-addon right-addon">
							    <i class="fa fa-key hidden-xs fa-size"></i>
						  		<input type="text" class="form-control text-field-left-border" id="passwordType" name="passwordType" placeholder="Password Type"/>
							</div>
						</div>
					</div>
					<div class="form-group form-group-margin">
						<div class="input-group">
							<span class="input-group-addon input-group-addon-label">Description*</span>
							<div class="inner-addon right-addon">
							    <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
								<input type="text" class="form-control text-field-left-border" name="description" id="description" placeholder="Description"/>
							</div>
						</div>
					</div>
					<div class="form-group form-group-margin">
						<div class="input-group">
						  <span class="input-group-addon input-group-addon-label">Login ID*</span>
						  <div class="inner-addon right-addon">
							    <i class="fa fa-user hidden-xs fa-size"></i>
						  		<input type="text" class="form-control text-field-left-border" id="userID" name="userID" placeholder="Login ID" aria-describedby="basic-addon1"/>
						  </div>
						</div>
					</div>
					<div class="form-group form-group-margin">
						<div class="input-group">
						  <span class="input-group-btn"><span class="input-group-addon group-addon-text-custom input-group-addon-label">Password*</span></span>
						  <input type="password" class="form-control text-field-left-border" name="password" id="password" placeholder="Password"/>
						  <span class="input-group-btn"><button class="btn btn-primary button-addon-custom" type="button" id="showPassword"><i class="fa fa-eye fa-lg"></i></button></span>
						</div>
					</div>
					<div class="form-group form-group-margin">
						<div class="input-group">
						  <span class="input-group-btn"><span class="input-group-addon group-addon-text-custom input-group-addon-label">Other Password</span></span>
						  <input type="password" class="form-control text-field-left-border" name="password1" id="otherPassword" placeholder="Other Password (Optional)"/>
						  <span class="input-group-btn"><button class="btn btn-primary button-addon-custom" type="button" id="showOtherPassword"><i class="fa fa-eye fa-lg"></i></button></span>
						</div>
					</div>
				</div> <!-- Modal Body --> 
				</form>
			</div><!--modal-content-->
		</div>
	</div><!--modal-->

	<!--Delete Contact Modal-->
	<div class="modal fade" id="deletePassword" tabindex="-1" role="dialog" aria-labelledby="deletePassword" aria-hidden="true">
		<div class="modal-dialog">
		  <div class="modal-content">
		    <div class="modal-header">
		      <h4 class="modal-title text-center">
		          Are you sure, you want to DELETE this Password?
		      </h4>   
		    </div>
		    <br>
		    <center>
		      <div class="modal-body">
		      <div class="btn-group">
		        <form method="POST" action="controller.php" id="form-password-delete" >
		          <input type="hidden" name="passwordCode" id="form-delete-code" />
		          <input type="hidden" name="mode" id="form-delete-mode" value="D" />
		          <button class="btn btn-danger modal_button" type="submit">
		            <span class='glyphicon glyphicon-ok'></span>&nbsp
		            Yes
		          </button>
		        </form>
		          
		        </div>
		        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		        <div class="btn-group">
		          <button class="btn btn-success modal_button" data-dismiss="modal">
		            <span class='glyphicon glyphicon-remove'></span>&nbsp
		            No
		          </button>
		        </div>
		        <br>
		        <br>
		      </div>
		    </center>
		  </div><!--modal-content-->
		</div>
	</div><!--modal-->
</body>
</html>
