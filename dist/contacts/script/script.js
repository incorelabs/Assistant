var root = "http://incorelabs.com/Assist/";
//var root = "http://localhost/assist/";
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
  console.log("Getting contact details of : "+id);
  $.ajax({
    method: "GET",
    url: root+"contacts/getContact.php",
    data: { 
        id: id
     }
  })
    .done(function(msg) {
      contact = JSON.parse(msg);
      console.log("Contact arr: ");
      console.log(contact);
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
  //console.log(arr);
  if (arr.contact ) {
    
  }
  else{
    getContact(0);
    return;
  }
  var headerStr = "<h12>Contact Details</h12><button class='btn btn-success pull-right' onclick='openEditContact();'><span class='glyphicon glyphicon-pencil'></span></button><button class='btn btn-danger pull-left' onclick='openDeleteModal("+((arr.contact) ? arr.contact.contactCode : "1")+")'><span class='glyphicon glyphicon-trash'></span></button>";
  var str = "";
  var imgLocation = "";
  if (arr.contact.imageLocation) {
    imgLocation = arr.contact.imageLocation;
  }
  else{
    imgLocation = "../img/contacts/profile/profilePicture1.png";
  }


  str += "<div class='list-group-item'><div class='image'><a data-toggle='modal' data-target='#imageModal' id='pop'><img src='"+imgLocation+"' id='imageresource' alt='...' class='img-rounded pull-left'/><div class='overlay img-rounded pull-left'><span class='glyphicon glyphicon-pencil' style='padding-top:10px'></span></div></a></div><div class='header_font'>Name</div><h5 class='list-group-item-heading'>"+((arr.contact.contactTitle) ? arr.contact.contactTitle + " " : "")+((arr.contact.fullName) ? arr.contact.fullName : "")+"</h5></div>";


  //if (arr.contact.fullName) {
  //  str += "<div class='list-group-item'><h4 class='list-group-item-heading header_font'>Name<value class='name'>"+((arr.contact.fullName) ? arr.contact.fullName : "")+"</value></h4></div>";
  //};

  
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Guardian</div><value><div class='col-md-9'>"+((arr.contact.guardianName) ? arr.contact.guardianName : "")+"</div></value></div></div>";
  

  //if (arr.contact.company) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Company</div><value><div class='col-md-9'>"+((arr.contact.company) ? arr.contact.company : "" )+"</div></value></div></div>";
  //};

  //if (arr.contact.designation) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Designation</div><value><div class='col-md-9'>"+((arr.contact.designation) ? arr.contact.designation : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.alias) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Alias</div><value><div class='col-md-9'>"+((arr.contact.alias) ? arr.contact.alias : "")+"</div></value></div></div>";
  //};
  
  //if (arr.contact.dob) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.B</div><value><div class='col-md-9'>"+((arr.contact.dob) ? arr.contact.dob : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.dom) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.M</div><value><div class='col-md-9'>"+((arr.contact.dom) ? arr.contact.dom : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.group) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Group</div><value><div class='col-md-9'>"+((arr.contact.group) ? arr.contact.group : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.remarks) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>"+((arr.contact.remarks) ? arr.contact.remarks : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.mobile) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Mobile</div><value><div class='col-md-9'>"+((arr.contact.mobile) ? arr.contact.mobile : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.email) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Email</div><value><div class='col-md-9'>"+((arr.contact.email) ? arr.contact.email : "")+"</div></value></div></div>";
  //};



  str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Home Address</div><value><div class='col-md-9'>"+((arr.address) ? arr.address.home.address+"<br style='padding-bottom:30px'>"+arr.address.home.city : "")+"</div></value></div></div>";
  str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Home City</div><value><div class='col-md-9'>"+((arr.address) ? arr.address.home.city : "")+"</div></value></div></div>";
  str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Home City</div><value><div class='col-md-9'>"+((arr.address) ? arr.address.home.state : "")+"</div></value></div></div>";
  str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Home City</div><value><div class='col-md-9'>"+((arr.address) ? arr.address.home.country : "")+"</div></value></div></div>";


  //if (arr.contact.facebook) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Facebook</div><value><div class='col-md-9'>"+((arr.contact.facebook) ? arr.contact.facebook : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.twitter) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Twitter</div><value><div class='col-md-9'>"+((arr.contact.twitter) ? arr.contact.twitter  : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.google) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Google</div><value><div class='col-md-9'>"+((arr.contact.google) ? arr.contact.google : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.linkedin) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Linkedin</div><value><div class='col-md-9'>"+((arr.contact.linkedin) ? arr.contact.linkedin  : "")+"</div></value></div></div>";
  //};

  //if (arr.contact.website) {
    str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Website</div><value><div class='col-md-9'>"+((arr.contact.website) ? arr.contact.website : "")+"</div></value></div></div>";
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

  if (contact.address) {
    var address = contact.address;
    var type = "";
    if (address.home) {
      type = "home";
      createEditAddressData(address,type);
    }

    if (address.work) {
      type = "work";
      createEditAddressData(address,type);
    }

    if (address.other) {
      type = "other";
      createEditAddressData(address,type);
    }
  }

  $("#addModal").modal('show');
}

function createEditAddressData(address,type){
  if (address[type].countryCode) {
    $("#"+type+"Country").val(address[type].country);
    $("#"+type+"CountryCode").val(address[type].countryCode);
  }

  if (address[type].stateCode) {
    $("#"+type+"State").val(address[type].state);
    $("#"+type+"StateCode").val(address[type].stateCode); 
  }

  if (address[type].cityCode) {
    $("#"+type+"City").val(address[type].city);
    $("#"+type+"CityCode").val(address[type].cityCode); 
  } 

  if (address[type].areaCode) {
    $("#"+type+"Area").val(address[type].area);
    $("#"+type+"AreaCode").val(address[type].areaCode); 
  }

  if (address[type].address1) {
    $("#"+type+"Address1").val(address[type].address1);
  } 

  if (address[type].address2) {
    $("#"+type+"Address2").val(address[type].address2);
  }

  if (address[type].address3) {
    $("#"+type+"Address3").val(address[type].address3);
  }

  if (address[type].address4) {
    $("#"+type+"Address4").val(address[type].address4);
  }

  if (address[type].address5) {
    $("#"+type+"Address5").val(address[type].address5);
  }

  if (address[type].pincode) {
    $("#"+type+"Pincode").val(address[type].pincode);
  }

  if (address[type].phone) {
    $("#"+type+"Phone").val(address[type].phone);
  }
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
        setTimeout(function(){
          getContact(id);
          getContactList();
          showNotificationSuccess(response.message);
          refreshMasterList();
        },500);
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

window.mobilecheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
}

$(document).ready(function(event){
  
  if (window.mobilecheck()) {
    var headerData = "<div class='navbar navbar-default navbar-bg navbar-fixed-top' style='margin-top:50px; height:60px;'><div class='container-fluid'><div class='row'><div class='col-md-12' style='padding-top:12px'><form><div class='form-group'><div class='col-md-10 col-sm-10 col-xs-10'><div class='input-group'><input id='searchContact' type='text' class='form-control' onkeyup='doSearch();' placeholder='Search...' autofocus /><div class='input-group-btn'><div class='btn-group btn-group1' role='group'><div class='dropdown dropdown-lg'><button type='button' class='btn btn1 btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='false' onclick='showDiv()'><span class='glyphicon glyphicon-filter'></span></button><div class='dropdown-menu dropdown-menu-right' role='menu' id='search_filter'><form class='form-horizontal' role='form'><div class='form-group' style='padding-bottom:30px;'><label for='filter'>Filter by</label><select class='form-control' id='filter'><option value='name'>Name</option><option value='mobile'>Mobile</option><option value='email'>Email</option><option value='company'>Company</option><option value='designation'>Designation</option><option value='guardian'>Father/Husband</option><option value='birthday'>Birthday</option><option value='anniversary'>Anniversary</option><option value='group'>Group</option><option value='home_area'>Home Area</option><option value='home_city'>Home City</option><option value='home_phone'>Home Phone</option><option value='work_area'>Work Area</option><option value='work_city'>Work City</option><option value='work_phone'>Work Phone</option><option value='other_area'>Other Area</option><option value='other_city'>Other City</option><option value='other_phone'>Other Phone</option></select></div></form></div></div></div></div></div></div><div><!--<button type='button' class='btn btn-info btn-size'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></button>--><button class='btn btn-primary btn-size' onclick='openAddContact();'><span class='glyphicon glyphicon-plus'></span></button></div></div></form></div><!-- /.navbar-collapse --></div><!--/.row --></div><!-- /.container-fluid --></div>";
    $("#mobileHeader").html(headerData);
    var bodyData = "<div class='col-md-5 col-sm-12 col-xs-12 panel-padding-remove'><div class='panel panel-default panel-margin' id='style-3'><!-- List group -->  <div id='contactList' class='list-group force-scroll'> <div class='list-group-item'><p class='list-group-item-text'>Loading...</p> </div></div><!--List close--> </div><!--Panel-->  </div><!--COL--></div>  <!-- Edit div-->";
    $("#mobileBody").html(bodyData);
  }

  getContact(0);
  getContactList();
  refreshMasterList();

  $('.alert').fadeOut(2000);

  $(".progress").hide();

  $('#addModal').on('shown.bs.modal', function () {
    $('#addTitle').focus()
  });

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var tabPane = $(e.target).attr('href')
    var inputArr = $(tabPane).find('input');
    $(inputArr[0]).focus();
     // previous active tab
  });

  $('#filter').change(function(){
    if ($(this).val() != "0") {
        $('#search_filter').hide();
    }
  });

  $(function() {
    
    var active = $('a[data-toggle="tab"]').parents('.active').length;
    var tabClicked = false;
    
    // Closes current active tab (toggle and pane):
    var close = function() {
        $('a[data-toggle="tab"]').parent().removeClass('active');
        $('.tab-pane.active').removeClass('active');
        active = false;
    }
    
    // Closing active tab on clicking on toggle:
    $('[data-toggle=tab]').click(function(){
        if ($(this).parent().hasClass('active')){
            $($(this).attr("href")).toggleClass('active');
            active = false;
        } else {
            tabClicked = true;
            active = this;
        }
    });
    
    // Closing active tab on clicking outside tab context (toggle and pane):
    $(document).on('click.bs.tab.data-api', function(event) {
        if(active && !tabClicked && !$(event.target).closest('.tab-pane.active').length) {
            close();
        }
        
        tabClicked = false;
    });
    
    // Closing active tab on ESC key release:
    $(document).keyup(function(e){
        if(active && e.keyCode === 27) { // ESC
            close();
        }
    });
});
  $('#imgInp').change(function(){
    var image = this.files[0];
    if ((image.size || image.fileSize) < 1 * 1000 * 1000) {
      console.log(image);
      var img = $("#imagepreview");
      var reader = new FileReader();
      reader.onloadend = function() {         
         //img.src = reader.result;
         img.attr("src",reader.result);
      }
      reader.readAsDataURL(image);
      $("#imageErrorMsg").html("");
    }
    else{
      $("#imageErrorMsg").html("Image size is greater than 1MB");
      document.getElementById("profileForm").reset();
    }
  });

  $('#imageModal').on('show.bs.modal', function () {
    document.getElementById("profileForm").reset();
    $('#photoId').val(contact.contact.registerLicenceCode+contact.contact.contactCode);
    if (contact.contact.imageLocation) {
      $("#imagepreview").attr("src",contact.contact.imageLocation);
    }
    else{
      $("#imagepreview").attr("src","../img/contacts/profile/profilePicture1.png");
    }
  });

  $("#profileForm").ajaxForm({
    beforeSubmit:function(){
      $(".progress").show();
    },
    uploadProgress: function(event, position, total, percentComplete){
      $(".progress-bar").width(percentComplete+"%");
      $("#progressValue").html(percentComplete+"% complete");
    }, 
    success: function(responseText, statusText, xhr, $form){
      console.log(responseText);
      var response = JSON.parse(responseText);
      if (response.status == 1) {
        $("#imageModal").modal('hide');
        $("#imageresource").attr("src",response.location);
        contact.contact.imageLocation = response.location;
        $(".progress").hide();
      }
    },
  });

  $("#deleteContact").ajaxForm({ 
    success: function(responseText, statusText, xhr, $form){
      console.log(responseText);
      var response = JSON.parse(responseText);
      if (response.status == 1) {
        showNotificationSuccess(response.message);
        getContact(response.landing);
        getContactList();
        $("#deleteModal").modal('hide');
      }
      else{
        showNotificationFailure(response.message);
      }
    },
  });
});