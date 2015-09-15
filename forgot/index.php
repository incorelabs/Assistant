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

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    include_once ROOT . 'dist/bootstrap.php';
    ?>
    <link rel="stylesheet" type="text/css" href="../dist/css/style.css"/>
    <link rel="stylesheet" href="../dist/homePage/css/style.css"/>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script src="../dist/script/script.js"></script>
    <script src="../dist/forgot/script/script.js"></script>
    <link rel="stylesheet" href="../dist/css/sidebar.css"/>
    <link rel="stylesheet" href="../dist/css/jquery_sidebar.css"/>
    <script src="../dist/script/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript">
        $(function () {
            $('nav#menu').mmenu();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var forgotEmail = document.getElementById('forgotEmail'),
                forgotMobile = document.getElementById('forgotMobile');

            function enableToggle(current, other) {
                other.disabled = current.value.replace(/\s+/, '').length > 0 ? true : false;
            }

            forgotEmail.onkeyup = function () {
                enableToggle(this, forgotMobile);
            }
            forgotMobile.onkeyup = function () {
                enableToggle(this, forgotEmail);
            }
        });
    </script>
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
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>
