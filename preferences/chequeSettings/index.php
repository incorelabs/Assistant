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
    <title>Assistant - Cheque Settings</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    include_once ROOT . 'dist/bootstrap.php';
    ?>

    <link rel="stylesheet" href="../../dist/preferences/chequeSettings/css/style.css"/>
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
    <script src="../../dist/preferences/chequeSettings/script/script.js"></script>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Cheque Settings');
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
        <button class="btn btn-primary" data-toggle="modal" data-target="#chequeModal">
            <i class="fa fa-plus fa-lg"></i>
        </button>
    </div>
    <div class="text-center">
        <table class="table table-top-margin borderless">
            <thead>
            <tr>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">#</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">Name</th>
                <th class="text-center col-md-1 col-sm-1 hidden-xs">A/C Holder Name</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">Continuous Feed</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">Print Feed</th>
                <th class="text-center col-md-1 col-sm-1 col-xs-1">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <tr>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">1</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Test</td>
                <td class="text-center col-md-1 col-sm-1 hidden-xs">Darshan</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Yes</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Left</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1"><a href="#" data-toggle="modal"
                                                                      data-target="#chequeModal"><i
                            class="fa fa-pencil fa-lg fa-green"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"
                                                                                                         data-toggle="modal"
                                                                                                         data-target="#deleteCheque"><i
                            class="fa fa-trash-o fa-lg fa-red"></i></a></td>
            </tr>
            <tr>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">2</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Test1</td>
                <td class="text-center col-md-1 col-sm-1 hidden-xs">-</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">No</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1">Middle</td>
                <td class="text-center col-md-1 col-sm-1 col-xs-1"><a href="#" data-toggle="modal"
                                                                      data-target="#chequeModal"><i
                            class="fa fa-pencil fa-lg fa-green"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"
                                                                                                         data-toggle="modal"
                                                                                                         data-target="#deleteCheque"><i
                            class="fa fa-trash-o fa-lg fa-red"></i></a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="chequeSettingsModal" tabindex="-1" role="dialog" aria-labelledby="chequeSettingsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="" id="chequeSettingsForm" autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left modal-header-btn-left">
                        <button class="btn btn-danger button-top-remove" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </button>
                    </div>
                    <div class="form-group pull-right modal-header-btn-right">
                        <button type="submit" class="btn btn-success button-top-remove">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 id="familyModalHeading" class="modal-title text-center">
                        Add Cheque
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="info text-center">*Please enter all the values in "mm" only</div>
                    <div class="form-group form-group-margin">
                        <table class="table borderless">
                            <thead>
                            <tr>
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Name</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="text" name="chequeName" id="chequeName"
                                           class="form-control input-height" placeholder="Cheque Name"/>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center col-md-1 col-sm-1 col-xs-1 border-remove table-padding"></th>
                                <th class="text-center col-md-1 col-sm-1 col-xs-1 border-remove table-padding">Top</th>
                                <th class="text-center col-md-1 col-sm-1 col-xs-1 border-remove table-padding">Left</th>
                                <th class="text-center col-md-1 col-sm-1 col-xs-1 border-remove table-padding">Wide</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="chequeDate">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding table-padding-first-row">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Date</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding table-padding-first-row">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="dateTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding table-padding-first-row">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="dateLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding table-padding-first-row">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="dateWidth" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeName">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Name</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="nameTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="nameLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="nameWidth"/>
                                </td>
                            </tr>
                            <tr id="chequeBearer">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Bearer</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="bearerTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="bearerLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="bearerWidth"/>
                                </td>
                            </tr>
                            <tr id="chequeRupeeLineOne">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Rupee Line 1</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="rupeeLineOneTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="rupeeLineOneLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="rupeeLineOneWidth"/>
                                </td>
                            </tr>
                            <tr id="chequeRupeeLineTwo">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Rupee Line 2</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="rupeeLineTwoTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="rupeeLineTwoLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="rupeeLineTwoWidth"/>
                                </td>
                            </tr>
                            <tr id="chequeAmount">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Amount</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="amountTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="amountLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="amountWidth" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeAcctPayee">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">A/C Payee</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="acctPayeeTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="acctPayeeLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="acctPayeeWidth" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeNotExceed">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Not Exceeding</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="notExceedTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="notExceedLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="notExceedWidth" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeForHolderName">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">For Holder</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="text" name="forAcctName" id="forAcctName"
                                           class="form-control input-height" placeholder="For Holder Name"/>
                                </td>
                            </tr>
                            <tr id="chequeForHolderNamePosition">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">For Holder</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="forAcctNameTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="forAcctNameLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="forAcctNameWidth" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeSignatory">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Signatory</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="text" name="signatory" id="signatory"
                                           class="form-control input-height" placeholder="Signatory"/>
                                </td>
                            </tr>
                            <tr id="chequeSignatoryPosition">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Signatory</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top"
                                           id="forAcctNameTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left"
                                           id="forAcctNameLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide"
                                           id="forAcctNameWidth" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeDateSplit">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Date Split</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <select class="form-control input-height">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="chequeFeed">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Print Feed</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <select class="form-control input-height">
                                        <option value="left">Left</option>
                                        <option value="middle">Middle</option>
                                        <option value="right">Right</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="chequeContinuousFeed">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span
                                        class="input-group-addon-label text-left input-group-addon span-label-height label-border">Continuous Feed</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <select class="form-control input-height">
                                        <option value="yes">Yes</option>
                                        <option value="no" selected="selected">No</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal Body -->
            </form>
        </div>
        <!--modal-content-->
    </div>
    <!--modal dialog-->
</div>
<!--modal start-->
<!--Delete Contact Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
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
                        <form method="POST" action="controller.php" id="deleteChequeSettingsForm">
                            <input type="hidden" name="chequeCode" id="deleteFamilyCode"/>
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