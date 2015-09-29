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
    <title>Assistant - General Settings</title>
    <?php
    include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/preferences/generalSettings/css/style.css"/>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'General Settings');
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
<div class="text-right button-top-margin">
    <button class="btn btn-primary" onclick="pageLabelSettings.openAddLabelSettingsModal();">
        <i class="fa fa-plus fa-lg"></i>
    </button>
</div>
<div class='container' style='padding-top:50px'>
    <div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
        <div class='panel panel-success'>
            <div class='panel-heading text-center'>Advance Reminders</div>
            <div class='panel-body panel-body-height'>
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <label class="label-padding">Documents (in months)</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <select class="form-control" name="documentsReminder" id="documentsReminder">
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
                        </select>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <label class="label-padding">Investments (in Days)</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <select class="form-control" name="investmentsReminders" id="investmentsReminders">
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
                        </select>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <label class="label-padding">Assets (in Days)</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <select class="form-control" name="assetsReminders" id="assetsReminders">
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
                        </select>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <label class="label-padding">Expense (in Days)</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <select class="form-control" name="expenseReminders" id="expenseReminders">
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
                        </select>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <label class="label-padding">Income (in Days)</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <select class="form-control" name="incomeReminders" id="incomeReminders">
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
                        </select>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Reminder until confirmation?</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 switch-top-padding">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='confirmReminder' id='confirmReminder' class='switch-input' checked/>
                            <label for='confirmReminder' class='switch-label'></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
        <div class='panel panel-danger'>
            <div class='panel-heading text-center'>Active & Private</div>
            <div class='panel-body panel-body-height'>
                <div class="row">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Contacts</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 switch-top-padding">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='activeContacts' id='activeContacts' class='switch-input' checked/>
                            <label for='confirmReminder' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Investments</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 switch-top-padding">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='activeInvestments' id='activeInvestments' class='switch-input' checked/>
                            <label for='confirmReminder' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Assets</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 switch-top-padding">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='activeAssets' id='activeAssets' class='switch-input' checked/>
                            <label for='confirmReminder' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Documents</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 switch-top-padding">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='activeDocuments' id='activeDocuments' class='switch-input' checked/>
                            <label for='confirmReminder' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Expense</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 switch-top-padding">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='activeExpense' id='activeExpense' class='switch-input' checked/>
                            <label for='confirmReminder' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Income</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 switch-top-padding">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='activeIncome' id='activeIncome' class='switch-input' checked/>
                            <label for='confirmReminder' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Passwords</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 switch-top-padding">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='activePasswords' id='activePasswords' class='switch-input' checked/>
                            <label for='confirmReminder' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Events</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 switch-top-padding">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='activeEvents' id='activeEvents' class='switch-input' checked/>
                            <label for='confirmReminder' class='switch-label'></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
        <div class='panel panel-primary'>
            <div class='panel-heading text-center'>Other</div>
            <div class='panel-body panel-body-height'>
                <div class="row">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Investments Vouchers</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='investmentVoucher' id='investmentVoucher' class='switch-input' checked/>
                            <label for='investmentVoucher' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Assets Vouchers</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='assetVoucher' id='assetVoucher' class='switch-input' checked/>
                            <label for='assetVoucher' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Expense Vouchers</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='expenseVoucher' id='expenseVoucher' class='switch-input' checked/>
                            <label for='expenseVoucher' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Income Vouchers</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='incomeVoucher' id='incomeVoucher' class='switch-input' checked/>
                            <label for='incomeVoucher' class='switch-label'></label>
                        </div>
                    </div>
                </div>
                <div class="row row-top-padding">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <label>Unique Alias Name?</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class='switch switch-padding'>
                            <input type='checkbox' name='uniqueAlias' id='uniqueAlias' class='switch-input' checked/>
                            <label for='incomeVoucher' class='switch-label'></label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
include_once ROOT.'dist/fetchJS.php';
?>
<script src="../../dist/preferences/generalSettings/script/script.js"></script>
</body>
</html>