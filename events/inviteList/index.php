<?php
session_start();
define("ROOT", "../../");
include_once ROOT . 'dist/authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Events</title>
    <?php
    include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/events/inviteList/css/style.css"/>
</head>
<body>
<?php
define('PAGE_TITLE', 'Events');
$root_location = ROOT;
include_once ROOT . 'dist/navbar.php';
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
        <div class="col-xs-12 col-md-12 id="searchEventsHeader">
            <div class="list-group list-margin">
                <div class="list-group-item list-margin">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="col-md-3">
                            <span class="multiselect-label">Select State</span>
                            </div>
                            <div class="col-md-9 col-padding">
                                <div class="multiselect" id="countries" multiple="multiple" data-target="multi-0">
                                    <div class="title noselect">
                                        <span class="text">State</span>
                                        <span class="close-icon">&times;</span>
                                        <span class="expand-icon">&plus;</span>
                                    </div>
                                    <div class="multicontainer">
                                        <option value='Andaman and Nicobar Islands'>Andaman and Nicobar</option>
                                        <option value='Andhra Pradesh'>Andhra Pradesh</option>
                                        <option value='Arunachal Pradesh'>Arunachal Pradesh</option>
                                        <option value='Assam'>Assam</option>
                                        <option value='Bihar'>Bihar</option>
                                        <option value='Chandigarh'>Chandigarh</option>
                                        <option value='Chhattisgarh'>Chhattisgarh</option>
                                        <option value='Dadra and Nagar Haveli'>Dadra and Nagar Haveli</option>
                                        <option value='Daman and Diu'>Daman and Diu</option>
                                        <option value='Delhi'>Delhi</option>
                                        <option value='Goa'>Goa</option>
                                        <option value='Gujarat'>Gujarat</option>
                                        <option value='Haryana'>Haryana</option>
                                        <option value='Himachal Pradesh'>Himachal Pradesh</option>
                                        <option value='Jammu and Kashmir'>Jammu and Kashmir</option>
                                        <option value='Jharkhand'>Jharkhand</option>
                                        <option value='Karnataka'>Karnataka</option>
                                        <option value='Kerala'>Kerala</option>
                                        <option value='Lakshadweep'>Lakshadweep</option>
                                        <option value='Madhya Pradesh'>Madhya Pradesh</option>
                                        <option value='Maharashtra'>Maharashtra</option>
                                        <option value='Manipur'>Manipur</option>
                                        <option value='Meghalaya'>Meghalaya</option>
                                        <option value='Mizoram'>Mizoram</option>
                                        <option value='Nagaland'>Nagaland</option>
                                        <option value='Odisha'>Odisha</option>
                                        <option value='Puducherry'>Puducherry</option>
                                        <option value='Punjab'>Punjab</option>
                                        <option value='Rajasthan'>Rajasthan</option>
                                        <option value='Sikkim'>Sikkim</option>
                                        <option value='Tamil Nadu'>Tamil Nadu</option>
                                        <option value='Telengana'>Telengana</option>
                                        <option value='Tripura'>Tripura</option>
                                        <option value='Uttar Pradesh'>Uttar Pradesh</option>
                                        <option value='Uttarakhand'>Uttarakhand</option>
                                        <option value='West Bengal'>West Bengal</option>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-top-padding">
                            <div class="col-md-3">
                                <span class="multiselect-label">Select City</span>
                            </div>
                            <div class="col-md-9 col-padding">
                                <div class="multiselect" id="state" multiple="multiple" data-target="multi-0">
                                    <div class="title noselect">
                                        <span class="text">City</span>
                                        <span class="close-icon">&times;</span>
                                        <span class="expand-icon">&plus;</span>
                                    </div>
                                    <div class="multicontainer">
                                        <option value="us">USA</option>
                                        <option value="fr">France</option>
                                        <option value="gr">Greece</option>
                                        <option value="uk">United Kingdom</option>
                                        <option value="ge">Germany</option>
                                        <option value="sp">Spain</option>
                                        <option value="it">Italy</option>
                                        <option value="ch">China</option>
                                        <option value="jp">Japan</option>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-top-padding">
                            <div class="col-md-3">
                                <span class="multiselect-label">Select Group</span>
                            </div>
                            <div class="col-md-9 col-padding">
                            <div class="multiselect" id="group" multiple="multiple" data-target="multi-0">
                                <div class="title noselect">
                                    <span class="text">Group</span>
                                    <span class="close-icon">&times;</span>
                                    <span class="expand-icon">&plus;</span>
                                </div>
                                <div class="multicontainer">
                                    <option value="us">USA</option>
                                    <option value="fr">France</option>
                                    <option value="gr">Greece</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="ge">Germany</option>
                                    <option value="sp">Spain</option>
                                    <option value="it">Italy</option>
                                    <option value="ch">China</option>
                                    <option value="jp">Japan</option>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-top-padding">
                            <div class="col-md-3">
                                <span class="multiselect-label">Invited</span>
                            </div>
                            <div class="col-md-9 col-padding">
                                <select class="form-control selectbox-height">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--row-->
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12" id="eventsListDiv">
            <div class="panel panel-default panelHeight panel-margin" id="eventsListScroll">
                <div class="panel-height">
                    <!-- List group -->
                    <div id="eventsList" class="list-group force-scroll mobile-list">
                    </div>
                    <!--List close-->
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->
    </div>
    <!--ROW-->
</div>
<!--Container-->

<!-- Add Events Modal -->
<div class="modal fade" id="eventsModal" tabindex="-1" role="dialog" aria-labelledby="eventsModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="eventsForm" autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left" style="margin-top:-5px">
                        <a class="btn btn-danger button-top-remove" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </a>
                    </div>
                    <div class="form-group pull-right" style="margin-top:-5px">
                        <button type="submit" class="btn btn-success button-top-remove">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 id="eventsModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" class="hidden" name="eventsTypeCode" id="eventsTypeCode" value="1"/>
                    <input type="text" class="hidden" name="eventsCode" id="form-add-edit-code"/>
                    <input type="text" class="hidden" name="mode" id="form-add-edit-mode"/>


                    <div class="form-group form-group-margin">
                        <label class="col-xs-3 control-label">Private</label>

                        <div class="col-xs-3">
                            <div class='switch switch-padding'>
                                <input type='checkbox' name='private' id='addPrivacy' class='switch-input'>
                                <label for='addPrivacy' class='switch-label'></label>
                            </div>
                        </div>
                        <label class="col-xs-3 control-label">Active</label>

                        <div class="col-xs-3">
                            <div class='switch switch-padding'>
                                <input type='checkbox' name='active' id='addActiveStatus' class='switch-input'
                                       checked='checked'>
                                <label for='addActiveStatus' class='switch-label'></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Event Name*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="eventName"
                                       id="eventName" placeholder="Name" tabindex="1" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Date*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="eventDate"
                                       id="eventDate" placeholder="dd/mm/yyyy" tabindex="2" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Sub Events*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="subEvents" name="subEvents"
                                       placeholder="Sub Events" aria-describedby="basic-addon1" tabindex="3" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Body -->
            </form>
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->

<!--Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Event?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteEventsForm">
                            <input type="text" class="hidden" name="eventCode" id="form-delete-code"/>
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
<script src="../../dist/events/inviteList/script/script.js"></script>
<script>
    var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
</script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>