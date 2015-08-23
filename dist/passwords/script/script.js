var familyList;

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

$(document).ready(function() {
	getFamilyList();

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