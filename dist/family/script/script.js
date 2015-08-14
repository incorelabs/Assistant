function showhidediv( rad )
    {
        var rads = document.getElementsByName( rad.name );
        document.getElementById( 'loginAccess' ).style.display = ( rads[0].checked ) ? 'block' : 'none';
        document.getElementById( 'loginAccess' ).style.display = ( rads[1].checked ) ? 'none' : 'block';
    }
$(document).ready(function(){

	$("#gender").focusout(function(){
		validateGender(this);
	});

	$("#gender").focusin(function()
	{
		var gender = $(this).val();
		var formGroup = $(this).closest(".form-group");
		formGroup.removeClass("has-error");
		$(this).closest('.form-group').find('.info').empty();
	});

	function validateGender(element){
		var gender = $(element).val();
		var formGroup = $(element).closest(".form-group");
		if (gender == "") 
		{
			formGroup.removeClass("has-success");
			formGroup.addClass("has-error");
			$(element).closest('.form-group').find('.info').html("Select a Gender");
			country_count = 0;
		}
		else
		{
			formGroup.removeClass("has-error");
			formGroup.addClass("has-success");
			$(element).closest('.form-group').find('.info').empty();
			country_count = 1;
		}
	}

	$("#relation").focusout(function(){
		validateRelation(this);
	});

	$("#relation").focusin(function()
	{
		var relation = $(this).val();
		var formGroup = $(this).closest(".form-group");
		formGroup.removeClass("has-error");
		$(this).closest('.form-group').find('.info').empty();
	});

	function validateRelation(element){
		var relation = $(element).val();
		var formGroup = $(element).closest(".form-group");
		if (relation == "") 
		{
			formGroup.removeClass("has-success");
			formGroup.addClass("has-error");
			$(element).closest('.form-group').find('.info').html("Select a Gender");
			country_count = 0;
		}
		else
		{
			formGroup.removeClass("has-error");
			formGroup.addClass("has-success");
			$(element).closest('.form-group').find('.info').empty();
			country_count = 1;
		}
	}

	$("#btn-addFamily").click(function(event){
		document.getElementById("form-family").reset();
	});
	
	$('#addFamily').on('show.bs.modal', function (e) {
	  $('.info').empty();
	  $('.form-group').removeClass("has-success");
	  $('.form-group').removeClass("has-error");
	  var rads = document.getElementsByName( 'access' );
	  document.getElementById( 'no' ).checked = true;
	  document.getElementById( 'loginAccess' ).style.display = ( rads[1].checked ) ? 'none' : 'block';
	});

});