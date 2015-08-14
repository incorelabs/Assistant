$(document).ready(function(){
	var errorStatus = [false,false,false,false,false,false,false];
	var email_count = 0;
	var pwd_count = 0;
	var c_pwd_count = 0;
	var name_count = 0;
	var country_count = 0;
	var mobile_count = 0;
	var dob_count = 0;

	$(".email").focusout(function(){
		validateEmail(this);
	});

	$(".email").focusin(function()
	{
		var email = $(this).val();
		var formGroup = $(this).closest(".form-group");
		formGroup.removeClass("has-error");
		$(this).closest('.form-group').find('.info').empty();
	});

	function validateEmail(element){
		var email = $(element).val();
		var formGroup = $(element).closest(".form-group");
		var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  		if(email.length == "" || email.length == 0)
  		{
  			formGroup.removeClass("has-success");
			formGroup.addClass("has-error");
			email_count = 0;
			errorStatus[0] = false;
			$(element).closest('.form-group').find('.info').html("Please Enter an Email Address");
  		}
  		
		
		else
		{
			if(re.test(email))
			{
				formGroup.addClass("has-success");
				formGroup.removeClass("has-error");
				$(element).closest('.form-group').find('.info').empty();
				email_count = 1;
				errorStatus[0] = true;
			}
			else
			{
				formGroup.removeClass("has-success");
				formGroup.addClass("has-error");
				email_count = 0;
				errorStatus[0] = false;
				$(element).closest('.form-group').find('.info').html("Please Enter a Valid Email Address");
			}
			
		}
	}

	$(".password").focusout(function(){
		validatePassword(this);
	});

	$(".password").focusin(function()
	{
		var email = $(this).val();
		var formGroup = $(this).closest(".form-group");
		formGroup.removeClass("has-error");
		$(this).closest('.form-group').find('.info').empty();
	});

	function validatePassword(element){
		var password = $(element).val();
		var formGroup = $(element).closest(".form-group");
		var letter = /[a-zA-Z]/;
    	var number = /[0-9]/;
		var msg = "";

  		if(password.length == 0)
		{
			formGroup.removeClass("has-success");
			formGroup.addClass("has-error");
			$(element).closest('.form-group').find('.info').html("Please Enter a Password");
			pwd_count = 0
			errorStatus[1] = false;
		}
		
		else
		{
			if(password.length < 8 || password.length >16)
			{
				formGroup.removeClass("has-success");
				formGroup.addClass("has-error");
				$(element).closest('.form-group').find('.info').html("Password should between 8 to 16 characters");
				pwd_count = 0;
				errorStatus[1] = false;
			}

			else
			{
				if ( number.test(password) && letter.test(password) )
				{
					formGroup.addClass("has-success");
					formGroup.removeClass("has-error");
					$(element).closest('.form-group').find('.info').empty();
					pwd_count = 1;	
					errorStatus[1] = true;
				}
				else
				{
					formGroup.removeClass("has-success");
					formGroup.addClass("has-error");
					$(element).closest('.form-group').find('.info').html("Password should atleast have 1 alphabet and one number");
					pwd_count = 0;	
					errorStatus[1] = false;
				}
			}	
		}
	}

	$(".c_password").focusout(function(){
		
		validateConfirmPassword(".password",this);
	});
	$(".c_password").focusin(function()
	{
		var email = $(this).val();
		var formGroup = $(this).closest(".form-group");
		formGroup.removeClass("has-error");
		$(this).closest('.form-group').find('.info').empty();
	});

	function validateConfirmPassword(p,element){
		var password = $(p).val();
		var c_password = $(element).val();
		var formGroup = $(element).closest(".form-group");
		if(c_password.length == 0 || c_password.length == "")
		{
			formGroup.removeClass("has-success");
			formGroup.addClass("has-error");
			$(element).closest('.form-group').find('.info').html("Please Enter Confirm Password");
			c_pwd_count = 0;
			errorStatus[2] = false;
		}
		else
		{
			if(c_password == password)
			{
				formGroup.addClass("has-success");
				formGroup.removeClass("has-error");
				$(element).closest('.form-group').find('.info').empty();
				c_pwd_count = 1;
				errorStatus[2] = true;
			}
			else
			{
				formGroup.removeClass("has-success");
				formGroup.addClass("has-error");
				$(element).closest('.form-group').find('.info').html("Passwords do not match");
				c_pwd_count = 0;
				errorStatus[2] = false;
			}
		}
	}

	$(".name").focusout(function(){
		validateName(this);
	});
	$(".name").focusin(function()
	{
		var email = $(this).val();
		var formGroup = $(this).closest(".form-group");
		formGroup.removeClass("has-error");
		$(this).closest('.form-group').find('.info').empty();
	});

	function validateName(element){
		var name = $(element).val();
		var formGroup = $(element).closest(".form-group");
		if (name.length == 0 || name.length == "")
		{
			formGroup.removeClass("has-success");
			formGroup.addClass("has-error");
			$(element).closest('.form-group').find('.info').html("Please Enter a Name");
			name_count = 0;
			errorStatus[3] = false;
		}
		else
		{
			if (name.length < 3 || name.length > 40) 
			{
				formGroup.addClass("has-error");
				formGroup.removeClass("has-success");
				$(element).closest('.form-group').find('.info').html("Please Enter a Valid Name");
				name_count = 0;
				errorStatus[3] = false;
			}
			else
			{
				if(!name.match(/^[a-zA-Z\s]+$/))
				{
					formGroup.addClass("has-error");
					formGroup.removeClass("has-success");
					$(element).closest('.form-group').find('.info').html("Name must consist of alphabets only");
					name_count = 0;
					errorStatus[3] = false;
				}
				else
				{
					formGroup.removeClass("has-error");
					formGroup.addClass("has-success");
					$(element).closest('.form-group').find('.info').empty();
					name_count = 1;
					errorStatus[3] = true;
				}
			}
		}
	}

	$("#country").focusout(function(){
		validateCountry(this);
	});

	$("#country").focusin(function()
	{
		var email = $(this).val();
		var formGroup = $(this).closest(".form-group");
		formGroup.removeClass("has-error");
		$(this).closest('.form-group').find('.info').empty();
	});

	function validateCountry(element){
		var country = $(element).val();
		var formGroup = $(element).closest(".form-group");
		if (country == "") 
		{
			formGroup.removeClass("has-success");
			formGroup.addClass("has-error");
			$(element).closest('.form-group').find('.info').html("Select a Country");
			country_count = 0;
			errorStatus[4] = false;
		}
		else
		{
			formGroup.removeClass("has-error");
			formGroup.addClass("has-success");
			$(element).closest('.form-group').find('.info').empty();
			country_count = 1;
			errorStatus[4] = true;
		}
	}

	$(".mobile").focusout(function(){
		validateMobile(this);
	});

	$(".mobile").focusin(function()
	{
		var email = $(this).val();
		var formGroup = $(this).closest(".form-group");
		formGroup.removeClass("has-error");
		$(this).closest('.form-group').find('.info').empty();
	});

	function validateMobile(element){
		var mobile = $(element).val();
		var indNum = /^[0]?[56789]\d{9}$/;
		var country = $('#country').val();
		var formGroup = $(element).closest(".form-group");
		if (country == "")
		{
			formGroup.removeClass("has-success");
				formGroup.addClass("has-error");
				$(element).closest('.form-group').find('.info').html("Please Select a country");
				mobile_count = 0;
				errorStatus[5] = false;
		}
		else
		{
			if (mobile.length != 10 || isNaN(mobile))
			{
					formGroup.removeClass("has-success");
					formGroup.addClass("has-error");
					$(element).closest('.form-group').find('.info').html("Please Enter a Valid Phone Number");
					mobile_count = 0;
					errorStatus[5] = false;
			}
			else
			{
				if(country == 1046)
				{
					if(indNum.test(mobile))
					{
						formGroup.removeClass("has-error");
						formGroup.addClass("has-success");
						$(element).closest('.form-group').find('.info').empty();
						mobile_count = 1;
						errorStatus[5] = true;
					}
					else
					{
						formGroup.removeClass("has-success");
						formGroup.addClass("has-error");
						$(element).closest('.form-group').find('.info').html("Please Enter a Valid Phone Number");
						mobile_count = 0;
						errorStatus[5] = false;
					}
				}
				else
				{
					formGroup.removeClass("has-error");
					formGroup.addClass("has-success");
					$(element).closest('.form-group').find('.info').empty();
					mobile_count = 1;
					errorStatus[5] = true;
				}
			}
		}
	}

	$(".date").focusout(function(){
		validateDate(this);
	});

	$(".date").focusin(function()
	{
		var email = $(this).val();
		var formGroup = $(this).closest(".form-group");
		formGroup.removeClass("has-error");
		$(this).closest('.form-group').find('.info').empty();
	});

	function validateDate(element){
		var formGroup = $(element).closest(".form-group");
		var date = new MyDate($(element).val());
		if (date.isValid()){
			formGroup.removeClass("has-error");
			formGroup.addClass("has-success");
			$(element).closest('.form-group').find('.info').empty();
			dob_count = 1;
			errorStatus[6] = true;
		}
		else{
			formGroup.removeClass("has-success");
			formGroup.addClass("has-error");
			$(element).closest('.form-group').find('.info').html("Invalid Date. Enter Date in dd/mm/yyyy format");
			dob_count = 0;
			errorStatus[6] = false;
		}
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