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
    <title>Assistant - Investments</title>
    <?php
    include_once ROOT . 'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../dist/investments/css/style.css"/>
</head>
<body>
<?php
define('PAGE_TITLE', 'Investment');
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
        <div class="col-xs-12 col-md-5 col-padding" id="searchInvestmentHeader">
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
                            <button class="btn btn-primary btn-size" onclick="pageInvestment.openAddInvestmentModal();">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-xs-12 col-sm-12 hidden-sm hidden-xs" id="investmentDetailHeaderDiv">
            <div class="panel panel-default panelHeight list-margin" id="style-3">
                <div id="investmentDetailHeader" class="panel-heading text-center">
                    <h12 id='investmentDetailsTag'>Investment Details</h12>
                    <button id='editInvestmentBtn' class='btn btn-success pull-right btn-header-margin-left'
                            onclick='pageInvestment.openEditInvestmentModal();'>
                        <span class='glyphicon glyphicon-pencil'></span>
                    </button>
                    <button id='deleteInvestmentBtn' class='btn btn-danger pull-left'
                            onclick='pageInvestment.openDeleteInvestmentModal()'>
                        <span class='glyphicon glyphicon-trash'></span>
                    </button>
                    <button id='voucherInvestmentBtn' class='btn btn-info pull-right'
                            onclick='pageInvestment.openVoucherInvestmentModal()'>
                        <span class='fa fa-sticky-note-o fa-lg'></span>
                    </button>
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->
    </div>
    <!--row-->
    <div class="row">

        <div class="col-md-5 col-sm-12 col-xs-12 col-padding" id="investmentListDiv">
            <div class="panel panel-default panelHeight panel-margin" id="investmentListScroll">
                <div class="panel-height">
                    <!-- List group -->
                    <div id="investmentList" class="list-group force-scroll mobile-list">
                    </div>
                    <!--List close-->
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->

        <div class="col-md-7 col-sm-12 col-xs-12 hidden-sm hidden-xs" id="investmentDetailDiv">
            <div id="investmentDetail" class="panel panel-default panelHeight panel-margin">
                <div class='panel-height'>
                    <!-- List group -->
                    <div class="list-group">
                        <div id="investmentDetailBody" class='list-group-item list-group-item-border'>
                            <div class="row contact-details row-top-padding">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3 image-details-padding">Images</div>
                                    <value>
                                        <div class="col-md-9">
                                            <div class="image">
                                                <a href="#" onclick="pageInvestment.openInvestmentImageModal()"
                                                   class="clickable">
                                                    <img src="../img/default/preferences/logo.png" id="imageResource"
                                                         alt="..." class="img-rounded img-size">

                                                    <div class="overlay img-rounded">
                                                        <span class="glyphicon glyphicon-pencil overlay-icon"></span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Holder's Name</div>
                                    <value>
                                        <div class="col-md-9">Darshan</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Investment Type</div>
                                    <value>
                                        <div class="col-md-8 col-sm-8 col-xs-8">Test</div>
                                        <div class="col-md-1 col-sm-1 col-xs-1"><a href="#"
                                                                                   onclick="pageInvestment.openInvestmentTypeModal()"><i
                                                    class="fa fa-sticky-note-o fa-size"></i></a></div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Description</div>
                                    <value>
                                        <div class="col-md-9">Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Invested With</div>
                                    <value>
                                        <div class="col-md-9">Dr. Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Joint Holder Name</div>
                                    <value>
                                        <div class="col-md-9"></div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Scheme</div>
                                    <value>
                                        <div class="col-md-9">Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Agent</div>
                                    <value>
                                        <div class="col-md-9"></div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Nominee Name</div>
                                    <value>
                                        <div class="col-md-9">Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Document Location</div>
                                    <value>
                                        <div class="col-md-9">Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Investment Date</div>
                                    <value>
                                        <div class="col-md-9">12/12/2012</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Investment Amount</div>
                                    <value>
                                        <div class="col-md-9">5000</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Remarks</div>
                                    <value>
                                        <div class="col-md-8 text-justify">Lorem Ipsum is simply dummy text of the
                                            printing and typesetting industry. Lorem Ipsum has been the industry's
                                            standard dummy text ever since the 1500s, when an unknown printer took a
                                            galley of type and scrambled it to make a type specimen book. It has
                                            survived not only five centuries, but also the leap into electronic
                                            typesetting, remaining essentially unchanged. It was popularised in the
                                            1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                                            and more recently with desktop publishing software like Aldus PageMaker
                                            including versions of Lorem Ipsum.
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

<!-- Add Investment Modal -->
<div class="modal fade" id="investmentModal" tabindex="-1" role="dialog" aria-labelledby="investmentModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="investmentForm" autocomplete="off">
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
                    <h4 id="investmentModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" class="hidden" name="investmentTypeCode" id="investmentTypeCode" value="1"/>
                    <input type="text" class="hidden" name="investmentCode" id="form-add-edit-code"/>
                    <input type="text" class="hidden" name="mode" id="form-add-edit-mode"/>

                    <div class="form-group form-group-margin">
                        <label class="col-xs-3 control-label">Private</label>

                        <div class="col-xs-3">
                            <div class='switch switch-padding'>
                                <input type='checkbox' name='privateFlag' id='privateFlag' class='switch-input'>
                                <label for='privateFlag' class='switch-label'></label>
                            </div>
                        </div>
                        <label class="col-xs-3 control-label">Active</label>

                        <div class="col-xs-3">
                            <div class='switch switch-padding'>
                                <input type='checkbox' name='activeFlag' id='activeFlag' class='switch-input'
                                       checked='checked'>
                                <label for='activeFlag' class='switch-label'></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Holder's Name*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" name="holderCode" id="holderCode"
                                        tabindex="1">
                                    <option>Select Holder Name</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Investment Type*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-key hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="investmentTypeName"
                                       id="investmentTypeName" placeholder="Investment Type" tabindex="2" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Description*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border"
                                       name="investmentDescription"
                                       id="investmentDescription" placeholder="Description" tabindex="3" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="info text-center"></div>
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Invested With</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="investmentWith"
                                       id="investmentWith" placeholder="Invested With" aria-describedby="basic-addon1"
                                       tabindex="4"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Joint Holder</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="jointHolder"
                                       id="jointHolder" placeholder="Joint Holder" tabindex="5"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Scheme</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-globe fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="investmentScheme"
                                       id="investmentScheme" placeholder="Investment Scheme" tabindex="6"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Agent</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-globe fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="investmentAgent"
                                       id="investmentAgent" placeholder="Investment Agent" tabindex="7"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Nominee.</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="nomineeName"
                                       id="nomineeName" placeholder="Nominee Name" aria-describedby="basic-addon1"
                                       tabindex="8"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Location*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="investmentLocation"
                                       id="investmentLocation" placeholder="Document Location"
                                       aria-describedby="basic-addon1"
                                       tabindex="9" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Date</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date"
                                       name="investmentDate"
                                       id="investmentDate" placeholder="Investment Date"
                                       aria-describedby="basic-addon1"
                                       tabindex="10"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Amount</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-money hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="investmentAmount"
                                       id="investmentAmount" placeholder="Investment Amount"
                                       aria-describedby="basic-addon1"
                                       tabindex="11"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Remarks</span>
                                <textarea class="form-control text-field-left-border textarea-style"
                                          name="investmentRemarks"
                                          id="investmentRemarks" placeholder="Investment Remarks"
                                          aria-describedby="basic-addon1" rows="3"
                                          tabindex="12"></textarea>
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

<!-- Add Investment Type Modal -->
<div class="modal fade" id="investmentTypeModal" tabindex="-1" role="dialog" aria-labelledby="investmentTypeModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="investmentTypeForm"
                  autocomplete="off">
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
                    <h4 id="investmentTypeModalHeading" class="modal-title text-center">
                        Edit Details
                    </h4>
                </div>
                <div class="modal-body investment-details-body">
                    <div id="durationDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span
                                    class="input-group-addon input-group-addon-label">Duration</span>
                                <span class="input-group-btn select-inline">
                                    <input type="number" class="form-control select-field-left-border input-no-radius"
                                           name="durationYears" id="durationYears" placeholder="Years"/>
                                </span>
                                <span class="input-group-btn select-inline">
                                    <input type="number" class="form-control select-field-left-border input-no-radius"
                                           name="durationMonths" id="durationMonths" placeholder="Months"/>
                                </span>
                                <span class="input-group-btn select-inline">
                                    <input type="number" class="form-control text-field-left-border input-right-radius"
                                           name="durationDays" id="durationDays" placeholder="Days"/>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="paymentFrequencyDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Payment Freq</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-caret-down fa-size"></i>
                                    <select class="form-control select-field-left-border" name="paymentFrequency"
                                            id="paymentFrequency">
                                        <option value="1">Daily</option>
                                        <option value="2">Weekly</option>
                                        <option value="3">Fort Night</option>
                                        <option value="4">Monthly</option>
                                        <option value="5">Bi-Monthly</option>
                                        <option value="6">Quarterly</option>
                                        <option value="7">Half Yearly</option>
                                        <option value="8">Yearly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="coverageDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Coverage</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-money hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="investmentCoverage"
                                           id="investmentCoverage" placeholder="Investment Coverage"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="nextDueDateDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Next Due Date</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-calendar hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border date"
                                           name="nextDueDate" id="nextDueDate" placeholder="DD/MM/YYYY"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="interestRateDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Interest Rate</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="investmentRate"
                                           id="investmentRate" placeholder="Interest Rate"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="interestFreqDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Interest Freq</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="interestFrequency"
                                           id="interestFrequency" placeholder="Interest Frequency"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="interestFirstDueDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Interest 1st Due</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-calendar hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border date"
                                           name="interestFirstDueDate"
                                           id="interestFirstDueDate" placeholder="DD/MM/YYYY"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="maturityDateDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Maturity Date</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-calendar fa-size hidden-xs"></i>
                                    <input type="text" class="form-control text-field-left-border date" name="maturityDate"
                                           id="maturityDate" placeholder="DD/MM/YYYY"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="maturityAmountDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Maturity Amount</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-money hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="maturityAmount"
                                           id="maturityAmount" placeholder="Maturity Amount"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="quantityDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Quantity</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="quantity"
                                           id="quantity" placeholder="Quantity"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="purchaseRateDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Purchase Rate</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="purchaseRate"
                                           id="purchaseRate" placeholder="Purchase Rate"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="formHEnclosedDiv">
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Form H Enclosed</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-caret-down fa-size"></i>
                                    <select class="form-control select-field-left-border" name="formHEclosed"
                                            id="formHEnclosed">
                                        <option value="0">Yes</option>
                                        <option value="1">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="familyMemberDiv">
                        <div class="row">
                            <div class="col-md-11 col-sm-11 col-xs-12">
                                <div class="form-group form-group-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon input-group-addon-label">Family Member</span>

                                        <div class="inner-addon right-addon">
                                            <i class="fa fa-caret-down fa-size"></i>
                                            <select class="form-control select-field-left-border"> <!-- Family Member List-->
                                                <option>Darshan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon input-group-addon-label two-col-span-label">Details</span>
                                        <span class="input-group-btn select-inline">
                                            <input type="number" class="form-control select-field-left-border input-no-radius"
                                                   name="acctNumber" id="acctNumber" placeholder="A/C Number"/>
                                        </span>
                                        <span class="input-group-btn select-inline">
                                            <input type="number" class="form-control select-field-left-border input-right-radius"
                                                   name="amountValue" id="amountValue" placeholder="Amount"/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12">
                                <div class="col-md-1 col-sm-1 col-xs-12">
                                    <center>
                                        <button type="button" class="btn btn-success subEventsBtn"
                                                onclick="pageInvestment.addSubDiv(1)">
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
<!--modal-->

<!--Delete Investment Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Investment?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteInvestmentForm">
                            <input type="text" class="hidden" name="investmentCode" id="form-delete-code"/>
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

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModal" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <form class="form-horizontal" method="POST" action="upload.php" enctype="multipart/form-data" id="imageForm"
                  runat="server">

                <div class="modal-header">

                    <div class="btn-group pull-left">
                        <a class="btn btn-danger" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>

                        </a>
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
                    <input type="text" class="hidden" name="investmentCode" id='investmentCodeForImage'/>

                    <div class="form-group row">
                        <center>
                            <div class="col-sm-12 col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-5">
                                    <label class="control-label">Select Image</label>
                                    <br>
                                    <br>

                                    <div class='input-group'>
                                        <input id='investmentsImgInputPath' name='investmentsImgInputPath'
                                               class='form-control' placeholder='Choose File' disabled='disabled'/>

                                        <div class='input-group-btn'>
                                            <div class='fileUpload btn btn-primary'>
                                                <span>Upload</span>
                                                <input type='file' id="imgInput" name="fileToUpload[]"
                                                       style="padding-bottom:10px;" class="upload"
                                                       accept="image/gif, image/jpeg, image/png" multiple/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">*You can select upto max 5 images</div>
                                    <p id="imageErrorMsg"></p>

                                    <div class="delete-btn-padding">
                                        <button type="button" class="btn btn-danger" id="deleteImageBtn"
                                                onclick="pageInvestment.deleteInvestmentImage(1)">
                                            Delete Image
                                        </button>
                                    </div>
                                    <div class="delete-btn-padding">
                                        <button type="button" class="btn btn-danger" id="deleteAllImageBtn"
                                                onclick="pageInvestment.deleteInvestmentImage(2)">
                                            Delete All Images
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-4">
                                    <label class="control-label">Image Preview</label>
                                    <br>
                                    <br>

                                    <div id="imagePreviewDiv">
                                        <img src="../img/default/preferences/logo.png" id="imagePreview"
                                             class="addImage">
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="image text-center image-horizontal-scroll" id="smallImagePreview">
                        </div>
                    </div>
                </div>
            </form>
            <div class="progress hidden" id="investmentUploadProgress">
                <div class="progress-bar" id="investmentUploadProgressBar" role="progressbar" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100"
                     style="width: 0%;">
                    <span class="sr-only" id="investmentUploadProgressValue">0% Complete</span>
                </div>
            </div>
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->

<?php
include_once ROOT . 'dist/fetchJS.php';
?>
<script src="../dist/investments/script/script.js"></script>
<script src="../dist/date/script.js"></script>
<script>
    var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
</script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>