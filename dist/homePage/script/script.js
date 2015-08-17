$(document).ready(function(){
	var downpayment = document.getElementById('forgotEmail'),
    full_payment = document.getElementById('forgotMobile');

	function enableToggle(current, other) {
	    other.disabled = current.value.replace(/\s+/,'').length > 0 ? true : false;
	}

	downpayment.onkeyup = function () {
	    enableToggle(this, forgotMobile);
	}
	full_payment.onkeyup = function () {
	    enableToggle(this, forgotEmail);
	}

	$("#form-signup").ajaxForm({
	    beforeSubmit:function(){
	      if(email_count == 1 && pwd_count == 1 && c_pwd_count == 1 && name_count == 1 && country_count == 1 && mobile_count == 1 && dob_count == 1)
			{
				return true;	 
			}
			else{
				validateEmail(".email");
				validatePassword(".password");
				validateConfirmPassword(".password",".c_password");
				validateName(".name");
				validateMobile(".mobile");
				validateCountry("#country");
				validateDate(".date");
				return false;
			}
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
});