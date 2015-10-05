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
    <title>Assistant - Events</title>
    <?php
    include_once ROOT.'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="../../dist/events/inviteList/css/style.css"/>
</head>
<body>
<?php
define('PAGE_TITLE', 'Events');
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
<div class="navbar navbar-default navbar-padding">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header navbar-top-margin">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand hidden-sm hidden-md hidden-lg">Filter</span>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav col-md-12 col-sm-12 col-xs-12 navbar-bottom-padding sm-left-padding sm-right-padding-none">
                <div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="col-md-3 col-left-padding label-margin">
                            <span class="multiselect-label">State</span>
                        </div>
                        <div class="col-md-9 col-padding">
                            <div class="multiselect" id="countries" multiple="multiple" data-target="multi-0">
                                <div class="title noselect">
                                    <span class="text">Select</span>
                                    <span class="close-icon">&times;</span>
                                    <span class="expand-icon">&plus;</span>
                                </div>
                                <div class="multicontainer">
                                    <option value='Andaman and Nicobar Islands'>Andaman and Nicobar</option>
                                    <option value='Andhra Pradesh'>Andhra Pradesh</option>
                                    <option value='Arunachal Pradesh'>Arunachal Pradesh</option>
                                    <option value='Assam'>Assam</option>
                                    <option value='Bihar'>Bihar</option>
                                    <option value='Chandigarh'>Chandigarh</option>
                                    <option value='Chhattisgarh'>Chhattisgarh</option>
                                    <option value='Dadra and Nagar Haveli'>Dadra and Nagar Haveli</option>
                                    <option value='Daman and Diu'>Daman and Diu</option>
                                    <option value='Delhi'>Delhi</option>
                                    <option value='Goa'>Goa</option>
                                    <option value='Gujarat'>Gujarat</option>
                                    <option value='Haryana'>Haryana</option>
                                    <option value='Himachal Pradesh'>Himachal Pradesh</option>
                                    <option value='Jammu and Kashmir'>Jammu and Kashmir</option>
                                    <option value='Jharkhand'>Jharkhand</option>
                                    <option value='Karnataka'>Karnataka</option>
                                    <option value='Kerala'>Kerala</option>
                                    <option value='Lakshadweep'>Lakshadweep</option>
                                    <option value='Madhya Pradesh'>Madhya Pradesh</option>
                                    <option value='Maharashtra'>Maharashtra</option>
                                    <option value='Manipur'>Manipur</option>
                                    <option value='Meghalaya'>Meghalaya</option>
                                    <option value='Mizoram'>Mizoram</option>
                                    <option value='Nagaland'>Nagaland</option>
                                    <option value='Odisha'>Odisha</option>
                                    <option value='Puducherry'>Puducherry</option>
                                    <option value='Punjab'>Punjab</option>
                                    <option value='Rajasthan'>Rajasthan</option>
                                    <option value='Sikkim'>Sikkim</option>
                                    <option value='Tamil Nadu'>Tamil Nadu</option>
                                    <option value='Telengana'>Telengana</option>
                                    <option value='Tripura'>Tripura</option>
                                    <option value='Uttar Pradesh'>Uttar Pradesh</option>
                                    <option value='Uttarakhand'>Uttarakhand</option>
                                    <option value='West Bengal'>West Bengal</option>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 col-top-padding col-left-padding">
                        <div class="col-md-3 col-left-padding label-margin">
                            <span class="multiselect-label">City</span>
                        </div>
                        <div class="col-md-9 col-padding">
                            <div class="multiselect" id="state" multiple="multiple" data-target="multi-0">
                                <div class="title noselect">
                                    <span class="text">Select</span>
                                    <span class="close-icon">&times;</span>
                                    <span class="expand-icon">&plus;</span>
                                </div>
                                <div class="multicontainer">
                                    <option value="us">USA</option>
                                    <option value="fr">France</option>
                                    <option value="gr">Greece</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="ge">Germany</option>
                                    <option value="sp">Spain</option>
                                    <option value="it">Italy</option>
                                    <option value="ch">China</option>
                                    <option value="jp">Japan</option>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 col-top-padding col-left-padding">
                        <div class="col-md-3 col-left-padding label-margin">
                            <span class="multiselect-label">Group</span>
                        </div>
                        <div class="col-md-9 col-padding">
                            <div class="multiselect" id="group" multiple="multiple" data-target="multi-0">
                                <div class="title noselect">
                                    <span class="text">Select</span>
                                    <span class="close-icon">&times;</span>
                                    <span class="expand-icon">&plus;</span>
                                </div>
                                <div class="multicontainer">
                                    <option value="us">USA</option>
                                    <option value="fr">France</option>
                                    <option value="gr">Greece</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="ge">Germany</option>
                                    <option value="sp">Spain</option>
                                    <option value="it">Italy</option>
                                    <option value="ch">China</option>
                                    <option value="jp">Japan</option>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12 col-top-padding col-left-padding">
                        <div class="col-md-4 col-sm-12 col-left-padding label-margin">
                            <span class="multiselect-label">Invitees</span>
                        </div>
                        <div class="col-md-8 col-sm-12 select-padding">
                            <select class="form-control selectbox-height">
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12 col-top-padding col-left-padding search-button-top-padding btn-position">
                        <button class="btn btn-success">Submit</button>
                    </div>
                </div>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</div>
<div class="panel-container">
    <div class="panel panel-default panelHeight panel-margin" id="contactListScroll">
        <!-- List group -->
        <div class="panel-height">

            <div id="demo" class="fixedTable">
                <header class="fixedTable-header">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>D</th>
                            <th>E</th>
                            <th>F</th>
                            <th>G</th>
                            <th>H</th>
                            <th>I</th>
                            <th>J</th>
                            <th>K</th>
                            <th>L</th>
                        </tr>
                        </thead>
                    </table>
                </header>
                <aside class="fixedTable-sidebar">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>9</td>
                        </tr>
                        <tr>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>11</td>
                        </tr>
                        <tr>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td>13</td>
                        </tr>
                        <tr>
                            <td>14</td>
                        </tr>
                        <tr>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td>16</td>
                        </tr>
                        <tr>
                            <td>17</td>
                        </tr>
                        <tr>
                            <td>18</td>
                        </tr>
                        <tr>
                            <td>19</td>
                        </tr>
                        </tbody>
                    </table>
                </aside>
                <div class="fixedTable-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                            <td>e</td>
                            <td>f</td>
                            <td>g</td>
                            <td>h</td>
                            <td>i</td>
                            <td>j</td>
                            <td>k</td>
                            <td>l</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once ROOT.'dist/fetchJS.php';
?>
<script src="../../dist/events/inviteList/script/script.js"></script>
<script>
    var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
</script>
<script>
    (function () {
        var demo, fixedTable;
        fixedTable = function (el) {
            var $body, $header, $sidebar;
            $body = $(el).find('.fixedTable-body');
            $sidebar = $(el).find('.fixedTable-sidebar table');
            $header = $(el).find('.fixedTable-header table');
            return $($body).scroll(function () {
                $($sidebar).css('margin-top', -$($body).scrollTop());
                return $($header).css('margin-left', -$($body).scrollLeft());
            });
        };
        demo = new fixedTable($('#demo'));
    }.call(this));
</script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>