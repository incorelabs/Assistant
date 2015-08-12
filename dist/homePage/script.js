//var root = "http://incorelabs.com/Assist/";
var root = "http://localhost/assist/";

$(document).ready(function(){
	$(".mobile").focusout(function(){
		//alert("focusout");
		var mobile = $(this).val();
		var formGroup = $(this).closest(".form-group");
		if (mobile.length != 10) {
			console.log("false");
			formGroup.removeClass("has-success");
			formGroup.addClass("has-error");
		}
		else{
			console.log("true");
			formGroup.removeClass("has-error");
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
	      	else{
	      		showNotificationSuccess(response.message);
	      		window.location.href = "login.php";
	      	}
	    },
  	});

  	$("#form-login").ajaxForm({
	    beforeSubmit:function(){
	      console.log("Test");
	    },
	    success: function(responseText, statusText, xhr, $form){
	    	console.log(responseText);
	    	var response = JSON.parse(responseText);
	    	if (response.status == 0) {
	    		showNotificationFailure(response.message);
	    	}
	      	else{
	      		showNotificationSuccess(response.message);
	      		window.location.href = "index.php";
	      	}
	    },
  	});

  	$("#logout").click(function(event){
 
  		$.ajax({
		    method: "GET",
		    url: root+"api/logout.php",
		  })
		    .done(function(msg) {
		      var response = JSON.parse(msg);
		      if (response.status == 1) {
		      	window.location.href = "index.php";
		      }
		      else{
		      	showNotificationFailure("Logout unsuccessfully. Please try again");
		      }
		    });
  	});
});