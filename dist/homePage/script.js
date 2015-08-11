$(document).ready(function(){
	$(".mobile").focusout(function(){
		//alert("focusout");
		var mobile = $(this).val();
		var formGroup = $(this).closest(".form-group");
		if (mobile.length < 10) {
			formGroup.addClass("has-error");
		}
		else{
			formGroup.addClass("has-success");
		}
	});

	$("#form-signup").ajaxForm({
	    beforeSubmit:function(){
	      
	    },
	    success: function(responseText, statusText, xhr, $form){
	    	console.log(responseText);
	    	var response = JSON.parse(responseText);
	    	if (response.status == 0) {
	    		showNotificationFailure(response.message);
	    	}
	      
	    },
  	});
});