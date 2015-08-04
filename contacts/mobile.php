<?php
define("ROOT", "../");

require_once ROOT.'db/Connection.php';

$id = "1234567890";

$mysqli = getConnection();

$status = "";

if (isset($_GET['status']) && isset($_GET['controller'])) {
  if ($_GET['status'] == 1) {
    if ($_GET['controller'] == "add") {
      $status = "<div class='alert alert-success alert-dismissible' role='alert'>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  Contact have been added successfully.
                </div>";
    }
    elseif ($_GET['controller'] == 'edit') {
      $status = "<div class='alert alert-success alert-dismissible' role='alert'>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  Updated contact successfully !!!
                </div>";
    }
  }
  elseif ($_GET['status'] == 0) {
    if ($_GET['controller'] == "add") {
      $status = "<div class='alert alert-danger alert-dismissible' role='alert'>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  Something went wrong while adding the contact
                </div>";
    }
    elseif ($_GET['controller'] == 'edit') {
      $status = "<div class='alert alert-danger alert-dismissible' role='alert'>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  Contact was not updated. Please retry.
                </div>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assist - Contacts</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Optional theme -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->
    <!--jQuery UI-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>/dist/css/mobile-style.css">

    <!--Adding jquery file-->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--jQuery UI script-->
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script src="../dist/contacts/script/script.js"></script>
    <script src="../dist/contacts/script/validation.js"></script>

    <!--To show the div on button click -->
    <script>
      function showDiv() {
        var check = false;
        var e = document.getElementById('search_filter');
        if(e.style.display == "block")
        {
            document.getElementById('search_filter').style.display = "none";
            
        }
        else
           document.getElementById('search_filter').style.display = "block";  
      }
  
    </script>
  </head>
  <body>
    <!-- fixed top navbar -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        
        <a class="navbar-brand dropdown-toggle" href="../">Assist</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <!--
        <form class="navbar-form navbar-left" role="search">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>-->
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#" id="notification-trigger" onclick="showNotificationSuccess()">Success Notification</a></li>
          <li><a href="#" id="notification-trigger" onclick="showNotificationFailure()">Failure Notification</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Profile<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#"><span class='glyphicon glyphicon-user'></span>&nbspMy Account</a></li>
              <li><a href="#"><span class='glyphicon glyphicon-wrench'></span>&nbspSettings</a></li>
              <!--<li><a href="#">Something else here</a></li>-->
              <li class="divider"></li>
              <li><a href="#"><span class='glyphicon glyphicon-log-out'></span>&nbspLogout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

    <!-- 2nd Navbar -->
  <div><!-- edit you show/hide in this div-->
   <div class="navbar navbar-default navbar-bg navbar-fixed-top" style="margin-top:50px; height:60px;">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12" style="padding-top:12px">
        <form>
          <div class="form-group">
            <div class="col-md-10 col-sm-10 col-xs-10">
              <div class="input-group">
                <input id="searchContact" type="text" class="form-control" onkeyup="doSearch();" placeholder="Search..." autofocus />
                  <div class="input-group-btn">
                    <div class="btn-group btn-group1" role="group">
                      <div class="dropdown dropdown-lg">
                        <button type="button" class="btn btn1 btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false" onclick="showDiv()"><span class="glyphicon glyphicon-filter"></span></button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu" id="search_filter">
                          <form class="form-horizontal" role="form">
                            <div class="form-group" style="padding-bottom:30px;">
                              <label for="filter">Filter by</label>
                              <select class="form-control" id="filter">
                                <option value="name">Name</option>
                                <option value="mobile">Mobile</option>
                                <option value="email">Email</option>
                                <option value="company">Company</option>
                                <option value="designation">Designation</option>
                                <option value="guardian">Father/Husband</option>
                                <option value="birthday">Birthday</option>
                                <option value="anniversary">Anniversary</option>
                                <option value="group">Group</option>
                                <option value="home_area">Home Area</option>
                                <option value="home_city">Home City</option>
                                <option value="home_phone">Home Phone</option>
                                <option value="work_area">Work Area</option>
                                <option value="work_city">Work City</option>
                                <option value="work_phone">Work Phone</option>
                                <option value="other_area">Other Area</option>
                                <option value="other_city">Other City</option>
                                <option value="other_phone">Other Phone</option>
                              </select>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div>
                  <!--<button type="button" class="btn btn-info btn-size"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>-->
                  <button class="btn btn-primary btn-size" onclick="openAddContact();"><span class="glyphicon glyphicon-plus"></span></button>
              </div>
          </div>
        </form>
      </div><!-- /.navbar-collapse -->
      </div><!--/.row -->
    </div><!-- /.container-fluid -->
  </div>
</div><!--Closing Div of Show/Hide -->


<!-- 3rd Navbar for contact details header -->
  <!-- 2nd Navbar -->
  <div><!-- edit you show/hide in this div-->
   <div class="navbar navbar-default navbar-bg1 navbar-fixed-top" style="margin-top:110px; height:60px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" style="padding-top:12px">
          <center>
            <h12>Contact Details</h12>
            <button class='btn btn-success pull-right' onclick='openEditContact();'>
              <span class='glyphicon glyphicon-pencil'></span>
            </button>
            <button class='btn btn-danger pull-left' onclick='openDeleteModal("+((arr.contact) ? arr.contact.contactCode : "1")+")'>
              <span class='glyphicon glyphicon-trash'></span>
            </button>
          </center>
        </div>              
      </div><!-- /.navbar-collapse -->
    </div><!--/.row -->
  </div><!-- /.container-fluid -->
</div><!--Closing Div of Show/Hide -->

  <div class="container-fluid navbar-padding">
    <?php 
      echo $status; 
      //echo json_encode($group['code']);
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


<!--
    <div class="row">
      <div class="col-xs-12 col-md-5">
        <div class="list-group list-margin">
          <div class="list-group-item list-margin">
            <div class="row">
               <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                <div class="input-group">
                <input id="searchContact" type="text" class="form-control" onkeyup="doSearch();" placeholder="Search..." autofocus />
                  <div class="input-group-btn">
                    <div class="btn-group" role="group">
                      <div class="dropdown dropdown-lg">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false" onclick="showDiv()"><span class="glyphicon glyphicon-filter"></span></button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu" id="search_filter">
                          <form class="form-horizontal" role="form">
                            <div class="form-group">
                              <label for="filter">Filter by</label>
                              <select class="form-control" id="filter">
                                <option value="name">Name</option>
                                <option value="mobile">Mobile</option>
                                <option value="email">Email</option>
                                <option value="company">Company</option>
                                <option value="designation">Designation</option>
                                <option value="guardian">Father/Husband</option>
                                <option value="birthday">Birthday</option>
                                <option value="anniversary">Anniversary</option>
                                <option value="group">Group</option>
                                <option value="home_area">Home Area</option>
                                <option value="home_city">Home City</option>
                                <option value="home_phone">Home Phone</option>
                                <option value="work_area">Work Area</option>
                                <option value="work_city">Work City</option>
                                <option value="work_phone">Work Phone</option>
                                <option value="other_area">Other Area</option>
                                <option value="other_city">Other City</option>
                                <option value="other_phone">Other Phone</option>
                              </select>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div>
                  <button type="button" class="btn btn-info btn-size"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                  <button class="btn btn-primary btn-size" onclick="openAddContact();"><span class="glyphicon glyphicon-plus"></span></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    
      <div class="col-md-7 col-sm-10 hidden-sm hidden-xs">
        <div class="panel panel-default scroll list-margin" id="style-3">
          <div id="contactDetailHeader" class="panel-heading text-center" >
            <h12>Contact Details</h12>
          </div>
             
        </div>
      </div>
    </div>-->


    <div class="row row-margin-top" style="margin-top:100px">
      <div> <!-- Edit here -->
        <div class="col-md-5 col-sm-12 col-xs-12 panel-padding-remove">
          <div class="panel panel-default panel-margin" id="style-3">
               <!-- List group -->
              <div id="contactList" class="list-group force-scroll">
                <div class="list-group-item">
                  <p class="list-group-item-text">Loading...</p>
                </div>
            </div><!--List close-->
          </div><!--Panel-->
        </div><!--COL-->
      </div>  <!-- Edit div-->

      <div><!-- Edit here -->
        <div class="col-md-7 col-sm-12 hidden-sm hidden-xs panel-padding-remove">
          <div id="contactDetail" class="panel panel-default panel-margin" id="style-3">
               <!-- List group -->  
                <div id="contactDetailBody" class="list-group">
                  <div class="list-group-item">
                    <p class="list-group-item-text">Loading...</p>
                  </div>
                </div><!--List close-->
          </div><!--Panel-->
        </div><!--COL-->
      </div> <!-- Edit div -->
    </div><!--ROW-->
  </div>


  <!-- Add Contact Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form class="form-horizontal" method="POST" action="add.php" id="addContactForm" autocomplete="off">
        
        <div class="modal-header">

          <div class="form-group pull-left">
            <button class="btn btn-danger" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span>
              
            </button>
          </div>
        
          <div class="form-group pull-right">
            <button type="button" class="btn btn-success" onclick="submitContactForm(event);">
              <span class='glyphicon glyphicon-ok'></span>
            </button>
          </div>

          <h4 id="contactModalHeading" class="modal-title text-center">
              Add Contact
          </h4>   
        </div>  

        <div class="modal-body">
            <input type="hidden" name="id" id='contactCode' />
            <div class="form-group form-group-margin">
              <label class="col-xs-3 control-label">Private</label>
                <div class="col-xs-3">
                  <div class='switch switch-padding'>
                  <input type='checkbox' name='Private' id='addPrivacy' class='switch-input' >
                  <label for='addPrivacy' class='switch-label'></label>
                </div>
                </div>
              <label class="col-xs-3 control-label">Active</label>
              <div class="col-xs-3">
                <div class='switch switch-padding'>
                  <input type='checkbox' name='activeStatus' id='addActiveStatus' class='switch-input' checked='checked'>
                  <label for='addActiveStatus' class='switch-label'></label>
                </div>
              </div>
            </div>
            <input type="hidden" name="inputType" id="inputType" />
            <div class="form-group form-group-margin">
              <label class="col-xs-4 control-label">Title</label>
              <div class="col-xs-4">
                <div class="left-inner-addon">
                  <i class="glyphicon glyphicon-star"></i>
                  <input type="text" name="title" class="form-control" id="addTitle" placeholder="Title" autofocus/>
                </div>
              </div>
            </div>
            <input type="hidden" id="titleId" name="titleId" value="0" />
            <div class="form-group form-group-margin">
                <label class="col-xs-4 control-label">First Name</label>
                <div class="col-xs-7">
                  <div class="left-inner-addon ">
                  <i class="fa fa-user"></i>
                  <input type="text" name="firstName" id="addFirstName" class="form-control" placeholder="First Name"/>
                </div>
              </div>
            </div>
            <div class="form-group form-group-margin">
              <label class="col-xs-4 control-label">Middle Name</label>
              <div class="col-xs-7">
                <div class="left-inner-addon ">
                  <i class="fa fa-user"></i>
                  <input type="text" name="middleName" id="addMiddleName" class="form-control" placeholder="Middle Name" />
                </div>
              </div>
            </div>
            <div class="form-group form-group-margin">
              <label class="col-xs-4 control-label">Last Name</label>
              <div class="col-xs-7">
                <div class="left-inner-addon ">
                  <i class="fa fa-user"></i>
                  <input type="text" name="lastName" id="addLastName" class="form-control" placeholder="Last Name" />
                </div>
              </div>
            </div>
            <div class="form-group form-group-margin">
              <label class="col-xs-4 control-label">Mobile</label>
              <div class="col-xs-7">
                <div class="left-inner-addon ">
                  <i class="glyphicon glyphicon-phone"></i>
                  <input type="text" name="mobile" id="addMobile" class="form-control" placeholder="Mobile" />
                </div>
              </div>
            </div>
            <div class="form-group form-group-margin">
              <label class="col-xs-4 control-label">Email</label>
              <div class="col-xs-7">
                <div class="left-inner-addon ">
                  <i class="glyphicon glyphicon-envelope"></i>
                  <input type="email" name="email" id="addEmail" class="form-control" placeholder="Email" />
                </div>
              </div>
            </div>
            
            <div class="form-group form-group-margin">
              <ul class="nav nav-tabs nav-justified">
                <li><a href="#tab1" data-toggle="tab"><span class='glyphicon glyphicon-user'></span><br>Personal Details</a></li>
                <li><a href="#tab3" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span><br>Professional Details</a></li>
                <li><a href="#tab4" data-toggle="tab"><span class='glyphicon glyphicon-globe'></span><br>Social Details</a></li>
                <li><a href="#home" data-toggle="tab"><span class='glyphicon glyphicon-home'></span><br>Home Address</a></li>
                <li><a href="#work" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span><br>Work Address</a></li>
                <li><a href="#other" data-toggle="tab"><span class='glyphicon glyphicon-road'></span><br>Other Address</a></li>
                
                <!--<li><a href="#tab7" data-toggle="tab">Seventh</a></li>-->
              </ul>
            </div>
 
            <div class="tab-content">
                <div class="tab-pane" id="tab1">
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Father/Husband Name</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="glyphicon glyphicon-user"></i>
                        <input type="text" name="guardianName" id="addGuardianName" class="form-control" placeholder="Father/Husband Name" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Date of Birth</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-birthday-cake"></i>
                        <input type="text" name="dob" id="addDOB" class="form-control datepicker" placeholder="Date of Birth" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Anniversary Date</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-calendar"></i>
                        <input type="text" name="dom" id="addDOM" class="form-control datepicker" placeholder="Anniversary Date" />
                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="groupId" name="groupId" value="0" />
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Group</label>
                    <div class="col-xs-7 ui-widget">
                      <div class="left-inner-addon ">
                        <i class="glyphicon glyphicon-tag"></i>
                        <input type="text" name="group" id="addGroup" class="form-control" placeholder="Group" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Comments</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-comment"></i>
                        <input type="text" name="remarks" id="addRemarks" class="form-control" placeholder="Comments" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Alias</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="glyphicon glyphicon-user"></i>
                        <input type="text" name="alias" id="addAlias" class="form-control" placeholder="Alias" />
                      </div>
                    </div>
                  </div>
                  <!--
                  <div class="form-group form-group-margin">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-8">
                      <label>
                        <input type="checkbox" id="addActiveStatus" name="activeStatus" checked="checked" /> Active Status
                      </label>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-8">
                      <label>
                        <input type="checkbox" id="addPrivacy" name="privacy" /> Private
                      </label>
                    </div>
                  </div>-->
                </div>

                <!-- Start of Home tab -->
                <div class="tab-pane" id="home">
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Home Address</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-home"></i>
                        <input type="text" name="homeAddress1" id="homeAddress1" class="form-control" placeholder="Address 1" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-home"></i>
                        <input type="text" name="homeAddress2" id="homeAddress2" class="form-control" placeholder="Address 2" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-home"></i>
                        <input type="text" name="homeAddress3" id="homeAddress3" class="form-control" placeholder="Address 3" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-home"></i>
                        <input type="text" name="homeAddress4" id="homeAddress4" class="form-control" placeholder="Address 4" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-home"></i>
                        <input type="text" name="homeAddress5" id="homeAddress5" class="form-control" placeholder="Address 5" />
                      </div>
                    </div>
                  </div>                 
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">City</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="homeCity" id="homeCity" class="form-control" placeholder="City" />
                        <input type="hidden" id="homeCityCode" name="homeCityCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">State</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="homeState" id="homeState" class="form-control" placeholder="State" />
                        <input type="hidden" id="homeStateCode" name="homeStateCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Country</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="homeCountry" id="homeCountry" class="countryText form-control" placeholder="Country" />
                        <input type="hidden" id="homeCountryCode" name="homeCountryCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Pincode</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>  
                        <input type="text" name="homePincode" id="homePincode" class="form-control" placeholder="Pincode" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Area</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="homeArea" id="homeArea" class="form-control" placeholder="Area" />
                        <input type="hidden" id="homeAreaCode" name="homeAreaCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Phone</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-phone"></i>
                        <input type="text" name="homePhone" id="homePhone" class="form-control" placeholder="Phone" />
                      </div>
                    </div>
                  </div>
                </div>


                <!-- Start of Work Tab -->
                <div class="tab-pane" id="work">
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Work Address</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-briefcase"></i>
                        <input type="text" name="workAddress1" id="workAddress1" class="form-control" placeholder="Address 1" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-briefcase"></i>
                        <input type="text" name="workAddress2" id="workAddress2" class="form-control" placeholder="Address 2" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-briefcase"></i>
                        <input type="text" name="workAddress3" id="workAddress3" class="form-control" placeholder="Address 3" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-briefcase"></i>
                        <input type="text" name="workAddress4" id="workAddress4" class="form-control" placeholder="Address 4" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-briefcase"></i>
                        <input type="text" name="workAddress5" id="workAddress5" class="form-control" placeholder="Address 5" />
                      </div>
                    </div>
                  </div>                 
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">City</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="workCity" id="workCity" class="form-control" placeholder="City" />
                        <input type="hidden" id="workCityCode" name="workCityCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">State</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="workState" id="workState" class="form-control" placeholder="State" />
                        <input type="hidden" id="workStateCode" name="workStateCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Country</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="workCountry" id="workCountry" class="countryText form-control" placeholder="Country" />
                        <input type="hidden" id="workCountryCode" name="workCountryCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Pincode</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>  
                        <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Area</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="workArea" id="workArea" class="form-control" placeholder="Area" />
                        <input type="hidden" id="workAreaCode" name="workAreaCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Phone</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-phone"></i>
                        <input type="text" name="workNumber" id="workNumber" class="form-control" placeholder="Phone" />
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Start of Others Pane -->
                <div class="tab-pane" id="other">
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Other Address</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-road"></i>
                        <input type="text" name="otherAddress1" id="otherAddress1" class="form-control" placeholder="Address 1" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-road"></i>
                        <input type="text" name="otherAddress2" id="otherAddress2" class="form-control" placeholder="Address 2" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-road"></i>
                        <input type="text" name="otherAddress3" id="otherAddress3" class="form-control" placeholder="Address 3" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-road"></i>
                        <input type="text" name="otherAddress4" id="otherAddress4" class="form-control" placeholder="Address 4" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-road"></i>
                        <input type="text" name="otherAddress5" id="otherAddress5" class="form-control" placeholder="Address 5" />
                      </div>
                    </div>
                  </div>                 
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">City</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="otherCity" id="otherCity" class="form-control" placeholder="City" />
                        <input type="hidden" id="otherCityCode" name="otherCityCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">State</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="otherState" id="otherState" class="form-control" placeholder="State" />
                        <input type="hidden" id="otherStateCode" name="otherStateCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Country</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="otherCountry" id="otherCountry" class="countryText form-control" placeholder="Country" />
                        <input type="hidden" id="otherCountryCode" name="otherCountryCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Pincode</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>  
                        <input type="text" name="otherPincode" id="otherPincode" class="form-control" placeholder="Pincode" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Area</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-globe"></i>
                        <input type="text" name="otherArea" id="otherArea" class="form-control" placeholder="Area" />
                        <input type="hidden" id="otherAreaCode" name="otherAreaCode" value="0" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Phone</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-phone"></i>
                        <input type="text" name="otherNumber" id="otherNumber" class="form-control" placeholder="Phone" />
                      </div>
                    </div>
                  </div>
                </div>
              
                <!--Start of Profession Tab-->
                <div class="tab-pane" id="tab3">
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Company</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-building-o"></i>
                        <input type="text" name="company" id="addCompany" class="form-control" placeholder="Company" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Designation</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-building-o"></i>
                        <input type="text" name="designation" id="addDesignation" class="form-control" placeholder="Designation" />
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Start of Social Tab -->
                <div class="tab-pane" id="tab4">
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Facebook ID</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-facebook"></i>
                        <input type="text" name="facebook" id="addFacebook" class="form-control" placeholder="Facebook ID" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Twitter Handle</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-twitter"></i>
                        <input type="text" name="twitter" id="addTwitter" class="form-control" placeholder="Twiter Handle" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Google ID</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-google-plus"></i>
                        <input type="text" name="google" id="addGoogle" class="form-control" placeholder="Google ID" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">Linkedin ID</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-linkedin"></i>
                      <input type="text" name="linkedin" id="addLinkedin" class="form-control" placeholder="Linkedin ID" />
                    </div>
                  </div>
                  <div class="form-group form-group-margin">
                    <label class="col-xs-4 control-label">URL Address</label>
                    <div class="col-xs-7">
                      <div class="left-inner-addon ">
                        <i class="fa fa-link"></i>
                        <input type="text" name="website" id="addWebsite" class="form-control" placeholder="URL Address" />
                      </div>
                    </div>
                  </div>
                </div>
            </div>  
          </div>
        </div>   
        </div>
        </form>
      </div><!--modal-content-->
    </div>
  </div><!--modal-->

  <!--Delete Contact Modal-->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center">
              Are you sure, you want to DELETE this Contact?
          </h4>   
        </div>
        <br>
        <center>
          <div class="modal-body">
          <div class="btn-group">
            <form action="delete.php" method="POST">
              <input type="hidden" name="id" id="deleteContact" />
              <button class="btn btn-danger modal_button" type="submit">
                <span class='glyphicon glyphicon-ok'></span>&nbsp
                Yes
              </button>
            </form>
              
            </div>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <div class="btn-group">
              <button type="submit" class="btn btn-success modal_button" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span>&nbsp
                No
              </button>
            </div>
            <br>
            <br>
          </div>
        </center>
      </div><!--modal-content-->
    </div>
  </div><!--modal-->

  <!-- Image Modal -->
  <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">

        <form class="form-horizontal" method="POST" action="#" id="form1" runat="server">
        
        <div class="modal-header">

          <div class="btn-group pull-left">
            <button class="btn btn-danger" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span>
              
            </button>
          </div>
        
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-success">
              <span class='glyphicon glyphicon-ok'></span>
              
            </button>
          </div>

          <h4 class="modal-title text-center">
              Edit Image
          </h4>   
        </div>  

        <div class="modal-body">
            <input type="hidden" name="id" id='contactCode' />
            <div class="form-group row">
              <center>
              <div class="col-sm-12 col-md-12">
              <div class="col-lg-6 col-md-6 col-sm-5">
              <label class="control-label">Select Image</label>
                <br>              
                <br>
                <input type='file' id="imgInp" style="padding-bottom:10px;"/>          
              </div>
              <div class="col-lg-6 col-md-6 col-sm-4">
                <label class="control-label">Image Preview</label>
                <br>
                <br>
                <img src="../img/contacts/profile/profilePicture1.png" id="imagepreview" class="addImage">
              </div>
            </div>
            </center>
          </div>
        </div>
        </form>
      </div><!--modal-content-->
    </div>
  </div><!--modal-->


  <script>
    $(function() {
      $( ".datepicker" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: "1915:2015"
      });
    });
  </script>

  <script>

  function addContactClicked(){
    var data = $("#addContactForm").serializeArray();
    console.log(data); 
    $.ajax({
      method: "POST",
      url: "add.php",
      data: { 
          id: $('#id')
       }
    })
      .done(function( msg ) {
        console.log( "Data Saved: " + msg );
      });
     
  }

  </script>
  </body>
</html>
<?php //$mysqli->close(); ?>