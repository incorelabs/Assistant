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

    <!-- Optional theme -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->
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
    <script>
    var contact;
    var contactCode = <?php echo $id; ?>;

    function getContactList(id){
      $.ajax({
        method: "GET",
        url: "getContact.php",
        data: { 
            list: 1
         }
      })
        .done(function(msg) {
          contact = JSON.parse(msg);
        });
    }

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

    function setContactViewList(arr){

    }

    function setContactView(arr){
      //var json = JSON.stringify(arr);
      var str = "<div class='panel-heading text-center'><h12>Contact Details</h12><button class='btn btn-success button_width pull-right ' onclick='openEditContact();'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbspEdit</button><button class='btn btn-danger button_width pull-left' onclick='openDeleteModal("+arr.contactCode+")'><span class='glyphicon glyphicon-trash'></span>&nbspDelete</button></div>";
      
      if (arr.photoUploaded) {

      }
      else{
        
      };
      //if (arr.fullName) {
        str += "<div class='list-group-item'><div class='image'><a data-toggle='modal' data-target='#imageModal' id='pop'><img src='../img/contacts/Darshan Turakhia.jpg' id='imageresource' alt='...' class='img-rounded pull-left'/><div class='overlay img-rounded pull-left'><span class='glyphicon glyphicon-pencil' style='padding-top:10px'></span></div></a></div><div class='pull-right'>Private&nbsp&nbsp<div class='switch'><input type='checkbox' name='Private' id='addPrivacy' class='switch-input'><label for='addPrivacy' class='switch-label'>Privacy</label></div></div><div class='header_font'>Name</div><div class='pull-right' style='padding-top:3px;'>Active Status&nbsp&nbsp<div class='switch' ><input type='checkbox' name='activeStatus' id='addActiveStatus' class='switch-input' checked='checked'><label for='addActiveStatus' class='switch-label'>Active Status</label></div></div><h4 class='list-group-item-heading'>"+((arr.fullName) ? arr.fullName : "")+"</h4></div>";
      //};

      //if (arr.fullName) {
      //  str += "<div class='list-group-item'><h4 class='list-group-item-heading header_font'>Name<value class='name'>"+((arr.fullName) ? arr.fullName : "")+"</value></h4></div>";
      //};

      if (arr.guardianName) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Guardian</div><value><div class='col-md-9'>"+arr.guardianName+"</div></value></div></div>";
      };

      //if (arr.company) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Company</div><value><div class='col-md-9'>"+((arr.company) ? arr.company : "" )+"</div></value></div></div>";
      //};

      //if (arr.designation) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Designation</div><value><div class='col-md-9'>"+((arr.designation) ? arr.designation : "")+"</div></value></div></div>";
      //};

      if (arr.alias) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Alias</div><value><div class='col-md-9'>"+arr.alias+"</div></value></div></div>";
      };
      
      if (arr.dob) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.B</div><value><div class='col-md-9'>"+arr.dob+"</div></value></div></div>";
      };

      if (arr.dom) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.M</div><value><div class='col-md-9'>"+arr.dom+"</div></value></div></div>";
      };

      if (arr.remarks) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>"+arr.remarks+"</div></value></div></div>";
      };

      //if (arr.mobile) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Mobile</div><value><div class='col-md-9'>"+((arr.mobile) ? arr.mobile : "")+"</div></value></div></div>";
      //};

      //if (arr.email) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Email</div><value><div class='col-md-9'>"+((arr.email) ? arr.email : "")+"</div></value></div></div>";
      //};

      if (arr.facebook) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Facebook</div><value><div class='col-md-9'>"+arr.facebook+"</div></value></div></div>";
      };

      if (arr.twitter) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Twitter</div><value><div class='col-md-9'>"+arr.twitter+"</div></value></div></div>";
      };

      if (arr.google) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Google</div><value><div class='col-md-9'>"+arr.google+"</div></value></div></div>";
      };

      if (arr.linkedin) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Linkedin</div><value><div class='col-md-9'>"+arr.linkedin+"</div></value></div></div>";
      };

      if (arr.website) {
        str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Website</div><value><div class='col-md-9'>"+arr.website+"</div></value></div></div>";
      };

      $("#contactDetail").empty();
      $("#contactDetail").html(str);
    }

    function openAddContact () {
      $("#addContactForm").attr("action","add.php");
      $("#contactCode").val(contactCode);
      document.getElementById("addContactForm").reset();
      $("#addModal").modal('show');
    }

    function openEditContact () {
      document.getElementById("addContactForm").reset();
      $("#addContactForm").attr("action","edit.php");

      $("#contactCode").val(contact.contactCode);

      if (contact.firstName) {
        $('#addFirstName').val(contact.firstName);
      };

      if (contact.middleName) {
        $('#addMiddleName').val(contact.middleName);
      };

      if (contact.lastName) {
        $('#addLastName').val(contact.lastName);
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

    function openDeleteModal(id){
      $("#deleteContact").val(id);
      $("#deleteModal").modal("show");
    }

    $(document).ready(function(event){
      getContact(0);

      var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
      ];

      $( "#addTitle" ).autocomplete({
        source: availableTags
      });
    });
    </script>
    <script>
    $('.nav li').click(function(e) {
    $('.nav li.active').removeClass('active');
    var $this = $(this);
    if (!$this.hasClass('active')) {
        $this.addClass('active');
    }
    e.preventDefault();
});
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

  <div class="container-fluid navbar-padding">
    <div class="row">
<!--<label class='pull-right'><input type='checkbox' id='addPrivacy' name='privacy'/>Private</label> -->
      <!-- A-Z Picker -->
      <!--
      <div class="col-md-1 col-sm-2 col-xs-2 ul_margin pre-scrollable scrollbar" id="style-3">
          <nav>
            <ul class="force-scroll">
              <center>
                <li class="ul_pad"><a href="#A">A</a></li>
                <li class="ul_pad"><a href="#B">B</a></li>
                <li class="ul_pad"><a href="#C">C</a></li>
                <li class="ul_pad"><a href="#D">D</a></li>
                <li class="ul_pad"><a href="#E">E</a></li>
                <li class="ul_pad"><a href="#F">F</a></li>
                <li class="ul_pad"><a href="#G">G</a></li>
                <li class="ul_pad"><a href="#H">H</a></li>
                <li class="ul_pad"><a href="#I">I</a></li>
                <li class="ul_pad"><a href="#J">J</a></li>
                <li class="ul_pad"><a href="#K">K</a></li>
                <li class="ul_pad"><a href="#L">L</a></li>
                <li class="ul_pad"><a href="#M">M</a></li>
                <li class="ul_pad"><a href="#N">N</a></li>
                <li class="ul_pad"><a href="#O">O</a></li>
                <li class="ul_pad"><a href="#P">P</a></li>
                <li class="ul_pad"><a href="#Q">Q</a></li>
                <li class="ul_pad"><a href="#R">R</a></li>
                <li class="ul_pad"><a href="#S">S</a></li>
                <li class="ul_pad"><a href="#T">T</a></li>
                <li class="ul_pad"><a href="#U">U</a></li>
                <li class="ul_pad"><a href="#V">V</a></li>
                <li class="ul_pad"><a href="#W">W</a></li>
                <li class="ul_pad"><a href="#X">X</a></li>
                <li class="ul_pad"><a href="#Y">Y</a></li>
                <li class="ul_pad"><a href="#Z">Z</a></li>
              </center>
            </ul>
          </nav>
      </div>
      -->
    
      <div class="col-md-5 col-sm-12 col-xs-12">
        <div class="panel panel-default scroll" id="style-3">
             <!-- List group -->
            <div class="list-group force-scroll">
              <li class="list-group-item">
                <div class="row">
                  <div class="col-xs-6 col-md-6">
                    <input type="text" class="form-control search_text" placeholder="Search..." />
                  </div>
                  <div class="col-xs-3 col-md-3">
                    <div class="input-group-btn">
                    <select class="form-control selectpicker" name="category" width="100%">
                      <option>Name</option>
                      <option>Address</option>
                      <option>Phone Number</option>
                      <option>Company</option>
                    </select>

                  </div>
                  </div>
                  <div class="col-xs-3 col-md-3">
                    <button class="btn btn-primary" style="width: 100%;" onclick="openAddContact();"><span class="glyphicon glyphicon-plus hidden-sm hidden-xs"></span>
                    Add
                    </button>
                  </div>
                </div>

              <?php 
                $sql = "SELECT contactCode,fullName FROM contact ORDER BY fullName;";
                $str = "";
                if ($result = $mysqli->query($sql)) {
                  if ($result->num_rows == 0) {
                    $str = "<a href='#' class='list-group-item '>
                            <li class='list-group-item-text header_font'>No contacts</li>
                          </a>";
                  }
                  else{
                    $letterIndex = "";
                    while ($row = $result->fetch_assoc()) {

                      $letter = substr(strtoupper($row['fullName']), 0,1);
                      
                      if ($letter != $letterIndex) {
                        $str .= "<li class='list-group-item-info li-pad' id='".$letter."'>".$letter."</li>";
                        $letterIndex = $letter;
                      }
                      
                      $str .= "<a onclick='getContact(".$row['contactCode'].")' class='list-group-item contacts_font'>
                              <h4 class='list-group-item-heading contacts_font'>".$row['fullName']."</h4>
                            </a>";
                    }
                  }
                }

                echo $str;
                
              ?>
          </div><!--List close-->
        </div><!--Panel-->
      </div><!--COL-->

      <div class="col-md-7 col-sm-10 hidden-sm hidden-xs">
        <?php echo $status; ?>
        <div id="contactDetail" class="panel panel-default scroll" id="style-3">
            <div class="panel-heading text-center force-overflow">
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
              <span class='glyphicon glyphicon-remove'></span>&nbsp
              Cancel
            </button>
          </div>
        
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-success">
              <span class='glyphicon glyphicon-ok'></span>&nbsp
              Save
            </button>
          </div>

          <h4 class="modal-title text-center">
              Add Contact
          </h4>   
        </div>  

        <div class="modal-body">
            <input type="hidden" name="id" id='contactCode' />
            <div class="form-group">
              <label class="col-xs-4 control-label">Title</label>
              <div class="col-xs-8 ui-widget">
                <input type="text" name="title" class="form-control title_css" id="addTitle" />
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
                <input type="text" name="lastName" id="addLastName" class="form-control" placeholder="Last Name" />
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
            <hr />
            <div class="form-group">
              <ul class="nav nav-tabs nav-justified">
                <li><a href="#tab2" data-toggle="tab"><span class='glyphicon glyphicon-road'></span>&nbspAddress</a></li>
                <li><a href="#tab1" data-toggle="tab"><span class='glyphicon glyphicon-user'></span>&nbspPersonal</a></li>
                <li><a href="#tab3" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span>&nbspProfessional</a></li>
                <li><a href="#tab4" data-toggle="tab"><span class='glyphicon glyphicon-globe'></span>&nbspSocial</a></li>
            <!--<li><a href="#tab5" data-toggle="tab">Fifth</a></li>
                <li><a href="#tab6" data-toggle="tab">Sixth</a></li>
                <li><a href="#tab7" data-toggle="tab">Seventh</a></li>-->
              </ul>
            </div>
 
            <div class="tab-content">
                <div class="tab-pane" id="tab1">
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Father/Husband Name</label>
                    <div class="col-xs-8">
                      <input type="text" name="guardianName" id="addGuardianName" class="form-control" placeholder="Father/Husband Name" />
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
                    <label class="col-xs-4 control-label">Alias</label>
                    <div class="col-xs-8">
                      <input type="text" name="alias" id="addAlias" class="form-control" placeholder="Alias" />
                    </div>
                  </div>
                  <!--
                  <div class="form-group">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-8">
                      <label>
                        <input type="checkbox" id="addActiveStatus" name="activeStatus" checked="checked" /> Active Status
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-8">
                      <label>
                        <input type="checkbox" id="addPrivacy" name="privacy" /> Private
                      </label>
                    </div>
                  </div>-->
                </div>

                <!-- Start of Address Tab -->
                <div class="tab-pane" id="tab2">
                  <div class="form-group">
                    <ul class="nav nav-pills nav-justified">
                      <li><a href="#home" data-toggle="tab"><span class='glyphicon glyphicon-home'></span>&nbspHome</a></li>
                      <li><a href="#work" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span>&nbspWork</a></li>
                      <li><a href="#other" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span>&nbspOther</a></li>
                    </ul>
                  </div>
                </div>

                <!-- Start of Home tab -->
                <div class="tab-pane" id="home">
                  <div class="form-group">
                    <ul class="nav nav-pills nav-justified">
                      <li><a href="#home" data-toggle="tab"><span class='glyphicon glyphicon-home'></span>&nbspHome</a></li>
                      <li><a href="#work" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span>&nbspWork</a></li>
                      <li><a href="#other" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span>&nbspOther</a></li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Home Address</label>
                    <div class="col-xs-8">
                      <input type="text" name="address" id="addAddress" class="form-control" placeholder="Address" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address1" id="address1" class="form-control" placeholder="Address 1" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address2" id="address2" class="form-control" placeholder="Address 2" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address3" id="address3" class="form-control" placeholder="Address 3" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address4" id="address4" class="form-control" placeholder="Address 4" />
                    </div>
                  </div>                 
                  <div class="form-group">
                    <label class="col-xs-4 control-label">City</label>
                    <div class="col-xs-8">
                      <input type="text" name="city_code" id="city_code" class="form-control" placeholder="City" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">State</label>
                    <div class="col-xs-8">
                      <input type="text" name="state_code" id="state_code" class="form-control" placeholder="State" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Country</label>
                    <div class="col-xs-8">
                      <input type="text" name="country_code" id="country_code" class="form-control" placeholder="Country" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Pincode</label>
                    <div class="col-xs-8">
                      <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Area</label>
                    <div class="col-xs-8">
                      <input type="text" name="area_code" id="area_code" class="form-control" placeholder="Area" />
                    </div>
                  </div>
                </div>

                <!-- Start of Work Tab -->
                <div class="tab-pane" id="work">
                  <div class="form-group">
                    <ul class="nav nav-pills nav-justified">
                      <li><a href="#home" data-toggle="tab"><span class='glyphicon glyphicon-home'></span>&nbspHome</a></li>
                      <li><a href="#work" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span>&nbspWork</a></li>
                      <li><a href="#other" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span>&nbspOther</a></li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Work Address</label>
                    <div class="col-xs-8">
                      <input type="text" name="address" id="addAddress" class="form-control" placeholder="Address" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address1" id="address1" class="form-control" placeholder="Address 1" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address2" id="address2" class="form-control" placeholder="Address 2" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address3" id="address3" class="form-control" placeholder="Address 3" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address4" id="address4" class="form-control" placeholder="Address 4" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Area</label>
                    <div class="col-xs-8">
                      <input type="text" name="area_code" id="area_code" class="form-control" placeholder="Area" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">City</label>
                    <div class="col-xs-8">
                      <input type="text" name="city_code" id="city_code" class="form-control" placeholder="City" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">State</label>
                    <div class="col-xs-8">
                      <input type="text" name="state_code" id="state_code" class="form-control" placeholder="State" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Country</label>
                    <div class="col-xs-8">
                      <input type="text" name="country_code" id="country_code" class="form-control" placeholder="Country" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Pincode</label>
                    <div class="col-xs-8">
                      <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode" />
                    </div>
                  </div>
                </div>

                <!-- Start of Others Pane -->
                <div class="tab-pane" id="other">
                  <div class="form-group">
                    <ul class="nav nav-pills nav-justified">
                      <li><a href="#home" data-toggle="tab"><span class='glyphicon glyphicon-home'></span>&nbspHome</a></li>
                      <li><a href="#work" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span>&nbspWork</a></li>
                      <li><a href="#other" data-toggle="tab"><span class='glyphicon glyphicon-briefcase'></span>&nbspOther</a></li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Other Address</label>
                    <div class="col-xs-8">
                      <input type="text" name="address" id="addAddress" class="form-control" placeholder="Address" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address1" id="address1" class="form-control" placeholder="Address 1" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address2" id="address2" class="form-control" placeholder="Address 2" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address3" id="address3" class="form-control" placeholder="Address 3" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-8">
                      <input type="text" name="address4" id="address4" class="form-control" placeholder="Address 4" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Area</label>
                    <div class="col-xs-8">
                      <input type="text" name="area_code" id="area_code" class="form-control" placeholder="Area" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">City</label>
                    <div class="col-xs-8">
                      <input type="text" name="city_code" id="city_code" class="form-control" placeholder="City" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">State</label>
                    <div class="col-xs-8">
                      <input type="text" name="state_code" id="state_code" class="form-control" placeholder="State" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Country</label>
                    <div class="col-xs-8">
                      <input type="text" name="country_code" id="country_code" class="form-control" placeholder="Country" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-4 control-label">Pincode</label>
                    <div class="col-xs-8">
                      <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode" />
                    </div>
                  </div>
                </div>

                <!--Start of Profession Tab-->
                <div class="tab-pane" id="tab3">
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
                </div>

                <!-- Start of Social Tab -->
                <div class="tab-pane" id="tab4">
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
                      <input type="text" name="google" id="addGoogle" class="form-control" placeholder="Google ID" />
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
    <div class="modal-dialog">
      <div class="modal-content">

        <form class="form-horizontal" method="POST" action="#" id="form1" runat="server">
        
        <div class="modal-header">

          <div class="btn-group pull-left">
            <button class="btn btn-danger" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span>&nbsp
              Cancel
            </button>
          </div>
        
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-success">
              <span class='glyphicon glyphicon-ok'></span>&nbsp
              Save
            </button>
          </div>

          <h4 class="modal-title text-center">
              Edit Image
          </h4>   
        </div>  

        <div class="modal-body">
            <input type="hidden" name="id" id='contactCode' />
            <div class="form-group">
              <label class="col-xs-4 control-label">Select Image</label>
              <div class="col-xs-8 ui-widget">
                <input type='file' id="imgInp" />
              </div>
            </div>            
            <div class="form-group">
              <label class="col-xs-4 control-label"></label>
              <div class="col-xs-8">
                <img src="" id="imagepreview" style="width: 30%; height: 30%;" >
              </div>
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