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
    <title>Assistant - Assign Task</title>
    <?php
    include_once ROOT . 'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/events/assignTask/css/style.css"/>
    <link rel="stylesheet" href="../../dist/multiselect/css/bootstrap-multiselect.css"/>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Assign Task');
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
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageAssignTask.navigateBack();">
                <i class="fa fa-arrow-left fa-lg"></i>
            </button>
        </div>
        <div class="text-center row-desc-margin"><h4 id="voucherHeader">Event Name</h4></div>
        <div class="text-right row-right-btn-margin">
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageAssignTask.openAddAssignTaskModal();">
                <i class="fa fa-plus fa-lg"></i>
            </button>
        </div>
    </div>
    <div class="text-center">
        <table class="table table-top-margin borderless">
            <thead>
            <tr class="text-left">
                <th class="col-md-1 col-sm-1 col-xs-1 text-left">#</th>
                <th class="col-md-4 col-sm-4 col-xs-2 text-left">Task</th>
                <th class="col-md-4 col-sm-4 col-xs-4 text-left">Assigned</th>
                <th class="col-md-2 col-sm-2 col-xs-2 text-left">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <tr class="text-left">
                <td class="col-md-1 col-sm-1 col-xs-1 text-left">1</td>
                <td class="col-md-4 col-sm-4 col-xs-2 text-left">Decoration</td>
                <td class="col-md-4 col-sm-4 col-xs-4 text-left">Bharath Acha<br/>Aman S Jain<br/>Pralith Chordia</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left"><a href='#'
                                                                    onclick='pageAssignTask.openEditAssignTaskModal()'><i
                            class='fa fa-pencil fa-lg fa-green'></i></a><a href='#'
                                                                           onclick='pageAssignTask.openDeleteModal()'
                                                                           class="action-btn-padding"><i
                            class='fa fa-trash-o fa-lg fa-red'></i></a></td>
            </tr>
            <tr class="text-left">
                <td class="col-md-1 col-sm-1 col-xs-1 text-left">2</td>
                <td class="col-md-4 col-sm-4 col-xs-2 text-left">Food</td>
                <td class="col-md-4 col-sm-4 col-xs-4 text-left">Kamlesh Bokdia<br>Neelabh Pandey</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left"><a href='#'
                                                                    onclick='pageAssignTask.openEditAssignTaskModal()'><i
                            class='fa fa-pencil fa-lg fa-green'></i></a><a href='#'
                                                                           onclick='pageAssignTask.openDeleteModal()'
                                                                           class="action-btn-padding"><i
                            class='fa fa-trash-o fa-lg fa-red'></i></a></td>
            </tr>
            <tr class="text-left">
                <td class="col-md-1 col-sm-1 col-xs-1 text-left">3</td>
                <td class="col-md-4 col-sm-4 col-xs-2 text-left">Transportation</td>
                <td class="col-md-4 col-sm-4 col-xs-4 text-left">Darshan A Turakhia</td>
                <td class="col-md-2 col-sm-2 col-xs-2 text-left"><a href='#'
                                                                    onclick='pageAssignTask.openEditAssignTaskModal()'><i
                            class='fa fa-pencil fa-lg fa-green'></i></a><a href='#'
                                                                           onclick='pageAssignTask.openDeleteModal()'
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
                <div class="modal-body">
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Task Name*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="taskName"
                                       name="taskName" placeholder="Task Name" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Assigned To*</span>
                            <select id="taskAssignedTo" multiple="multiple" class="form-control">
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
                    <center><div class="info">*Max Limit of 9 people</div></center>
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
<script src="../../dist/events/assignTask/script/script.js"></script>
<script src="../../dist/multiselect/script/bootstrap-multiselect.js"></script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>

</html>