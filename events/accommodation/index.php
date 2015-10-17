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
    <title>Assistant - Accommodation</title>
    <?php
    include_once ROOT . 'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/events/accommodation/css/style.css"/>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Accommodation');
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
    <div class="row button-top-margin" style="position:relative;">
        <div class="text-left">
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageAccommodation.navigateBack();">
                <i class="fa fa-arrow-left fa-lg"></i>
            </button>
        </div>
        <div class="text-center row-desc-margin"><h4 id="voucherHeader">Event Name</h4></div>
        <div class="text-right row-right-btn-margin">
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageAccommodation.openAddAccommodationModal();">
                <i class="fa fa-plus fa-lg"></i>
            </button>
        </div>
    </div>
    <div class="text-center">
        <table class="table table-top-margin borderless">
            <thead>
            <tr class="text-left">
                <th class="col-md-1 col-sm-1 col-xs-1 text-left">#</th>
                <th class="col-md-4 col-sm-4 col-xs-4 text-left">Venue</th>
                <th class="col-md-2 col-sm-2 col-xs-2 text-left">Rooms</th>
                <th class="col-md-2 col-sm-2 col-xs-2 text-left">Occupancy</th>
                <th class="col-md-2 col-sm-2 col-xs-2 text-left">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <tr class="text-left">
                <td class="col-md-1 col-sm-1 col-xs-1 text-left">1</td>
                <td class="col-md-4 col-sm-4 col-xs-4 text-left">The Park</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left">10</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left">20</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left"><a href='#'
                                                                    onclick='pageAccommodation.openEditAccommodationModal()'><i
                            class='fa fa-pencil fa-lg fa-green'></i></a><a href='#'
                                                                           onclick='pageAccommodation.openDeleteModal()'
                                                                           class="action-btn-padding"><i
                            class='fa fa-trash-o fa-lg fa-red'></i></a></td>
            </tr>
            <tr class="text-left">
                <td class="col-md-1 col-sm-1 col-xs-1 text-left">2</td>
                <td class="col-md-4 col-sm-4 col-xs-4 text-left">ITC Grand Chola</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left">5</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left">10</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left"><a href='#'
                                                                    onclick='pageAccommodation.openEditAccommodationModal()'><i
                            class='fa fa-pencil fa-lg fa-green'></i></a><a href='#'
                                                                           onclick='pageAccommodation.openDeleteModal()'
                                                                           class="action-btn-padding"><i
                            class='fa fa-trash-o fa-lg fa-red'></i></a></td>
            </tr>
            <tr class="text-left">
                <td class="col-md-1 col-sm-1 col-xs-1 text-left">3</td>
                <td class="col-md-4 col-sm-4 col-xs-4 text-left">Park Hyatt</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left">4</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left">16</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left"><a href='#'
                                                                    onclick='pageAccommodation.openEditAccommodationModal()'><i
                            class='fa fa-pencil fa-lg fa-green'></i></a><a href='#'
                                                                           onclick='pageAccommodation.openDeleteModal()'
                                                                           class="action-btn-padding"><i
                            class='fa fa-trash-o fa-lg fa-red'></i></a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!--Assign Task Modal -->
<div class="modal fade" id="assignTaskModal" tabindex="-1" role="dialog" aria-labelledby="assignTaskModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="assignTaskForm" autocomplete="off">
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
                    <h4 id="taskModalHeading" class="modal-title text-center">
                        Add Task
                    </h4>
                </div>
                <div class="modal-body add-room-modal-body">
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Accommodation*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="accommodationName"
                                       name="accommodationName" placeholder="Accommodation Name" tabindex="1" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-padding-right-remove">
                            <div class="form-group margin-right-none bottom-margin-ten">
                                <div class="input-group">
                                    <span
                                        class="input-group-addon input-group-addon-label check-span-label">Check-In</span>
                                    <input type="text" class="form-control text-field-left-border date" id="checkIn"
                                           name="checkIn" placeholder="DD/MM/YYYY" tabindex="2"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group margin-left-none bottom-margin-ten">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label two-col-span-label">Time</span>
                                    <span class="input-group-btn select-inline">
                                        <div class="inner-addon right-addon">
                                            <i class="fa fa-caret-down fa-size"></i>
                                            <select
                                                class="form-control select-field-left-border select-right-radius-none" tabindex="3">
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
                                            <select class="form-control select-field-left-border" tabindex="4">
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
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-padding-right-remove">
                            <div class="form-group margin-right-none bottom-margin-ten">
                                <div class="input-group">
                                    <span
                                        class="input-group-addon input-group-addon-label check-span-label">Check-Out</span>
                                    <input type="text" class="form-control text-field-left-border date" id="checkOut"
                                           name="checkOut" placeholder="DD/MM/YYYY" tabindex="5">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group margin-left-none bottom-margin-ten">
                                <div class="input-group">
                                    <span
                                        class="input-group-addon input-group-addon-label two-col-span-label">Time</span>
                                    <span class="input-group-btn select-inline">
                                        <div class="inner-addon right-addon">
                                            <i class="fa fa-caret-down fa-size"></i>
                                            <select
                                                class="form-control select-field-left-border select-right-radius-none" tabindex="6">
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
                                            <select class="form-control select-field-left-border" tabindex="7">
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
                    <div>
                        <div class="row">
                            <div class="col-md-11 col-sm-11 col-xs-12">
                                <div class="form-group form-group-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon input-group-addon-label">Rooms*</span>
                                        <input type="text" class="form-control text-field-left-border" id="accommodationRooms"
                                               name="accommodationRooms" placeholder="Room Number" tabindex="8" required/>
                                    </div>
                                </div>
                                <div class="form-group form-group-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon input-group-addon-label">Occupancy*</span>
                                        <input type="text" class="form-control text-field-left-border" id="occupancyCount"
                                               name="occupancyCount" placeholder="Occupancy Limit" tabindex="9" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12">
                                <div class="col-md-1 col-sm-1 col-xs-12">
                                    <center>
                                        <button type="button" class="btn btn-success twoTextBtn"
                                                onclick='pageAccommodation.addSubDiv(1)'>
                                            <i class="fa fa-plus fa-lg"></i>
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
<!-- Modal-->

<!--Delete Voucher Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Task?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteVoucherForm">
                            <input type="text" class="hidden" name="voucherNo" id="form-delete-code"/>
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
include_once ROOT . 'dist/fetchJS.php';
?>
<script src="../../dist/events/accommodation/script/script.js"></script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>

</html>