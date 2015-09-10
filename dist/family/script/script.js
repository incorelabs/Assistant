var pageFamily = {
    familyList: null,
    relationList: null,
    personDetail: null,
    mode: 1,
    isYesEnabled: true,
    isNoEnabled: true,
    getFamilyList: function () {
        var url = localStorage.getItem("websiteRoot") + "family/getFamily.php";

        $.getJSON(url, {
            list: 1
        }).done(function (data) {
            console.log(data);
            pageFamily.setFamilyList(data);
        }).fail(function (error) {

        });
    },
    setFamilyList: function (data) {
        pageFamily.familyList = data;
        var familyTableString = "";
        for (var i = 0; i < data.length; i++) {
            var gender;
            if (data[i]['Gender']) {
                if (data[i]['Gender'] == 0) {
                    gender = "-";
                }
                else {
                    if (data[i]['Gender'] == 1) {
                        gender = "Male";
                    }
                    else {
                        if (data[i]['Gender'] == 2) {
                            gender = "Female";
                        }
                        else {
                            gender = "Others";
                        }
                    }
                }
            }
            else {
                gender = "-";
            }

            familyTableString += "<tr class='text-left'><td>" + (i + 1) + "</td><td>" + data[i]['FamilyName'] + "</td><td class='hidden-xs hidden-sm'>" + ((data[i]['RelationName']) ? data[i]['RelationName'] : "-") + "</td><td class='hidden-xs hidden-sm'>" + ((data[i]['BirthDate']) ? data[i]['BirthDate'] : "-") + "</td><td class='hidden-xs hidden-sm'>" + ((data[i]['Email']) ? data[i]['Email'] : "-") + "</td><td>" + ((data[i]['Mobile']) ? data[i]['Mobile'] : "-") + "</td><td class='hidden-xs hidden-sm'>" + (gender) + "</td><td>" + ((data[i]['LoginFlag']) ? ((data[i]['LoginFlag'] == 1) ? "Yes" : "No") : "-") + "</td><td><a href='#' onclick='pageFamily.editFamily(" + i + ")'><i class='fa fa-pencil fa-lg fa-green'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='pageFamily.deleteFamily(" + i + ")'><i class='fa fa-trash-o fa-lg fa-red'></i></a></td></tr>";
        }
        $("#table-body").html(familyTableString);
    },
    editFamily: function (index) {
        //console.log(familyList[index]);
        initializeDate();
        pageFamily.mode = 2;
        $("#familyModalHeading").html("Edit");
        pageFamily.personDetail = pageFamily.familyList[index];
        pageFamily.setInputFields(pageFamily.personDetail);
        $("#familyCode").val(pageFamily.personDetail["FamilyCode"]);
        //$("#form-family").attr("action","edit.php");
        $("#mode").val('M');
        $("#addFamily").modal('show');
    },
    deleteFamily: function (index) {
        pageFamily.personDetail = pageFamily.familyList[index];
        $("#deleteFamilyCode").val(pageFamily.personDetail['FamilyCode']);
        $("#form-delete-mode").val("D");
        $("#deleteFamily").modal('show');
    },
    setInputFields: function (personDetail) {
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
        else {
            $("#mobile").val("");
        }
        if (personDetail["Gender"]) {
            $("#gender").val(personDetail["Gender"]);
        }
        if (personDetail["FamilyCode"] == 1001) {
            $("#provideLoginDiv").addClass("hidden");
        }
        else {
            $("#provideLoginDiv").removeClass("hidden");
        }
        if (personDetail["LoginFlag"]) {
            if (personDetail["LoginFlag"] == 1) {
                $('input:radio[name=access]')[0].checked = true;
                pageFamily.isYesEnabled = false;
                pageFamily.isNoEnabled = true;
                $("#email").attr("readonly", true);
            }
            else {
                $('input:radio[name=access]')[1].checked = true;
                pageFamily.isYesEnabled = true;
                pageFamily.isNoEnabled = false;
                $("#email").removeAttr("readonly");
            }
        }

        document.getElementById('loginAccess').style.display = 'none';
        $("#password").val("");
        $("#confirmPassword").val("");
    },
    getRelationList: function () {
        var url = localStorage.getItem("websiteRoot") + "family/getRelation.php";

        $.getJSON(url, {
            list: 1
        }).done(function (data) {
            console.log(data);
            pageFamily.setRelationList(data);
        }).fail(function (error) {

        });
    },
    setRelationList: function (data) {
        var relationListString = "<option value=''>Select Relation</option>";
        for (var i = 0; i < data.length; i++) {
            relationListString += "<option value=" + data[i]['RelationCode'] + ">" + data[i]['RelationName'] + "</option>"
        }
        $("#relation").html(relationListString);
    },
    showHideDiv: function (radioCheckBox) {
        var radioCheckBoxName = document.getElementsByName(radioCheckBox.name);
        document.getElementById('loginAccess').style.display = ( radioCheckBoxName[0].checked ) ? 'block' : 'none';
        document.getElementById('loginAccess').style.display = ( radioCheckBoxName[1].checked ) ? 'none' : 'block';
    },
    validateGender: function (element) {
        var gender = $(element).val();
        var formGroup = $(element).closest(".form-group");
        if (gender == "") {
            formGroup.removeClass("has-success");
            formGroup.addClass("has-error");
            $(element).closest('.form-group').find('.info').html("Select a Gender");
            pageIndex.country_count = 0;
        }
        else {
            formGroup.removeClass("has-error");
            formGroup.addClass("has-success");
            $(element).closest('.form-group').find('.info').empty();
            pageIndex.country_count = 1;
        }
    },
    validateRelation: function (element) {
        var relation = $(element).val();
        var formGroup = $(element).closest(".form-group");
        if (relation == "") {
            formGroup.removeClass("has-success");
            formGroup.addClass("has-error");
            $(element).closest('.form-group').find('.info').html("Select a Relation");
            pageIndex.country_count = 0;
        }
        else {
            formGroup.removeClass("has-error");
            formGroup.addClass("has-success");
            $(element).closest('.form-group').find('.info').empty();
            pageIndex.country_count = 1;
        }
    }
};

$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../");

    pageFamily.getFamilyList();
    pageFamily.getRelationList();

    $("#gender").focusout(function () {
        pageFamily.validateGender(this);
    });

    $("#gender").focusin(function () {
        var gender = $(this).val();
        var formGroup = $(this).closest(".form-group");
        formGroup.removeClass("has-error");
        $(this).closest('.form-group').find('.info').empty();
    });

    $("#relation").focusout(function () {
        pageFamily.validateRelation(this);
    });

    $("#relation").focusin(function () {
        var relation = $(this).val();
        var formGroup = $(this).closest(".form-group");
        formGroup.removeClass("has-error");
        $(this).closest('.form-group').find('.info').empty();
    });

    $("#btn-addFamily").click(function (event) {
        document.getElementById("form-family").reset();
        $("#password").attr("type", "password");
        $("#confirmPassword").attr("type", "password");
        //$("#familyCode").val(personDetail["FamilyCode"]);
        initializeDate();
        pageFamily.mode = 1;
        //$("#form-family").attr("action","add.php");
        $("#mode").val('A');
        $("#addFamily").modal('show');
        document.getElementById('loginAccess').style.display = 'none';
    });

    $('#addFamily').on('show.bs.modal', function (e) {
        $('.info').empty();
        $('.form-group').removeClass("has-success");
        $('.form-group').removeClass("has-error");
        $("#familyModalHeading").html("Edit");
        if (pageFamily.mode == 2) {
            $("#familyModalHeading").html("Edit");
        } else {
            $("#familyModalHeading").html("Add");
        }

        //var rads = document.getElementsByName( 'access' );
        //document.getElementById( 'loginAccess' ).style.display = ( rads[1].checked ) ? 'none' : 'block';
    });

    $("#relation").change(function (event) {
        console.log($(this).val());
        var relationCode = $(this).val();
        if (relationCode != "") {
            for (var i = 0; i < pageFamily.relationList.length; i++) {
                if (pageFamily.relationList[i]['RelationCode'] == relationCode) {
                    console.log(pageFamily.relationList[i]["Gender"]);
                    $("#gender").val(pageFamily.relationList[i]["Gender"]);
                    break;
                }
            }
        }
        else {
            $("#gender").val("");
        }
    });

    $("#form-family").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                pageIndex.showNotificationFailure(response.message);
            }
            else {
                pageIndex.showNotificationSuccess(response.message);
                setTimeout(pageFamily.getFamilyList(), 200);
            }
            $("#addFamily").modal('hide');
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $("#form-family-delete").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                pageIndex.showNotificationFailure(response.message);
            }
            else {
                pageIndex.showNotificationSuccess(response.message);
                setTimeout(pageFamily.getFamilyList(), 200);
            }
            $("#deleteFamily").modal('hide');
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $("#yes").click(function (event) {
        if (pageFamily.isYesEnabled) {
            pageFamily.showHideDiv(this);
        }
        return pageFamily.isYesEnabled;
    });

    $("#no").click(function (event) {
        if (pageFamily.isNoEnabled) {
            pageFamily.showHideDiv(this);
        }
        return pageFamily.isNoEnabled;
    });
});