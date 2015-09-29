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
    <title>Assistant - Import Contacts</title>
    <?php
    include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/preferences/importContacts/css/style.css"/>
</head>
<body>
<!-- fixed top navbar -->
<?php
define('PAGE_TITLE', 'Import Contacts');
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
        <div class='panel panel-primary'>

                <div class='panel-heading text-center'>Assistant Template</div>
                <div class='panel-body panel-body-height'>
                    <div class="text-center input-group">
                        <input id="AssistantUpload" name="AssistantUpload" class="form-control" placeholder="Choose File" disabled="disabled" />
                        <div class="input-group-btn">
                            <div class="fileUpload btn btn-primary">
                                <span>Upload</span>
                                <input type="file" class="upload" id="AssistantUploadBtn" name="AssistantUploadBtn"/>
                            </div>
                        </div>
                    </div>
                    <div class="input-padding text-center">
                        <a href="download.php?file=Assistant_Contacts_Template.csv"><button class="btn btn-primary">Download Template <i class="fa fa-download"></i></button></a>
                        <button class="btn btn-success">Submit</button>
                    </div>
                </div>

        </div>
    </div>
    <div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
        <div class='panel panel-success'>

                <div class='panel-heading text-center'>Outlook</div>
                <div class='panel-body panel-body-height'>
                    <div class="text-center input-group">
                        <input id="outlookUpload" name="outlookUpload" class="form-control" placeholder="Choose File" disabled="disabled" />
                        <div class="input-group-btn">
                            <div class="fileUpload btn btn-primary">
                                <span>Upload</span>
                                <input type="file" class="upload" id="outlookUploadBtn" name="outlookUploadBtn"/>
                            </div>
                        </div>
                    </div>
                    <div class="input-padding text-center">
                        <button class="btn btn-primary">Download Template <i class="fa fa-download"></i></button>
                        <button class="btn btn-success">Submit</button>
                    </div>
                </div>

        </div>
    </div>
    <div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
        <div class='panel panel-danger'>

                <div class='panel-heading text-center'>Import from Google Contacts</div>
                <div class='panel-body panel-body-height'>
                    <div class="input-padding text-center">
                        <div class="googleBtn" id="googleBtn">
                            <a href="#">
                                <span class="icon"><i class="fa fa-google fa-2x"></i></span>
                                <span class="buttonText">Google</span>
                            </a>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
<?php
include_once ROOT.'dist/fetchJS.php';
?>
<script src="../../dist/preferences/importContacts/script/script.js"></script>
</body>
</html>