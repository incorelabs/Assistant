var familyList;
var passwordList;
var modalHeading;
var firstTime = true;
var detailIndex = 0;

function getFamilyList(){
	$.ajax({
	    method: "GET",
	    url: root+"family/getFamily.php",
	    data: { 
	        list: 2
	     }
	  })
	    .done(function(msg) {
	      familyList = JSON.parse(msg);
	      //console.log(familyList);
	      setFamilyList(familyList);
	    });
}

function setFamilyList(arr){
	var str= "";
	for (var i = 0; i < arr.length; i++) {
		if(arr[i].FamilyCode == familyCode)
		{
			str += "<option value = "+arr[i].FamilyCode+" selected = 'selected'>"+arr[i].FamilyName+"</option>";
		}
		else
		{
			str += "<option value = "+arr[i].FamilyCode+">"+arr[i].FamilyName+"</option>";
		}
	};
	$("#holderName").html(str);
}

function getPasswordList(){
	$.ajax({
	    method: "GET",
	    url: root+"passwords/getPasswordsList.php",
	    data: { 
	        list: 1
	     }
	  })
	    .done(function(msg) {
	      passwordList = JSON.parse(msg);
	      //console.log(passwordList);
	      setPasswordList(passwordList);
	      setPasswordDetail(detailIndex);
	     
	    });
}

function setPasswordList(arr){
	var str= "";
	for (var i = 0; i < arr.length; i++) {
		str += "<a href='#' onclick='setPasswordDetail("+i+")' class='list-group-item contacts_font'><h4 class='list-group-item-heading contacts_font'>"+arr[i]["HolderName"]+" - "+arr[i]["PasswordName"]+"</h4></a>";
	}
	$("#passwordsList").html(str);
}

function setPasswordDetail(index){
	var detail = passwordList[index];
	var headerStr = "<h12>Password Details</h12><button class='btn btn-success pull-right' onclick='openEditPassword("+index+")'> <span class='glyphicon glyphicon-pencil'></span></button><button class='btn btn-danger pull-left' onclick='openDeleteModal("+index+")'><span class='glyphicon glyphicon-trash'></span></button>";

	var str= "";
	str += "<div class='panel-height'><!-- List group --><div id='passwordBody' class='list-group'><div class='list-group-item list-group-item-border'><div class='row contact-details' style='padding-top:0px'><div class='list-group-item-heading header_font'><div class='col-md-3'>Holder's Name</div><value><div class='col-md-9'>"+detail["HolderName"]+"</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password Type</div><value><div class='col-md-9'>"+detail["PasswordTypeName"]+"</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Description</div><value><div class='col-md-9'>"+detail["PasswordName"]+"</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Login ID</div><value><div class='col-md-9'>"+detail["LoginID"]+"</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password</div><value><div class='col-md-9'><div class='textShow'>"+detail["LoginPassword1"]+"</div><div class='pull-right' style='margin-top:-22px'><a href='#' id='passwordEncrypt'><i class='fa fa-eye fa-lg'></i></a></div></div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Optional Password</div><value><div class='col-md-9'><div class='textShow'>"+detail["LoginPassword2"]+"</div><div class='pull-right' style='margin-top:-22px'><a href='#' id='passwordEncrypt'><i class='fa fa-eye fa-lg'></i></a></div></div></value></div></div></div></div><!--List close--></div>";
	
	$("#passwordDetailHeader").html(headerStr);
	$("#password-Detail").html(str);
}

function openDeleteModal(index){
	detailIndex = ((index == 0) ? index+1 : index);
	var detail = passwordList[index];
	$("#form-delete-mode").val("D");
	$("#form-delete-code").val(detail["PasswordCode"]);
	$("#deletePassword").modal('show');
}

function openAddModal(){
	document.getElementById("form-passwords").reset();
	$("#input-type").val("A");
	modalHeading = "Add";
	$("#passwordCode").val("1");
	$("#addPassword").modal('show');
}

function openEditPassword(index){
	detailIndex = index;
	var detail = passwordList[index];
	$("#input-type").val("M");
	modalHeading = "Edit";
	$("#passwordCode").val(detail["PasswordCode"]);
	setModalInputFields(detail);
	$("#addPassword").modal('show');
}

function setModalInputFields(detail){
	document.getElementById("form-passwords").reset();
	var temp = familyCode;
	familyCode = detail["HolderCode"];
	setFamilyList(familyList);
	
	if (detail["ActiveFlag"]) {
		if (detail["ActiveFlag"] == 1) {
			$("#addActiveStatus").attr("checked",true);
		}
		else{
			$("#addActiveStatus").attr("checked",false);
		}
	}
	else{
		$("#addActiveStatus").attr("checked",false);
	}

	if (detail["PrivateFlag"]) {
		if (detail["PrivateFlag"] == 1) {
			$("#addPrivacy").attr("checked",true);
		}
		else{
			$("#addPrivacy").attr("checked",false);
		}
	}
	else{
		$("#addPrivacy").attr("checked",false);
	}

	if (detail["PasswordTypeCode"]) {
		$("#passwordType").val(detail["PasswordTypeName"]);
		$("#passwordTypeCode").val(detail["PasswordTypeCode"]);
	}

	if (detail["PasswordName"]) {
		$("#description").val(detail["PasswordName"]);
	}

	if (detail["LoginID"]) {
		$("#userID").val(detail["LoginID"]);
	}

	if (detail["LoginPassword1"]) {
		$("#password").val(detail["LoginPassword1"]);
	}

	if (detail["LoginPassword2"]) {
		$("#otherPassword").val(detail["LoginPassword2"]);	
	}
	familyCode = temp;
}

function getPasswordTypeList(){
	$.ajax({
	    method: "GET",
	    url: "getMasters.php",
	    data: { 
	        passwordType: 1
	     }
	  })
	    .done(function(msg) {
	      var passwordType = JSON.parse(msg);
	      //console.log(passwordType);
	      setPasswordTypeAutoComplete(passwordType);
	    });
}

function setPasswordTypeAutoComplete(tags){
	var data = [],
		dataIndex = [];
	for (var i = 0; i < tags.length; i++) {
		var arr = tags[i].split(",");
		data.push(arr[1]);
		dataIndex.push(arr[0]);
	};

	//console.log(data);
	$("#passwordType").autocomplete({
      source: data,
      select: function( event, ui ) {
      	var index = $.inArray(ui.item.value, data);
      	$("#passwordTypeCode").val(dataIndex[index]);
      }
    });
}

$(document).ready(function() {
	getFamilyList();
	getPasswordList();
	getPasswordTypeList();

	$('#addPassword').on('shown.bs.modal', function () {
	  $("#modalHeading").html(modalHeading);
	})

	//Password form submit
	$("#form-passwords").ajaxForm({
		beforeSubmit:function(){
	    },
	    success: function(responseText, statusText, xhr, $form){
	    	console.log(responseText);
	    	var response = JSON.parse(responseText);
	    	if (response.status == 0) {
	    		showNotificationFailure(response.message);
	    	}
	      	else{
	      		getPasswordList();
				getPasswordTypeList();
	      		showNotificationSuccess(response.message);
	      		$("#addPassword").modal("hide");
	      	}
	    }
	});

	//Password form submit
	$("#form-password-delete").ajaxForm({
		beforeSubmit:function(){
	    },
	    success: function(responseText, statusText, xhr, $form){
	    	console.log(responseText);
	    	var response = JSON.parse(responseText);
	    	if (response.status == 0) {
	    		showNotificationFailure(response.message);
	    	}
	      	else{
	      		getPasswordList();
				getPasswordTypeList();
	      		showNotificationSuccess(response.message);
	      		$("#deletePassword").modal("hide");
	      	}
	    }
	});
});