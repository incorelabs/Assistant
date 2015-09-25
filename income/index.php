<?php
session_start();
define("ROOT", "../");
//require_once ROOT.'db/Connection.php';

//$mysqli = getConnection();
include_once ROOT . 'dist/authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Income</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    include_once ROOT . 'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="../dist/css/style.css"/>
    <link rel="stylesheet" href="../dist/income/css/style.css"/>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script>
        var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
    </script>
    <script src="../dist/script/script.js"></script>
    <script src="../dist/date/script.js"></script>
    <script src="../dist/income/script/script.js"></script>
    <link rel="stylesheet" href="../dist/css/sidebar.css"/>
    <link rel="stylesheet" href="../dist/css/jquery_sidebar.css"/>
    <script src="../dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
        $(function () {
            $('nav#menu').mmenu();
        });
    </script>
</head>

<body>
<?php
define('PAGE_TITLE', 'Income');
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
        <div class="col-xs-12 col-md-5 col-padding" id="searchIncomeHeader">
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
                            <button class="btn btn-primary btn-size" onclick="pageIncome.openAddIncomeModal();">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-xs-12 col-sm-12 hidden-sm hidden-xs" id="incomeDetailHeaderDiv">
            <div class="panel panel-default panelHeight list-margin" id="style-3">
                <div id="incomeDetailHeader" class="panel-heading text-center">
                    <h12>Income Details</h12>
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->
    </div>
    <!--row-->
    <div class="row">

        <div class="col-md-5 col-sm-12 col-xs-12 col-padding" id="incomeListDiv">
            <div class="panel panel-default panelHeight panel-margin" id="incomeListScroll">
                <div class="panel-height">
                    <!-- List group -->
                    <div id="incomeList" class="list-group force-scroll mobile-list">
                    </div>
                    <!--List close-->
                </div>
            </div>
            <!--Panel-->
        </div>
        <!--COL-->

        <div class="col-md-7 col-sm-12 col-xs-12 hidden-sm hidden-xs" id="incomeDetailDiv">
            <div id="incomeDetail" class="panel panel-default panelHeight panel-margin">
                <div class='panel-height'>
                    <!-- List group -->
                    <div class="list-group">
                        <div id="incomeDetailBody" class='list-group-item list-group-item-border'>
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

<!-- Add Income Modal -->
<div class="modal fade" id="incomeModal" tabindex="-1" role="dialog" aria-labelledby="incomeModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="controller.php" id="incomeForm" autocomplete="off">
                <div class="modal-header">
                    <div class="form-group pull-left" style="margin-top:-5px">
                        <button class="btn btn-danger button-top-remove" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span>
                        </button>
                    </div>
                    <div class="form-group pull-right" style="margin-top:-5px">
                        <button type="submit" class="btn btn-success button-top-remove">
                            <span class='glyphicon glyphicon-ok'></span>
                        </button>
                    </div>
                    <h4 id="incomeModalHeading" class="modal-title text-center">
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="text" class="hidden" name="incomeTypeCode" id="incomeTypeCode" value="1"/>
                    <input type="text" class="hidden" name="contactCode" id="contactCode" value="1"/>
                    <input type="text" class="hidden" name="incomeCode" id="form-add-edit-code"/>
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
                            <span class="input-group-addon input-group-addon-label">Income Type*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-key hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="incomeTypeName"
                                       id="incomeTypeName" placeholder="Income Type" tabindex="2" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Description*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="incomeName"
                                       id="incomeName" placeholder="Description" tabindex="3" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="info text-center"></div>
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Due From*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-user hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="fullName"
                                       id="fullName" placeholder="Due From" aria-describedby="basic-addon1" tabindex="4"
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
                            <span class="input-group-addon input-group-addon-label">Remarks</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-sticky-note-o hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border" name="incomeRemarks"
                                       id="incomeRemarks" placeholder="Remarks" aria-describedby="basic-addon1"
                                       tabindex="6"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="col-md-6 col-sm-12 col-xs-12 first-col-left-padding first-col-right-padding"
                             id="billingDayDiv">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Billing Day*</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-caret-down fa-size"></i>
                                    <select class="form-control select-field-left-border" name="billingDay"
                                            id="billingDay" aria-describedby="basic-addin1" tabindex="7" required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 second-col-left-padding second-col-right-padding"
                             id="dueDayDiv">
                            <div class="input-group">
                                <span class="input-group-addon input-group-addon-label">Due Day*</span>

                                <div class="inner-addon right-addon">
                                    <i class="fa fa-caret-down fa-size"></i>
                                    <select class="form-control select-field-left-border" name="dueDay" id="dueDay"
                                            aria-describedby="basic-addin1" tabindex="8" required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Frequency*</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-caret-down fa-size"></i>
                                <select class="form-control select-field-left-border" name="incomeFrequency"
                                        id="incomeFrequency" aria-describedby="basic-addin1" tabindex="9" required>
                                    <option value="1">Daily</option>
                                    <option value="2">Weekly</option>
                                    <option value="3">Fort Night</option>
                                    <option value="4">Monthly</option>
                                    <option value="5">Bi-Monthly</option>
                                    <option value="6">Quaterly</option>
                                    <option value="7">Half Yearly</option>
                                    <option value="8">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-margin">
                        <div class="input-group">
                            <span class="input-group-addon input-group-addon-label">Expiry Date</span>

                            <div class="inner-addon right-addon">
                                <i class="fa fa-calendar hidden-xs fa-size"></i>
                                <input type="text" class="form-control text-field-left-border date" name="expiryDate"
                                       id="expiryDate" placeholder="Expiry Date" aria-describedby="basic-addon1"
                                       tabindex="10" required/>
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

<!--Delete Income Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    Are you sure, you want to DELETE this Income?
                </h4>
            </div>
            <br>
            <center>
                <div class="modal-body">
                    <div class="btn-group">
                        <form method="POST" action="controller.php" id="deleteIncomeForm">
                            <input type="text" class="hidden" name="incomeCode" id="form-delete-code"/>
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

</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>