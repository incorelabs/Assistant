var familyList;
var passwordList;

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
	      console.log(familyList);
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
	      console.log(passwordList);
	      setPasswordList(passwordList);
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
	
	var encryptedPassword1 = "-";
	if (detail["LoginPassword1"]) {
		encryptedPassword1 = detail["LoginPassword1"].replace(/./gi, "*");
	}
	
	var encryptedPassword2 = detail["LoginPassword2"].replace(/./gi, "*");
	if (detail["LoginPassword2"]) {
		encryptedPassword2 = detail["LoginPassword2"].replace(/./gi, "*");
	}
	var str= "";
	str += "<div class='panel-height'><!-- List group --><div id='passwordBody' class='list-group'><div class='list-group-item list-group-item-border'><div class='row contact-details' style='padding-top:0px'><div class='list-group-item-heading header_font'><div class='col-md-3'>Holder's Name</div><value><div class='col-md-9'>"+detail["HolderName"]+"</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password Type</div><value><div class='col-md-9'>"+detail["PasswordTypeName"]+"</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Description</div><value><div class='col-md-9'>"+detail["PasswordName"]+"</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Login ID</div><value><div class='col-md-9'>"+detail["LoginID"]+"</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password</div><value><div class='col-md-9'><div class='textShow'>"+detail["LoginPassword1"]+"</div><div class='pull-right' style='margin-top:-22px'><a href='#' id='passwordEncrypt'><i class='fa fa-eye fa-lg'></i></a></div></div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Optional Password</div><value><div class='col-md-9'><div class='textShow'>"+detail["LoginPassword2"]+"</div><div class='pull-right' style='margin-top:-22px'><a href='#' id='passwordEncrypt'><i class='fa fa-eye fa-lg'></i></a></div></div></value></div></div></div></div><!--List close--></div>";
	
	$("#password-Detail").html(str);
}

$(document).ready(function() {
	getFamilyList();
	getPasswordList();

	//Toggle password
	$("#passwordEncrypt").click(function () {
        $(".textShow").text(function(original, encrypted){
           return encrypted == originalPassword ? encryptedPassword : originalPassword
        })
    });

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
	      		showNotificationSuccess(response.message);
	      	}
	    }
	});
});