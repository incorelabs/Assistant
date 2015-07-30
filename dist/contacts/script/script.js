
var root = "http://localhost/assist/";
var contact;
var contactList;
var searchList;
var contactCode = 1234567890;
var titleTags = [];
var titleCode = [];
var groupTag = [];
var groupCode = [];

function getContactList(){
  $.ajax({
    method: "GET",
    url: root+"contacts/getContact.php",
    data: { 
        list: 1
     }
  })
    .done(function(msg) {
      contactList = JSON.parse(msg);
      setContactViewList(contactList);
    });
}

function getContact(id){
  showLoadingInContactDetail();
  $.ajax({
    method: "GET",
    url: root+"contacts/getContact.php",
    data: { 
        id: id
     }
  })
    .done(function(msg) {
      contact = JSON.parse(msg);
      setContactView(contact);
    });
}

function getTitles(){
  var title;
  $.ajax({
    method: "GET",
    url: root+"contacts/getMasters.php",
    data: { 
        type: 'title'
     }
  })
    .done(function(msg) {
      title = JSON.parse(msg);
      for (var i = 0; i < title.length; i++) {
        titleTags[i] = title[i]['description'];
        titleCode[i] = title[i]['code'];
      };
      setTitleAutoComplete();
    });
}

function getGroupes(){
  var title;
  $.ajax({
    method: "GET",
    url: root+"contacts/getMasters.php",
    data: { 
        type: 'group'
     }
  })
    .done(function(msg) {
      title = JSON.parse(msg);
      for (var i = 0; i < title.length; i++) {
        groupTag[i] = title[i]['description'];
        groupCode[i] = title[i]['code'];
      };
      setGroupAutoComplete();
    });
}

function setContactViewList(arr){
  var str = "";
  if (arr.length == 0) {
    str = "<div class='list-group-item'><li class='list-group-item-text header_font'>No contacts yet...</li></div>";
  }
  else{
    var letterIndex = "";
    for (var i = 0; i < arr.length; i++) {
      var letter = arr[i][1].toUpperCase()[0];
      if (letter != letterIndex) {
        str += "<li class='list-group-item-info li-pad'>"+letter+"</li>";
        letterIndex = letter;
      }
      str += "<a href='#' onclick='getContact("+arr[i][0]+")' class='list-group-item contacts_font'><h4 class='list-group-item-heading contacts_font'>"+arr[i][1]+"</h4></a>";
    }
  }

  $("#contactList").empty();
  $("#contactList").html(str);
}

function doSearch(){
  var query = $("#searchContact").val();
  query = query.toLowerCase();
  searchList = [];
  if (query.length == 0) {
    searchList = contactList;
  }
  else{
    for (var i = 0; i < contactList.length; i++) {
      var name = contactList[i][1].toLowerCase();
      if (name.indexOf(query) != -1) {
        searchList.push(contactList[i]);
      }
    }
  }
  setContactViewList(searchList);
}

function setContactView(arr){
  //var json = JSON.stringify(arr);
  var headerStr = "<h12>Contact Details</h12><button class='btn btn-success pull-right' onclick='openEditContact();'><span class='glyphicon glyphicon-pencil'></span></button><button class='btn btn-danger pull-left' onclick='openDeleteModal("+arr.contactCode+")'><span class='glyphicon glyphicon-trash'></span></button>";
  var str = "";
  if (arr.photoUploaded) {

  }
  else{
    str += "<div class='list-group-item'><div class='image'><a data-toggle='modal' data-target='#imageModal' id='pop'><img src='../img/contacts/profile/profilePicture1.png' id='imageresource' alt='...' class='img-rounded pull-left'/><div class='overlay img-rounded pull-left'><span class='glyphicon glyphicon-pencil' style='padding-top:10px'></span></div></a></div><div class='header_font'>Name</div><h5 class='list-group-item-heading'>"+((arr.contactTitle) ? arr.contactTitle + " " : "")+((arr.fullName) ? arr.fullName : "")+"</h5></div>";
  };
  //if (arr.fullName) {
    
  //};

  //if (arr.fullName) {
  //  str += "<div class='list-group-item'><h4 class='list-group-item-heading header_font'>Name<value class='name'>"+((arr.fullName) ? arr.fullName : "")+"</value></h4></div>";
  //};

  
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Guardian</div><value><div class='col-md-9'>"+((arr.guardianName) ? arr.guardianName : "")+"</div></value></div></div>";
  

  //if (arr.company) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Company</div><value><div class='col-md-9'>"+((arr.company) ? arr.company : "" )+"</div></value></div></div>";
  //};

  //if (arr.designation) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Designation</div><value><div class='col-md-9'>"+((arr.designation) ? arr.designation : "")+"</div></value></div></div>";
  //};

  //if (arr.alias) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Alias</div><value><div class='col-md-9'>"+((arr.alias) ? arr.alias : "")+"</div></value></div></div>";
  //};
  
  //if (arr.dob) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.B</div><value><div class='col-md-9'>"+((arr.dob) ? arr.dob : "")+"</div></value></div></div>";
  //};

  //if (arr.dom) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.M</div><value><div class='col-md-9'>"+((arr.dom) ? arr.dom : "")+"</div></value></div></div>";
  //};

  //if (arr.group) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Group</div><value><div class='col-md-9'>"+((arr.group) ? arr.group : "")+"</div></value></div></div>";
  //};

  //if (arr.remarks) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>"+((arr.remarks) ? arr.remarks : "")+"</div></value></div></div>";
  //};

  //if (arr.mobile) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Mobile</div><value><div class='col-md-9'>"+((arr.mobile) ? arr.mobile : "")+"</div></value></div></div>";
  //};

  //if (arr.email) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Email</div><value><div class='col-md-9'>"+((arr.email) ? arr.email : "")+"</div></value></div></div>";
  //};

  //if (arr.facebook) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Facebook</div><value><div class='col-md-9'>"+((arr.facebook) ? arr.facebook : "")+"</div></value></div></div>";
  //};

  //if (arr.twitter) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Twitter</div><value><div class='col-md-9'>"+((arr.twitter) ? arr.twitter  : "")+"</div></value></div></div>";
  //};

  //if (arr.google) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Google</div><value><div class='col-md-9'>"+((arr.google) ? arr.google : "")+"</div></value></div></div>";
  //};

  //if (arr.linkedin) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Linkedin</div><value><div class='col-md-9'>"+((arr.linkedin) ? arr.linkedin  : "")+"</div></value></div></div>";
  //};

  //if (arr.website) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Website</div><value><div class='col-md-9'>"+((arr.website) ? arr.website : "")+"</div></value></div></div>";
  //};

  $("#contactDetailHeader").empty();
  $("#contactDetailHeader").html(headerStr);
  $("#contactDetailBody").empty();
  $("#contactDetailBody").html(str);
}

function openAddContact () {
  $("#addContactForm").attr("action","add.php");
  $("#contactCode").val(contactCode);
  $('#contactModalHeading').empty();
  $('#contactModalHeading').html("Add Contact");
  document.getElementById("addContactForm").reset();
  $("#addModal").modal('show');
}

function openEditContact () {
  document.getElementById("addContactForm").reset();
  
  $('#titleId').val(0);
  $('#groupId').val(0);
  $('#contactModalHeading').empty();
  $('#contactModalHeading').html("Edit Contact");
  $("#addContactForm").attr("action","edit.php");

  $("#contactCode").val(contact.contactCode);

  if (contact.contactTitle) {
    $('#addTitle').val(contact.contactTitle);
  };

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

  if (contact.group) {
    $('#addGroup').val(contact.group);
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

function setTitleAutoComplete(){
  $( "#addTitle" ).autocomplete({
    source: titleTags,
    change: function( event, ui ) {
      if (ui.item) {
        var index = $.inArray(ui.item.value,titleTags);
        $("#titleId").val(titleCode[index]);
      }
      else{
        $("#titleId").val(-1);
      }
    },
    select: function(event,ui){
      var index = $.inArray(ui.item.value,titleTags);
      $("#titleId").val(titleCode[index]);
    }
  });
}

function setGroupAutoComplete(){
    $( "#addGroup" ).autocomplete({
    source: groupTag,
    change: function( event, ui ) {
      if (ui.item) {
        var index = $.inArray(ui.item.value,groupTag);
        $("#groupId").val(groupCode[index]);
      }
      else{
        $("#groupId").val(-1);
      }
      console.log($("#groupId").val());
    },
    select: function(event,ui){
      var index = $.inArray(ui.item.value,groupTag);
      $("#groupId").val(groupCode[index]);
      console.log($("#groupId").val());
    }
  });
}

function submitContactForm(event){
  console.log("Submit button clicked");
  var formData = $('#addContactForm').serializeArray();
  var uri = $("#addContactForm").attr("action");
  var url = root + "contacts/" + uri;
  showLoadingInContactDetail();
  $("#addModal").modal('hide');

  $.ajax({
    method: "POST",
    url: url,
    data: formData
  })
    .done(function(msg) {
      console.log(msg);
      var response = JSON.parse(msg);
      var id = parseInt(response.landing);
      console.log(id);
      getContact(id);
      getContactList();
    });
}

function showLoadingInContactDetail(){
  var contactDetailStr = "<div class='list-group-item'><p class='list-group-item-text'>Loading...</p></div>";
  $("#contactDetailBody").empty();
  $("#contactDetailBody").html(contactDetailStr);
}

$(document).ready(function(event){
  
  getContact(0);
  getContactList();
  getTitles();
  getGroupes();

  $('.alert').fadeOut(2000);

});