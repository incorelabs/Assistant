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
    <link rel="stylesheet" href="<?php echo ROOT; ?>/dist/css/style.css">

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
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
    var contact;
    function getContact(id){
      $.ajax({
        method: "GET",
        url: "getContact.php",
        data: { 
            id: id
         }
      })
        .done(function(msg) {
          contact = JSON.parse(msg);
          setContactView(contact);
        });
    }

    function setContactView(arr){
      //var json = JSON.stringify(arr);
      var str = "<div class='panel-heading text-center'><h12>Contact Details</h12><button class='btn btn-success button_width pull-right' onclick='openEditContact();'>Edit</button><button class='btn btn-danger button_width pull-left' data-toggle='modal' data-target='#deleteModal'>Delete</button></div>";
      
      if (arr.fullName) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Name</h4><p class='list-group-item-text'>"+arr.fullName+"</p></div>";
      };

      if (arr.guardianName) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Guardian</h4><p class='list-group-item-text'>"+arr.guardianName+"</p></div>";
      };

      if (arr.company) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Company</h4><p class='list-group-item-text'>"+arr.company+"</p></div>";
      };

      if (arr.designation) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Designation</h4><p class='list-group-item-text'>"+arr.designation+"</p></div>";
      };

      if (arr.alias) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Alias</h4><p class='list-group-item-text'>"+arr.alias+"</p></div>";
      };
      
      if (arr.dob) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>D.O.B</h4><p class='list-group-item-text'>"+arr.dob+"</p></div>";
      };

      if (arr.dom) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>D.O.M</h4><p class='list-group-item-text'>"+arr.dom+"</p></div>";
      };

      if (arr.remarks) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Remarks</h4><p class='list-group-item-text'>"+arr.remarks+"</p></div>";
      };

      if (arr.mobile) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Mobile</h4><p class='list-group-item-text'>"+arr.mobile+"</p></div>";
      };

      if (arr.email) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Email</h4><p class='list-group-item-text'>"+arr.email+"</p></div>";
      };

      if (arr.facebook) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Facebook</h4><p class='list-group-item-text'>"+arr.facebook+"</p></div>";
      };

      if (arr.twitter) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Twitter</h4><p class='list-group-item-text'>"+arr.twitter+"</p></div>";
      };

      if (arr.google) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Google</h4><p class='list-group-item-text'>"+arr.google+"</p></div>";
      };

      if (arr.linkedin) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Linkedin</h4><p class='list-group-item-text'>"+arr.linkedin+"</p></div>";
      };

      if (arr.website) {
        str += "<div class='list-group-item'><h4 class='list-group-item-heading'>Website</h4><p class='list-group-item-text'>"+arr.website+"</p></div>";
      };

      $("#contactDetail").empty();
      $("#contactDetail").html(str);
    }

    function openAddContact () {
      document.getElementById("addContactForm").reset();
      $("#addModal").modal('show');
    }

    function openEditContact () {
      if (contact.firstName) {
        $('#addFirstName').val(contact.firstName);
      };

      if (contact.middleName) {
        $('#addMiddleName').val(contact.middleName);
      };

      if (contact.lastName) {
        $('#addMiddleName').val(contact.lastName);
      };

      if (contact.guardianName) {
        $('#addGuardianName').val(contact.guardianName);
      };

      if (contact.company) {
        $('#addCompany').val(contact.company);
      };

      if (contact.designation) {
        $('#addDesignation').val(contact.designation);
      };

      if (contact.alias) {
        $('#addAlias').val(contact.alias);
      };
      
      if (contact.dob) {
        $('#addDOB').val(contact.dob);
      };

      if (contact.dom) {
        $('#addDOM').val(contact.dom);
      };

      if (contact.remarks) {
        $('#addRemarks').val(contact.remarks);
      };

      if (contact.mobile) {
        $('#addMobile').val(contact.mobile);
      };

      if (contact.email) {
        $('#addEmail').val(contact.email);
      };

      if (contact.facebook) {
        $('#addFacebook').val(contact.facebook);
      };

      if (contact.twitter) {
        $('#addTwitter').val(contact.twitter);
      };

      if (contact.google) {
        $('#addGoogle').val(contact.google);
      };

      if (contact.linkedin) {
        $('#addLinkedin').val(contact.linkedin);
      };

      if (contact.website) {
        $('#addWebsite').val(contact.website);
      };

      $("#addModal").modal('show');
    }

    $(document).ready(function(event){
      getContact(0);
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
                    <input type="text" class="form-control search_text" placeholder="Search..." />
                  </div>
                  <div class="col-xs-3">
                    <button class="btn btn-primary" style="width: 100%;" onclick="openAddContact();">
                    Add
                    </button>
                  </div>
                </div>
              </li>
              <?php 
                $sql = "SELECT contactCode,fullName FROM contact ORDER BY fullName;";
                $str = "";
                if ($result = $mysqli->query($sql)) {
                  if ($result->num_rows == 0) {
                    $str = "<a href='#' class='list-group-item'>
                            <li class='list-group-item-text'>No contacts</li>
                          </a>";
                  }
                  else{
                    while ($row = $result->fetch_assoc()) {
                      $str .= "<a onclick='getContact(".$row['contactCode'].")' class='list-group-item'>
                              <h4 class='list-group-item-heading'>".$row['fullName']."</h4>
                            </a>";
                    }
                  }
                }

                echo $str;
                
              ?>
          </div><!--List close-->
        </div><!--Panel-->
      </div><!--COL-->

      <div class="col-md-8 col-sm-12 hidden-sm hidden-xs">
        <div id="contactDetail" class="panel panel-default">
            <div class="panel-heading text-center">
              <h12>Contact Details</h12>
            </div>

             <!-- List group -->  
              <div class="list-group">
                <div class="list-group-item">
                  <p class="list-group-item-text">Loading...</p>
                </div>
              </div><!--List close-->
            
             
        </div><!--Panel-->
      </div><!--COL-->
    </div><!--ROW-->
  </div>

  <!-- Add Contact Modal -->
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
                <input type="text" name="title" class="form-control title_css" id="addTitle" placeholder="Title" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">First Name</label>
              <div class="col-xs-8">
                <input type="text" name="firstName" id="addFirstName" class="form-control" placeholder="First Name" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Middle Name</label>
              <div class="col-xs-8">
                <input type="text" name="middleName" id="addMiddleName" class="form-control" placeholder="Middle Name" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Last Name</label>
              <div class="col-xs-8">
                <input type="text" name="lastName" id="addMiddleName" class="form-control" placeholder="Last Name" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Father/Husband Name</label>
              <div class="col-xs-8">
                <input type="text" name="guardianName" id="addGuardianName" class="form-control" placeholder="Father/Husband Name" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Company</label>
              <div class="col-xs-8">
                <input type="text" name="company" id="addCompany" class="form-control" placeholder="Company" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Designation</label>
              <div class="col-xs-8">
                <input type="text" name="designation" id="addDesignation" class="form-control" placeholder="Designation" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Alias</label>
              <div class="col-xs-8">
                <input type="text" name="alias" id="addAlias" class="form-control" placeholder="Alias" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Date of Birth</label>
              <div class="col-xs-8">
                <input type="text" name="dob" id="addDOB" class="form-control datepicker" placeholder="Date of Birth" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Anniversary Date</label>
              <div class="col-xs-8">
                <input type="text" name="dom" id="addDOM" class="form-control datepicker" placeholder="Anniversary Date" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Group</label>
              <div class="col-xs-8">
                <input type="text" name="group" id="addGroup" class="form-control" placeholder="Group" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Comments</label>
              <div class="col-xs-8">
                <input type="text" name="remarks" id="addRemarks" class="form-control" placeholder="Comments" />
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4"></div>
              <div class="col-xs-8">
                <label>
                  <input type="checkbox" id="addActiveStatus" name="activeStatus" checked="checked" /> Active Status
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Mobile</label>
              <div class="col-xs-8">
                <input type="text" name="mobile" id="addMobile" class="form-control" placeholder="Phone" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Email</label>
              <div class="col-xs-8">
                <input type="email" name="email" id="addEmail" class="form-control" placeholder="Email" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Facebook ID</label>
              <div class="col-xs-8">
                <input type="text" name="facebook" id="addFacebook" class="form-control" placeholder="Facebook ID" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Twitter Handle</label>
              <div class="col-xs-8">
                <input type="text" name="twitter" id="addTwitter" class="form-control" placeholder="Twiter Handle" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Google ID</label>
              <div class="col-xs-8">
                <input type="text" name="google" id="addGoogle" class="form-control" placeholder="Facebook ID" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Linkedin ID</label>
              <div class="col-xs-8">
                <input type="text" name="linkedin" id="addLinkedin" class="form-control" placeholder="Linkedin ID" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">URL Address</label>
              <div class="col-xs-8">
                <input type="text" name="website" id="addWebsite" class="form-control" placeholder="URL Address" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 control-label">Address</label>
              <div class="col-xs-8">
                <input type="text" name="address" id="addAddress" class="form-control" placeholder="Address" />
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4"></div>
              <div class="col-xs-8">
                <label>
                  <input type="checkbox" id="addPrivacy" name="privacy" /> Private
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
              <button class="btn btn-danger modal_button" data-dismiss="modal">
                Yes
              </button>
            </div>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <div class="btn-group">
              <button type="submit" class="btn btn-success modal_button" data-dismiss="modal">
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