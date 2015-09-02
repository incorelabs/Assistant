<?php
session_start();
define("ROOT", "../");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Family</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    include_once ROOT.'dist/authenticate.php';
    include_once ROOT.'dist/bootstrap.php';
    ?>

    <link rel="stylesheet" href="../dist/family/css/style.css" />
    <link rel="stylesheet" href="../dist/css/style.css" />
    <script src="http://malsup.github.com/jquery.form.js"></script>

    <!-- Header Links -->
    <link type="text/css" rel="stylesheet" href="../dist/css/sidebar.css" />
    <link type="text/css" rel="stylesheet" href="../dist/css/jquery_sidebar.css" />
    <script type="text/javascript" src="../dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
        var root = "<?php echo ROOT; ?>";
        $(function() {
            $('nav#menu').mmenu();
        });
    </script>
    <script src="../dist/script/script.js"></script>
    <script src="../dist/date/script.js"></script>
    <script src="../dist/family/script/script.js"></script>
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
                if ($("#confirmPassword").attr("type") == "password") {
                    $("#confirmPassword").attr("type", "text");

                } else {
                    $("#confirmPassword").attr("type", "password");
                }
            });
        });
    </script>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Family');
$root_location = ROOT;
include_once ROOT.'dist/navbar.php';
echo $navbar_str;
?>
<div class="container">
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
    <div class="text-right button-top-margin">
        <button class="btn btn-primary" id="btn-addFamily" >
            <i class="fa fa-plus fa-lg"></i>
        </button>
    </div>
    <div class="text-center">
        <table class="table table-top-margin borderless">
            <thead>
            <tr class="text-left">
                <th class="text-left">#</th>
                <th class="text-left">Name</th>
                <th class="hidden-xs hidden-sm text-left">Relation</th>
                <th class="hidden-xs hidden-sm text-left">D.O.B</th>
                <th class="hidden-xs hidden-sm text-left">Email</th>
                <th class="text-left">Mobile</th>
                <th class="text-left hidden-sm hidden-xs text-left">Gender</th>
                <th class="text-left">Login</th>
                <th class="text-left">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">

            </tbody>
        </table>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addFamily" tabindex="-1" role="dialog" aria-labelledby="addFamily" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="form-family" autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left" style="padding-left:15px">
                        <button class="btn btn-danger button-top-remove" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </button>
                    </div>
                    <div class="form-group pull-right" style="padding-right:15px">
                        <button type="submit" class="btn btn-success button-top-remove">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 id="familyModalHeading" class="modal-title text-center">
                        Add Family
                    </h4>
                </div>
                <input type="hidden" id="familyCode" name="familyCode" value="1" />
                <input type="hidden" id="mode" name="mode" />
                <div class="modal-body">
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Name*</span>
                            <div class="inner-addon right-addon">
                                <i class="fa fa-user fa-size hidden-xs"></i>
                                <input type="text" name="name" id="firstName" class="form-control name text-field-left-border" placeholder="Name"/>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Relation*</span>
                            <div class="inner-addon right-addon">
                                <i class="fa fa-star fa-size hidden-xs"></i>
                                <select name="relation" class="form-control textbox_height text-field-left-border" id="relation">
                                </select>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Date of Birth*</span>
                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar fa-size hidden-xs"></i>
                                <input type="text" name="dob" id="dob" class="form-control date text-field-left-border" placeholder="Date of Birth"/>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Mobile</span>
                            <div class="inner-addon right-addon">
                                <i class="glyphicon glyphicon-phone fa-size hidden-xs"></i>
                                <input type="text" name="mobile" id="mobile" class="form-control text-field-left-border" placeholder="Mobile" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Gender*</span>
                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-lg fa-size hidden-xs" style="right:12px"></i>
                                <select name="gender" id='gender' class="form-control select-field-left-border">
                                    <option value="">Select a Gender</option>
                                    <option value="2">Female</option>
                                    <option value="1">Male</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin" id="provideLoginDiv">
                        <label class="col-xs-4 control-label">Provide Login</label>
                        <div class="col-xs-7">
                            <div class="radio">
                                <div class="col-xs-4">
                                    <label>
                                        <input type="radio" name="access" id="yes" value="1">Yes</input>
                                    </label>
                                </div>
                                <div class="col-xs-4">
                                    <label>
                                        <input type="radio" name="access" id="no"  checked="checked" value="2">No</input>
                                    </label>
                                </div>
                            </div>
                            <div class='info'></div>
                        </div>
                    </div>
                    <div id="loginAccess" style="display:none">
                        <hr/>
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Email*</span>
                                <div class="inner-addon right-addon">
                                    <i class="fa fa-envelope-o fa-size hidden-xs"></i>
                                    <input type="email" name="email" id="email" class="form-control email text-field-left-border" placeholder="Email" />
                                </div>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Password*</span>
                                <input type="password" name="password" id="password" class="form-control password text-field-left-border" placeholder="Password" />
                                <span class="input-group-btn"><button class="btn btn-primary button-addon-custom" type="button" id="showPassword"><i class="fa fa-eye fa-lg"></i></button></span>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Confirm*</span>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control c_password text-field-left-border" placeholder="Confirm Password" />
                                <span class="input-group-btn"><button class="btn btn-primary button-addon-custom" type="button" id="showOtherPassword"><i class="fa fa-eye fa-lg"></i></button></span>
                            </div>
                            <div class='info'></div>
                        </div>
                    </div>
                </div>
        </div> <!-- Modal Body -->
    </div>
    </form>
</div><!--modal-content-->
</div>
</div><!--modal-->
<!--Delete Contact Modal-->
<div class="modal fade" id="deleteFamily" tabindex="-1" role="dialog" aria-labelledby="deleteFamily" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Contact?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="form-family-delete" >
                            <input type="hidden" name="familyCode" id="deleteFamilyCode" />
                            <input type="hidden" name="mode" id="form-delete-mode" />
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