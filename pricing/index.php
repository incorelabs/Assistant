<?php
session_start();
define("ROOT", "../");
include_once ROOT . 'dist/authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Pricing</title>
    <?php
    include_once ROOT . 'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../dist/pricing/css/style.css"/>
</head>
<body>
<?php
define('PAGE_TITLE', 'Pricing');
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
<div class="container">
    <div class="row row-top-80 row-left-right-0">
        <div class="row text-center row-bottom-15">
            <h3>Our Pricing</h3>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">Trial</span>
                    </div>
                    <hr/>
                    <div class="pricing-plan-desc">
                        <p><span class="features-bold">500</span> Contacts</p>
                        <p><span class="features-bold">1</span> Event</p>
                        <p><span class="features-bold">5</span> Assets</p>
                        <p><span class="features-bold">5</span> Investments</p>
                        <p><span class="features-bold">5</span> Documents</p>
                        <p><span class="features-bold">5</span> Expense</p>
                        <p><span class="features-bold">5</span> Income</p>
                        <p><span class="features-bold">5</span> Password</p>
                        <p><span class="features-bold">5</span> Cheque Prints</p>
                        <p><span class="features-bold">5</span> Label Prints</p>
                        <p><span class="features-bold">5</span> Envelopes Prints</p>
                        <p><span class="features-bold">1 Month</span> Validity</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">FREE</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">Starter</span>
                    </div>
                    <hr/>
                    <div class="pricing-plan-desc">
                        <p><span class="features-bold">1000</span> Contacts</p>
                        <p><span class="features-bold">5</span> Events</p>
                        <p><span class="features-bold">2</span> Family Members</p>
                        <p><span class="features-bold">Unlimited</span> Assets</p>
                        <p><span class="features-bold">Unlimited</span> Investments</p>
                        <p><span class="features-bold">Unlimited</span> Documents</p>
                        <p><span class="features-bold">Unlimited</span> Expense</p>
                        <p><span class="features-bold">Unlimited</span> Income</p>
                        <p><span class="features-bold">Unlimited</span> Password</p>
                        <p><span class="features-bold">Unlimited</span> Cheque Prints</p>
                        <p><span class="features-bold">Unlimited</span> Label Prints</p>
                        <p><span class="features-bold">Unlimited</span> Envelopes Prints</p>
                        <p><span class="features-bold">Unlimited</span> Validity</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">&#8377;299</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">Pro</span>
                    </div>
                    <hr/>
                    <div class="pricing-plan-desc">
                        <p><span class="features-bold">5000</span> Contacts</p>
                        <p><span class="features-bold">25</span> Events</p>
                        <p><span class="features-bold">5</span> Family Members</p>
                        <p><span class="features-bold">Unlimited</span> Assets</p>
                        <p><span class="features-bold">Unlimited</span> Investments</p>
                        <p><span class="features-bold">Unlimited</span> Documents</p>
                        <p><span class="features-bold">Unlimited</span> Expense</p>
                        <p><span class="features-bold">Unlimited</span> Income</p>
                        <p><span class="features-bold">Unlimited</span> Password</p>
                        <p><span class="features-bold">Unlimited</span> Cheque Prints</p>
                        <p><span class="features-bold">Unlimited</span> Label Prints</p>
                        <p><span class="features-bold">Unlimited</span> Envelopes Prints</p>
                        <p><span class="features-bold">Unlimited</span> Validity</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">&#8377;599</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">Ultimate</span>
                    </div>
                    <hr/>
                    <div class="pricing-plan-desc">
                        <p><span class="features-bold">Unlimited</span> Contacts</p>
                        <p><span class="features-bold">Unlimited</span> Events</p>
                        <p><span class="features-bold">10</span> Family Members</p>
                        <p><span class="features-bold">Unlimited</span> Assets</p>
                        <p><span class="features-bold">Unlimited</span> Investments</p>
                        <p><span class="features-bold">Unlimited</span> Documents</p>
                        <p><span class="features-bold">Unlimited</span> Expense</p>
                        <p><span class="features-bold">Unlimited</span> Income</p>
                        <p><span class="features-bold">Unlimited</span> Password</p>
                        <p><span class="features-bold">Unlimited</span> Cheque Prints</p>
                        <p><span class="features-bold">Unlimited</span> Label Prints</p>
                        <p><span class="features-bold">Unlimited</span> Envelopes Prints</p>
                        <p><span class="features-bold">Unlimited</span> Validity</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">&#8377;999</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row row-left-right-0">
        <div class="row row-bottom-15 text-center">
            <h3>SMS Packs</h3>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">500<br/>Pack</span>
                    </div>
                    <hr/>
                    <div class="pricing-sms-desc">
                        <p>You can send upto a maximum of <span class="features-bold">500</span> SMSes to any of your contacts</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">&#8377;999</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">1500<br/>Pack</span>
                    </div>
                    <hr/>
                    <div class="pricing-sms-desc">
                        <p>You can send upto a maximum of <span class="features-bold">1500</span> SMSes to any of your contacts</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">&#8377;1999</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">2500<br/>Pack</span>
                    </div>
                    <hr/>
                    <div class="pricing-sms-desc">
                        <p>You can send upto a maximum of <span class="features-bold">2500</span> SMSes to any of your contacts</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">&#8377;4999</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">5000<br/>Pack</span>
                    </div>
                    <hr/>
                    <div class="pricing-sms-desc">
                        <p>You can send upto a maximum of <span class="features-bold">5000</span> SMSes to any of your contacts</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">&#8377;4999</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">7500<br/>Pack</span>
                    </div>
                    <hr/>
                    <div class="pricing-sms-desc">
                        <p>You can send upto a maximum of <span class="features-bold">7500</span> SMSes to any of your contacts</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">&#8377;4999</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
            <div class="panel panel-default panel-highlight">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="pricing-header">10000<br/>Pack</span>
                    </div>
                    <hr/>
                    <div class="pricing-sms-desc">
                        <p>You can send upto a maximum of <span class="features-bold">10000</span> SMSes to any of your contacts</p>
                    </div>
                    <hr/>
                    <div>
                        <button class="pricing-button">&#8377;4999</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once ROOT . 'dist/fetchJS.php';
?>
<script src="../dist/pricing/script/script.js"></script>
<script>
    var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
</script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>