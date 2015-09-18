<?php
session_start();
define("ROOT", "../");
//require_once ROOT.'db/Connection.php';

//$mysqli = getConnection();
include_once ROOT . 'dist/authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Expense</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    include_once ROOT . 'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="../dist/css/style.css"/>
    <link rel="stylesheet" href="../dist/expense/css/style.css"/>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script>
        var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
    </script>
    <script src="../dist/script/script.js"></script>
    <script src="../dist/date/script.js"></script>
    <script src="../dist/expense/script/script.js"></script>
    <link rel="stylesheet" href="../dist/css/sidebar.css"/>
    <link rel="stylesheet" href="../dist/css/jquery_sidebar.css"/>
    <script src="../dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
        $(function () {
            $('nav#menu').mmenu();
        });
    </script>
</head>

<body>
<?php
define('PAGE_TITLE', 'Expense');
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
        <div class="col-xs-12 col-md-5 col-padding" id="searchExpenseHeader">
            <div class="list-group list-margin">
                <div class="list-group-item list-margin">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                            <div class="input-group">
                                <input id="searchBox" type="text" class="form-control" placeholder="Search..."
                                       autofocus/>

                                <div class="input-group-btn">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-size"
                                    onclick="pageExpense.openAddExpenseModal();"><span
                                    class="glyphicon glyphicon-plus"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-xs-12 col-sm-12 hidden-sm hidden-xs" id="expenseDetailHeaderDiv">
            <div class="panel panel-default panelHeight list-margin" id="style-3">
                <div id="expenseDetailHeader" class="panel-heading text-center">
                    <h12>Expense Details</h12>
                    <button id='editVoucherdBtn' class='btn btn-success pull-right btn-header-margin-left'
                            onclick='pageExpense.openEditExpenseModal();'><span
                            class='glyphicon glyphicon-pencil'></span></button>
                    <button id='deleteVoucherBtn' class='btn btn-danger pull-left'
                            onclick='pageExpense.openDeleteExpenseModal(" + data.detail.expense.ExpenseCode + ")'><span
                            class='glyphicon glyphicon-trash'></span></button>
                    <button id='voucherExpenceBtn' class='btn btn-success pull-right'
                            onclick='pageExpense.openVoucherExpenseModal()'><span
                            class='fa fa-sticky-note-o fa-lg'></span></button>
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->
    </div>
    <!--row-->
    <div class="row">

        <div class="col-md-5 col-sm-12 col-xs-12 col-padding" id="expenseListDiv">
            <div class="panel panel-default panelHeight panel-margin" id="expenseListScroll">
                <div class="panel-height">
                    <!-- List group -->
                    <div id="expenseList" class="list-group force-scroll mobile-list">
                        <div class='list-group-item list-border-none'>
                            <li class='list-group-item-text header_font'>Test</li>
                        </div>
                    </div>
                    <!--List close-->
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->

        <div class="col-md-7 col-sm-12 col-xs-12 hidden-sm hidden-xs" id="expenseDetailDiv">
            <div id="expenseDetail" class="panel panel-default panelHeight panel-margin">
                <div class='panel-height'>
                    <!-- List group -->
                    <div class="list-group">
                        <div id="expenseDetailBody" class='list-group-item list-group-item-border'>
                            <div class='row contact-details row-top-padding'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Holder's Name</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Joint Holder Name</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Expense Type</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Description</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Issuing Authority</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Remarks</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Bill Date</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Due Date</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Payment Frequency</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Loan Due Date</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Payment Mode</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class='row contact-details'>
                                <div class='list-group-item-heading header_font'>
                                    <div class='col-md-3'>Payment URL</div>
                                    <value>
                                        <div class='col-md-9'>Test</div>
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

<!-- Add Expense Modal -->
<div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="expenseForm" autocomplete="off">
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
                    <h4 id="expenseModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" class="hidden" name="expenseTypeCode" id="expenseTypeCode" value="1"/>
                    <input type="text" class="hidden" name="expenseCode" id="form-add-edit-code"/>
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
                            <span class="input-group-addon input-group-addon-label">Holder's Name*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" id="holderName" name="name"
                                        tabindex="1">
                                    <option>Select Holder Name</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Joint Holder</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="jointHolderName"
                                       name="jointHolderName" placeholder="Joint Holder" tabindex="2"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Expense Type*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-key hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="expenseType"
                                       name="expenseType" placeholder="Expense Type" tabindex="3" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Description*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="description"
                                       id="description" placeholder="Description" tabindex="4" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Issuing Auth*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="issuingAuthority"
                                       name="issuingAuthority"
                                       placeholder="Issuing Authority" aria-describedby="basic-addon1" tabindex="5"
                                       required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Remarks</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="remarks"
                                       name="remarks"
                                       placeholder="Remarks" aria-describedby="basic-addon1" tabindex="6"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Bill Date*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" id="billDate" name="billDate"
                                        aria-describedby="basic-addin1" tabindex="7" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
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
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Due Date*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" id="dueDate" name="dueDate"
                                        aria-describedby="basic-addin1" tabindex="8" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
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
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Frequency*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" id="frequency" name="frequency"
                                        aria-describedby="basic-addin1" tabindex="9" required>
                                    <option value="1">Daily</option>
                                    <option value="2">Weekly</option>
                                    <option value="3">Fort Night</option>
                                    <option value="4">Monthly</option>
                                    <option value="5">Bi-Monthly</option>
                                    <option value="6">Quaterly</option>
                                    <option value="7">Half Yearly</option>
                                    <option value="8">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Loan Due Date</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" id="loadDueDate"
                                       name="loadDueDate"
                                       placeholder="Loan Due Date" aria-describedby="basic-addon1" tabindex="10"
                                       required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Payment Mode</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" id="paymentMode"
                                        name="paymentMode" tabindex="11">
                                    <option value="1">Cash</option>
                                    <option value="2">Online</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin hidden" id="paymentSiteDiv">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Payment Site</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-globe fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="paymentSite"
                                       id="paymentSite" placeholder="Payment URL" tabindex="12"/>
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

<!--Delete Expense Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Expense?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteExpenseForm">
                            <input type="text" class="hidden" name="ExpenseCode" id="form-delete-code"/>
                            <input type="text" class="hidden" name="mode" id="form-delete-mode" value="D"/>
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

<!--Voucher Modal-->
<div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="voucherForm" autocomplete="off">
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
                    <h4 class="modal-title text-center">
                        Add Voucher
                    </h4>
                </div>
                <div class="modal-body">
                    <!--<input type="text" class="hidden" name="expenseTypeCode" id="expenseTypeCode" value="1"/>
                    <input type="text" class="hidden" name="expenseCode" id="form-add-edit-code"/>
                    <input type="text" class="hidden" name="mode" id="form-add-edit-mode"/> -->

                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Description</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o-down hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="voucherDescription"
                                       name="voucherDescription" tabindex="1" value="Description" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Voucher No.*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user hidden-xs fa-size"></i>
                                <input type="number" class="form-control text-field-left-border" id="voucherNumber"
                                       name="voucherNumber" placeholder="Voucher Number" tabindex="2" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Date*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" id="voucherDate"
                                       name="voucherDate" placeholder="Voucher Date" tabindex="3" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin" id="voucherPaymentModeDiv">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Payment Mode*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" name="voucherPaymentMode"
                                        id="voucherPaymentMode" tabindex="4">
                                    <option value="1">Cash</option>
                                    <option value="2">Debit/Credit Card</option>
                                    <option value="3">Cheque</option>
                                    <option value="4">Demand Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin hidden" id="receiptNumberDiv">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Receipt No*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" id="receiptNumber"
                                       name="receiptNumber"
                                       placeholder="Receipt Number" aria-describedby="basic-addon1" tabindex="5"
                                       required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin hidden" id="receiptDateDiv">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Date*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="receiptDate"
                                       name="receiptDate"
                                       placeholder="Date of Receipt" aria-describedby="basic-addon1" tabindex="6"
                                       required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Amount*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-money hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="voucherAmount"
                                       name="voucherAmount"
                                       placeholder="Amount" aria-describedby="basic-addon1" tabindex="7"
                                       required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Remarks</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o fa-size hidden-xs"></i>
                                <input type="text" class="form-control text-field-left-border" id="voucherRemarks"
                                       name="voucherRemarks"
                                       placeholder="Remarks" aria-describedby="basic-addon1" tabindex="8"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Body -->

        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->

</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>