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
    include_once ROOT . 'dist/fetchCSS.php';
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
<div>
    <form name="eventInviteListForm" id="eventInviteListForm">
    <div class="navbar-padding">
        <div id="parent">
            <table id="fixTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="name-column">Name</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Group</th>
                    <th class="mobile-width">Mobile</th>
                    <th class="event-width">Event</th>
                    <th class="event-width">Sub Event Name 1</th>
                    <th class="serial-number">#</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Darshan A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840729849</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Vishal A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9884591641</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Atul A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840121566</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>Nita A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9940230666</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>Chetan Sanghvi</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840123456</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Kamlesh Bokdia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9444610605</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>Neelabh Pandey</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9876543210</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>Bharath Acha</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9629540040</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>Aman S Jain</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840102143</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>Pralith Chordia</td>
                    <td>Andaman & Nicobar</td>
                    <td>Some Place</td>
                    <td>Friends</td>
                    <td>9600123123</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Darshan A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840729849</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>Vishal A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9884591641</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>12</td>
                </tr>
                <tr>
                    <td>Atul A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840121566</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>Nita A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9940230666</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>Chetan Sanghvi</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840123456</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>Kamlesh Bokdia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9444610605</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>16</td>
                </tr>
                <tr>
                    <td>Neelabh Pandey</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9876543210</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>17</td>
                </tr>
                <tr>
                    <td>Bharath Acha</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9629540040</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>18</td>
                </tr>
                <tr>
                    <td>Aman S Jain</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840102143</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>19</td>
                </tr>
                <tr>
                    <td>Pralith Chordia</td>
                    <td>Andaman & Nicobar</td>
                    <td>Some Place</td>
                    <td>Friends</td>
                    <td>9600123123</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>20</td>
                </tr>
                <tr>
                    <td>Darshan A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840729849</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>21</td>
                </tr>
                <tr>
                    <td>Vishal A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9884591641</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>22</td>
                </tr>
                <tr>
                    <td>Atul A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840121566</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>23</td>
                </tr>
                <tr>
                    <td>Nita A Turakhia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9940230666</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>24</td>
                </tr>
                <tr>
                    <td>Chetan Sanghvi</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840123456</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>25</td>
                </tr>
                <tr>
                    <td>Kamlesh Bokdia</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9444610605</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>26</td>
                </tr>
                <tr>
                    <td>Neelabh Pandey</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9876543210</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>27</td>
                </tr>
                <tr>
                    <td>Bharath Acha</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9629540040</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>28</td>
                </tr>
                <tr>
                    <td>Aman S Jain</td>
                    <td>Tamil Nadu</td>
                    <td>Chennai</td>
                    <td>Friends</td>
                    <td>9840102143</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>29</td>
                </tr>
                <tr>
                    <td>Pralith Chordia</td>
                    <td>Andaman & Nicobar</td>
                    <td>Some Place</td>
                    <td>Friends</td>
                    <td>9600123123</td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>
                        <input type="checkbox" class="eventCheckbox" name="name1"/>
                        <input type="number" class="eventTextbox form-control text-width" name="" id=""
                               placeholder="Count" disabled/>
                    </td>
                    <td>30</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="submit-btn">
        <button type="submit" class="btn btn-success" name="submit">Submit</button>
    </div>
    </form>
</div>
<?php
include_once ROOT . 'dist/fetchJS.php';
?>
<script src="../../dist/events/inviteList/script/script.js"></script>
<script src="../../dist/events/inviteList/script/tableHeadFixer.js"></script>
<script>
    var familyCode = '<?php echo $_SESSION['familyCode']; ?>';
</script>
</body>
<div class="cover">
    <div id="pageLoading"></div>
</div>
</html>