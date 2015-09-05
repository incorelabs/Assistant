var familyList;
var passwordList;
var modalHeading;
var firstTime = true;
var detailIndex = 0;
var isPasswordTypeSelected = false;

function getFamilyList() {
    $.ajax({
        method: "GET",
        url: root + "family/getFamily.php",
        data: {
            list: 2
        }
    })
        .done(function (msg) {
            familyList = JSON.parse(msg);
            //console.log(familyList);
            setFamilyList(familyList);
        });
}

function setFamilyList(arr) {
    var str = "";
    for (var i = 0; i < arr.length; i++) {
        if (arr[i].FamilyCode == familyCode) {
            str += "<option value = " + arr[i].FamilyCode + " selected = 'selected'>" + arr[i].FamilyName + "</option>";
        }
        else {
            str += "<option value = " + arr[i].FamilyCode + ">" + arr[i].FamilyName + "</option>";
        }
    }
    ;
    $("#holderName").html(str);
}

function getPasswordList() {
    $.ajax({
        method: "GET",
        url: root + "passwords/getPasswordsList.php",
        data: {
            list: 1
        }
    })
        .done(function (msg) {
            passwordList = JSON.parse(msg);
            //console.log(passwordList);
            setPasswordDetail(detailIndex);
            setPasswordList(passwordList);
        });
}

function setPasswordList(arr) {
    var str = "";
    for (var i = 0; i < arr.length; i++) {
        str += "<a href='#' onclick='setPasswordDetail(" + i + ")' class='list-group-item contacts_font'><h4 class='list-group-item-heading contacts_font'>" + arr[i]["HolderName"] + " - " + arr[i]["PasswordName"] + "</h4></a>";
    }
    $("#passwordsList").html(str);
}

function setPasswordDetail(index) {
    var headerStr = "";
    var str = "";
    var detail = "";
    var originalPassword = "";
    var originalOtherPassword = "";
    var encryptedPassword = "";
    var encryptedOtherPassword = "";

    if (window.innerWidth < 992 && !firstTime) {
        console.log("width less than 992");
        //Show the Password Details Header and hides the search header
        $("#searchPasswordHeader").addClass('hidden');
        $("#passwordDetailsHeader").removeClass('hidden-xs hidden-sm');

        //Show the Password Details and hides the password list
        $("#passwordListDiv").addClass('hidden');
        $("#passwordDetails").removeClass('hidden-xs hidden-sm');

        //Show Hide of menu button with back button
        $(".menu_img").addClass('hidden');
        $("#backButton").removeClass('hidden');

        $("#backButton").click(function () {
            //Show the Password Details Header and hides the search header
            $("#passwordDetailsHeader").addClass('hidden-xs hidden-sm');
            $("#searchPasswordHeader").removeClass('hidden');

            //Show the Password Details and hides the password list
            $("#passwordListDiv").removeClass('hidden');
            $("#passwordDetails").addClass('hidden-xs hidden-sm');

            //Show Hide of menu button with back button
            $(".menu_img").removeClass('hidden');
            $("#backButton").addClass('hidden');

        });
    }
    firstTime = false;
    if (passwordList.length == 0) {
        headerStr = "<h12>Password Details</h12>";
        str += "<div class='panel-height'><div class='list-group'><div class='list-group-item list-group-item-border'><div class='row contact-details'><div class='list-group-item-heading text-center'>No Passwords Added</div></div></div></div></div>";
    }
    else {
        detail = passwordList[index];
        headerStr = "<h12>Password Details</h12><button class='btn btn-success pull-right' onclick='openEditPassword(" + index + ")'> <span class='glyphicon glyphicon-pencil'></span></button><button class='btn btn-danger pull-left' onclick='openDeleteModal(" + index + ")'><span class='glyphicon glyphicon-trash'></span></button>";
        str += "<div class='panel-height'><!-- List group --><div id='passwordBody' class='list-group'><div class='list-group-item list-group-item-border'><div class='row contact-details' style='padding-top:0px'><div class='list-group-item-heading header_font'><div class='col-md-3'>Holder's Name</div><value><div class='col-md-9'>" + detail["HolderName"] + "</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password Type</div><value><div class='col-md-9'>" + detail["PasswordTypeName"] + "</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Description</div><value><div class='col-md-9'>" + detail["PasswordName"] + "</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Login ID</div><value><div class='col-md-9'>" + detail["LoginID"] + "</div></value></div></div><div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password</div><value><div class='col-md-8 col-sm-8 col-xs-8'><div class='textShow'>" + detail["LoginPassword1"] + "</div></div><div class='col-md-1 pull-right'><a href='#' id='passwordEncrypt'><i class='fa fa-eye fa-lg'></i></a></div></value></div></div><div class='row contact-details' id='optionalPasswordRow'><div class='list-group-item-heading header_font'><div class='col-md-3'>Optional Password</div><value><div class='col-md-8 col-sm-8 col-xs-8'><div class='textShow1'>" + detail["LoginPassword2"] + "</div></div><div class='col-md-1 pull-right'><a href='#' id='passwordEncrypt1'><i class='fa fa-eye fa-lg'></i></a></div></value></div></div></div></div><!--List close--></div>";
    }
    $("#passwordDetailHeader").html(headerStr);
    $("#password-Detail").html(str);
    originalPassword = $(".textShow").html();
    encryptedPassword = originalPassword.replace(/./gi, "*");  // replace each character by an *
    $(".textShow").text(encryptedPassword);
    $("#passwordEncrypt").click(function () {
        $(".textShow").text(function (original, encrypted) {
            return encrypted == originalPassword ? encryptedPassword : originalPassword
        })
    });

    originalOtherPassword = $(".textShow1").html();
    if (originalOtherPassword.length > 0) {
        encryptedOtherPassword = originalOtherPassword.replace(/./gi, "*");
    }
    else {
        $("#optionalPasswordRow").addClass("hidden");
        encryptedOtherPassword = originalOtherPassword;
    }
    $(".textShow1").text(encryptedOtherPassword);
    $("#passwordEncrypt1").click(function () {
        $(".textShow1").text(function (original, encrypted) {
            return encrypted == originalOtherPassword ? encryptedOtherPassword : originalOtherPassword
        })
    });
}

function openDeleteModal(index) {
    detailIndex = ((index == 0) ? index + 1 : index);
    var detail = passwordList[index];
    $("#form-delete-mode").val("D");
    $("#form-delete-code").val(detail["PasswordCode"]);
    $("#deletePassword").modal('show');
}

function openAddModal() {
    document.getElementById("form-passwords").reset();
    $("#mode").val("A");
    modalHeading = "Add";
    $("#passwordCode").val("1");
    $("#addPassword").modal('show');
}

function openEditPassword(index) {
    detailIndex = index;
    var detail = passwordList[index];
    $("#mode").val("M");
    modalHeading = "Edit";
    $("#passwordCode").val(detail["PasswordCode"]);
    setModalInputFields(detail);
    $("#addPassword").modal('show');
}

function setModalInputFields(detail) {
    document.getElementById("form-passwords").reset();
    var temp = familyCode;
    familyCode = detail["HolderCode"];
    setFamilyList(familyList);

    if (detail["ActiveFlag"]) {
        if (detail["ActiveFlag"] == 1) {
            $("#addActiveStatus").attr("checked", true);
        }
        else {
            $("#addActiveStatus").attr("checked", false);
        }
    }
    else {
        $("#addActiveStatus").attr("checked", false);
    }

    if (detail["PrivateFlag"]) {
        if (detail["PrivateFlag"] == 1) {
            $("#addPrivacy").attr("checked", true);
        }
        else {
            $("#addPrivacy").attr("checked", false);
        }
    }
    else {
        $("#addPrivacy").attr("checked", false);
    }

    if (detail["PasswordTypeCode"]) {
        $("#passwordType").val(detail["PasswordTypeName"]);
        $("#passwordTypeCode").val(detail["PasswordTypeCode"]);
    }

    if (detail["PasswordName"]) {
        $("#description").val(detail["PasswordName"]);
    }

    if (detail["LoginID"]) {
        $("#userID").val(detail["LoginID"]);
    }

    if (detail["LoginPassword1"]) {
        $("#password").val(detail["LoginPassword1"]);
    }

    if (detail["LoginPassword2"]) {
        $("#otherPassword").val(detail["LoginPassword2"]);
    }
    familyCode = temp;
}

function getPasswordTypeList() {
    $.ajax({
        method: "GET",
        url: "getMasters.php",
        data: {
            passwordType: 1
        }
    })
        .done(function (msg) {
            var passwordType = JSON.parse(msg);
            console.log(msg);
            console.log(passwordType);

            //console.log(passwordType);
            setPasswordTypeAutoComplete(passwordType);
        });
}

function setPasswordTypeAutoComplete(tags) {
    var data = [],
        dataIndex = [];
    for (var i = 0; i < tags.length; i++) {
        var arr = tags[i].split(",");
        data.push(arr[1]);
        dataIndex.push(arr[0]);
    }

    //console.log(data);
    $("#passwordType").autocomplete({
        source: data,
        select: function (event, ui) {
            var index = $.inArray(ui.item.value, data);
            $("#passwordTypeCode").val(dataIndex[index]);
            isPasswordTypeSelected = true;
            //console.log("ON SELECT: " + ($("#passwordTypeCode").val()));

        },
        change: function (event, ui) {
            console.log("Change triggered");
            //$("#passwordTypeCode").val("1");
            if (!isPasswordTypeSelected) {
                $("#passwordTypeCode").val("0");
            }
            isPasswordTypeSelected = false;
            //console.log("ON Change: " + ($("#passwordTypeCode").val()));
        }
    });
}

$(document).ready(function () {

    getFamilyList();
    getPasswordList();
    getPasswordTypeList();


    $('#addPassword').on('shown.bs.modal', function () {
        $("#modalHeading").html(modalHeading);
    });

    $('#addPassword').on('show.bs.modal', function () {
        $("#password").attr("type", "password");
        $("#otherPassword").attr("type", "password");
    })

    //Password form submit
    $("#form-passwords").ajaxForm({
        beforeSubmit: function () {
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                showNotificationFailure(response.message);
            }
            else {
                getPasswordList();
                getPasswordTypeList();
                showNotificationSuccess(response.message);
                $("#addPassword").modal("hide");
            }
        }
    });

    //Password form submit
    $("#form-password-delete").ajaxForm({
        beforeSubmit: function () {
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                showNotificationFailure(response.message);
            }
            else {
                getPasswordList();
                getPasswordTypeList();
                showNotificationSuccess(response.message);
                $("#deletePassword").modal("hide");
            }
        }
    });

    if (window.innerWidth < 992) {
        $("body").css("overflow", "auto");
        $("#passwordListScroll").removeClass("panelHeight");
        $("#passwordsList").addClass("mobile-list");
        $("#passwordListDiv").addClass("mobileBody");
        $("#searchPasswordHeader").addClass("mobileHeader");

        $("#password-Detail").removeClass("panelHeight");
        $("#passwordDetails").addClass("mobileBody");
        $("#passwordDetailsHeader").addClass("mobileHeader");
    }
});
$(window).resize(function () {
    console.log(window.innerWidth);
    if (window.innerWidth < 992) {
        $("body").css("overflow", "auto");
        $("#passwordListScroll").removeClass("panelHeight");
        $("#passwordsList").addClass("mobile-list");
        $("#passwordListDiv").addClass("mobileBody");
        $("#searchPasswordHeader").addClass("mobileHeader");

        $("#password-Detail").removeClass("panelHeight");
        $("#passwordDetails").addClass("mobileBody");
        $("#passwordDetailsHeader").addClass("mobileHeader");
    }
    else {

        $("body").css("overflow", "hidden");
        $("#passwordListScroll").addClass("panelHeight");
        $("#passwordsList").removeClass("mobile-list");
        $("#passwordListDiv").removeClass("mobileBody");
        $("#searchPasswordHeader").removeClass("mobileHeader");

        $("#password-Detail").addClass("panelHeight");
        $("#passwordDetails").removeClass("mobileBody");
        $("#passwordDetailsHeader").removeClass("mobileHeader");

        //Show the Password Details Header and hides the search header
        $("#passwordDetailsHeader").addClass('hidden-xs hidden-sm');
        $("#searchPasswordHeader").removeClass('hidden');

        //Show the Password Details and hides the password list
        $("#passwordListDiv").removeClass('hidden');
        $("#passwordDetails").addClass('hidden-xs hidden-sm');

        //Show Hide of menu button with back button
        $(".menu_img").removeClass('hidden');
        $("#backButton").addClass('hidden');
    }
});