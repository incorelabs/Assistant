var pagePassword = {
    currentPageNo: 1,
    localPassword: null,
    defPasswordList: $.Deferred(),
    familyList: null,
    passwordList: null,
    modalHeading: null,
    firstTime: true,
    detailIndex: 0,
    isPasswordTypeSelected: false,
    getFamilyList: function () {
        var url = localStorage.getItem("websiteRoot") + "family/getFamily.php";

        $.getJSON(url, {
            list: 2
        }).done(function (data) {
            console.log(data);
            pagePassword.setFamilyList(data);
        }).fail(function (error) {

        });
    },
    setFamilyList: function (data) {
        pagePassword.familyList = data;
        var str = "";
        for (var i = 0; i < data.length; i++) {
            if (data[i].FamilyCode == familyCode) {
                str += "<option value = " + data[i].FamilyCode + " selected = 'selected'>" + data[i].FamilyName + "</option>";
            }
            else {
                str += "<option value = " + data[i].FamilyCode + ">" + data[i].FamilyName + "</option>";
            }
        }
        $("#holderName").html(str);
    },
    getPasswordList: function () {
        var url = localStorage.getItem("websiteRoot") + "passwords/getPasswordList.php";

        $.getJSON(url, {
            pageNo: pagePassword.currentPageNo
        }).done(function (data) {
            console.log(data);
            pagePassword.defPasswordList.resolve(data);
            pagePassword.setPasswordList(data);
            //pagePassword.passwordList = data;
            //pagePassword.setPasswordDetails(pagePassword.detailIndex);
        }).fail(function (error) {

        });
    },
    setPasswordList: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pagePassword.currentPageNo++;
            var str = "";
            for (var i = 0; i < data.result.length; i++) {
                str += "<a onclick='pagePassword.getPasswordDetails(" + data.result[i].PasswordCode + ")' class='list-group-item contacts_font'><h4 class='list-group-item-heading contacts_font'>" + data.result[i].HolderName + " - " + data.result[i].PasswordName + "</h4></a>";
            }
            $("#passwordList").append(str);
            console.log(str);
            // Print on screen
            console.log(data.result);
            if (pagePassword.currentPageNo <= data.pages) {
                // Show Load More
                var str = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pagePassword.getPasswordList();'>Load more..</a></div>";
                $("#passwordList").append(str);
            }
        } else {
            var str = "<div class='list-group-item'><li class='list-group-item-text header_font'>";
            str += data.message + "</li></div>";
            $("#passwordList").empty();
            $("#passwordList").html(str);
        }
    },
    getPasswordDetails: function (passwordCode) {
        var url = localStorage.getItem("websiteRoot") + "passwords/getPasswordDetail.php";

        $.getJSON(url, {
            passwordCode: passwordCode
        }).done(function (data) {
            console.log(data);
            console.log(data.detail.password);
            pagePassword.setPasswordDetails(data);
        }).fail(function (error) {

        });
    },
    setPasswordDetails: function (data) {
        if (data.status == 1) {
            var str = "";
            var originalPassword = "";
            var originalOtherPassword = "";
            var encryptedPassword = "";
            var encryptedOtherPassword = "";

            pagePassword.localPassword = data.detail;

            if (window.innerWidth < 992 && !pagePassword.firstTime) {
                console.log("width less than 992");
                //Show the Password Details Header and hides the search header
                $("#searchPasswordHeader").addClass('hidden');
                $("#passwordDetailsHeader").removeClass('hidden-xs hidden-sm');

                //Show the Password Details and hides the password list
                $("#passwordListDiv").addClass('hidden');
                $("#passwordDetailDiv").removeClass('hidden-xs hidden-sm');

                //Show Hide of menu button with back button
                $(".menu_img").addClass('hidden');
                $("#backButton").removeClass('hidden');

                $("#backButton").click(function () {
                    //Show the Password Details Header and hides the search header
                    $("#passwordDetailsHeader").addClass('hidden-xs hidden-sm');
                    $("#searchPasswordHeader").removeClass('hidden');

                    //Show the Password Details and hides the password list
                    $("#passwordListDiv").removeClass('hidden');
                    $("#passwordDetailDiv").addClass('hidden-xs hidden-sm');

                    //Show Hide of menu button with back button
                    $(".menu_img").removeClass('hidden');
                    $("#backButton").addClass('hidden');

                });
            }
            pagePassword.firstTime = false;

            var headerStr = "<h12>Password Details</h12><button id='editPasswordBtn' class='btn btn-success pull-right' onclick='pagePassword.openEditPasswordModal();'><span class='glyphicon glyphicon-pencil'></span></button><button id='deletePasswordBtn' class='btn btn-danger pull-left' onclick='pagePassword.openDeletePasswordModal(" + data.detail.password.PasswordCode + ")'><span class='glyphicon glyphicon-trash'></span></button>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Holder's Name</div><value><div class='col-md-9'>" + data.detail.password.HolderName + "</div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password Type</div><value><div class='col-md-9'>" + data.detail.password.PasswordTypeName + "</div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Description</div><value><div class='col-md-9'>" + data.detail.password.PasswordName + "</div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Login ID</div><value><div class='col-md-9'>" + data.detail.password.LoginID + "</div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password</div><value><div class='col-md-8 col-sm-8 col-xs-8'><div class='textShow'>" + data.detail.password.LoginPassword1 + "</div></div><div class='col-md-1 pull-right'><a href='#' id='passwordEncrypt'><i class='fa fa-eye fa-lg'></i></a></div></value></div></div>";

            str += "<div class='row contact-details' id='optionalPasswordRow'><div class='list-group-item-heading header_font'><div class='col-md-3'>Optional Password</div><value><div class='col-md-8 col-sm-8 col-xs-8'><div class='textShow1'>" + data.detail.password.LoginPassword2 + "</div></div><div class='col-md-1 pull-right'><a href='#' id='passwordEncrypt1'><i class='fa fa-eye fa-lg'></i></a></div></value></div></div>";

            $("#passwordDetailHeader").html(headerStr);
            $("#passwordDetailBody").html(str);
            originalPassword = $(".textShow").html();
            encryptedPassword = originalPassword.replace(/./gi, "*");  // replace each character by an *
            $(".textShow").text(encryptedPassword);
            $("#passwordEncrypt").click(function () {
                $(".textShow").text(function (original, encrypted) {
                    return encrypted == originalPassword ? encryptedPassword : originalPassword
                });
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
                });
            });

        } else {
            pagePassword.localPassword = null;
        }

    },
    openAddPasswordModal: function () {
        document.getElementById("form-passwords").reset();

        $('#addPrivacy').attr('checked', false);
        $('#addActiveStatus').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#passwordModalHeading').empty();
        $('#passwordModalHeading').html("Add Password");

        $("#passwordModal").modal('show');
    },
    openEditPasswordModal: function (index) {
        pagePassword.detailIndex = index;
        var detail = pagePassword.passwordList[index];
        $("#mode").val("M");
        pagePassword.modalHeading = "Edit";
        $("#passwordCode").val(detail["PasswordCode"]);
        pagePassword.setModalInputFields(detail);
        $("#passwordModal").modal('show');
    },
    openDeletePasswordModal: function (passwordCode) {
        $("#form-delete-code").val(passwordCode);
        $("#deleteModal").modal("show");
    },
    setModalInputFields: function (detail) {
        document.getElementById("form-passwords").reset();
        var temp = familyCode;
        familyCode = detail["HolderCode"];
        pagePassword.setFamilyList(pagePassword.familyList);

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
    },
    getPasswordTypeList: function () {
        var url = localStorage.getItem("websiteRoot") + "passwords/getMasters.php";

        $.getJSON(url, {
            passwordType: 1
        }).done(function (data) {
            console.log(data);
            pagePassword.setPasswordTypeAutoComplete(data);
        }).fail(function (error) {

        });
    },
    setPasswordTypeAutoComplete: function (tags) {
        var data = [];
        var dataIndex = [];
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
                pagePassword.isPasswordTypeSelected = true;
                //console.log("ON SELECT: " + ($("#passwordTypeCode").val()));

            },
            change: function (event, ui) {
                console.log("Change triggered");
                //$("#passwordTypeCode").val("1");
                if (!pagePassword.isPasswordTypeSelected) {
                    $("#passwordTypeCode").val("1");
                }
                pagePassword.isPasswordTypeSelected = false;
                //console.log("ON Change: " + ($("#passwordTypeCode").val()));
            }
        });
    }
};

$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../");

    $.when(pagePassword.defPasswordList).done(function (data) {
        console.log(data.status);
        if (data.status == 1)
            pagePassword.getPasswordDetails(data.result[0].PasswordCode);
    });

    pagePassword.getFamilyList();
    pagePassword.getPasswordList();
    pagePassword.getPasswordTypeList();


    $('#passwordModal').on('shown.bs.modal', function () {
        $("#modalHeading").html(pagePassword.modalHeading);
    });

    $('#passwordModal').on('show.bs.modal', function () {
        $("#password").attr("type", "password");
        $("#otherPassword").attr("type", "password");
    });

    //Password form submit
    $("#form-passwords").ajaxForm({
        beforeSubmit: function (arr) {
            console.log(arr);
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                setTimeout(function () {
                    pagePassword.currentPageNo = 1;
                    $("#passwordList").empty();
                    pagePassword.getPasswordDetails(response.landing);
                    pagePassword.getPasswordList();
                    pageIndex.showNotificationSuccess(response.message);
                    pagePassword.getPasswordTypeList();
                    $("#passwordModal").modal("hide");
                }, 500);
            }
            else {
                pageIndex.showNotificationFailure(response.message);
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    //Password form submit
    $("#form-password-delete").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                setTimeout(function () {
                    pagePassword.currentPageNo = 1;
                    $("#passwordList").empty();
                    $("#passwordDetailBody").empty();
                    $("#editPasswordBtn").remove();
                    $("#deletePasswordBtn").remove();
                    pageIndex.showNotificationSuccess(response.message);
                    pagePassword.getPasswordList();
                    pagePassword.getPasswordDetails(response.landing);
                    $("#deleteModal").modal("hide");
                }, 500);
            } else {
                pageIndex.showNotificationFailure(response.message);
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    if (window.innerWidth < 992) {
        $("body").css("overflow", "auto");
        $("#passwordListScroll").removeClass("panelHeight");
        $("#passwordList").addClass("mobile-list");
        $("#passwordListDiv").addClass("mobileBody");
        $("#searchPasswordHeader").addClass("mobileHeader");

        $("#passwordDetail").removeClass("panelHeight");
        $("#passwordDetailDiv").addClass("mobileBody");
        $("#passwordDetailsHeader").addClass("mobileHeader");
    }
});
$(window).resize(function () {
    console.log(window.innerWidth);
    if (window.innerWidth < 992) {
        $("body").css("overflow", "auto");
        $("#passwordListScroll").removeClass("panelHeight");
        $("#passwordList").addClass("mobile-list");
        $("#passwordListDiv").addClass("mobileBody");
        $("#searchPasswordHeader").addClass("mobileHeader");

        $("#passwordDetail").removeClass("panelHeight");
        $("#passwordDetailDiv").addClass("mobileBody");
        $("#passwordDetailsHeader").addClass("mobileHeader");
    }
    else {

        $("body").css("overflow", "hidden");
        $("#passwordListScroll").addClass("panelHeight");
        $("#passwordList").removeClass("mobile-list");
        $("#passwordListDiv").removeClass("mobileBody");
        $("#searchPasswordHeader").removeClass("mobileHeader");

        $("#passwordDetail").addClass("panelHeight");
        $("#passwordDetailDiv").removeClass("mobileBody");
        $("#passwordDetailsHeader").removeClass("mobileHeader");

        //Show the Password Details Header and hides the search header
        $("#passwordDetailsHeader").addClass('hidden-xs hidden-sm');
        $("#searchPasswordHeader").removeClass('hidden');

        //Show the Password Details and hides the password list
        $("#passwordListDiv").removeClass('hidden');
        $("#passwordDetailDiv").addClass('hidden-xs hidden-sm');

        //Show Hide of menu button with back button
        $(".menu_img").removeClass('hidden');
        $("#backButton").addClass('hidden');
    }
});