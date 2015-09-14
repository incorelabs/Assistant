var pageFamily = {
    isParentLoggedIn: false,
    familyList: null,
    relationList: null,
    personDetail: null,
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

            familyTableString += "<tr class='text-left'>";
            familyTableString += "<td>" + (i + 1) + "</td><td>" + data[i]['FamilyName'] + "</td>";
            familyTableString += "<td class='hidden-xs hidden-sm'>" + ((data[i]['RelationName']) ? data[i]['RelationName'] : "-") + "</td>";
            familyTableString += "<td class='hidden-xs hidden-sm'>" + ((data[i]['BirthDate']) ? data[i]['BirthDate'] : "-") + "</td>";

            familyTableString += "<td class='hidden-xs hidden-sm'>" + ((data[i]['Email']) ? data[i]['Email'] : "-") + "</td>";

            familyTableString += "<td>" + ((data[i]['Mobile']) ? data[i]['Mobile'] : "-") + "</td>";

            familyTableString += "<td class='hidden-xs hidden-sm'>" + (gender) + "</td>";

            familyTableString += "<td>" + ((data[i]['LoginFlag']) ? ((data[i]['LoginFlag'] == 1) ? "Yes" : "No") : "-") + "</td>";

            if (pageFamily.isParentLoggedIn) {
                // This is the parent, so show only edit for him and for the rest show edit and delete.
                if (data[i]['FamilyCode'] == familyCode) {
                    familyTableString += "<td><a href='#' onclick='pageFamily.openEditFamilyModal(" + i + ")'><i class='fa fa-pencil fa-lg fa-green'></i></a></td>";
                } else {
                    familyTableString += "<td><a href='#' onclick='pageFamily.openEditFamilyModal(" + i + ")'><i class='fa fa-pencil fa-lg fa-green'></i></a>";
                    familyTableString += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='pageFamily.openDeleteFamilyModal(" + data[i].FamilyCode + ")'><i class='fa fa-trash-o fa-lg fa-red'></i></a></td>";
                }
            } else {
                // This is the child, so show only edit for his.
                if (data[i]['FamilyCode'] == familyCode) {
                    familyTableString += "<td><a href='#' onclick='pageFamily.openEditFamilyModal(" + i + ")'><i class='fa fa-pencil fa-lg fa-green'></i></a></td>";
                }
            }

            familyTableString += "</tr>";
        }
        $("#table-body").html(familyTableString);
    },
    openAddFamilyModal: function () {
        document.getElementById("familyForm").reset();

        $("#passwordDiv").empty();
        $("#confirmPasswordDiv").empty();

        initializeDate();

        $("#form-add-edit-mode").val('A');
        $("#form-add-edit-code").val(1);

        $('#familyModalHeading').empty();
        $('#familyModalHeading').html("Add Family Member");

        if (pageFamily.isParentLoggedIn)
            $("#provideLoginDiv").removeClass("hidden");

        $("#email").removeAttr("readonly");
        $("#passwordDiv").html(pageFamily.getPasswordDivString());
        $("#confirmPasswordDiv").html(pageFamily.getConfirmPasswordDivString());

        /*$("#password").attr("type", "password");
         $("#confirmPassword").attr("type", "password");*/

        $("#loginAccess").addClass("hidden");

        $("#familyModal").modal('show');
        //document.getElementById('loginAccess').style.display = 'none';
    },
    openEditFamilyModal: function (memberIndex) {
        pageFamily.personDetail = pageFamily.familyList[memberIndex];

        document.getElementById("familyForm").reset();
        $("#form-add-edit-mode").val('M');

        $('#familyModalHeading').empty();
        $('#familyModalHeading').html("Edit Family Member");

        console.log(pageFamily.familyList[memberIndex]);
        initializeDate();

        pageFamily.setInputFields(pageFamily.personDetail);
        $("#form-add-edit-code").val(pageFamily.personDetail["FamilyCode"]);
        console.log(pageFamily.personDetail["FamilyCode"]);

        $("#familyModal").modal('show');
    },
    openDeleteFamilyModal: function (familyCode) {
        console.log(familyCode);
        $("#form-delete-code").val(familyCode);
        $("#deleteModal").modal('show');
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
        } else {
            $("#mobile").val("");
        }
        if (personDetail["Gender"]) {
            $("#gender").val(personDetail["Gender"]);
        }
        if (pageFamily.isParentLoggedIn) {
            if (personDetail["FamilyCode"] == familyCode) {
                $("#provideLoginDiv").addClass("hidden");
                $("#loginAccess").addClass("hidden");
                $("#passwordDiv").empty();
                $("#confirmPasswordDiv").empty();
            } else {
                $("#provideLoginDiv").removeClass("hidden");
                if (personDetail["LoginFlag"]) {
                    if (personDetail["LoginFlag"] == 1) {
                        $('input:radio[name=access]')[0].checked = true;
                        $("#loginAccess").removeClass("hidden");
                        $("#passwordDiv").empty();
                        $("#confirmPasswordDiv").empty();
                        $("#email").attr("readonly", true);
                    } else {
                        $('input:radio[name=access]')[1].checked = true;
                        $("#loginAccess").addClass("hidden");
                        $("#email").removeAttr("readonly");
                        $("#passwordDiv").html(pageFamily.getPasswordDivString());
                        $("#confirmPasswordDiv").html(pageFamily.getConfirmPasswordDivString());
                    }
                }
            }
        } else {
            $("#provideLoginDiv").addClass("hidden");
            $("#loginAccess").addClass("hidden");
        }
        /*
         $("#password").val("");
         $("#confirmPassword").val("");*/
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
        pageFamily.relationList = data;

        var relationListString = "<option value=''>Select Relation</option>";
        for (var i = 0; i < data.length; i++) {
            relationListString += "<option value=" + data[i]['RelationCode'] + ">" + data[i]['RelationName'] + "</option>"
        }
        $("#relation").html(relationListString);
    },
    getPasswordDivString: function () {
        return "<div class='input-group'><span class='input-group-addon input-group-addon-label'>Password*</span><input type='password' name='password' id='password' class='form-control password text-field-left-border' placeholder='Password' tabindex='8'/><span class='input-group-btn'><button class='btn btn-primary button-addon-custom' type='button' onclick='pageFamily.toggleInputFieldPassword(0)'><i class='fa fa-eye fa-lg'></i></button></span></div><div class='info'></div>";
    },
    getConfirmPasswordDivString: function () {
        return "<div class='input-group'><span class='input-group-addon input-group-addon-label'>Confirm*</span><input type='password' name='confirmPassword' id='confirmPassword' class='form-control c_password text-field-left-border' placeholder='Confirm Password' tabindex='9'/><span class='input-group-btn'><button class='btn btn-primary button-addon-custom' type='button' onclick='pageFamily.toggleInputFieldPassword(1)'><i class='fa fa-eye fa-lg'></i></button></span></div><div class='info'></div>";
    },
    toggleInputFieldPassword: function (typeOfPassword) {
        switch (typeOfPassword) {
            case 0:
                if ($("#password").attr("type") == "password")
                    $("#password").attr("type", "text");
                else
                    $("#password").attr("type", "password");
                break;
            case 1:
                if ($("#confirmPassword").attr("type") == "password")
                    $("#confirmPassword").attr("type", "text");
                else
                    $("#confirmPassword").attr("type", "password");
                break;
        }
    },
    showLoginAccess: function () {
        $("#loginAccess").removeClass("hidden");
    },
    hideLoginAccess: function () {
        $("#loginAccess").addClass("hidden");
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

    if (familyCode == 1001) {
        // isParentLoggedIn = true; Implies Parent
        pageFamily.isParentLoggedIn = true;
    } else {
        $("#btnAddFamilyMember").remove();
        // isParentLoggedIn = false; Implies Child
        pageFamily.isParentLoggedIn = false;
    }

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

    $('#familyModal').on('show.bs.modal', function (e) {
        $('.info').empty();
        $('.form-group').removeClass("has-success");
        $('.form-group').removeClass("has-error");
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

    $("#familyForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                pageIndex.showNotificationFailure(response.message);
                $("#familyModal").modal('show');
            }
            else {
                pageIndex.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageFamily.getFamilyList();
                }, 200);
                $("#familyModal").modal('hide');
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $("#deleteFamilyForm").ajaxForm({
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
                setTimeout(function () {
                    pageFamily.getFamilyList();
                }, 200);
            }
            $("#deleteModal").modal('hide');
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });
});