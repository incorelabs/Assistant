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
    <title>Assist - Contacts</title>

    <!-- Bootstrap -->
    <?php
    include_once ROOT . 'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="../dist/css/style.css"/>
    <link rel="stylesheet" href="../dist/contacts/css/style.css">
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script>
        var root = "<?php echo ROOT; ?>";
    </script>
    <script src="../dist/script/script.js"></script>
    <script src="../dist/contacts/script/script.js"></script>
    <script src="../dist/contacts/script/validation.js"></script>
    <script src="../dist/date/script.js"></script>

    <!-- Header Links -->
    <link type="text/css" rel="stylesheet" href="../dist/css/sidebar.css"/>
    <link type="text/css" rel="stylesheet" href="../dist/css/jquery_sidebar.css"/>
    <script type="text/javascript" src="../dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
        $(function () {
            $('nav#menu').mmenu();
        });
    </script>
</head>
<body>
<!-- fixed top navbar -->
<?php

define('PAGE_TITLE', 'Contact');
$root_location = ROOT;
include_once ROOT . 'dist/navbar.php';
echo $navbar_str;
?>
<div class="container-fluid navbar-padding">
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

    <div class="row">
        <div class="col-xs-12 col-md-5">
            <div class="list-group list-margin">
                <div class="list-group-item list-margin">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                            <div class="input-group">
                                <input id="searchBox" type="text" class="form-control" placeholder="Search..."
                                       autofocus/>

                                <div class="input-group-btn">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success" onclick="pageContact.doSearch();"
                                                style="border-radius:0px">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="input-group-btn">
                                    <div class="btn-group" role="group">
                                        <div class="dropdown dropdown-lg">
                                            <button type="button" class="btn btn-danger dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false"
                                                    onclick="pageContact.showFilters();"
                                                    style="border-bottom-left-radius: 0px; border-top-left-radius: 0px;"><span
                                                    class="glyphicon glyphicon-filter"></span></button>
                                            <div class="dropdown-menu dropdown-menu-right" role="menu"
                                                 id="search_filter">
                                                <form class="form-horizontal" role="form">
                                                    <div class="form-group">
                                                        <label for="filter">Filter by</label>
                                                        <select class="form-control" id="filter">
                                                            <option value="1">Name</option>
                                                            <option value="2">Mobile</option>
                                                            <option value="3">Email</option>
                                                            <option value="4">Company</option>
                                                            <option value="5">Designation</option>
                                                            <option value="6">Father/Husband</option>
                                                            <option value="7">Birthday</option>
                                                            <option value="8">Anniversary</option>
                                                            <option value="9">Group</option>
                                                            <option value="10">Home Area</option>
                                                            <option value="11">Home City</option>
                                                            <option value="12">Home Phone</option>
                                                            <option value="13">Work Area</option>
                                                            <option value="14">Work City</option>
                                                            <option value="15">Work Phone</option>
                                                            <option value="16">Other Area</option>
                                                            <option value="17">Other City</option>
                                                            <option value="18">Other Phone</option>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <!--<button type="button" class="btn btn-info btn-size"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>-->
                            <button class="btn btn-primary btn-size" onclick="pageContact.openAddContact();"><span
                                    class="glyphicon glyphicon-plus"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-sm-10 hidden-sm hidden-xs">
            <div class="panel panel-default panelHeight list-margin" id="style-3">
                <div id="contactDetailHeader" class="panel-heading text-center">
                    <h12>Contact Details</h12>
                </div>

            </div>
            <!--Panel-->
        </div>
        <!--COL-->
    </div>
    <!--row-->
    <div class="row">

        <div class="col-md-5 col-sm-12 col-xs-12">
            <div class="panel panel-default panelHeight panel-margin" id="style-3">
                <!-- List group -->
                <div id="contactList" class="list-group force-scroll">

                </div>
                <!--List close-->
            </div>
            <!--Panel-->
        </div>
        <!--COL-->

        <div class="col-md-7 col-sm-10 hidden-sm hidden-xs">
            <div id="contactDetail" class="panel panel-default panelHeight panel-margin" id="style-3">
                <!-- List group -->
                <div id="contactDetailBody" class="list-group">
                    <div class="list-group-item">
                        <p class="list-group-item-text">Loading...</p>
                    </div>
                </div>
                <!--List close-->

            </div>
            <!--Panel-->
        </div>
        <!--COL-->
    </div>
    <!--ROW-->
</div>


<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="form-horizontal" method="POST" action="controller.php" id="contactForm" autocomplete="off">

                <div class="modal-header">

                    <div class="form-group pull-left">
                        <button class="btn btn-danger" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>

                        </button>
                    </div>

                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-success button-top-remove">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>

                    <h4 id="contactModalHeading" class="modal-title text-center"></h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="contactCode" id='form-add-edit-code'/>
                    <input type="hidden" name="mode" id="form-add-edit-mode"/>

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
                            <span class="input-group-addon input-group-addon-label">Title*</span>

                            <div class="inner-addon right-addon">
                                <i class="glyphicon glyphicon-star fa-size hidden-xs"></i>
                                <input type="text" name="title" class="form-control text-field-left-border"
                                       id="addTitle" placeholder="Title" autofocus/>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="titleCode" id="titleCode" value="0"/>

                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">First Name*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user fa-size hidden-xs"></i>
                                <input type="text" name="firstName" id="addFirstName"
                                       class="form-control text-field-left-border" placeholder="First Name"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Middle Name</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user fa-size hidden-xs"></i>
                                <input type="text" name="middleName" id="addMiddleName"
                                       class="form-control text-field-left-border" placeholder="Middle Name"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Last Name</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user fa-size hidden-xs"></i>
                                <input type="text" name="lastName" id="addLastName"
                                       class="form-control text-field-left-border" placeholder="Last Name"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Mobile</span>
                            <input type="text" name="mobile1" id="addMobile1"
                                   class="form-control text-field-left-border" placeholder="Mobile"/>
                            <span class="input-group-btn">
                                <button class="btn btn-success button-addon-custom btn-add-mobile" type="button"
                                        onclick="pageContact.addBtn(0)">
                                    <i class="fa fa-plus fa-lg"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class='addMobileDiv'></div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Email</span>
                            <input type="email" name="email1" id="addEmail1"
                                   class="form-control text-field-left-border" placeholder="Email"/>
                            <span class="input-group-btn">
                                <button class="btn btn-success button-addon-custom btn-add-email" type="button"
                                        onclick="pageContact.addBtn(1)">
                                    <i class="fa fa-plus fa-lg"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class='addEmailDiv'></div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label"
                                  style="height:40px;">Default Address</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size hidden-xs"></i>
                                <select class="form-control select-field-left-border">
                                    <option value="1" selected="selected">Home</option>
                                    <option value="2">Work</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin"
                         style="margin-left:0px !important; margin-right:0px !important">
                        <ul class="nav nav-tabs nav-justified" id="myTab">
                            <li><a href="#tab1" data-toggle="tab"><span class='glyphicon glyphicon-user'></span><br>Personal
                                    Details</a></li>
                            <li><a href="#tab3" data-toggle="tab"><span
                                        class='glyphicon glyphicon-briefcase'></span><br>Professional Details</a>
                            </li>
                            <li><a href="#tab4" data-toggle="tab"><span
                                        class='glyphicon glyphicon-globe'></span><br>Social Details</a></li>
                            <li><a href="#home" data-toggle="tab"><span class='glyphicon glyphicon-home'></span><br>Home
                                    Address</a></li>
                            <li><a href="#work" data-toggle="tab"><span
                                        class='glyphicon glyphicon-briefcase'></span><br>Work Address</a></li>
                            <li><a href="#other" data-toggle="tab"><span
                                        class='glyphicon glyphicon-road'></span><br>Other Address</a></li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane" id="tab1">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Guardian</span>

                                    <div class="inner-addon right-addon">
                                        <i class="glyphicon glyphicon-user fa-size"></i>
                                        <input type="text" name="guardianName" id="addGuardianName"
                                               class="form-control text-field-left-border"
                                               placeholder="Father/Husband Name"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Date of Birth</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-birthday-cake fa-size"></i>
                                        <input type="text" name="dob" id="addDOB"
                                               class="form-control date text-field-left-border"
                                               placeholder="Date of Birth"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Anniversary</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-calendar fa-size"></i>
                                        <input type="text" name="dom" id="addDOM"
                                               class="form-control date text-field-left-border"
                                               placeholder="Anniversary Date"/>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="groupCode" id="groupCode" value="0"/>

                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Group</span>

                                    <div class="inner-addon right-addon">
                                        <i class="glyphicon glyphicon-tag fa-size"></i>
                                        <input type="text" name="group" id="addGroup"
                                               class="form-control text-field-left-border" placeholder="Group"/>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="emergencyCode" id="emergencyCode" value="0"/>

                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Emergency</span>

                                    <div class="inner-addon right-addon">
                                        <i class="glyphicon glyphicon-tag fa-size"></i>
                                        <input type="text" name="emergency" id="addEmergency"
                                               class="form-control text-field-left-border"
                                               placeholder="Emergency"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Remarks</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-comment fa-size"></i>
                                        <input type="text" name="remarks" id="addRemarks"
                                               class="form-control text-field-left-border" placeholder="Remarks"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Alias</span>

                                    <div class="inner-addon right-addon">
                                        <i class="glyphicon glyphicon-user fa-size"></i>
                                        <input type="text" name="alias" id="addAlias"
                                               class="form-control text-field-left-border" placeholder="Alias"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Start of Home tab -->
                        <div class="tab-pane" id="home">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 1</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-home fa-size"></i>
                                        <input type="text" name="address[home][address1]" id="homeAddress1"
                                               class="form-control text-field-left-border" placeholder="Address 1"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 2</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-home fa-size"></i>
                                        <input type="text" name="address[home][address2]" id="homeAddress2"
                                               class="form-control text-field-left-border" placeholder="Address 2"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 3</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-home fa-size"></i>
                                        <input type="text" name="address[home][address3]" id="homeAddress3"
                                               class="form-control text-field-left-border" placeholder="Address 3"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 4</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-home fa-size"></i>
                                        <input type="text" name="address[home][address4]" id="homeAddress4"
                                               class="form-control text-field-left-border" placeholder="Address 4"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 5</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-home fa-size"></i>
                                        <input type="text" name="address[home][address5]" id="homeAddress5"
                                               class="form-control text-field-left-border" placeholder="Address 5"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">City</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[home][city]" id="homeCity"
                                               class="form-control text-field-left-border" placeholder="City"/>
                                        <input type="hidden" name="address[home][cityCode]" id="homeCityCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">State</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[home][state]" id="homeState"
                                               class="form-control text-field-left-border" placeholder="State"/>
                                        <input type="hidden" name="address[home][stateCode]" id="homeStateCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Country</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[home][country]" id="homeCountry"
                                               class="countryText form-control text-field-left-border"
                                               placeholder="Country"/>
                                        <input type="hidden" name="address[home][countryCode]" id="homeCountryCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Pincode</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[home][pincode]" id="homePincode"
                                               class="form-control text-field-left-border" placeholder="Pincode"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Area</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[home][area]" id="homeArea"
                                               class="form-control text-field-left-border" placeholder="Area"/>
                                        <input type="hidden" name="address[home][areaCode]" id="homeAreaCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Phone</span>
                                    <input type="text" name="address[home][phone1]" id="homePhone1"
                                           class="form-control text-field-left-border" placeholder="Phone"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-success button-addon-custom btn-home-phone"
                                                type="button" onclick="pageContact.addBtn(2)">
                                            <i class="fa fa-plus fa-lg"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="addHomePhone"></div>
                        </div>


                        <!-- Start of Work Tab -->
                        <div class="tab-pane" id="work">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 1</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-briefcase fa-size"></i>
                                        <input type="text" name="address[work][address1]" id="workAddress1"
                                               class="form-control text-field-left-border" placeholder="Address 1"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 2</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-briefcase fa-size"></i>
                                        <input type="text" name="address[work][address2]" id="workAddress2"
                                               class="form-control text-field-left-border" placeholder="Address 2"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 3</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-briefcase fa-size"></i>
                                        <input type="text" name="address[work][address3]" id="workAddress3"
                                               class="form-control text-field-left-border" placeholder="Address 3"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 4</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-briefcase fa-size"></i>
                                        <input type="text" name="address[work][address4]" id="workAddress4"
                                               class="form-control text-field-left-border" placeholder="Address 4"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 5</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-briefcase fa-size"></i>
                                        <input type="text" name="address[work][address5]" id="workAddress5"
                                               class="form-control text-field-left-border" placeholder="Address 5"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">City</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[work][city]" id="workCity"
                                               class="form-control text-field-left-border" placeholder="City"/>
                                        <input type="hidden" name="address[work][cityCode]" id="workCityCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">State</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[work][state]" id="workState"
                                               class="form-control text-field-left-border" placeholder="State"/>
                                        <input type="hidden" name="address[work][stateCode]" id="workStateCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Country</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[work][country]" id="workCountry"
                                               class="countryText form-control text-field-left-border"
                                               placeholder="Country"/>
                                        <input type="hidden" name="address[work][countryCode]" id="workCountryCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Pincode</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[work][pincode]" id="pincode"
                                               class="form-control text-field-left-border" placeholder="Pincode"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Area</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[work][area]" id="workArea"
                                               class="form-control text-field-left-border" placeholder="Area"/>
                                        <input type="hidden" name="address[work][areaCode]" id="workAreaCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Phone</span>
                                    <input type="text" name="address[work][phone1]" id="workPhone1"
                                           class="form-control text-field-left-border" placeholder="Phone"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-success button-addon-custom btn-work-phone"
                                                type="button" onclick="pageContact.addBtn(3)">
                                            <i class="fa fa-plus fa-lg"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="addWorkPhone"></div>
                        </div>

                        <!-- Start of Others Pane -->
                        <div class="tab-pane" id="other">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 1</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-road fa-size"></i>
                                        <input type="text" name="address[other][address1]" id="otherAddress1"
                                               class="form-control text-field-left-border" placeholder="Address 1"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 2</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-road fa-size"></i>
                                        <input type="text" name="address[other][address2]" id="otherAddress2"
                                               class="form-control text-field-left-border" placeholder="Address 2"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 3</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-road fa-size"></i>
                                        <input type="text" name="address[other][address3]" id="otherAddress3"
                                               class="form-control text-field-left-border" placeholder="Address 3"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 4</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-road fa-size"></i>
                                        <input type="text" name="address[other][address4]" id="otherAddress4"
                                               class="form-control text-field-left-border" placeholder="Address 4"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Address Line 5</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-road fa-size"></i>
                                        <input type="text" name="address[other][address5]" id="otherAddress5"
                                               class="form-control text-field-left-border" placeholder="Address 5"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">City</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[other][city]" id="otherCity"
                                               class="form-control text-field-left-border" placeholder="City"/>
                                        <input type="hidden" name="address[other][cityCode]" id="otherCityCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">State</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[other][state]" id="otherState"
                                               class="form-control text-field-left-border" placeholder="State"/>
                                        <input type="hidden" name="address[other][stateCode]" id="otherStateCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Country</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[other][country]" id="otherCountry"
                                               class="countryText form-control text-field-left-border"
                                               placeholder="Country"/>
                                        <input type="hidden" name="address[other][countryCode]" id="otherCountryCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Pincode</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[other][pincode]" id="otherPincode"
                                               class="form-control text-field-left-border" placeholder="Pincode"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Area</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-globe fa-size"></i>
                                        <input type="text" name="address[other][area]" id="otherArea"
                                               class="form-control text-field-left-border" placeholder="Area"/>
                                        <input type="hidden" name="address[other][areaCode]" id="otherAreaCode"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Phone</span>
                                    <input type="text" name="address[other][phone1]" id="otherPhone1"
                                           class="form-control text-field-left-border" placeholder="Phone"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-success button-addon-custom btn-other-phone"
                                                type="button" onclick="pageContact.addBtn(4)">
                                            <i class="fa fa-plus fa-lg"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="addOtherPhone"></div>
                        </div>

                        <!--Start of Profession Tab-->
                        <div class="tab-pane" id="tab3">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Company</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-building-o fa-size"></i>
                                        <input type="text" name="company" id="addCompany"
                                               class="form-control text-field-left-border" placeholder="Company"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Designation</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-building-o fa-size"></i>
                                        <input type="text" name="designation" id="addDesignation"
                                               class="form-control text-field-left-border"
                                               placeholder="Designation"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Start of Social Tab -->
                        <div class="tab-pane" id="tab4">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Facebook</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-facebook fa-size"></i>
                                        <input type="text" name="facebook" id="addFacebook"
                                               class="form-control text-field-left-border"
                                               placeholder="Facebook ID"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Twitter</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-twitter fa-size"></i>
                                        <input type="text" name="twitter" id="addTwitter"
                                               class="form-control text-field-left-border"
                                               placeholder="Twitter Handle"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Google Plus</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-google-plus fa-size"></i>
                                        <input type="text" name="google" id="addGoogle"
                                               class="form-control text-field-left-border" placeholder="Google ID"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Linkedin</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-linkedin fa-size"></i>
                                        <input type="text" name="linkedin" id="addLinkedin"
                                               class="form-control text-field-left-border"
                                               placeholder="Linkedin ID"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">URL Address</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-link fa-size"></i>
                                        <input type="text" name="website" id="addWebsite"
                                               class="form-control text-field-left-border"
                                               placeholder="URL Address"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->

<!--Delete Contact Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
     aria-hidden="true">
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
                        <form action="controller.php" id="deleteContact" method="POST">
                            <input type="hidden" name="contactCode" id="form-delete-code"/>
                            <input type="hidden" name="mode" id="form-delete-mode" value="D"/>
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
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <form class="form-horizontal" method="POST" action="uploadProfile.php" enctype="multipart/form-data"
                  id="profileForm" runat="server">

                <div class="modal-header">

                    <div class="btn-group pull-left">
                        <button class="btn btn-danger" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>

                        </button>
                    </div>

                    <div class="btn-group pull-right">
                        <button type="submit" class="btn btn-success">
                            <span class='glyphicon glyphicon-ok'></span>

                        </button>
                    </div>

                    <h4 class="modal-title text-center">
                        Edit Image
                    </h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="contactCode" id='photoId'/>

                    <div class="form-group row">
                        <center>
                            <div class="col-sm-12 col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-5">
                                    <label class="control-label">Select Image</label>
                                    <br>
                                    <br>
                                    <input type='file' id="imgInp" name="fileToUpload"
                                           style="padding-bottom:10px;"/>

                                    <p id="imageErrorMsg"></p>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-4">
                                    <label class="control-label">Image Preview</label>
                                    <br>
                                    <br>
                                    <img src="../img/default/contact/profilePicture.png" id="imagepreview"
                                         class="addImage">
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </form>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                     style="width: 0%;">
                    <span class="sr-only" id="progressValue">0% Complete</span>
                </div>
            </div>
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->

</body>
</html>