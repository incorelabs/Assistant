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
    <title>Assistant - Voucher</title>
    <?php
    include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/assetsVoucher/css/style.css"/>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Asset Voucher');
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
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageAssetVoucher.navigateBack();">
                <i class="fa fa-arrow-left fa-lg"></i>
            </button>
        </div>
        <div class="text-center row-desc-margin"><h4 id="voucherHeader"></h4></div>
        <div class="text-right row-right-btn-margin">
            <button class="btn btn-primary" id="btnAddVoucher" onclick="pageAssetVoucher.openAddVoucherModal();">
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
                <th class="col-md-1 hidden-sm hidden-xs text-left">Type</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Date</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Payment</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Chq/DD No.</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Chq/DD Date.</th>
                <th class="col-md-1 hidden-sm hidden-xs text-left">Receipt No.</th>
                <th class="col-md-1 col-sm-1 col-xs-1 text-left">Amount</th>
                <th class="col-md-1 col-sm-1 col-xs-1 hidden-xs hidden-sm text-left">Remarks</th>
                <th class="col-md-1 col-sm-1 col-xs-1">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
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
                        <a class="btn btn-danger" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </a>
                    </div>
                    <div class="form-group pull-right" style="margin-top:-5px">
                        <button type="submit" class="btn btn-success">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 class="modal-title text-center" id="voucherModalHeading">

                    </h4>
                </div>
                <input type="text" class="hidden" name="voucherNo" id="form-add-edit-code"/>
                <input type="text" class="hidden" name="assetCode" id="assetCodeForAddEditVoucher"/>
                <input type="text" class="hidden" name="mode" id="form-add-edit-mode"/>

                <div class="modal-body">

                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Description</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o-down hidden-xs fa-size"></i>
                                <input type="text" name="voucherDescription" id="voucherDescription"
                                       class="form-control text-field-left-border" tabindex="1" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Date*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" name="voucherDt" id="voucherDt"
                                       class="form-control text-field-left-border date" placeholder="DD/MM/YYYY"
                                       tabindex="2" required/>
                            </div>
                        </div>
                        <div class="info"></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Type*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select name="voucherType" id="voucherType"
                                        class="form-control select-field-left-border" tabindex="3" required>
                                    <option value="1">Service</option>
                                    <option value="2">Renewal of Warranty</option>
                                    <option value="3">Sold</option>
                                    <option value="4">Lost</option>
                                    <option value="5">Damaged</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Payment Mode*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select name="payMode" id="payMode"
                                        class="form-control select-field-left-border" tabindex="3">
                                    <option value="1">Cash</option>
                                    <option value="2">Debit/Credit Card</option>
                                    <option value="3">Cheque</option>
                                    <option value="4">Demand Draft</option>
                                    <option value="5">Net Banking</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin" id="referenceNumberDiv">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Ref No.</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" name="referNo" id="referNo"
                                       class="form-control text-field-left-border" placeholder="Reference Number"
                                       aria-describedby="basic-addon1" tabindex="4"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin" id="chequeDateDiv">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Ref Date</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" name="referDt" id="referDt"
                                       class="form-control text-field-left-border date" placeholder="DD/MM/YYYY"
                                       aria-describedby="basic-addon1" tabindex="5"/>
                            </div>
                        </div>
                        <div class="info"></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Document No</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" name="docNo" id="docNo" class="form-control text-field-left-border"
                                       placeholder="Receipt Number" aria-describedby="basic-addon1" tabindex="6"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Amount</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-money hidden-xs fa-size"></i>
                                <input type="text" name="docAmount" id="docAmount"
                                       class="form-control text-field-left-border" placeholder="Amount"
                                       aria-describedby="basic-addon1" tabindex="7" />
                            </div>
                        </div>
                        <div class="info"></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Remarks</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o fa-size hidden-xs"></i>
                                <input type="text" name="remarks" id="remarks"
                                       class="form-control text-field-left-border" placeholder="Remarks"
                                       aria-describedby="basic-addon1" tabindex="8"/>
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
                            <input type="text" class="hidden" name="voucherNo" id="form-delete-code"/>
                            <input type="text" class="hidden" name="assetCode" id="assetCodeForDeleteVoucher"/>
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
                    <input type="text" class="hidden" name="voucherNo" id='photoId'/>
                    <input type="text" class="hidden" name="assetCode" id='assetCodeForImage'/>

                    <div class="form-group row">
                        <center>
                            <div class="col-sm-12 col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-5">
                                    <label class="control-label">Select Image</label>
                                    <br>
                                    <br>
                                    <div class='input-group'>
                                        <input id='assetImgInputPath' name='assetImgInputPath' class='form-control' placeholder='Choose File' disabled='disabled' />
                                        <div class='input-group-btn'>
                                            <div class='fileUpload btn btn-primary'>
                                                <span>Upload</span>
                                                <input type='file' id="imgInput" name="fileToUpload" style="padding-bottom:10px;" class="upload" accept="image/gif, image/jpeg, image/png" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <p id="imageErrorMsg"></p>

                                    <div class="delete-btn-padding">
                                        <button type="button" class="btn btn-danger" id="deleteImageBtn"
                                                onclick="pageAssetVoucher.deleteCurrentLogo();">
                                            Delete Image
                                        </button>
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
            <div class="progress hidden" id="assetVoucherUploadProgress">
                <div class="progress-bar" id="assetVoucherUploadProgressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                     style="width: 0%;">
                    <span class="sr-only" id="assetVoucherUploadProgressValue">0% Complete</span>
                </div>
            </div>
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->

<?php
include_once ROOT.'dist/fetchJS.php';
?>
<script src="../../dist/assetsVoucher/script/script.js"></script>
<script src="../../dist/date/script.js"></script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>

</html>