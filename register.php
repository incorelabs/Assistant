<?php
define("ROOT", "");
require_once ROOT . 'db/Connection.php';
require_once ROOT . 'modules/functions.php';

$mysqli = getConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Sign Up</title>
    <?php
    include_once ROOT . 'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="dist/homePage/css/style.css"/>
</head>
<body>
<?php
include_once ROOT . 'dist/navbar_logout.php';
$root_location = ROOT;
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
        <div class="inner" style="padding-top:70px">
            <div class="panel panel-primary">
                <div class="panel-heading panel-header-height">
                    <h1 class="panel-title text-center" style="font-size: 24px;">Sign Up</h1>
                </div>
                <form action="" method="POST" id="signUpForm">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="inner-addon right-addon">
                                <i class="fa fa-user" style="font-size: 20px;"></i>
                                <input type="email" class="form-control textbox_height email" name="email" id="email"
                                       placeholder="Email ID" required/>
                            </div>
                            <div class="info"></div>
                        </div>
                        <div class="form-group">
                            <div class="inner-addon right-addon">
                                <i class="fa fa-key" style="font-size: 20px;"></i>
                                <input type="password" class="form-control textbox_height password" name="password"
                                       id="password" placeholder="Password" required/>
                            </div>
                            <div class="info"></div>
                        </div>
                        <div class="form-group">
                            <div class="inner-addon right-addon">
                                <i class="fa fa-key" style="font-size: 20px;"></i>
                                <input type="password" class="form-control textbox_height"
                                       name="confirmPassword" id="confirmPassword" placeholder="Confirm Password"
                                       required/>
                            </div>
                            <div class="info"></div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <div class="inner-addon right-addon">
                                <i class="fa fa-user" style="font-size: 20px;"></i>
                                <input type="text" class="form-control textbox_height name" name="name" id="name"
                                       placeholder="Name" required/>
                            </div>
                            <div class="info"></div>
                        </div>
                        <div class="form-group">
                            <div class="inner-addon right-addon">
                                <i class="fa fa-globe" style="font-size: 20px;"></i>
                                <select name="country" id="country" class="form-control textbox_height" required>
                                    <option value="">Select Country</option>
                                    <!--<option value="1046">India</option>-->
                                    <?php
                                    $sql = "SELECT CountryCode, CountryName FROM Table106 ORDER BY CountryName;";
                                    if ($result = $mysqli->query($sql)) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['CountryCode'] . "'>" . $row['CountryName'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>

                                <div class="info"></div>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="inner-addon right-addon">
                                <i class="glyphicon glyphicon-phone" style="font-size: 20px;"></i>
                                <input type="number" class="form-control textbox_height mobile" id="mobile"
                                       name="mobile"
                                       placeholder="Mobile" required/>

                                <div class="info"></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="form-group" style="padding-top: 10px;">
                            <button type="button" class="btn btn-primary form-control" id="register">Register</button>
                        </div>
                    </div>
                </form>
            </div>
            <p>Already Signed Up?<a href="login.php" style="color:blue">Login Here.</a></p>
        </div>
    </div>
</div>
<?php
include_once ROOT . 'dist/fetchJS.php';
?>
<script src="dist/script/register.js"></script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>