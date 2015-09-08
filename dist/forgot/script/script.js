$(document).ready(function() {
	$("#form-forgot").ajaxForm({
		beforeSubmit:function(){
			$(".cover").fadeIn(100);
			$("#pageLoading").addClass("loader");
		},
	    success: function(responseText, statusText, xhr, $form){
	    	console.log(responseText);
	    	var response = JSON.parse(responseText);
	    	if (response.status == 0) {
	    		showNotificationFailure(response.message);
	    	}
	      	else{
	      		showNotificationSuccess(response.message);
	      		window.location.href = "../login.php";
	      	}
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
	    }
	});
});