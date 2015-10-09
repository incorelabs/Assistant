<?php
session_start();
define("ROOT", "../");
include_once ROOT . 'dist/authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Family</title>
    <?php
        include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../dist/family/css/style.css"/>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Family');
$root_location = ROOT;
include_once ROOT . 'dist/navbar.php';
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
        <button class="btn btn-primary" id="btnAddFamilyMember" onclick="pageFamily.openAddFamilyModal();">
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
<div class="modal fade" id="familyModal" tabindex="-1" role="dialog" aria-labelledby="familyModal" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="familyForm" autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left" style="padding-left:15px">
                        <a class="btn btn-danger button-top-remove" data-dismiss="modal" tabindex="11">
                            <span class='glyphicon glyphicon-remove'></span>
                        </a>
                    </div>
                    <div class="form-group pull-right" style="padding-right:15px">
                        <button type="submit" class="btn btn-success button-top-remove" tabindex="10">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 id="familyModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <input type="text" class="hidden" name="familyCode" id="form-add-edit-code"/>
                <input type="text" class="hidden" name="mode" id="form-add-edit-mode"/>

                <div class="modal-body">
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Name*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user fa-size hidden-xs"></i>
                                <input type="text" name="name" id="firstName"
                                       class="form-control name text-field-left-border" placeholder="Name"
                                       tabindex="1" required/>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Relation*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size hidden-xs"></i>
                                <select name="relation" class="form-control textbox_height select-field-left-border"
                                        id="relation" tabindex="2" required>
                                </select>
                                <input type="text" class="hidden" name="" id="relationTextBox" />
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Date of Birth*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar fa-size hidden-xs"></i>
                                <input type="text" name="dob" id="dob" class="form-control date text-field-left-border"
                                       placeholder="Date of Birth" tabindex="3" required/>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Mobile</span>

                            <div class="inner-addon right-addon">
                                <i class="glyphicon glyphicon-phone fa-size hidden-xs"></i>
                                <input type="text" name="mobile" id="mobile" class="form-control text-field-left-border"
                                       placeholder="Mobile" tabindex="4"/>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Gender*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-lg fa-size hidden-xs" style="right:12px"></i>
                                <select name="gender" id='gender' class="form-control select-field-left-border"
                                        tabindex="5" required>
                                    <option value="">Select a Gender</option>
                                    <option value="2">Female</option>
                                    <option value="1">Male</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin hidden" id="provideLoginDiv">
                        <label class="col-xs-4 control-label">Provide Login</label>

                        <div class="col-xs-7">
                            <div class="radio">
                                <div class="col-xs-4">
                                    <label>
                                        <input type="radio" name="access" id="chkboxYes" value="1" tabindex="6"
                                               onclick="pageFamily.showLoginAccess();">Yes</input>
                                    </label>
                                </div>
                                <div class="col-xs-4">
                                    <label>
                                        <input type="radio" name="access" id="chkboxNo" checked="checked" value="2"
                                               tabindex="6" onclick="pageFamily.hideLoginAccess();">No</input>
                                    </label>
                                </div>
                            </div>
                            <div class='info'></div>
                        </div>
                    </div>
                    <div class="hidden" id="loginAccess">
                        <hr/>
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Email*</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-envelope-o fa-size hidden-xs"></i>
                                    <input type="email" name="email" id="email"
                                           class="form-control email text-field-left-border" placeholder="Email"
                                           tabindex="7"/>
                                </div>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="form-group form-group-margin" id="passwordDiv">
                        </div>
                        <div class="form-group form-group-margin" id="confirmPasswordDiv">

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Delete Contact Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true"
     data-backdrop="static">
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
                        <form method="POST" action="controller.php" id="deleteFamilyForm">
                            <input type="text" class="hidden" name="familyCode" id="form-delete-code"/>
                            <input type="text" class="hidden" name="mode" id="form-delete-mode" value="D"/>
                            <button class="btn btn-danger modal_button" type="submit">
                                <span class='glyphicon glyphicon-ok'></span>&nbsp
                                Yes
                            </button>
                        </form>

                    </div>
                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <div class="btn-group">
                        <a class="btn btn-success modal_button" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>&nbsp
                            No
                        </a>
                    </div>
                    <br>
                    <br>
                </div>
            </center>
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->

<?php
    include_once ROOT.'dist/fetchJS.php';
?>
<script src="../dist/family/script/script.js"></script>
<script src="../dist/date/script.js"></script>
<script>
    var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
</script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>