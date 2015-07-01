<?php
  define("ROOT", "../");

  require_once ROOT.'db/Connection.php';

  $mysqli = getConnection();

  $id = 0; 

  $sql = "SELECT MAX(contactCode) as 'contactCode' FROM contact";

  if ($result = $mysqli->query($sql)) {
    if ($result->num_rows == 0) {
      $id = 1001;
    }
    else{
      while ($row = $result->fetch_assoc()) {
        if (is_null($row['contactCode'])) {
          $id = 1001;     
        }
        else{
          $id = intval($row['contactCode']) + 1;
        }
      }
    }
  }
  else{

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

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!--jQuery UI-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

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
    <script>
    $(function() {
      var availableTags = [
        "Mr",
        "Mrs",
        "Miss",
        "Master"
      ];

      $( "#addTitle" ).autocomplete({
        source: availableTags
      });
    });
    </script>

  </head>
  <body>
    <!-- fixed top navbar -->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../">Assist</a>
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
          <!--<li><a href="#">Link</a></li>-->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Profile<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">My Account</a></li>
              <li><a href="#">Settings</a></li>
              <!--<li><a href="#">Something else here</a></li>-->
              <li class="divider"></li>
              <li><a href="#">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 col-sm-12">
        <div class="panel panel-default">
             <!-- List group -->
            <div class="list-group">
              <li class="list-group-item">
                <div class="row">
                  <div class="col-xs-9">
                    <input type="text" style="width: 105%; height: 35px;padding: 10px;" placeholder="Search..." />
                  </div>
                  <div class="col-xs-3">
                    <button class="btn btn-primary" style="width: 100%;" data-toggle="modal" data-target="#addModal">
                    Add
                    </button>
                  </div>
                </div>
              </li>
              <a href="#" class="list-group-item">
                <h4 class="list-group-item-heading">Kamlesh Bokdia</h4>
              </a>
              <a href="#" class="list-group-item">
                <h4 class="list-group-item-heading">Darshan Turakhia</h4>
              </a>
          </div><!--List close-->
        </div><!--Panel-->
      </div><!--COL-->

      <div class="col-md-8 col-sm-12 hidden-sm hidden-xs">
        <div class="panel panel-default">
            <div class="panel-heading text-center">Contact Details</div>
             <!-- List group -->  
              <div class="list-group">
                <div class="list-group-item">
                  <h4 class="list-group-item-heading">Name</h4>
                  <p class="list-group-item-text">Kamlesh Bokdia</p>
                </div>
                <div class="list-group-item">
                  <h4 class="list-group-item-heading">Company</h4>
                  <p class="list-group-item-text">Incore Labs.</p>
                </div>
                <div class="list-group-item">
                  <h4 class="list-group-item-heading">Designation</h4>
                  <p class="list-group-item-text">Director</p>
                </div>
              </div><!--List close-->
            
             
        </div><!--Panel-->
      </div><!--COL-->
    </div><!--ROW-->
  </div>
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form class="form-horizontal" method="POST" action="add.php" id="addContactForm">
        
        <div class="modal-header">

          <div class="btn-group pull-left">
            <button class="btn btn-danger" data-dismiss="modal">
              Cancel
            </button>
          </div>
        
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-check"></i>Save
            </button>
          </div>

          <h4 class="modal-title text-center">
              Add Contact
          </h4>   
        </div>  

        <div class="modal-body">
            <input type="hidden" name="id" id='contactCode' value='<?php echo $id; ?>' />
            <div class="form-group">
              <label class="col-xs-4 control-label">Title</label>
              <div class="col-xs-8 ui-widget">
                <input type="text" name="title" id="addTitle" placeholder="Title" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">First Name</label>
              <div class="col-xs-8">
                <input type="text" name="firstName" class="form-control" placeholder="First Name" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Middle Name</label>
              <div class="col-xs-8">
                <input type="text" name="middleName" class="form-control" placeholder="Middle Name" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Last Name</label>
              <div class="col-xs-8">
                <input type="text" name="lastName" class="form-control" placeholder="Last Name" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Father/Husband Name</label>
              <div class="col-xs-8">
                <input type="text" name="guardianName" class="form-control" placeholder="Father/Husband Name" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Company</label>
              <div class="col-xs-8">
                <input type="text" name="company" class="form-control" placeholder="Company" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Designation</label>
              <div class="col-xs-8">
                <input type="text" name="designation" class="form-control" placeholder="Designation" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Alias</label>
              <div class="col-xs-8">
                <input type="text" name="alias" class="form-control" placeholder="Alias" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Date of Birth</label>
              <div class="col-xs-8">
                <input type="text" name="dob" class="form-control" placeholder="Date of Birth" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Anniversary Date</label>
              <div class="col-xs-8">
                <input type="text" name="dom" class="form-control" placeholder="Anniversary Date" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Group</label>
              <div class="col-xs-8">
                <input type="text" name="group" class="form-control" placeholder="Group" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Comments</label>
              <div class="col-xs-8">
                <input type="text" name="remarks" class="form-control" placeholder="Comments" value="">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4"></div>
              <div class="col-xs-8">
                <label>
                  <input type="checkbox" name="activeStatus" checked="checked" /> Active Status
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Mobile</label>
              <div class="col-xs-8">
                <input type="text" name="mobile" class="form-control" placeholder="Phone" value="+">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Email</label>
              <div class="col-xs-8">
                <input type="email" name="email" class="form-control" placeholder="Email" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Facebook ID</label>
              <div class="col-xs-8">
                <input type="text" name="facebook" class="form-control" placeholder="Facebook ID"
                value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Twitter Handle</label>
              <div class="col-xs-8">
                <input type="text" name="twitter" class="form-control" placeholder="Twiter Handle"
                value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Google ID</label>
              <div class="col-xs-8">
                <input type="text" name="google" class="form-control" placeholder="Facebook ID"
                value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Linkedin ID</label>
              <div class="col-xs-8">
                <input type="text" name="linkedin" class="form-control" placeholder="Linkedin ID"
                value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">URL Address</label>
              <div class="col-xs-8">
                <input type="text" name="website" class="form-control" placeholder="URL Address"
                value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Address</label>
              <div class="col-xs-8">
                <input type="text" name="address" class="form-control" placeholder="Address"
                value="">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4"></div>
              <div class="col-xs-8">
                <label>
                  <input type="checkbox" name="privacy" /> Private
                </label>
              </div>
            </div>
          </div>
        </div>
                  
        </div>
        </form>

      </div><!--modal-content-->
    </div>
  </div><!--modal-->

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