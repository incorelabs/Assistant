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
    <?php
        include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/preferences/chequeSettings/css/style.css"/>
</head>
<body>
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
        <button class="btn btn-primary" onclick="pageChequeSettings.openAddChequeSettingsModal();">
            <i class="fa fa-plus fa-lg"></i>
        </button>
    </div>
    <div>
        <table class="table table-top-margin borderless">
            <thead>
            <tr>
                <th class="col-md-1 col-sm-1 col-xs-1">#</th>
                <th class="col-md-3 col-sm-2 col-xs-1">Name</th>
                <th class="col-md-2 hidden-sm hidden-xs">A/C Holder Name</th>
                <th class="col-md-2 hidden-sm hidden-xs">Continuous Feed</th>
                <th class="col-md-2 col-sm-1 col-xs-1">Print Feed</th>
                <th class="col-md-2 col-sm-1 col-xs-1">Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            </tbody>
        </table>
    </div>
</div>


<!-- Add Cheque Modal -->
<div class="modal fade" id="chequeSettingsModal" tabindex="-1" role="dialog" aria-labelledby="chequeSettingsModal"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="chequeSettingsForm"
                  autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left modal-header-btn-left">
                        <a class="btn btn-danger button-top-remove" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </a>
                    </div>
                    <div class="form-group pull-right modal-header-btn-right">
                        <button type="submit" class="btn btn-success button-top-remove">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 id="chequeSettingsModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <input type="text" class="hidden" name="chequeCode" id="form-add-edit-code"/>
                <input type="text" class="hidden" name="mode" id="form-add-edit-mode"/>

                <div class="modal-body">
                    <div class="info text-center">*Please enter all the values in "mm" only</div>
                    <div class="form-group form-group-margin">
                        <table class="table borderless">
                            <thead>
                            <tr>
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Name*</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="text" name="chequeName" id="chequeName" class="form-control input-height" placeholder="Cheque Name" required/>
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
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Date*</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding table-padding-first-row">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="dateTop" id="dateTop" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding table-padding-first-row">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="dateLeft" id="dateLeft" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding table-padding-first-row">
                                    <input type="number" class="form-control input-height" placeholder="Wide" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeName">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Name*</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="nameTop" id="nameTop" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="nameLeft" id="nameLeft" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide" name="nameWidth" id="nameWidth" required/>
                                </td>
                            </tr>
                            <tr id="chequeBearer">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Bearer</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="bearerTop" id="bearerTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="bearerLeft" id="bearerLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide" name="bearerWidth" id="bearerWidth"/>
                                </td>
                            </tr>
                            <tr id="chequeRupeeLineOne">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Rupee Line 1*</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="rupee1Top" id="rupee1Top" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="rupee1Left" id="rupee1Left" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide" name="rupee1Width" id="rupee1Width" required/>
                                </td>
                            </tr>
                            <tr id="chequeRupeeLineTwo">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Rupee Line 2*</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="rupee2Top" id="rupee2Top" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="rupee2Left" id="rupee2Left" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide" name="rupee2Width" id="rupee2Width" required/>
                                </td>
                            </tr>
                            <tr id="chequeAmount">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Amount*</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="rsTop" id="rsTop" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="rsLeft" id="rsLeft" required/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeAcctPayee">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">A/C Payee</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="acPayeeTop" id="acPayeeTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="acPayeeLeft" id="acPayeeLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeNotExceed">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Not Exceeding</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="notExceedTop" id="notExceedTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="notExceedLeft" id="notExceedLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeForHolderName">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">For Holder</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="text" class="form-control input-height" placeholder="For Holder Name" name="forAcName" id="forAcName"/>
                                </td>
                            </tr>
                            <tr id="chequeForHolderNamePosition">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">For Holder</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="forAcNameTop" id="forAcNameTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="forAcNameLeft" id="forAcNameLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeSignatory">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Signatory</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="text" class="form-control input-height" placeholder="Signatory" name="signatoryName" id="signatoryName"/>
                                </td>
                            </tr>
                            <tr id="chequeSignatoryPosition">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Signatory</span>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Top" name="signatoryNameTop" id="signatoryNameTop"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Left" name="signatoryNameLeft" id="signatoryNameLeft"/>
                                </td>
                                <td class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <input type="number" class="form-control input-height" placeholder="Wide" disabled="disabled"/>
                                </td>
                            </tr>
                            <tr id="chequeDateSplit">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Date Split</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <select class="form-control input-height" name="dateSplit" id="dateSplit">
                                        <option value="1" selected="selected">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="chequeFeed">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Print Feed</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <select class="form-control input-height" name="chequeFeed" id="chequeFeed">
                                        <option value="1" selected="selected">Left</option>
                                        <option value="2">Middle</option>
                                        <option value="3">Right</option>
                                </td>
                            </tr>
                            <tr id="chequeContinuousFeed">
                                <td class="col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <span class="input-group-addon-label text-left input-group-addon span-label-height label-border">Continuous Feed</span>
                                </td>
                                <td colspan="3" class="text-center col-md-1 col-sm-1 col-xs-1 table-padding">
                                    <select class="form-control input-height" name="continousFeed" id="continousFeed">
                                        <option value="1">Yes</option>
                                        <option value="2" selected="selected">No</option>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal Body -->
                </div>
            </form>
        </div>
        <!--modal-content-->
    </div>
</div>
<!--modal-->

<!--Delete Cheque Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Cheque Setting?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteChequeSettingsForm">
                            <input type="text" class="hidden" name="chequeCode" id="form-delete-code"/>
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

<?php
    include_once ROOT.'dist/fetchJS.php';
?>
<script src="../../dist/preferences/chequeSettings/script/script.js"></script>
<script src="../../dist/date/script.js"></script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>