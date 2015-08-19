var familyList;
var relationList;
var personDetail;
var mode = 1;

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

		str += "<tr class='text-left'><td>"+(i+1)+"</td><td>"+arr[i]['FamilyName']+"</td><td class='hidden-xs hidden-sm'>"+((arr[i]['RelationName']) ? arr[i]['RelationName'] : "-")+"</td><td class='hidden-xs hidden-sm'>"+((arr[i]['BirthDate']) ? arr[i]['BirthDate'] : "-")+"</td><td class='hidden-xs hidden-sm'>"+((arr[i]['Email']) ? arr[i]['Email'] : "-")+"</td><td>"+((arr[i]['Mobile']) ? arr[i]['Mobile'] : "-")+"</td><td class='hidden-xs hidden-sm'>"+(gender)+"</td><td>"+((arr[i]['LoginFlag']) ? ((arr[i]['LoginFlag'] == 1) ? "Yes" : "No") : "-")+"</td><td><a href='#' onclick='editFamily("+i+")'><i class='fa fa-pencil fa-lg fa-green'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='deleteFamily("+i+")'><i class='fa fa-trash-o fa-lg fa-red'></i></a></td></tr>";
	}
	$("#table-body").html(str);
}

function editFamily(index){
	//console.log(familyList[index]);
	initializeDate();
	mode = 2;
	$("#familyModalHeading").html("Edit");
	personDetail = familyList[index];
	setInputFields(personDetail);
	$("#familyCode").val(personDetail["FamilyCode"]);
	//$("#form-family").attr("action","edit.php");
	$("#input-type").val('M');
	$("#addFamily").modal('show');
}

function deleteFamily(index){
	personDetail = familyList[index];
	$("#deleteFamilyCode").val(personDetail['FamilyCode']);
	$("#form-delete-mode").val("D");
	$("#deleteFamily").modal('show');
}

function setInputFields(personDetail){
	if (personDetail["FamilyName"]) {
		$("#firstName").val(personDetail["FamilyName"]);
	}
	if (personDetail["RelationCode"]) {
		$("#relation").val(personDetail["RelationCode"]);
	}
	if (personDetail["BirthDate"]) {
		$("#dob").val(personDetail["BirthDate"]);
	}
	if (personDetail["Email"]) {
		$("#email").val(personDetail["Email"]);
	}
	if (personDetail["Mobile"]) {
		$("#mobile").val(personDetail["Mobile"]);
	}
	if (personDetail["Gender"]) {
		$("#gender").val(personDetail["Gender"]);
	}
	if (personDetail["LoginFlag"]) {
		if (personDetail["LoginFlag"] == 1) {
			$('input:radio[name=access]')[0].checked = true;
		}
		else{
			$('input:radio[name=access]')[1].checked = true;
		}
	}
	document.getElementById( 'loginAccess' ).style.display = 'none';
	$("#password").val("");
	$("#confirmPassword").val("");
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
		//$("#familyCode").val(personDetail["FamilyCode"]);
		initializeDate();
		mode = 1;
		//$("#form-family").attr("action","add.php");
		$("#input-type").val('A');
		$("#addFamily").modal('show');
		document.getElementById( 'loginAccess' ).style.display = 'none';
	});
	
	$('#addFamily').on('show.bs.modal', function (e) {
	  $('.info').empty();
	  $('.form-group').removeClass("has-success");
	  $('.form-group').removeClass("has-error");
	  $("#familyModalHeading").html("Edit");
	  if (mode == 2) {
	  	$("#familyModalHeading").html("Edit");
	  }else{
	  	$("#familyModalHeading").html("Add");
	  }
	  
	  //var rads = document.getElementsByName( 'access' );
	  //document.getElementById( 'loginAccess' ).style.display = ( rads[1].checked ) ? 'none' : 'block';
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
	      		setTimeout(function(){
	      			getFamilyList();
	      		},500);
	      	}
	      	$("#addFamily").modal('hide');
	    },
	});

	$("#form-family-delete").ajaxForm({
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
	      		setTimeout(function(){
	      			getFamilyList();
	      		},500);
	      	}
	      	$("#deleteFamily").modal('hide');
	    },
	});
});


