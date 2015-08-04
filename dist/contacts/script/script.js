
var root = "http://localhost/assist/";
var contact;
var contactList;
var searchList;
var contactCode = 1234567890;
var titleTags = [];
var titleCode = [];
var groupTag = [];
var groupCode = [];
var countryTag = [];
var countryCode = [];
var country = [];
var stateTag = [];
var stateCode = [];
var state = [];
var cityTag = [];
var cityCode = [];
var city = [];
var areaTag = [];
var areaCode = [];
var area = [];

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

function getCountry(){
  $.ajax({
    method: "GET",
    url: root+"contacts/getMasters.php",
    data: { 
        type: 'country'
     }
  })
    .done(function(msg) {
      country = JSON.parse(msg);
      for (var i = 0; i < country.length; i++) {
        countryTag[i] = country[i]['description'];
        countryCode[i] = country[i]['code'];
      };
      setCountryAutoComplete();
    });
}

function getStates(){
  $.ajax({
    method: "GET",
    url: root+"contacts/getMasters.php",
    data: { 
        type: 'state'
     }
  })
    .done(function(msg) {
      state = JSON.parse(msg);
      for (var i = 0; i < state.length; i++) {
        stateTag[i] = state[i]['description'];
        stateCode[i] = state[i]['code'];
      };
      setStateAutoComplete();
    });
}

function getCities(){
  $.ajax({
    method: "GET",
    url: root+"contacts/getMasters.php",
    data: { 
        type: 'city'
     }
  })
    .done(function(msg) {
      city = JSON.parse(msg);
      for (var i = 0; i < city.length; i++) {
        cityTag[i] = city[i]['description'];
        cityCode[i] = city[i]['code'];
      };
      setCityAutoComplete();
    });
}

function getAreas(){
  $.ajax({
    method: "GET",
    url: root+"contacts/getMasters.php",
    data: { 
        type: 'area'
     }
  })
    .done(function(msg) {
      area = JSON.parse(msg);
      for (var i = 0; i < area.length; i++) {
        areaTag[i] = area[i]['description'];
        areaCode[i] = area[i]['code'];
      };
      setAreaAutoComplete();
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
  if (contact.contact.contactCode == null) {
    getContact(0);
    return;
  };
  var headerStr = "<h12>Contact Details</h12><button class='btn btn-success pull-right' onclick='openEditContact();'><span class='glyphicon glyphicon-pencil'></span></button><button class='btn btn-danger pull-left' onclick='openDeleteModal("+((arr.contact) ? arr.contact.contactCode : "1")+")'><span class='glyphicon glyphicon-trash'></span></button>";
  var str = "";

  str += "<div class='list-group-item'><div class='image'><a data-toggle='modal' data-target='#imageModal' id='pop'><img src='../img/contacts/profile/profilePicture1.png' id='imageresource' alt='...' class='img-rounded pull-left'/><div class='overlay img-rounded pull-left'><span class='glyphicon glyphicon-pencil' style='padding-top:10px'></span></div></a></div><div class='header_font'>Name</div><h5 class='list-group-item-heading'>"+((arr.contact.contactTitle) ? arr.contact.contactTitle + " " : "")+((arr.contact.fullName) ? arr.contact.fullName : "")+"</h5></div>";
  //if (arr.contact.fullName) {
    
  //};

  //if (arr.contact.fullName) {
  //  str += "<div class='list-group-item'><h4 class='list-group-item-heading header_font'>Name<value class='name'>"+((arr.contact.fullName) ? arr.contact.fullName : "")+"</value></h4></div>";
  //};

  
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Guardian</div><value><div class='col-md-9'>"+((arr.contact.guardianName) ? arr.contact.guardianName : "")+"</div></value></div></div>";
  

  //if (arr.contact.company) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Company</div><value><div class='col-md-9'>"+((arr.contact.company) ? arr.contact.company : "" )+"</div></value></div></div>";
  //};

  //if (arr.contact.designation) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Designation</div><value><div class='col-md-9'>"+((arr.contact.designation) ? arr.contact.designation : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.alias) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Alias</div><value><div class='col-md-9'>"+((arr.contact.alias) ? arr.contact.alias : "")+"</div></value></div></div>";
  //};
  
  //if (arr.contact.dob) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.B</div><value><div class='col-md-9'>"+((arr.contact.dob) ? arr.contact.dob : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.dom) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.M</div><value><div class='col-md-9'>"+((arr.contact.dom) ? arr.contact.dom : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.group) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Group</div><value><div class='col-md-9'>"+((arr.contact.group) ? arr.contact.group : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.remarks) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>"+((arr.contact.remarks) ? arr.contact.remarks : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.mobile) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Mobile</div><value><div class='col-md-9'>"+((arr.contact.mobile) ? arr.contact.mobile : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.email) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Email</div><value><div class='col-md-9'>"+((arr.contact.email) ? arr.contact.email : "")+"</div></value></div></div>";
  //};


  str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Home Address</div><value><div class='col-md-9'>"+((arr.address) ? arr.address.home.address : "")+"</div></value></div></div>";
  str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Home City</div><value><div class='col-md-9'>"+((arr.address) ? arr.address.home.city : "")+"</div></value></div></div>";

  //if (arr.contact.facebook) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Facebook</div><value><div class='col-md-9'>"+((arr.contact.facebook) ? arr.contact.facebook : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.twitter) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Twitter</div><value><div class='col-md-9'>"+((arr.contact.twitter) ? arr.contact.twitter  : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.google) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Google</div><value><div class='col-md-9'>"+((arr.contact.google) ? arr.contact.google : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.linkedin) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Linkedin</div><value><div class='col-md-9'>"+((arr.contact.linkedin) ? arr.contact.linkedin  : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.website) {
    str += "<div class='list-group-item contact_details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Website</div><value><div class='col-md-9'>"+((arr.contact.website) ? arr.contact.website : "")+"</div></value></div></div>";
  //};


  $("#contactDetailHeader").empty();
  $("#contactDetailHeader").html(headerStr);
  $("#contactDetailBody").empty();
  $("#contactDetailBody").html(str);
}

function openAddContact () {
  $("#addContactForm").attr("action","add.php");
  $("#contactCode").val(contactCode);
  $("#inputType").val(1);
  $('#contactModalHeading').empty();
  $('#contactModalHeading').html("Add Contact");
  document.getElementById("addContactForm").reset();
  $("#addModal").modal('show');
}

function openEditContact () {
  document.getElementById("addContactForm").reset();

  $('#contactModalHeading').empty();
  $('#contactModalHeading').html("Edit Contact");
  $("#addContactForm").attr("action","add.php");
  $("#inputType").val(2);
  $("#contactCode").val(contact.contact.contactCode);

  if (contact.contact.contactTitle) {
    $('#addTitle').val(contact.contact.contactTitle);
  };

  if (contact.contact.titleCode) {
    $('#titleId').val(contact.contact.titleCode);
  };

  if (contact.contact.firstName) {
    $('#addFirstName').val(contact.contact.firstName);
  };

  if (contact.contact.middleName) {
    $('#addMiddleName').val(contact.contact.middleName);
  };

  if (contact.contact.lastName) {
    $('#addLastName').val(contact.contact.lastName);
  };

  if (contact.contact.guardianName) {
    $('#addGuardianName').val(contact.contact.guardianName);
  };

  if (contact.contact.company) {
    $('#addCompany').val(contact.contact.company);
  };

  if (contact.contact.designation) {
    $('#addDesignation').val(contact.contact.designation);
  };

  if (contact.contact.alias) {
    $('#addAlias').val(contact.contact.alias);
  };
  
  if (contact.contact.dob) {
    $('#addDOB').val(contact.contact.dob);
  };

  if (contact.contact.dom) {
    $('#addDOM').val(contact.contact.dom);
  };

  if (contact.contact.group) {
    $('#addGroup').val(contact.contact.group);
  };

  if (contact.contact.groupCode) {
    $('#groupId').val(contact.contact.groupCode);
  };

  if (contact.contact.remarks) {
    $('#addRemarks').val(contact.contact.remarks);
  };

  if (contact.contact.mobile) {
    $('#addMobile').val(contact.contact.mobile);
  };

  if (contact.contact.email) {
    $('#addEmail').val(contact.contact.email);
  };

  if (contact.contact.facebook) {
    $('#addFacebook').val(contact.contact.facebook);
  };

  if (contact.contact.twitter) {
    $('#addTwitter').val(contact.contact.twitter);
  };

  if (contact.contact.google) {
    $('#addGoogle').val(contact.contact.google);
  };

  if (contact.contact.linkedin) {
    $('#addLinkedin').val(contact.contact.linkedin);
  };

  if (contact.contact.website) {
    $('#addWebsite').val(contact.contact.website);
  };

  $("#addModal").modal('show');
}

function openDeleteModal(id){
  $("#deleteContact").val(id);
  $("#deleteModal").modal("show");
}

function setTitleAutoComplete(){
  setAutoComplete("#addTitle", "#titleId", titleTags, titleCode);
}

function setGroupAutoComplete(){
  setAutoComplete("#addGroup", "#groupId", groupTag, groupCode);
}

function setCountryAutoComplete(){
  setAutoComplete("#homeCountry", "#homeCountryCode", countryTag, countryCode);
  setAutoComplete("#workCountry", "#workCountryCode", countryTag, countryCode);
  setAutoComplete("#otherCountry", "#otherCountryCode", countryTag, countryCode);
}

function setAutoComplete(autoCompleteId, changeCodeId, autoCompleteArray, changeCodeArray){
  $( autoCompleteId ).autocomplete({
    source: autoCompleteArray,
    change: function(event, ui){
      if (ui.item) {
        var index = $.inArray(ui.item.value, autoCompleteArray);
        $(changeCodeId).val(changeCodeArray[index]);
      }
      else{
        $(changeCodeId).val(-1);
      }
    },
    select: function(event, ui){
      var index = $.inArray(ui.item.value, autoCompleteArray);
      $(changeCodeId).val(changeCodeArray[index]);
      console.log($(changeCodeId).val());
    }
  });
}

function setStateAutoComplete(){
  setStateAutoCompleteWithOptions("#homeState","#homeStateCode","#homeCountry","#homeCountryCode");
  setStateAutoCompleteWithOptions("#workState","#workStateCode","#workCountry","#workCountryCode");
  setStateAutoCompleteWithOptions("#otherState","#otherStateCode","#otherCountry","#otherCountryCode");
}

function setStateAutoCompleteWithOptions(autoCompleteId,changeCodeId,countryId,countryCodeId){
  $( autoCompleteId ).autocomplete({
    source: stateTag,
    change: function(event, ui){
      if (ui.item) {
        var index = $.inArray(ui.item.value, stateTag);
        $(changeCodeId).val(stateCode[index]);
      }
      else{
        $(changeCodeId).val(-1);
      }
    },
    select: function(event, ui){
      var index = $.inArray(ui.item.value, stateTag);
      var code = stateCode[index];
      $(changeCodeId).val(stateCode[index]);
      var countryCodeValue = 0;
      for (var i = 0; i < state.length; i++) {
        if(state[i]["code"] == code){
          countryCodeValue = state[i]["countryCode"];
          break;
        }
      };
      $(countryCodeId).val(countryCodeValue);
      var countryIndex = $.inArray(countryCodeValue,countryCode);
      $(countryId).val(countryTag[countryIndex]);
      console.log($(changeCodeId).val());
    }
  });
}

function setCityAutoComplete(){
  setCityAutoCompleteWithOptions("#homeCity","#homeCityCode","#homeCountry","#homeCountryCode","#homeState","#homeStateCode");
  setCityAutoCompleteWithOptions("#workCity","#workCityCode","#workCountry","#workCountryCode","#workState","#workStateCode");
  setCityAutoCompleteWithOptions("#otherCity","#otherCityCode","#otherCountry","#otherCountryCode","#otherState","#otherStateCode");
}

function setCityAutoCompleteWithOptions(autoCompleteId,changeCodeId,countryId,countryCodeId,stateId,stateCodeId){
  $( autoCompleteId ).autocomplete({
    source: cityTag,
    change: function(event, ui){
      if (ui.item) {
        var index = $.inArray(ui.item.value, cityTag);
        $(changeCodeId).val(cityCode[index]);
      }
      else{
        $(changeCodeId).val(-1);
      }
    },
    select: function(event, ui){
      var index = $.inArray(ui.item.value, cityTag);
      var code = cityCode[index];
      $(changeCodeId).val(cityCode[index]);
      var stateCodeValue = 0;
      var countryCodeValue = 0;
      for (var i = 0; i < city.length; i++) {
        if(city[i]["code"] == code){
          stateCodeValue = city[i]["stateCode"];
          countryCodeValue = city[i]["countryCode"];
          break;
        }
      };
      $(stateCodeId).val(stateCodeValue);
      var stateIndex = $.inArray(stateCodeValue,stateCode);
      $(stateId).val(stateTag[stateIndex]);
      console.log(stateTag[stateIndex]);
      $(countryCodeId).val(countryCodeValue);
      var countryIndex = $.inArray(countryCodeValue,countryCode);
      $(countryId).val(countryTag[countryIndex]);
      //console.log($("#homeStateCode").val());
    }
  });
}

function setAreaAutoComplete(){
  setAutoComplete("#homeArea", "#homeArea", areaTag, areaCode);
  setAutoComplete("#workArea", "#workAreaCode", areaTag, areaCode);
  setAutoComplete("#otherArea", "#otherAreaCode", areaTag, areaCode);
  //setAreaAutoCompleteWithOptions("#homeArea","#homeAreaCode","#homeCountry","#homeCountryCode","#homeState","#homeStateCode","#homeCity","#homeCityCode");
  //setAreaAutoCompleteWithOptions("#workArea","#workAreaCode","#workCountry","#workCountryCode","#workState","#workStateCode","#workCity","#workCityCode");
  //setAreaAutoCompleteWithOptions("#otherArea","#otherAreaCode","#otherCountry","#otherCountryCode","#otherState","#otherStateCode","#otherCity","#otherCityCode");
}

function setAreaAutoCompleteWithOptions(autoCompleteId,changeCodeId,countryId,countryCodeId,stateId,stateCodeId,cityId,cityCodeId){
  $( autoCompleteId ).autocomplete({
    source: areaTag,
    change: function(event, ui){
      if (ui.item) {
        var index = $.inArray(ui.item.value, areaTag);
        $(changeCodeId).val(areaCode[index]);
      }
      else{
        $(changeCodeId).val(-1);
      }
    },
    select: function(event, ui){
      var index = $.inArray(ui.item.value, areaTag);
      var code = areaCode[index];
      $(changeCodeId).val(areaCode[index]);
      var cityCodeValue = 0;
      var stateCodeValue = 0;
      var countryCodeValue = 0;
      for (var i = 0; i < area.length; i++) {
        if(area[i]["code"] == code){
          cityCodeValue = area[i]["cityCode"]
          stateCodeValue = area[i]["stateCode"];
          countryCodeValue = area[i]["countryCode"];
          break;
        }
      };

      $(cityCodeId).val(cityCodeValue);
      var cityIndex = $.inArray(cityCodeValue,cityCode);
      $(cityId).val(cityTag[cityIndex]);

      $(stateCodeId).val(stateCodeValue);
      var stateIndex = $.inArray(stateCodeValue,stateCode);
      $(stateId).val(stateTag[stateIndex]);
      
      console.log(stateTag[stateIndex]);
      
      $(countryCodeId).val(countryCodeValue);
      var countryIndex = $.inArray(countryCodeValue,countryCode);
      $(countryId).val(countryTag[countryIndex]);
      //console.log($("#homeStateCode").val());
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
      var status = parseInt(response.status)
      if (status == 1) {
        getContact(id);
        getContactList();
        showNotificationSuccess(response.message);
        refreshMasterList();
      }
      else{
        getContact(0);
        showNotificationFailure(response.message);
      }
      console.log(id);
    });
}

function showNotificationSuccess(msg) 
{
  $("#notification_success").html(msg);
  document.getElementById('notification_success').style.display = "block";  
  $("#notification_success").delay(2000).fadeOut("slow");
}

function showNotificationFailure(msg) 
{
  $("#notification_failure").html(msg);
  document.getElementById('notification_failure').style.display = "block";  
  $("#notification_failure").delay(2000).fadeOut("slow");
}

function showLoadingInContactDetail(){
  var contactDetailStr = "<div class='list-group-item'><p class='list-group-item-text'>Loading...</p></div>";
  $("#contactDetailBody").empty();
  $("#contactDetailBody").html(contactDetailStr);
}

function refreshMasterList(){
  getTitles();
  getGroupes();
  getCountry();
  getStates();
  getCities();
  getAreas();
}

$(document).ready(function(event){
  
  getContact(0);
  getContactList();
  refreshMasterList();

  $('.alert').fadeOut(2000);

  $('#addModal').on('shown.bs.modal', function () {
    console.log("on show");
    $('#addTitle').focus()
  });

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var tabPane = $(e.target).attr('href')
    var inputArr = $(tabPane).find('input');
    $(inputArr[0]).focus();
     // previous active tab
  });
});