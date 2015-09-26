<?php
session_start();
define("ROOT", "../");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Forgot Password</title>
    <?php
        include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../dist/homePage/css/style.css"/>
</head>
<body>
<?php
define('PAGE_TITLE', 'Contact');
$root_location = ROOT;
include_once ROOT . 'dist/navbar_logout.php';
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
<div class="outer">
    <div class="middle">
        <div class="inner">
            <div class="panel panel-primary">
                <div class="panel-heading panel-header-height">
                    <h1 class="panel-title text-center" style="font-size: 20px;">Forgot Password</h1>
                </div>
                <form action="controller.php" method="POST" id="forgotPasswordForm">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="inner-addon left-addon">
                                <i class="fa fa-user" style="font-size: 20px;"></i>
                                <input type="email" class="form-control textbox_height" name="email" id="forgotEmail"
                                       placeholder="Email" autofocus="true"/>

                                <div class="info"></div>
                            </div>
                        </div>
                        <p class="text-center">OR</p>

                        <div class="form-group">
                            <div class="inner-addon left-addon">
                                <i class="glyphicon glyphicon-phone" style="font-size: 20px;"></i>
                                <input type="text" class="form-control textbox_height" name="mobile" id="forgotMobile"
                                       placeholder="Mobile"/>

                                <div class="info"></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                        </div>
                    </div>
                    <!--Footer-->
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    include_once ROOT.'dist/fetchJS.php';
?>
<script src="../dist/forgot/script/script.js"></script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>
