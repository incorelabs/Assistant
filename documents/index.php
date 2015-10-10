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
    <title>Assistant - Documents</title>
    <?php
    include_once ROOT . 'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../dist/documents/css/style.css"/>
</head>
<body>
<?php
define('PAGE_TITLE', 'Documents');
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
        <div class="col-xs-12 col-md-5 col-padding" id="searchDocumentsHeader">
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
                            <button class="btn btn-primary btn-size" onclick="pageDocuments.openAddDocumentsModal();">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-xs-12 col-sm-12 hidden-sm hidden-xs" id="documentsDetailHeaderDiv">
            <div class="panel panel-default panelHeight list-margin" id="style-3">
                <div id="documentsDetailHeader" class="panel-heading text-center">
                    <h12 id='documentsDetailsTag'>Document Details</h12>
                    <button id='editDocumentsBtn' class='btn btn-success pull-right btn-header-margin-left'
                            onclick='pageDocuments.openEditDocumentsModal();'>
                        <span class='glyphicon glyphicon-pencil'></span>
                    </button>
                    <button id='deleteDocumentsBtn' class='btn btn-danger pull-left'
                            onclick='pageDocuments.openDeleteDocumentsModal()'>
                        <span class='glyphicon glyphicon-trash'></span>
                    </button>
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->
    </div>
    <!--row-->
    <div class="row">

        <div class="col-md-5 col-sm-12 col-xs-12 col-padding" id="documentsListDiv">
            <div class="panel panel-default panelHeight panel-margin" id="documentsListScroll">
                <div class="panel-height">
                    <!-- List group -->
                    <div id="documentsList" class="list-group force-scroll mobile-list">
                        <div class="list-group">
                        </div>
                    </div>
                    <!--List close-->
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->

        <div class="col-md-7 col-sm-12 col-xs-12 hidden-sm hidden-xs" id="documentsDetailDiv">
            <div id="documentsDetail" class="panel panel-default panelHeight panel-margin">
                <div class='panel-height'>
                    <!-- List group -->
                    <div class="list-group">
                        <div id="documentsDetailBody" class='list-group-item list-group-item-border'>
                            <div class="row contact-details row-top-padding">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3 image-details-padding">Images</div>
                                    <value>
                                        <div class="col-md-9">
                                            <div class="image">
                                                <a href="#" onclick="pageDocuments.openDocumentsImageModal()"
                                                   class="clickable">
                                                    <img src="../img/default/preferences/logo.png"
                                                         id="imageResource" alt="..." class="img-rounded img-size">

                                                    <div class="overlay img-rounded">
                                                            <span
                                                                class="glyphicon glyphicon-pencil overlay-icon"></span>
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
                                    <div class="col-md-3">Document Type</div>
                                    <value>
                                        <div class="col-md-9">Test</div>
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
                                    <div class="col-md-3">Doctor</div>
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
                                    <div class="col-md-3">Issuing Authority</div>
                                    <value>
                                        <div class="col-md-9">Test</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Document Location</div>
                                    <value>
                                        <div class="col-md-9"></div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Issue Date</div>
                                    <value>
                                        <div class="col-md-9">12/12/2012</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Expiry Date</div>
                                    <value>
                                        <div class="col-md-9">11/12/2018</div>
                                    </value>
                                </div>
                            </div>
                            <div class="row contact-details">
                                <div class="list-group-item-heading header_font">
                                    <div class="col-md-3">Remarks</div>
                                    <value>
                                        <div class="col-md-9"></div>
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

<!-- Add documents Modal -->
<div class="modal fade" id="documentsModal" tabindex="-1" role="dialog" aria-labelledby="documentsModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="documentsForm" autocomplete="off">
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
                    <h4 id="documentsModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" class="hidden" name="documentsTypeCode" id="documentsTypeCode" value="1"/>
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
                            <span class="input-group-addon input-group-addon-label">Doc Type*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-key hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="documentsTypeName"
                                       id="documentsTypeName" placeholder="Document Type" tabindex="2" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Description*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="documentsDec"
                                       id="documentsDesc" placeholder="Description" tabindex="3" required/>
                            </div>
                        </div>
                    </div>
                    <div class="hidden"><!-- Show when autocomplete is selected as Medical Consultation-->
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Doctor Name</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-user hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="doctorName"
                                           id="doctorName" placeholder="Doctor Name" tabindex="4"/><!-- Saves Name in contacts -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden"><!-- Show when autocomplete is selected as Medical Test-->
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Lab Name</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-user hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="labName"
                                           id="labName" placeholder="Lab Name" tabindex="4"/><!-- Saves Name in contacts -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden"><!-- Show when autocomplete is selected as Property-->
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Property Holder</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-user hidden-xs fa-size"></i>
                                    <input type="text" class="form-control text-field-left-border" name="propertyHolder"
                                           id="propertyHolder" placeholder="Property Holder" tabindex="4"/><!-- Saves Name in contacts -->
                                </div>
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
                            <span class="input-group-addon input-group-addon-label">Issuing Auth</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-globe fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="issuingAuthority"
                                       id="issuingAuthority" placeholder="Issuing Authority" tabindex="6"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Doc Location*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-globe fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="locationName"
                                       id="locationName" placeholder="Document Location" tabindex="7" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Issue Date</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" name="issueDate"
                                       id="issueDate" placeholder="DD/MM/YYYY" aria-describedby="basic-addon1"
                                       tabindex="8"/>
                            </div>
                        </div>
                        <div class="info"></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Expiry Date</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" name="expiryDate"
                                       id="expiryDate" placeholder="DD/MM/YYYY" aria-describedby="basic-addon1"
                                       tabindex="9"/>
                            </div>
                        </div>
                        <div class="info"></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Remarks</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="remarks"
                                       id="remarks" placeholder="Remarks" aria-describedby="basic-addon1"
                                       tabindex="10"/>
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

<!--Delete Documents Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Document?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteDocumentsForm">
                            <input type="text" class="hidden" name="documentsCode" id="form-delete-code"/>
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
                    <input type="text" class="hidden" name="documentsCode" id='documentsCodeForImage'/>

                    <div class="form-group row">
                        <center>
                            <div class="col-sm-12 col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-5">
                                    <label class="control-label">Select Image</label>
                                    <br>
                                    <br>

                                    <div class='input-group'>
                                        <input id='documentsImgInputPath' name='documentsImgInputPath'
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
                                                onclick="pageDocuments.deleteDocumentsImage(1)">
                                            Delete Image
                                        </button>
                                    </div>
                                    <div class="delete-btn-padding">
                                        <button type="button" class="btn btn-danger" id="deleteAllImageBtn"
                                                onclick="pageDocuments.deleteDocumentsImage(2)">
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
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                            <a href="#" onclick="" class="clickable">
                                <img src="../img/default/preferences/logo.png" class="img-thumbnail modal-img-size">
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="progress hidden" id="documentsUploadProgress">
                <div class="progress-bar" id="documentsUploadProgressBar" role="progressbar" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100"
                     style="width: 0%;">
                    <span class="sr-only" id="documentsUploadProgressValue">0% Complete</span>
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
<script src="../dist/documents/script/script.js"></script>
<script src="../dist/date/script.js"></script>
<script>
    var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
</script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>