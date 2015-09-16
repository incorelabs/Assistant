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
    <title>Assistant - Label Settings</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    include_once ROOT . 'dist/bootstrap.php';
    ?>

    <link rel="stylesheet" href="../../dist/preferences/labelSettings/css/style.css"/>
    <link rel="stylesheet" href="../../dist/css/style.css"/>
    <script src="http://malsup.github.com/jquery.form.js"></script>

    <!-- Header Links -->
    <link type="text/css" rel="stylesheet" href="../../dist/css/sidebar.css"/>
    <link type="text/css" rel="stylesheet" href="../../dist/css/jquery_sidebar.css"/>
    <script type="text/javascript" src="../../dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
        $(function () {
            $('nav#menu').mmenu();
        });
    </script>
    <script src="../../dist/script/script.js"></script>
    <script src="../../dist/preferences/labelSettings/script/script.js"></script>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Label Settings');
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
        <button class="btn btn-primary" data-toggle="modal" data-target="#labelSettingsModal">
            <i class="fa fa-plus fa-lg"></i>
        </button>
    </div>
    <div class="text-center">
        <table class="table table-top-margin borderless">
            <thead>
            <tr>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">#</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-3">Logo</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-3">Name</th>
                <th class="text-center col-md-1 col-sm-1 hidden-xs">Rows</th>
                <th class="text-center col-md-1 col-sm-1 hidden-xs">Columns</th>
                <th class="text-center col-md-1 col-sm-1 hidden-xs">Lines in Label</th>
                <th class="text-center col-md-1 col-sm-1 hidden-xs">Single Content</th>
                <th class="text-center col-md-1 col-sm-1 hidden-xs">Orientation</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-3">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <tr>
                <td class="text-center text-middle col-md-1 col-sm-1 col-xs-1">1</td>
                <td class="text-center text-middle col-md-1 col-sm-1 col-xs-3">
                    <div class='image'>
                        <a data-toggle='modal' data-target='#imageModal' class='clickable'>
                            <img src='../../img/default/preferences/logo.png' id='imageResource' alt='...'
                                 class='img-rounded'/>

                            <div class='overlay img-rounded'>
                                <span class='glyphicon glyphicon-pencil overlay-icon'></span>
                            </div>
                        </a>
                    </div>
                </td>
                <td class="text-center text-middle col-md-1 col-sm-1 col-xs-3">Test</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">7</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">3</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">5</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">No</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">Portrait</td>
                <td class="text-center text-middle col-md-1 col-sm-1 col-xs-3">
                    <a href="#" data-toggle="modal" data-target="#labelSettingsModal">
                        <i class="fa fa-pencil fa-lg fa-green"></i>
                    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" data-toggle="modal" data-target="#deleteModal">
                        <i class="fa fa-trash-o fa-lg fa-red"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-center text-middle col-md-1 col-sm-1 col-xs-1">2</td>
                <td class="text-center text-middle col-md-1 col-sm-1 col-xs-3">
                    <div class='image disabledLogo'>
                        <a data-toggle='modal' data-target='#imageModal' class='clickable disable-anchor'>
                            <img src='../../img/default/preferences/logo.png' id='imageResource' alt='...'
                                 class='img-rounded'/>

                            <div class='overlay-default img-rounded'>
                                <span class='glyphicon glyphicon-remove overlay-icon'></span>
                            </div>
                        </a>
                    </div>
                </td>
                <td class="text-center text-middle col-md-1 col-sm-1 col-xs-3">Test1</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">21</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">7</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">2</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">Yes</td>
                <td class="text-center text-middle col-md-1 col-sm-1 hidden-xs">Landscape</td>
                <td class="text-center text-middle col-md-1 col-sm-1 col-xs-3">
                    <a href="#" data-toggle="modal" data-target="#labelSettingsModal">
                        <i class="fa fa-pencil fa-lg fa-green"></i>
                    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" data-toggle="modal" data-target="#deleteModal">
                        <i class="fa fa-trash-o fa-lg fa-red"></i>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Label Modal -->
<div class="modal fade" id="labelSettingsModal" tabindex="-1" role="dialog" aria-labelledby="labelSettingsModal"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="" id="labelSettingsForm" autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left" style="padding-left:15px">
                        <button class="btn btn-danger button-top-remove" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </button>
                    </div>
                    <div class="form-group pull-right" style="padding-right:15px">
                        <button type="submit" class="btn btn-success button-top-remove">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 id="" class="modal-title text-center">
                        Add Label
                    </h4>
                </div>
                <input type="text" class="hidden" name="labelCode" id="form-add-edit-code"/>
                <input type="text" class="hidden" name="mode" id="form-add-edit-mode"/>

                <div class="modal-body">
                    <div class="info text-center">*Please enter all the values in "mm" only</div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Name</span>
                            <input type="text" name="labelName" id="labelName"
                                   class="form-control text-field-left-border" placeholder="Label Name"/>
                        </div>
                        <div class='info'></div>
                    </div>
                    <hr/>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Lines</span>
                            <input type="number" name="labelLines" id="labelLines"
                                   class="form-control text-field-left-border" placeholder="No. of Lines"/>
                        </div>
                        <div class='info'></div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Rows</span>
                                <input type="number" name="rowLabel" id="rowLabel"
                                       class="form-control text-field-left-border" placeholder="No. of Rows"/>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Columns</span>


                                <input type="number" name="columnLabel" id="columnLabel"
                                       class="form-control text-field-left-border" placeholder="No. of Cols"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Height</span>


                                <input type="number" name="labelHeight" id="labelHeight"
                                       class="form-control text-field-left-border" placeholder="Label Height"/>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Width</span>
                                <input type="number" name="labelWidth" id="labelHeight"
                                       class="form-control text-field-left-border" placeholder="Label Width"/>
                            </div>
                            <div class='info'></div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group form-group-margin">
                        <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Start Left</span>
                                <input type="number" name="startLeft" id="startLeft"
                                       class="form-control text-field-left-border" placeholder="Start Left"/>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Next Left</span>
                                <input type="number" name="nextLeft" id="nextLeft"
                                       class="form-control text-field-left-border" placeholder="Next Left"/>
                            </div>
                            <div class='info'></div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Start Top</span>
                                <input type="number" name="startTop" id="startTop"
                                       class="form-control text-field-left-border" placeholder="Start Top"/>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Next Top</span>
                                <input type="number" name="nextTop" id="nextTop"
                                       class="form-control text-field-left-border" placeholder="Next Top"/>
                            </div>
                            <div class='info'></div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group form-group-margin">
                        <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Content</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-caret-down fa-size"></i>
                                    <select id="singleContent" class="form-control select-field-left-border">
                                        <option value="Single Content">Single Content</option>
                                        <option value="Multiple Content">Multiple Content</option>
                                    </select>
                                </div>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Logo</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-caret-down fa-size"></i>
                                    <select id="logoPrint" class="form-control select-field-left-border">
                                        <option value="0">Yes</option>
                                        <option value="1" selected="selected">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class='info'></div>
                        </div>
                    </div>
                    <div id="logoDiv" style="display:none">
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Top</span>
                                    <input type="number" name="logoTop" id="logoTop"
                                           class="form-control text-field-left-border" placeholder="Logo Top"/>
                                </div>
                                <div class='info'></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Left</span>
                                    <input type="number" name="logoLeft" id="logoLeft"
                                           class="form-control text-field-left-border" placeholder="Logo Left"/>
                                </div>
                                <div class='info'></div>
                            </div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Height</span>
                                    <input type="number" name="logoHeight" id="logoHeight"
                                           class="form-control text-field-left-border" placeholder="Logo Height"/>
                                </div>
                                <div class='info'></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Width</span>
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
                            <span class="input-group-addon input-group-addon-label">Layout</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select id="logoPrint" class="form-control select-field-left-border">
                                    <option value="0">Portrait</option>
                                    <option value="1">Landscape</option>
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

<!--Delete Label Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Contact?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteLabelSettingsForm">
                            <input type="text" class="hidden" name="labelCode" id="form-delete-code"/>
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

            <form class="form-horizontal" method="" action="" enctype="multipart/form-data" id="" runat="server">

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
                    <input type="text" class="hidden" name="" id='photoId'/>

                    <div class="form-group row">
                        <center>
                            <div class="col-sm-12 col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-5">
                                    <label class="control-label">Select Image</label>
                                    <br>
                                    <br>
                                    <input type='file' id="imgInput" name="fileToUpload"
                                           style="padding-bottom:10px;" required/>

                                    <p id="imageErrorMsg"></p>
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
</html>