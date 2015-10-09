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
    <title>Assistant - Guest Confirmation</title>
    <?php
    include_once ROOT . 'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/events/guestConfirmation/css/style.css"/>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Guest');
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
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageGuestConfirmation.navigateBack();">
                <i class="fa fa-arrow-left fa-lg"></i>
            </button>
        </div>
        <div class="text-center row-desc-margin"><h4 id="voucherHeader">Event Name</h4></div>
        <div class="text-right row-right-btn-margin">
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageGuestConfirmation.openAddGuestConfirmationModal();">
                <i class="fa fa-plus fa-lg"></i>
            </button>
        </div>
    </div>
    <div class="text-center">
        <table class="table table-top-margin borderless">
            <thead>
            <tr class="text-left">
                <th class="col-md-1 col-sm-1 col-xs-1 text-left">#</th>
                <th class="col-md-2 col-sm-2 col-xs-2 text-left">Name</th>
                <th class="col-md-2 col-sm-2 col-xs-2 text-left">Arrival</th>
                <th class="col-md-2 hidden-sm hidden-xs text-left">Arrival Location</th>
                <th class="col-md-2 hidden-sm hidden-xs text-left">Dept</th>
                <th class="col-md-2 hidden-sm hidden-xs text-left">Dept Location</th>
                <th class="col-md-1 col-sm-2 col-xs-2 text-left">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <tr class="text-left">
                <td class="col-md-1 col-sm-1 col-xs-1 text-left">1</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left">Darshan A Turakhia</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left">12/12/2012 14:30</td>
                <td class="col-md-2 hidden-sm hidden-xs text-left">Chennai Airport</td>
                <td class="col-md-2 hidden-sm hidden-xs text-left">18/12/2012 14:30</td>
                <td class="col-md-2 hidden-sm hidden-xs text-left">Chennai Airport</td>
                <td class="col-md-1 col-sm-2 col-xs-2 text-left"><a href='#'
                                                                    onclick='pageGuestConfirmation.openEditGuestConfirmationModal()'><i
                            class='fa fa-pencil fa-lg fa-green'></i></a><a href='#'
                                                                           onclick='pageGuestConfirmation.openDeleteModal()'
                                                                           class="action-btn-padding"><i
                            class='fa fa-trash-o fa-lg fa-red'></i></a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!--Guest Modal -->
<div class="modal fade" id="guestConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="guestConfirmationModal"
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
                    <h4 id="guestConfirmationHeading" class="modal-title text-center">
                    </h4>
                </div>
                <div class="modal-body add-room-modal-body">
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Guest Name*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down hidden-xs fa-size"></i>
                                <select class="form-control select-field-left-border">
                                    <option>Darshan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">*</span>
                            <input type="text" class="form-control text-field-left-border" id="venueRooms"
                                   name="venueRooms" placeholder="Room Number" required/>
                            <span class="input-group-btn">
                                <button class="btn btn-success button-addon-custom" type="button" onclick="pageAccomodation.addSubDiv(1)"><i class="fa fa-plus fa-lg"></i></button>
                            </span>
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
<script src="../../dist/events/guestConfirmation/script/script.js"></script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>

</html>