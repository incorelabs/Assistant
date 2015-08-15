var familyList;
var relationList;

function getFamilyList(){
	$.ajax({
	    method: "GET",
	    url: root+"family/getFamily.php",
	    data: { 
	        list: 1
	     }
	  })
	    .done(function(msg) {
	      familyList = JSON.parse(msg);
	      console.log(familyList);
	      setFamilyList(familyList);
	    });
}

function setFamilyList(arr){
	var str = "";
	for (var i = 0; i < arr.length; i++) {
		var gender;
		if (arr[i]['Gender']) {
			if (arr[i]['Gender'] == 0) {
				gender = "-";
			}
			else{
				if (arr[i]['Gender'] == 1) {
					gender = "Male";
				}
				else{
					if (arr[i]['Gender'] == 2) {
						gender = "Female";
					}
					else{
						gender = "Others";
					}
				}
			}
		}
		else{
			gender = "-";
		}

		str += "<tr class='text-left'><td>"+(i+1)+"</td><td>"+arr[i]['FamilyName']+"</td><td class='hidden-xs hidden-sm'>"+((arr[i]['RelationName']) ? arr[i]['RelationName'] : "-")+"</td><td class='hidden-xs hidden-sm'>"+((arr[i]['BirthDate']) ? arr[i]['BirthDate'] : "-")+"</td><td class='hidden-xs hidden-sm'>"+((arr[i]['Email']) ? arr[i]['Email'] : "-")+"</td><td>"+((arr[i]['Mobile']) ? arr[i]['Mobile'] : "-")+"</td><td class='hidden-xs hidden-sm'>"+(gender)+"</td><td>"+((arr[i]['LoginFlag']) ? ((arr[i]['LoginFlag'] == 1) ? "Yes" : "No") : "-")+"</td><td><a href='#' data-toggle='modal' data-target='#addFamily'><i class='fa fa-pencil fa-lg fa-green'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' data-toggle='modal' data-target='#deleteFamily'><i class='fa fa-trash-o fa-lg fa-red'></i></a></td></tr>";
	}
	$("#table-body").html(str);
}

function getRelationList(){
	$.ajax({
	    method: "GET",
	    url: root+"family/getRelation.php",
	    data: { 
	        list: 1
	     }
	  })
	    .done(function(msg) {
	      relationList = JSON.parse(msg);
	      //console.log(relationList);
	      setRelationList(relationList);
	    });
}

function setRelationList(arr){
	var str = "<option value=''>Select Relation</option>";
	for (var i = 0; i < arr.length; i++) {
		str += "<option value="+arr[i]['RelationCode']+">"+arr[i]['RelationName']+"</option>"
	}
	$("#relation").html(str);
}

function showhidediv( rad )
{
    var rads = document.getElementsByName( rad.name );
    document.getElementById( 'loginAccess' ).style.display = ( rads[0].checked ) ? 'block' : 'none';
    document.getElementById( 'loginAccess' ).style.display = ( rads[1].checked ) ? 'none' : 'block';
}

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

function validateRelation(element){
	var relation = $(element).val();
	var formGroup = $(element).closest(".form-group");
	if (relation == "") 
	{
		formGroup.removeClass("has-success");
		formGroup.addClass("has-error");
		$(element).closest('.form-group').find('.info').html("Select a Relation");
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

$(document).ready(function(){

	getFamilyList();
	getRelationList();

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

	$("#relation").change(function(event){
		console.log($(this).val());
		var relationCode = $(this).val();
		if (relationCode != "") {
			for (var i = 0; i < relationList.length; i++) {
				if (relationList[i]['RelationCode'] == relationCode){
					console.log(relationList[i]["Gender"]);
					$("#gender").val(relationList[i]["Gender"]);
					break;
				}
			}
		}
		else{
			$("#gender").val("");	
		}
	});

	$("#form-family").ajaxForm({
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
	      		getFamilyList();
	      	}
	      	$("#addFamily").modal('hide');
	    },
	});
});


