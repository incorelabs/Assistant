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
    <title>Assistant - Envelope Settings</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    include_once ROOT . 'dist/authenticate.php';
    include_once ROOT . 'dist/bootstrap.php';
    ?>

    <link rel="stylesheet" href="../../dist/preferences/envelopeSettings/css/style.css"/>
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
    <script src="../../dist/date/script.js"></script>
    <script src="../../dist/preferences/envelopeSettings/script/script.js"></script>
    <script>
        $(document).ready(function () {
            $('#envelopeFrom').change(function () {
                if ($("#envelopeFrom").val() == "0") {
                    $("#fromDiv").css("display", "block");
                }
                else {
                    $("#fromDiv").css("display", "none");
                }
            });
            $('#logoPrint').change(function () {
                if ($("#logoPrint").val() == "0") {
                    $("#logoDiv").css("display", "block");
                }
                else {
                    $("#logoDiv").css("display", "none");
                }
            });
            $('#envelopeTitleSelect').change(function () {
                if ($("#envelopeTitleSelect").val() == "0") {
                    $("")
                    $("#envelopeCaptionDiv").css("display", "block");
                    $("#envelopeTitle").addClass("col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding");
                }
                else {
                    $("#envelopeCaptionDiv").css("display", "none");
                    $("#envelopeTitle").removeClass("col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding");
                }
            });
        });
    </script>
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
        <button class="btn btn-primary" data-toggle="modal" data-target="#envelopeModal">
            <i class="fa fa-plus fa-lg"></i>
        </button>
    </div>
    <div class="text-center">
        <table class="table table-top-margin borderless">
            <thead>
            <tr>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">#</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">Name</th>
                <th class="text-center col-md-1 col-sm-1 hidden-xs">From</th>
                <th class="text-center col-md-1 col-sm-1 hidden-xs">Caption</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">Logo</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">Print Feed</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <tr>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">1</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Test</td>
                <td class="text-center col-md-1 col-sm-1 hidden-xs">No</td>
                <td class="text-center col-md-1 col-sm-1 hidden-xs">Test</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Left</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">No</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1"><a href="#" data-toggle="modal"
                                                                      data-target="#envelopeModal"><i
                            class="fa fa-pencil fa-lg fa-green"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"
                                                                                                         data-toggle="modal"
                                                                                                         data-target="#deleteLabel"><i
                            class="fa fa-trash-o fa-lg fa-red"></i></a></td>
            </tr>
            <tr>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">2</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Test1</td>
                <td class="text-center col-md-1 col-sm-1 hidden-xs">Yes</td>
                <td class="text-center col-md-1 col-sm-1 hidden-xs">Test123</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Right</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Yes</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1"><a href="#" data-toggle="modal"
                                                                      data-target="#envelopeModal"><i
                            class="fa fa-pencil fa-lg fa-green"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"
                                                                                                         data-toggle="modal"
                                                                                                         data-target="#deleteLabel"><i
                            class="fa fa-trash-o fa-lg fa-red"></i></a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="envelopeModal" tabindex="-1" role="dialog" aria-labelledby="envelopeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="" id="form-label" autocomplete="off">
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
                    <h4 id="familyModalHeading" class="modal-title text-center">
                        Add Envelope
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="info text-center">*Please enter all the values in "mm" only</div>
                    <div class="form-group form-group-margin">
                        <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Name</span>
                                <input type="text" name="envelopeName" id="envelopeName"
                                       class="form-control text-field-left-border" placeholder="Envelope Name"/>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">From Req</span>
                                <div class="inner-addon right-addon">
                                    <i class="fa fa-caret-down fa-size"></i>
                                    <select class="form-control select-field-left-border" id="envelopeFrom">
                                        <option value="">From Required?</option>
                                        <option value="0">Yes</option>
                                        <option value="1">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="fromDiv" style="display:none">
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Top</span>
                                    <input type="number" name="fromTop" id="fromTop"
                                           class="form-control text-field-left-border" placeholder="From Top"/>
                                </div>
                                <div class='info'></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Left</span>
                                    <input type="number" name="fromLeft" id="fromLeft"
                                           class="form-control text-field-left-border" placeholder="From Left"/>
                                </div>
                                <div class='info'></div>
                            </div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Address</span>
                                <input type="text" name="fromAddress" id="fromAddress"
                                       class="form-control text-field-left-border" placeholder="From Address"/>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Line 1</span>
                                    <input type="text" name="fromLine1" id="fromLine1"
                                           class="form-control text-field-left-border" placeholder="Line 1"/>
                                </div>
                                <div class='info'></div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Line 2</span>
                                    <input type="text" name="fromLine2" id="fromLine2"
                                           class="form-control text-field-left-border" placeholder="Line 2"/>
                                </div>
                                <div class='info'></div>
                            </div>
                        </div>
                        <div class="form-group form-group-margin">
                            <div class="col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Line 3</span>
                                    <input type="text" name="fromLine3" id="fromLine3"
                                           class="form-control text-field-left-border" placeholder="Line 3"/>
                                </div>
                                <div class='info'></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-addon-label">Line 4</span>
                                    <input type="text" name="fromLine4" id="fromLine4"
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
                                <input type="number" name="topTop" id="toTop"
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
                        <div id="envelopeTitle">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Title</span>
                                <div class="inner-addon right-addon">
                                    <i class="fa fa-caret-down fa-size"></i>
                                    <select class="form-control select-field-left-border" id="envelopeTitleSelect">
                                        <option value="">Title Required?</option>
                                        <option value="0">Yes</option>
                                        <option value="1">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class='info'></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 second-col-left-padding second-col-right-padding" id="envelopeCaptionDiv" style="display: none">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Caption</span>
                                <input type="text" name="envelopeCaption" id="envelopeCaption"
                                       class="form-control text-field-left-border" placeholder="Envelope Caption"/>
                            </div>
                            <div class='info'></div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Logo</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-caret-down fa-size"></i>
                                    <select id="logoPrint" class="form-control select-field-left-border">
                                        <option value="">Include Logo?</option>
                                        <option value="0">Yes</option>
                                        <option value="1">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class='info'></div>
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
                        <div class="form-group form-group-margin">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Upload</span>
                                <input type="file" name="nextTop" id="nextTop"
                                       class="form-control text-field-left-border custom-file-input"
                                       placeholder=""/>
                            </div>
                            <div class='info'></div>
                        </div>
                        <hr/>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Feed</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select id="logoPrint" class="form-control select-field-left-border">
                                    <option value="">Envelope Feed</option>
                                    <option value="0">Left</option>
                                    <option value="1">Center</option>
                                    <option value="2">Right</option>
                                </select>
                            </div>
                        </div>
                        <div class='info'></div>
                    </div>
                </div>
        </div>
        <!-- Modal Body -->
    </div>
    </form>
</div>
<!--modal-content-->
</div>
</div><!--modal-->
<!--Delete Contact Modal-->
<div class="modal fade" id="deleteLabel" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
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
                        <form method="POST" action="controller.php" id="form-family-delete">
                            <input type="hidden" name="familyCode" id="deleteFamilyCode"/>
                            <input type="hidden" name="mode" id="form-delete-mode"/>
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
</body>
</html>