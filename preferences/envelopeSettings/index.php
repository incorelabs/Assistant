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
    <title>Assistant - Envelope Settings</title>
    <?php
        include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/preferences/envelopeSettings/css/style.css"/>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Envelope Settings');
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
    <div class="text-right button-top-margin">
        <button class="btn btn-primary" onclick="pageEnvelopeSettings.openAddEnvelopeSettingsModal();">
            <i class="fa fa-plus fa-lg"></i>
        </button>
    </div>
    <div class="text-center">
        <table class="table table-top-margin borderless">
            <thead>
            <tr>
                <th class="col-md-1 col-sm-2 col-xs-2">#</th>
                <th class="col-md-1 col-sm-3 col-xs-3">Logo</th>
                <th class="col-md-1 col-sm-3 col-xs-3">Name</th>
                <th class="col-md-1 hidden-sm hidden-xs">From</th>
                <th class="col-md-1 hidden-sm hidden-xs">Caption</th>
                <th class="col-md-1 hidden-sm hidden-xs">Print Feed</th>
                <th class="col-md-1 col-sm-3 col-xs-3">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">

            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="envelopeSettingsModal" tabindex="-1" role="dialog" aria-labelledby="envelopeSettingsModal"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="envelopeSettingsForm"
                  autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left" style="padding-left:15px">
                        <a class="btn btn-danger button-top-remove" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </a>
                    </div>
                    <div class="form-group pull-right" style="padding-right:15px">
                        <button type="submit" class="btn btn-success button-top-remove">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 id="envelopeSettingsModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <input type="text" class="hidden" name="coverCode" id="form-add-edit-code"/>
                <input type="text" class="hidden" name="mode" id="form-add-edit-mode"/>

                <div class="modal-body">
                    <div class="info text-center">*Please enter all the values in "mm" only</div>
                    <div class="form-group form-group-margin">
                        <div class="col-md-12 col-sm-12 col-xs-12 first-col-left-padding first-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Name*</span>
                                <input type="text" name="coverName" id="coverName"
                                       class="form-control text-field-left-border" placeholder="Envelope Name"
                                       required/>
                            </div>
                            <div class='info'></div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">From Req</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" name="fromRequired"
                                        id="fromRequired">
                                    <option value="1">Yes</option>
                                    <option value="2" selected="selected">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="hidden" id="fromDiv">
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Top*</span>
                                    <input type="number" name="fromTop" id="fromTop"
                                           class="form-control text-field-left-border" placeholder="From Top"/>
                                </div>
                                <div class='info'></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Left*</span>
                                    <input type="number" name="fromLeft" id="fromLeft"
                                           class="form-control text-field-left-border" placeholder="From Left"/>
                                </div>
                                <div class='info'></div>
                            </div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Name*</span>
                                <input type="text" name="fromName" id="fromName"
                                       class="form-control text-field-left-border" placeholder="From Name"/>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Line 1</span>
                                    <input type="text" name="fromAdd1" id="fromAdd1"
                                           class="form-control text-field-left-border" placeholder="Line 1"/>
                                </div>
                                <div class='info'></div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Line 2</span>
                                    <input type="text" name="fromAdd2" id="fromAdd2"
                                           class="form-control text-field-left-border" placeholder="Line 2"/>
                                </div>
                                <div class='info'></div>
                            </div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Line 3</span>
                                    <input type="text" name="fromAdd3" id="fromAdd3"
                                           class="form-control text-field-left-border" placeholder="Line 3"/>
                                </div>
                                <div class='info'></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Line 4</span>
                                    <input type="text" name="fromAdd4" id="fromAdd4"
                                           class="form-control text-field-left-border" placeholder="Line 4"/>
                                </div>
                                <div class='info'></div>
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">To Top</span>
                                <input type="number" name="toTop" id="toTop"
                                       class="form-control text-field-left-border" placeholder="To Top"/>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">To Left</span>
                                <input type="number" name="toLeft" id="toLeft"
                                       class="form-control text-field-left-border" placeholder="To Left"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Caption</span>
                            <input type="text" name="caption" id="caption"
                                   class="form-control text-field-left-border" placeholder="Envelope Caption"/>
                        </div>
                        <div class='info'></div>
                    </div>
                    <hr/>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Logo</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" name="logoAvailable"
                                        id="logoAvailable">
                                    <option value="1">Yes</option>
                                    <option value="2" selected="selected">No</option>
                                </select>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="hidden" id="logoDiv">
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Top*</span>
                                    <input type="number" name="logoTop" id="logoTop"
                                           class="form-control text-field-left-border" placeholder="Logo Top"/>
                                </div>
                                <div class='info'></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Left*</span>
                                    <input type="number" name="logoLeft" id="logoLeft"
                                           class="form-control text-field-left-border" placeholder="Logo Left"/>
                                </div>
                                <div class='info'></div>
                            </div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Height*</span>
                                    <input type="number" name="logoHeight" id="logoHeight"
                                           class="form-control text-field-left-border" placeholder="Logo Height"/>
                                </div>
                                <div class='info'></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Width*</span>
                                    <input type="number" name="logoWidth" id="logoWidth"
                                           class="form-control text-field-left-border" placeholder="Logo Width"/>
                                </div>
                                <div class='info'></div>
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Feed</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" name="coverFeed" id="coverFeed">
                                    <option value="1">Left</option>
                                    <option value="2">Middle</option>
                                    <option value="3">Right</option>
                                </select>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this ENVELOPE?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteEnvelopeSettingsForm">
                            <input type="text" class="hidden" name="coverCode" id="form-delete-code"/>
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

            <form class="form-horizontal" method="POST" action="upload.php" enctype="multipart/form-data"
                  id="logoForm"
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
                    <input type="text" class="hidden" name="coverCode" id='photoId'/>

                    <div class="form-group row">
                        <center>
                            <div class="col-sm-12 col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-5">
                                    <label class="control-label">Select Image</label>
                                    <br>
                                    <br>
                                    <div class='input-group'>
                                        <input id='envelopeImgInputPath' name='envelopeImgInputPath' class='form-control' placeholder='Choose File' disabled='disabled' />
                                        <div class='input-group-btn'>
                                            <div class='fileUpload btn btn-primary'>
                                                <span>Upload</span>
                                                <input type='file' id="imgInput" name="fileToUpload" style="padding-bottom:10px;" class="upload" accept="image/gif, image/jpeg, image/png" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <p id="imageErrorMsg" class="info"></p>

                                    <div class="delete-btn-padding">
                                        <button type="button" class="btn btn-danger" id="deleteImageBtn"
                                                onclick="pageEnvelopeSettings.deleteCurrentLogo();">
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
<script src="../../dist/preferences/envelopeSettings/script/script.js"></script>
</body>
</html>