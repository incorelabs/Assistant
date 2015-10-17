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
    <title>Assistant - Events</title>
    <?php
    include_once ROOT . 'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../dist/events/css/style.css"/>
    <link rel="stylesheet" href="../dist/multiselect/css/bootstrap-multiselect.css"/>
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
        <div class="col-xs-12 col-md-5 col-padding" id="searchEventHeader">
            <div class="list-group list-margin">
                <div class="list-group-item list-margin">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                            <div class="input-group">
                                <input id="searchBox" type="text" class="form-control" placeholder="Search..."
                                       autofocus/>

                                <div class="input-group-btn">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success"
                                                onclick="">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-size"
                                    onclick="pageEvent.openAddEventModal()"><span
                                    class="glyphicon glyphicon-plus"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-xs-12 col-sm-12 hidden-sm hidden-xs" id="eventDetailsHeaderDiv">
            <div class="panel panel-default panelHeight list-margin">
                <div class="panel-heading text-center" id="eventDetailHeader">
                    <h12>Event Details</h12>
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->
    </div>
    <!--row-->
    <div class="row">

        <div class="col-md-5 col-sm-12 col-xs-12 col-padding" id="eventListDiv">
            <div class="panel panel-default panelHeight panel-margin" id="eventListScroll">
                <div class="panel-height">
                    <!-- List group -->
                    <div id="assetsList" class="list-group force-scroll mobile-list">
                        <a href="#" class="list-group-item contacts_font"
                           onclick="pageEvent.openEventInviteListModal()">Test to open invite modal</a>
                    </div>
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->

        <div class="col-md-7 col-sm-12 col-xs-12 hidden-sm hidden-xs" id="eventDetailDiv">
            <div id="eventDetail" class="panel panel-default panelHeight panel-margin">
                <div class='panel-height'>
                    <!-- List group -->
                    <div class="list-group list-group-remove-margin">
                        <div id="eventDetailBody" class='list-group-item list-group-item-border'>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Event Name</div>
                                    <value>
                                        <div class="col-md-9">Incore Labs Success Party</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">From Date</div>
                                    <value>
                                        <div class="col-md-9">07/10/2015</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">To Date</div>
                                    <value>
                                        <div class="col-md-9">10/10/2015</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Sub Event</div>
                                    <value>
                                        <div class="col-md-9">
                                            Sub Event Name 1
                                            <br>Venue
                                            <br>Date & Time
                                        </div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Sub Event</div>
                                    <value>
                                        <div class="col-md-9">
                                            Sub Event Name 2
                                            <br>Venue
                                            <br>Date & Time
                                        </div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Invitees</div>
                                    <value>
                                        <div class="col-md-9">
                                            <button class="btn btn-primary"
                                                    onclick="pageEvent.openEventInviteListModal()"><i
                                                    class="fa fa-sticky-note-o"></i></button>
                                        </div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Assign Tasks</div>
                                    <value>
                                        <div class="col-md-9">
                                            <button class="btn btn-primary" onclick="pageEvent.openAssignTaskPage()">
                                                <i
                                                    class="fa fa-sticky-note-o"></i></button>
                                        </div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Guest Confirmation</div>
                                    <value>
                                        <div class="col-md-9">
                                            <button class="btn btn-primary"
                                                    onclick="pageEvent.openGuestConfirmationPage()"><i
                                                    class="fa fa-sticky-note-o"></i></button>

                                        </div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Accommodation</div>
                                    <value>
                                        <div class="col-md-9">
                                            <button class="btn btn-primary" onclick="pageEvent.openAccommodationPage()">
                                                <i
                                                    class="fa fa-sticky-note-o"></i></button>

                                        </div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Room Allocation</div>
                                    <value>
                                        <div class="col-md-9">
                                            <button class="btn btn-primary"
                                                    onclick="pageEvent.openRoomAllocationPage()"><i
                                                    class="fa fa-sticky-note-o"></i></button>
                                        </div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Vehicle Allocation</div>
                                    <value>
                                        <div class="col-md-9">
                                            <button class="btn btn-primary"
                                                    onclick="pageEvent.openVehicleAllocationPage()"><i
                                                    class="fa fa-sticky-note-o"></i></button>

                                        </div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Service Provider</div>
                                    <value>
                                        <div class="col-md-9">
                                            <button class="btn btn-primary"
                                                    onclick="pageEvent.openServiceProviderPage()"><i
                                                    class="fa fa-sticky-note-o"></i></button>

                                        </div>
                                    </value>
                                </div>
                            </div>
                        </div>
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

<!-- Add Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="eventForm" autocomplete="off">
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
                    <h4 id="eventModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <div class="modal-body add-event-modal-body">
                    <input type="text" class="hidden" name="eventTypeCode" id="eventTypeCode" value="1"/>
                    <input type="text" class="hidden" name="eventCode" id="form-add-edit-code"/>
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
                    <div class="col-md-6 col-sm-6 col-xs-12 col-padding-left-remove col-padding-right-remove col-padding-remove">
                        <div class="form-group margin-right-none">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">From Date*</span>
                                <input type="text" class="form-control text-field-left-border date"
                                       name="eventFromDate"
                                       id="eventFromDate" placeholder="dd/mm/yyyy" tabindex="2" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-padding-right-remove col-padding-remove">
                        <div class="form-group margin-left-none">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">To Date*</span>
                                <input type="text" class="form-control text-field-left-border date"
                                       name="eventToDate"
                                       id="eventToDate" placeholder="dd/mm/yyyy" tabindex="3" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Sub Events*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down hidden-xs fa-size"></i>
                                <select class="form-control select-field-left-border" name="subEventConfirmation"
                                        id="subEventConfirmation" onchange="pageEvent.subEventConfirmation()"
                                        tabindex="4">
                                    <option value="0">Yes</option>
                                    <option value="1" selected>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mainEventDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Venue*</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="eventVenue"
                                           id="eventVenue" placeholder="Venue" tabindex="5" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row row-margin-none">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-padding-left-remove col-padding-right-remove col-padding-remove">
                                <div class="form-group margin-right-none">
                                    <div class="input-group">
                                        <span
                                            class="input-group-addon input-group-addon-label two-col-span-label">From*</span>
                                        <span class="input-group-btn select-inline">
                                            <div class="inner-addon right-addon">
                                                <i class="fa fa-caret-down fa-size"></i>
                                                <select
                                                    class="form-control select-field-left-border select-right-radius-none">
                                                    <option value="00">00</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                </select>
                                            </div>
                                        </span>
                                        <span class="input-group-btn select-inline">
                                            <div class="inner-addon right-addon">
                                                <i class="fa fa-caret-down fa-size"></i>
                                                <select class="form-control select-field-left-border">
                                                    <option value="00">00</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="00">24</option>
                                                    <option value="01">25</option>
                                                    <option value="02">26</option>
                                                    <option value="03">27</option>
                                                    <option value="04">28</option>
                                                    <option value="05">29</option>
                                                    <option value="06">30</option>
                                                    <option value="07">31</option>
                                                    <option value="08">32</option>
                                                    <option value="09">33</option>
                                                    <option value="10">34</option>
                                                    <option value="11">35</option>
                                                    <option value="12">36</option>
                                                    <option value="13">37</option>
                                                    <option value="14">38</option>
                                                    <option value="15">39</option>
                                                    <option value="16">40</option>
                                                    <option value="17">41</option>
                                                    <option value="18">42</option>
                                                    <option value="19">43</option>
                                                    <option value="20">44</option>
                                                    <option value="21">45</option>
                                                    <option value="22">46</option>
                                                    <option value="23">47</option>
                                                    <option value="00">48</option>
                                                    <option value="01">49</option>
                                                    <option value="02">50</option>
                                                    <option value="03">51</option>
                                                    <option value="04">52</option>
                                                    <option value="05">53</option>
                                                    <option value="06">54</option>
                                                    <option value="07">55</option>
                                                    <option value="08">56</option>
                                                    <option value="09">57</option>
                                                    <option value="10">58</option>
                                                    <option value="11">59</option>
                                                </select>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 col-padding-right-remove col-padding-remove">
                            <div class="form-group margin-left-none">
                                <div class="input-group">
                                    <span
                                        class="input-group-addon input-group-addon-label two-col-span-label">To</span>
                                    <span class="input-group-btn select-inline">
                                        <div class="inner-addon right-addon">
                                            <i class="fa fa-caret-down fa-size"></i>
                                            <select
                                                class="form-control select-field-left-border select-right-radius-none">
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                            </select>
                                        </div>
                                    </span>
                                    <span class="input-group-btn select-inline">
                                        <div class="inner-addon right-addon">
                                            <i class="fa fa-caret-down fa-size"></i>
                                            <select class="form-control select-field-left-border">
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="00">24</option>
                                                <option value="01">25</option>
                                                <option value="02">26</option>
                                                <option value="03">27</option>
                                                <option value="04">28</option>
                                                <option value="05">29</option>
                                                <option value="06">30</option>
                                                <option value="07">31</option>
                                                <option value="08">32</option>
                                                <option value="09">33</option>
                                                <option value="10">34</option>
                                                <option value="11">35</option>
                                                <option value="12">36</option>
                                                <option value="13">37</option>
                                                <option value="14">38</option>
                                                <option value="15">39</option>
                                                <option value="16">40</option>
                                                <option value="17">41</option>
                                                <option value="18">42</option>
                                                <option value="19">43</option>
                                                <option value="20">44</option>
                                                <option value="21">45</option>
                                                <option value="22">46</option>
                                                <option value="23">47</option>
                                                <option value="00">48</option>
                                                <option value="01">49</option>
                                                <option value="02">50</option>
                                                <option value="03">51</option>
                                                <option value="04">52</option>
                                                <option value="05">53</option>
                                                <option value="06">54</option>
                                                <option value="07">55</option>
                                                <option value="08">56</option>
                                                <option value="09">57</option>
                                                <option value="10">58</option>
                                                <option value="11">59</option>
                                            </select>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div id="subEventAddDiv" class="hidden">
                            <hr/>
                            <div class="row">
                                <div class="col-md-11 col-sm-11 col-xs-12">
                                    <div class="form-group form-group-margin">
                                        <div class="input-group">
                                            <span class="input-group-addon input-group-addon-label">Name*</span>

                                            <div class="inner-addon right-addon">
                                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                                <input type="text" class="form-control text-field-left-border" id=""
                                                       name=""
                                                       placeholder="Sub Event Name" tabindex="6" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-margin">
                                        <div class="input-group">
                                            <span class="input-group-addon input-group-addon-label">Venue*</span>

                                            <div class="inner-addon right-addon">
                                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                                <input type="text" class="form-control text-field-left-border" id=""
                                                       name=""
                                                       placeholder="Sub Event Venue" tabindex="7" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-margin">
                                        <div class="input-group">
                                            <span class="input-group-addon input-group-addon-label">Date*</span>

                                            <div class="inner-addon right-addon">
                                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                                <input type="text" class="form-control text-field-left-border date"
                                                       id=""
                                                       name="" placeholder="DD/MM/YYYY" tabindex="8" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-padding-left-remove col-padding-right-remove col-padding-remove">
                                        <div class="form-group margin-right-none">
                                            <div class="input-group">
                                                <span class="input-group-addon input-group-addon-label two-col-span-label">From*</span>
                                                <span class="input-group-btn select-inline">
                                                    <div class="inner-addon right-addon">
                                                        <i class="fa fa-caret-down fa-size"></i>
                                                        <select
                                                            class="form-control select-field-left-border select-right-radius-none">
                                                            <option value="00">00</option>
                                                            <option value="01">01</option>
                                                            <option value="02">02</option>
                                                            <option value="03">03</option>
                                                            <option value="04">04</option>
                                                            <option value="05">05</option>
                                                            <option value="06">06</option>
                                                            <option value="07">07</option>
                                                            <option value="08">08</option>
                                                            <option value="09">09</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                        </select>
                                                    </div>
                                                </span>
                                                <span class="input-group-btn select-inline">
                                                    <div class="inner-addon right-addon">
                                                        <i class="fa fa-caret-down fa-size"></i>
                                                        <select class="form-control select-field-left-border">
                                                            <option value="00">00</option>
                                                            <option value="01">01</option>
                                                            <option value="02">02</option>
                                                            <option value="03">03</option>
                                                            <option value="04">04</option>
                                                            <option value="05">05</option>
                                                            <option value="06">06</option>
                                                            <option value="07">07</option>
                                                            <option value="08">08</option>
                                                            <option value="09">09</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                            <option value="00">24</option>
                                                            <option value="01">25</option>
                                                            <option value="02">26</option>
                                                            <option value="03">27</option>
                                                            <option value="04">28</option>
                                                            <option value="05">29</option>
                                                            <option value="06">30</option>
                                                            <option value="07">31</option>
                                                            <option value="08">32</option>
                                                            <option value="09">33</option>
                                                            <option value="10">34</option>
                                                            <option value="11">35</option>
                                                            <option value="12">36</option>
                                                            <option value="13">37</option>
                                                            <option value="14">38</option>
                                                            <option value="15">39</option>
                                                            <option value="16">40</option>
                                                            <option value="17">41</option>
                                                            <option value="18">42</option>
                                                            <option value="19">43</option>
                                                            <option value="20">44</option>
                                                            <option value="21">45</option>
                                                            <option value="22">46</option>
                                                            <option value="23">47</option>
                                                            <option value="00">48</option>
                                                            <option value="01">49</option>
                                                            <option value="02">50</option>
                                                            <option value="03">51</option>
                                                            <option value="04">52</option>
                                                            <option value="05">53</option>
                                                            <option value="06">54</option>
                                                            <option value="07">55</option>
                                                            <option value="08">56</option>
                                                            <option value="09">57</option>
                                                            <option value="10">58</option>
                                                            <option value="11">59</option>
                                                        </select>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-padding-right-remove col-padding-remove">
                                        <div class="form-group margin-left-none">
                                            <div class="input-group">
                                                <span class="input-group-addon input-group-addon-label two-col-span-label">To</span>
                                                <span class="input-group-btn select-inline">
                                                    <div class="inner-addon right-addon">
                                                        <i class="fa fa-caret-down fa-size"></i>
                                                        <select
                                                            class="form-control select-field-left-border select-right-radius-none">
                                                            <option value="00">00</option>
                                                            <option value="01">01</option>
                                                            <option value="02">02</option>
                                                            <option value="03">03</option>
                                                            <option value="04">04</option>
                                                            <option value="05">05</option>
                                                            <option value="06">06</option>
                                                            <option value="07">07</option>
                                                            <option value="08">08</option>
                                                            <option value="09">09</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                        </select>
                                                    </div>
                                                </span>
                                                <span class="input-group-btn select-inline">
                                        <div class="inner-addon right-addon">
                                            <i class="fa fa-caret-down fa-size"></i>
                                            <select class="form-control select-field-left-border">
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="00">24</option>
                                                <option value="01">25</option>
                                                <option value="02">26</option>
                                                <option value="03">27</option>
                                                <option value="04">28</option>
                                                <option value="05">29</option>
                                                <option value="06">30</option>
                                                <option value="07">31</option>
                                                <option value="08">32</option>
                                                <option value="09">33</option>
                                                <option value="10">34</option>
                                                <option value="11">35</option>
                                                <option value="12">36</option>
                                                <option value="13">37</option>
                                                <option value="14">38</option>
                                                <option value="15">39</option>
                                                <option value="16">40</option>
                                                <option value="17">41</option>
                                                <option value="18">42</option>
                                                <option value="19">43</option>
                                                <option value="20">44</option>
                                                <option value="21">45</option>
                                                <option value="22">46</option>
                                                <option value="23">47</option>
                                                <option value="00">48</option>
                                                <option value="01">49</option>
                                                <option value="02">50</option>
                                                <option value="03">51</option>
                                                <option value="04">52</option>
                                                <option value="05">53</option>
                                                <option value="06">54</option>
                                                <option value="07">55</option>
                                                <option value="08">56</option>
                                                <option value="09">57</option>
                                                <option value="10">58</option>
                                                <option value="11">59</option>
                                            </select>
                                        </div>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12">
                                    <div class='col-md-1 col-sm-1 col-xs-12'>
                                        <center>
                                            <button type='button' class='btn btn-success subEventsBtn'
                                                    onclick='pageEvent.addSubDiv(1)'>
                                                <i class='fa fa-plus fa-lg'></i>
                                            </button>
                                        </center>
                                    </div>
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
                        <form method="POST" action="controller.php" id="deleteEventForm">
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

<!--Invite List Modal -->
<div class="modal fade" id="inviteListModal" tabindex="-1" role="dialog" aria-labelledby="inviteListModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="inviteListForm" autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left" style="margin-top:-5px">
                        <a class="btn btn-danger button-top-remove" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </a>
                    </div>
                    <div class="form-group pull-right" style="margin-top:-5px">
                        <button type="button" class="btn btn-success button-top-remove"
                                onclick="window.location.href = 'inviteList/'">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 id="eventModalHeading" class="modal-title text-center">
                        Invitees
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label-multiselect">State*</span>
                                    <select id="statesSelection" multiple="multiple" class="form-control">
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
                                        <option value='1'>Tamil Nadu</option>
                                        <option value='Telengana'>Telengana</option>
                                        <option value='Tripura'>Tripura</option>
                                        <option value='Uttar Pradesh'>Uttar Pradesh</option>
                                        <option value='Uttarakhand'>Uttarakhand</option>
                                        <option value='West Bengal'>West Bengal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label-multiselect">Cities*</span>
                                    <select id="citiesSelection" multiple="multiple" class="form-control">
                                        <option value="cheese">Cheese</option>
                                        <option value="tomatoes">Tomatoes</option>
                                        <option value="mozarella">Mozzarella</option>
                                        <option value="mushrooms">Mushrooms</option>
                                        <option value="pepperoni">Pepperoni</option>
                                        <option value="onions">Onions</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 margin-left">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label-multiselect">Groups*</span>
                                    <select id="groupsSelection" multiple="multiple" class="form-control">
                                        <option value="cheese">Cheese</option>
                                        <option value="tomatoes">Tomatoes</option>
                                        <option value="mozarella">Mozzarella</option>
                                        <option value="mushrooms">Mushrooms</option>
                                        <option value="pepperoni">Pepperoni</option>
                                        <option value="onions">Onions</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 margin-left">
                            <div class="form-group form-group-margin">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label-multiselect">Groups*</span>

                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-caret-down fa-size"></i>
                                        <select id="inviteesOption" class="form-control select-field-left-border">
                                            <option value="0">Yes</option>
                                            <option value="1" selected="selected">No</option>
                                        </select>
                                    </div>
                                </div>
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
<!-- Modal-->

<?php
include_once ROOT . 'dist/fetchJS.php';
?>
<script src="../dist/events/script/script.js"></script>
<script src="../dist/date/script.js"></script>
<script src="../dist/multiselect/script/bootstrap-multiselect.js"></script>
<script src="../dist/multiselect/script/bootstrap-multiselect-collapsible-groups.js"></script>
<script>
    var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
</script>
<script type="text/javascript">
    $(document).ready(function () {

    });
</script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>