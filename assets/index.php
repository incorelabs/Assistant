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
    <title>Assistant - Asset</title>
    <?php
    include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../dist/assets/css/style.css"/>
</head>
<body>
<?php
define('PAGE_TITLE', 'Asset');
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
        <div class="col-xs-12 col-md-5 col-padding" id="searchAssetsHeader">
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
                            <button class="btn btn-primary btn-size" onclick="pageAssets.openAddAssetsModal();">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-xs-12 col-sm-12 hidden-sm hidden-xs" id="assetsDetailHeaderDiv">
            <div class="panel panel-default panelHeight list-margin" id="style-3">
                <div id="assetsDetailHeader" class="panel-heading text-center">
                    <h12 id='assetsDetailsTag'>Asset Details</h12>
                    <button id='editAssetsBtn' class='btn btn-success pull-right btn-header-margin-left' onclick='pageAssets.openEditAssetsModal();'>
                        <span class='glyphicon glyphicon-pencil'></span>
                    </button>
                    <button id='deleteAssetsBtn' class='btn btn-danger pull-left' onclick='pageAssets.openDeleteAssetsModal()'>
                        <span class='glyphicon glyphicon-trash'></span>
                    </button>
                    <button id='voucherAssetsBtn' class='btn btn-info pull-right' onclick='pageAssets.openVoucherAssetsModal()'>
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

        <div class="col-md-5 col-sm-12 col-xs-12 col-padding" id="assetsListDiv">
            <div class="panel panel-default panelHeight panel-margin" id="assetsListScroll">
                <div class="panel-height">
                    <!-- List group -->
                    <div id="assetsList" class="list-group force-scroll mobile-list">
                        <a class="list-group-item contacts_font" onclick="">Audi R8</a>
                    </div>
                    <!--List close-->
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->

        <div class="col-md-7 col-sm-12 col-xs-12 hidden-sm hidden-xs" id="assetsDetailDiv">
            <div id="assetsDetail" class="panel panel-default panelHeight panel-margin">
                <div class='panel-height'>
                    <!-- List group -->
                    <div class="list-group">
                        <div id="assetsDetailBody" class='list-group-item list-group-item-border'>
                            <div class="row contact-details row-top-padding">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3 image-details-padding">Images</div>
                                    <value>
                                        <div class="col-md-9">
                                            <div class="image">
                                                <a href="#" onclick="pageAssets.openAssetImageModal()" class="clickable">
                                                    <img src="../img/default/preferences/logo.png" id='imageResource' alt='...' class='img-rounded img-size'/>
                                                    <div class='overlay img-rounded'>
                                                        <span class='glyphicon glyphicon-pencil overlay-icon'></span>
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
                                        <div class="col-md-9">Darshan A Turakhia</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Asset Type</div>
                                    <value>
                                        <div class="col-md-9">Automobile</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Description</div>
                                    <value>
                                        <div class="col-md-9">Audi R8</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Bought From</div>
                                    <value>
                                        <div class="col-md-9">Audi Chennai</div>
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
                                    <div class="col-md-3">Model Number</div>
                                    <value>
                                        <div class="col-md-9">R8</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Serial Number</div>
                                    <value>
                                        <div class="col-md-9">x1231</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Remarks</div>
                                    <value>
                                        <div class="col-md-9">TN 01 R 8</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Bill No.</div>
                                    <value>
                                        <div class="col-md-9">1531</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Bill Date</div>
                                    <value>
                                        <div class="col-md-9">12/12/2012</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Asset Cost</div>
                                    <value>
                                        <div class="col-md-9">11441231</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Warranty Upto</div>
                                    <value>
                                        <div class="col-md-9">11/12/2014</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Service Center</div>
                                    <value>
                                        <div class="col-md-9">Saidapet Audi</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Document Location</div>
                                    <value>
                                        <div class="col-md-9">NA</div>
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

<!-- Add Asset Modal -->
<div class="modal fade" id="assetsModal" tabindex="-1" role="dialog" aria-labelledby="assetsModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="assetsForm" autocomplete="off">
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
                    <h4 id="assetsModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" class="hidden" name="assetsTypeCode" id="assetsTypeCode" value="1"/>
                    <input type="text" class="hidden" name="contactCode" id="contactCode" value="1"/>
                    <input type="text" class="hidden" name="assetsCode" id="form-add-edit-code"/>
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
                            <span class="input-group-addon input-group-addon-label">Asset Type*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-key hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="assetsTypeName"
                                       id="assetsTypeName" placeholder="Asset Type" tabindex="2" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Description*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="assetsName"
                                       id="assetsName" placeholder="Description" tabindex="3" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="info text-center"></div>
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Bought From*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="boughtFrom"
                                       id="boughtFrom" placeholder="Bought From" aria-describedby="basic-addon1" tabindex="4"
                                       required/>
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
                            <span class="input-group-addon input-group-addon-label">Service Center</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-globe fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="serviceCenter"
                                       id="serviceCenter" placeholder="Service Center" tabindex="13"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Doc Location*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-globe fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="documentLocation"
                                       id="documentLocation" placeholder="Document Location" tabindex="14" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Bill No.</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="billNumber"
                                       id="billNumber" placeholder="Bill Number" aria-describedby="basic-addon1"
                                       tabindex="9"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Bill Date*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" name="billDate"
                                       id="billDate" placeholder="DD/MM/YYYY" aria-describedby="basic-addon1"
                                       tabindex="10" required/>
                            </div>
                        </div>
                        <div class="info"></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Asset Cost</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="assetCost"
                                       id="assetCost" placeholder="Asset Cost" aria-describedby="basic-addon1"
                                       tabindex="11"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Warranty Upto</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" name="warrantyDate"
                                       id="warrantyDate" placeholder="DD/MM/YYYY" aria-describedby="basic-addon1"
                                       tabindex="12"/>
                            </div>
                        </div>
                        <div class="info"></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Model Name</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="modelNumber"
                                       id="modelNumber" placeholder="Model Name" tabindex="6"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Serial No.</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="serialNumber"
                                       id="serialNumber" placeholder="Serial Number" tabindex="7"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Remarks</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="assetsRemarks"
                                       id="assetsRemarks" placeholder="Remarks" aria-describedby="basic-addon1"
                                       tabindex="8"/>
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

<!--Delete Asset Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Asset?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteAssetForm">
                            <input type="text" class="hidden" name="assetsCode" id="form-delete-code"/>
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
                    <input type="text" class="hidden" name="expenseCode" id='expenseCodeForImage'/>

                    <div class="form-group row">
                        <center>
                            <div class="col-sm-12 col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-5">
                                    <label class="control-label">Select Image</label>
                                    <br>
                                    <br>
                                    <div class='input-group'>
                                        <input id='expenseImgInputPath' name='expenseImgInputPath' class='form-control' placeholder='Choose File' disabled='disabled' />
                                        <div class='input-group-btn'>
                                            <div class='fileUpload btn btn-primary'>
                                                <span>Upload</span>
                                                <input type='file' id="imgInput" name="fileToUpload" style="padding-bottom:10px;" class="upload" accept="image/gif, image/jpeg, image/png" required multiple/>
                                            </div>
                                        </div>
                                    </div>

                                    <p id="imageErrorMsg"></p>

                                    <div class="delete-btn-padding">
                                        <button type="button" class="btn btn-danger" id="deleteImageBtn"
                                                onclick="">
                                            Delete Image
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
                    <div class="image text-center">
                        <a href="#" onclick="pageAssets.changeImage('../img/default/preferences/logo.png')" class="clickable">
                            <img src="../img/index/assets.png" id='imageResource' alt='...' class='img-thumbnail modal-img-size'/>
                        </a>
                        <a href="#" onclick="pageAssets.openAssetImageModal()" class="clickable">
                            <img src="../img/index/assets1.png" id='imageResource' alt='...' class='img-thumbnail modal-img-size'/>
                        </a>
                        <a href="#" onclick="pageAssets.openAssetImageModal()" class="clickable">
                            <img src="../img/index/cars.png" id='imageResource' alt='...' class='img-thumbnail modal-img-size'/>
                        </a>
                        <a href="#" onclick="pageAssets.openAssetImageModal()" class="clickable">
                            <img src="../img/index/contacts.png" id='imageResource' alt='...' class='img-thumbnail modal-img-size'/>
                        </a>
                        <a href="#" onclick="pageAssets.openAssetImageModal()" class="clickable">
                            <img src="../img/index/shares.png" id='imageResource' alt='...' class='img-thumbnail modal-img-size'/>
                        </a>
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

<?php
include_once ROOT.'dist/fetchJS.php';
?>
<script src="../dist/assets/script/script.js"></script>
<script src="../dist/date/script.js"></script>
<script>
    var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
</script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>