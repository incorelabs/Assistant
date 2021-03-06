var pageFamily = {
    isParentLoggedIn: false,
    familyList: null,
    relationList: null,
    personDetails: null,
    isYesEnabled: true,
    isNoEnabled: true,
    getFamilyList: function () {
        var url = app.websiteRoot + "family/getFamily.php";

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
            familyTableString += "<td>" + (i + 1) + "</td>";
            familyTableString += "<td>" + data[i]['FamilyName'] + "</td>";
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

        initializeDate();

        $("#form-add-edit-mode").val('A');
        $("#form-add-edit-code").val(1);

        $('#familyModalHeading').empty().html("Add Family");

        if (pageFamily.isParentLoggedIn)
            $("#provideLoginDiv").removeClass("hidden");

        $("#passwordDiv").empty().html(pageFamily.getPasswordDivString());
        $("#confirmPasswordDiv").empty().html(pageFamily.getConfirmPasswordDivString());

        $("#loginAccess").addClass("hidden");

        $("#relation option[value='1']").remove();
        $("#relation").removeAttr("disabled");
        $("#relationTextBox").removeAttr("name");

        $("#dob").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#mobile").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#email").removeAttr("readonly").removeAttr("required").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#password").removeAttr("required").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#confirmPassword").removeAttr("required").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $("#familyModal").modal('show');
    },
    openEditFamilyModal: function (memberIndex) {
        pageFamily.personDetails = pageFamily.familyList[memberIndex];

        document.getElementById("familyForm").reset();
        $("#form-add-edit-mode").val('M');

        $('#familyModalHeading').empty().html("Edit Family");

        console.log(pageFamily.familyList[memberIndex]);
        initializeDate();

        $("#relation").removeAttr("disabled");
        $("#relationTextBox").removeAttr("name");

        $("#dob").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#mobile").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#email").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#password").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#confirmPassword").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        pageFamily.setInputFields(pageFamily.personDetails);
        $("#form-add-edit-code").val(pageFamily.personDetails["FamilyCode"]);
        console.log(pageFamily.personDetails["FamilyCode"]);

        $("#familyModal").modal('show');
    },
    openDeleteFamilyModal: function (familyCode) {
        console.log(familyCode);
        $("#form-delete-code").val(familyCode);
        $("#deleteModal").modal('show');
    },
    setInputFields: function (personDetails) {
        if (personDetails["FamilyName"]) {
            $("#firstName").val(personDetails["FamilyName"]);
        }
        if (personDetails["RelationCode"]) {
            $("#relation").val(personDetails["RelationCode"]);
        }
        if (personDetails["BirthDate"]) {
            $("#dob").val(personDetails["BirthDate"]);
        }
        if (personDetails["Email"]) {
            $("#email").val(personDetails["Email"]);
        }
        if (personDetails["Mobile"]) {
            $("#mobile").val(personDetails["Mobile"]);
        } else {
            $("#mobile").val("");
        }
        if (personDetails["Gender"]) {
            if (personDetails["Gender"] == "0")
                $("#gender").val("");
            else
                $("#gender").val(personDetails["Gender"]);
        }
        if (pageFamily.isParentLoggedIn) {
            if (personDetails["FamilyCode"] == familyCode) {
                $("#relation").append("<option value='1'>Self</option>").val("1").attr("disabled", "");
                $("#relationTextBox").attr("name", "relation").val("1");
                $('input:radio[name=access]')[0].checked = true;
                $("#provideLoginDiv").addClass("hidden");
                $("#loginAccess").addClass("hidden");

                $("#email").attr("required", "").attr("readonly", "");

                $("#passwordDiv").empty();
                $("#confirmPasswordDiv").empty();
            } else {
                $("#relation option[value='1']").remove();
                $("#provideLoginDiv").removeClass("hidden");
                if (personDetails["LoginFlag"] == 1) {
                    $('input:radio[name=access]')[0].checked = true;
                    $("#loginAccess").removeClass("hidden");
                    $("#passwordDiv").empty();
                    $("#confirmPasswordDiv").empty();

                    $("#email").attr({
                        "readonly": true,
                        "required": ""
                    });
                } else {
                    $('input:radio[name=access]')[1].checked = true;
                    $("#loginAccess").addClass("hidden");
                    $("#passwordDiv").html(pageFamily.getPasswordDivString());
                    $("#confirmPasswordDiv").html(pageFamily.getConfirmPasswordDivString());

                    $("#email").removeAttr("readonly").removeAttr("required");
                    $("#password").removeAttr("required");
                    $("#confirmPassword").removeAttr("required");
                }
            }
        } else {
            $("#relation option[value='1']").remove();
            if (personDetails["LoginFlag"] == 1) {
                $("input:radio[name=access]")[0].checked = true;
                $("#email").attr("required", "");
            } else
                $("input:radio[name=access]")[1].checked = true;
        }
    },
    getRelationList: function () {
        var url = app.websiteRoot + "family/getRelation.php";

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
        return "<div class='input-group'><span class='input-group-addon input-group-addon-label'>Confirm*</span><input type='password' name='confirmPassword' id='confirmPassword' class='form-control text-field-left-border' placeholder='Confirm Password' tabindex='9'/><span class='input-group-btn'><button class='btn btn-primary button-addon-custom' type='button' onclick='pageFamily.toggleInputFieldPassword(1)'><i class='fa fa-eye fa-lg'></i></button></span></div><div class='info'></div>";
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

        $("#email").attr("required", "").on('input propertychange', function () {
            app.validate(this, 2);
        }).focusout(function () {
            if (this.value.trim() === "") {
                if (!this.required) {
                    $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                }
            }
        });
        $("#password").attr("required", "").on('input propertychange', function () {
            app.validate(this, 4);
        }).focusout(function () {
            if (this.value.trim() === "") {
                if (!this.required) {
                    $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                }
            }
        });
        $("#confirmPassword").attr("required", "").on('input propertychange', function () {
            app.validate(this, 5);
        }).focusout(function () {
            if (this.value.trim() === "") {
                if (!this.required) {
                    $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                }
            }
        });
    },
    hideLoginAccess: function () {
        $("#loginAccess").addClass("hidden");

        $("#email").removeAttr("required").off().val("").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#password").removeAttr("required").off().val("").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#confirmPassword").removeAttr("required").off().val("").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
    }
};

$(document).ready(function () {
    app.websiteRoot = "../";
    app.getLoginDetails();

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

    $("#dob").focusin(function () {
        if (this.value.indexOf('_') > -1) {
            this.value = "";
        }
    }).focusout(function () {
        app.validate(this, 1);
        if (this.value.trim() === "" || this.value.trim() === "__/__/____") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#mobile").on('input propertychange', function () {
        console.log("Er");
        app.validate(this, 3);
    }).focusout(function () {
        console.log("fr");
        if (this.value.trim() === "") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
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
        beforeSubmit: function (formData) {
            console.log(formData);
            var isValid = false;
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    app.showNotificationFailure("Required fields are empty");
                    return false;
                }
                if (formData[i].name === "dob") {
                    if (app.validateDate(formData[i].value) === app.dateValidationState.SUCCESS)
                        isValid = true;
                    else {
                        isValid = false;
                        break;
                    }
                } else if (formData[i].name === "mobile") {
                    if (formData[i].value.trim() != "") {
                        if (app.validateNumber(formData[i].value) === app.numberValidationState.SUCCESS)
                            isValid = true;
                        else {
                            isValid = false;
                            break;
                        }
                    } else {
                        isValid = true;
                    }
                } else if (formData[i].name === "email") {
                    formData[i].value = formData[i].value.toLowerCase();
                    if (formData[i].value.trim() != "") {
                        if (app.validateEmail(formData[i].value) === app.emailValidationState.SUCCESS)
                            isValid = true;
                        else {
                            isValid = false;
                            break;
                        }
                    }
                } else if (formData[i].name === "password") {
                    if (formData[i].value.trim() != "") {
                        if (app.validatePassword(formData[i].value) === app.passwordValidationState.SUCCESS)
                            isValid = true;
                        else {
                            isValid = false;
                            break;
                        }
                    }
                } else if (formData[i].name === "confirmPassword") {
                    if (formData[i].value.trim() != "") {
                        if (app.validateConfirmPassword(formData[i - 1].value, formData[i].value) === app.confirmPasswordValidationState.SUCCESS)
                            isValid = true;
                        else {
                            isValid = false;
                            break;
                        }
                    }
                }
            }
            console.log(isValid);
            if (!isValid) {
                app.showNotificationFailure("Validation Failed for some input field");
                return false;
            }
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                app.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageFamily.getFamilyList();
                }, 200);
                $("#familyModal").modal('hide');
            } else {
                app.showNotificationFailure(response.message);
                $("#familyModal").modal('show');
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
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
            if (response.status == 1) {
                app.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageFamily.getFamilyList();
                }, 200);
            } else {
                app.showNotificationFailure(response.message);
            }
            $("#deleteModal").modal('hide');
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });
});