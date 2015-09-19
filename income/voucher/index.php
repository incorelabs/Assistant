<?php
session_start();
define("ROOT", "../../");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Voucher</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    include_once ROOT . 'dist/authenticate.php';
    include_once ROOT . 'dist/bootstrap.php';
    ?>

    <link rel="stylesheet" href="../../dist/incomeVoucher/css/style.css"/>
    <link rel="stylesheet" href="../../dist/css/style.css"/>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script>
        var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
    </script>

    <!-- Header Links -->
    <link type="text/css" rel="stylesheet" href="../../dist/css/sidebar.css"/>
    <link type="text/css" rel="stylesheet" href="../..//dist/css/jquery_sidebar.css"/>
    <script type="text/javascript" src="../../dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
        $(function () {
            $('nav#menu').mmenu();
        });
    </script>
    <script src="../../dist/script/script.js"></script>
    <script src="../../dist/date/script.js"></script>
    <script src="../../dist/incomeVoucher/script/script.js"></script>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Income Voucher');
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
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageVoucher.navigateBack();">
                <i class="fa fa-arrow-left fa-lg"></i>
            </button>
        </div>
        <div class="text-center row-desc-margin"><h4>Income Description</h4></div>
        <div class="text-right row-right-btn-margin">
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageVoucher.openAddVoucherModal();">
                <i class="fa fa-plus fa-lg"></i>
            </button>
        </div>
    </div>
    <div class="text-center">
        <table class="table table-top-margin borderless">
            <thead>
            <tr class="text-left">
                <th class="col-md-1 col-sm-1 col-xs-1 text-left">#</th>
                <th class="col-md-1 col-sm-1 col-xs-1 text-left">Image</th>
                <th class="col-md-1 hidden-xs hidden-sm text-left">Type</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Date</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Payment</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Ref No.</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Ref Date.</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Receipt No.</th>
                <th class="col-md-1 col-sm-1 col-xs-1 text-left">Amount</th>
                <th class="col-md-1 col-sm-1 col-xs-1 hidden-xs hidden-sm text-left">Remarks</th>
                <th class="col-md-1 col-sm-1 col-xs-1">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <tr class="text-left">
                <td class="col-md-1 col-sm-1 col-xs-1 text-left text-middle">1</td>
                <td class="col-md-1 col-sm-1 col-xs-1 text-left text-middle"><div class='image'><img src='../../img/default/preferences/logo.png' id='imageResource' alt='...' class='img-rounded'/><div class='overlay img-rounded'><a href="#" class='clickable' onclick='pageVoucher.openVoucherImageModal()'><span class='glyphicon glyphicon-pencil overlay-icon' style="height: 40px; width: 40px;"></span></a></div></div></td>
                <td class="col-md-1 hidden-xs hidden-sm text-left text-middle">Phone</td>
                <td class="col-md-1 hidden-sm hidden-xs text-left text-middle">01/01/2011</td>
                <td class="col-md-1 hidden-sm hidden-xs text-left text-middle">Cash</td>
                <td class="col-md-1 hidden-sm hidden-xs text-left text-middle">-</td>
                <td class="col-md-1 hidden-sm hidden-xs text-left text-middle">-</td>
                <td class="col-md-1 hidden-sm hidden-xs text-left text-middle">1111</td>
                <td class="col-md-1 col-sm-1 col-xs-1 text-left text-middle">111</td>
                <td class="col-md-1 hidden-sm hidden-xs text-left text-middle">-</td>
                <td class="col-md-1 col-sm-1 col-xs-1 text-middle"><a href="#" onclick="pageVoucher.openEditVoucherModal()"><i class="fa fa-pencil fa-lg fa-green"></i></a><a href="#" onclick="pageVoucher.openDeleteIncomeModal()" class="action-btn-padding"><i class="fa fa-trash-o fa-lg fa-red"></i></a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!--Voucher Modal-->
<div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="voucherForm" autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left" style="margin-top:-5px">
                        <button class="btn btn-danger" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </button>
                    </div>
                    <div class="form-group pull-right" style="margin-top:-5px">
                        <button type="submit" class="btn btn-success">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 class="modal-title text-center"  id="voucherModalHeading">

                    </h4>
                </div>
                <div class="modal-body">
                    <!--<input type="text" class="hidden" name="incomeTypeCode" id="incomeTypeCode" value="1"/>
                    <input type="text" class="hidden" name="incomeCode" id="form-add-edit-code"/>
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
                            <span class="input-group-addon input-group-addon-label">Date*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" id="voucherDate"
                                       name="voucherDate" placeholder="Voucher Date" tabindex="2" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin" id="voucherPaymentModeDiv">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Payment Mode*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" name="voucherPaymentMode"
                                        id="voucherPaymentMode" tabindex="3">
                                    <option value="1">Cash</option>
                                    <option value="2">Debit/Credit Card</option>
                                    <option value="3">Cheque</option>
                                    <option value="4">Demand Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin" id="referenceNumberDiv">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Reference No</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" id="referenceNumber"
                                       name="receiptNumber"
                                       placeholder="Reference Number" aria-describedby="basic-addon1" tabindex="4"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin" id="chequeDateDiv">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Date</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="chequeDate"
                                       name="chequeDate"
                                       placeholder="Date of Cheque/DD" aria-describedby="basic-addon1" tabindex="5"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Receipt No</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" id="receiptNumber"
                                       name="receiptNumber"
                                       placeholder="Receipt Number" aria-describedby="basic-addon1" tabindex="6"/>
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


<!--Delete Voucher Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Voucher?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteVoucherForm">
                            <input type="text" class="hidden" name="voucherCode" id="form-delete-code"/>
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

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModal" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <form class="form-horizontal" method="POST" action="upload.php" enctype="multipart/form-data" id="imageForm"
                  runat="server">

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
                    <input type="text" class="hidden" name="labelCode" id='photoId'/>

                    <div class="form-group row">
                        <center>
                            <div class="col-sm-12 col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-5">
                                    <label class="control-label">Select Image</label>
                                    <br>
                                    <br>
                                    <input type='file' id="imgInput" name="fileToUpload"
                                           style="padding-bottom:10px;" accept="image/gif, image/jpeg, image/png" required/>

                                    <p id="imageErrorMsg"></p>
                                    <div class="delete-btn-padding">
                                        <button type="button" class="btn btn-danger" onclick="pageVoucher.confirmDeleteImage()">Delete Image</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-4">
                                    <label class="control-label">Image Preview</label>
                                    <br>
                                    <br>
                                    <img src="../../img/default/preferences/logo.png" id="imagePreview"
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
<div class="cover">
    <div id="pageLoading"></div>
</div>

</html>