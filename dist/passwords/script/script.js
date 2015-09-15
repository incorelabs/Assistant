var pagePassword = {
    currentPageNo: 1,
    localPassword: null,
    defPasswordList: $.Deferred(),
    defSearchResult: $.Deferred(),
    familyList: null,
    passwordList: null,
    firstTime: true,
    stateEncryptLoginPassword1: false,
    stateEncryptLoginPassword2: false,
    getFamilyList: function () {
        var url = localStorage.getItem("websiteRoot") + "family/getFamily.php";

        $.getJSON(url, {
            list: 2
        }).done(function (data) {
            pagePassword.setFamilyList(data);
        }).fail(function (error) {

        });
    },
    setFamilyList: function (data) {
        pagePassword.familyList = data;
        var familyListString = "";
        for (var i = 0; i < data.length; i++) {
            if (data[i].FamilyCode == familyCode) {
                familyListString += "<option value = " + data[i].FamilyCode + " selected = 'selected'>" + data[i].FamilyName + "</option>";
            }
            else {
                familyListString += "<option value = " + data[i].FamilyCode + ">" + data[i].FamilyName + "</option>";
            }
        }
        $("#holderName").html(familyListString);
    },
    getPasswordList: function () {
        var url = localStorage.getItem("websiteRoot") + "passwords/getPasswordList.php";

        $.getJSON(url, {
            pageNo: pagePassword.currentPageNo
        }).done(function (data) {
            pagePassword.defPasswordList.resolve(data);
            pagePassword.setPasswordList(data);
        }).fail(function (error) {

        });
    },
    setPasswordList: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pagePassword.currentPageNo++;
            var passwordListString = "";
            for (var i = 0; i < data.result.length; i++) {
                passwordListString += "<a onclick='pagePassword.getPasswordDetails(" + data.result[i].PasswordCode + ")' class='list-group-item contacts_font'><h4 class='list-group-item-heading contacts_font'>" + data.result[i].HolderName + " - " + data.result[i].PasswordName + "</h4></a>";
            }
            $("#passwordList").append(passwordListString);
            if (pagePassword.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pagePassword.getPasswordList();'>Load more..</a></div>";
                $("#passwordList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#passwordList").empty();
            $("#passwordList").html(noMoreDataString);
        }
    },
    doSearch: function () {
        $("#passwordList").empty();
        pagePassword.currentPageNo = 1;
        pagePassword.firstTime = true;
        pagePassword.defSearchResult = $.Deferred();
        pagePassword.getSearchResults();
        $.when(pagePassword.defSearchResult).done(function (data) {
            if (data.status == 1)
                pagePassword.getPasswordDetails(data.result[0].PasswordCode);
        });
    },
    getSearchResults: function () {
        var url = localStorage.getItem("websiteRoot") + "passwords/getPasswordList.php";

        $.getJSON(url, {
            pageNo: pagePassword.currentPageNo,
            searchType: 1,
            searchText: $('#searchBox').val().trim()
        }).done(function (data) {
            pagePassword.defSearchResult.resolve(data);
            pagePassword.setSearchResults(data);
        }).fail(function (error) {

        });
    },
    setSearchResults: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pagePassword.currentPageNo++;
            var searchResultsString = "";
            for (var i = 0; i < data.result.length; i++) {
                searchResultsString += "<a onclick='pagePassword.getPasswordDetails(" + data.result[i].PasswordCode + ")' class='list-group-item contacts_font'><h4 class='list-group-item-heading contacts_font'>" + data.result[i].HolderName + " - " + data.result[i].PasswordName + "</h4></a>";
            }
            $("#passwordList").append(searchResultsString);
            if (pagePassword.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pagePassword.getSearchResults();'>Load more..</a></div>";
                $("#passwordList").append(loadMoreString);
            }

        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#passwordList").empty();
            $("#passwordList").html(noMoreDataString);
            $("#passwordDetailBody").empty();
            $("#editPasswordBtn").remove();
            $("#deletePasswordBtn").remove();
        }
    },
    getPasswordDetails: function (passwordCode) {
        if (passwordCode == null)
            return;
        var url = localStorage.getItem("websiteRoot") + "passwords/getPasswordDetail.php";

        $.getJSON(url, {
            passwordCode: passwordCode
        }).done(function (data) {
            pagePassword.setPasswordDetails(data);
        }).fail(function (error) {

        });
    },
    setPasswordDetails: function (data) {
        if (data.status == 1) {
            pagePassword.localPassword = data.detail;

            var passwordHeaderString = "<h12>Password Details</h12><button id='editPasswordBtn' class='btn btn-success pull-right' onclick='pagePassword.openEditPasswordModal();'><span class='glyphicon glyphicon-pencil'></span></button><button id='deletePasswordBtn' class='btn btn-danger pull-left' onclick='pagePassword.openDeletePasswordModal(" + data.detail.password.PasswordCode + ")'><span class='glyphicon glyphicon-trash'></span></button>";
            var passwordDetailsString = "";

            if (window.innerWidth < 992 && !pagePassword.firstTime) {
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

            passwordDetailsString += "<div class='row contact-details' style='padding-top:0px'><div class='list-group-item-heading header_font'><div class='col-md-3'>Holder's Name</div><value><div class='col-md-9'>" + data.detail.password.HolderName + "</div></value></div></div>";

            passwordDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password Type</div><value><div class='col-md-9'>" + data.detail.password.PasswordTypeName + "</div></value></div></div>";

            passwordDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Description</div><value><div class='col-md-9'>" + data.detail.password.PasswordName + "</div></value></div></div>";

            passwordDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Login ID</div><value><div class='col-md-9'>" + data.detail.password.LoginID + "</div></value></div></div>";

            passwordDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Password</div><value><div class='col-md-8 col-sm-8 col-xs-8' id='loginPassword1'>" + pagePassword.morphPassword(data.detail.password.LoginPassword1, 1) + "</div><div class='col-md-1 pull-right'><a href='#' onclick='pagePassword.togglePassword(1)'><i class='fa fa-eye fa-lg'></i></a></div></value></div></div>";

            if (data.detail.password.LoginPassword2 != null) {
                passwordDetailsString += "<div class='row contact-details' id='optionalPasswordRow'><div class='list-group-item-heading header_font'><div class='col-md-3'>Optional Password</div><value><div class='col-md-8 col-sm-8 col-xs-8' id='loginPassword2'>" + pagePassword.morphPassword(data.detail.password.LoginPassword2, 2) + "</div><div class='col-md-1 pull-right'><a href='#' onclick='pagePassword.togglePassword(2)'><i class='fa fa-eye fa-lg'></i></a></div></value></div></div>";
            } else
                pagePassword.stateEncryptLoginPassword2 = false;

            $("#passwordDetailHeader").html(passwordHeaderString);
            $("#passwordDetailBody").html(passwordDetailsString);
        } else {
            pagePassword.localPassword = null;
        }

    },
    morphPassword: function (passwordText, passwordType) {
        switch (passwordType) {
            case 1:
                pagePassword.stateEncryptLoginPassword1 = true;
                break;
            case 2:
                pagePassword.stateEncryptLoginPassword2 = true;
                break;
        }
        return passwordText.replace(/./gi, "*");
    },
    togglePassword: function (btnType) {
        switch (btnType) {
            case 1:
                if (pagePassword.stateEncryptLoginPassword1) {
                    $("#loginPassword1").html(pagePassword.localPassword.password.LoginPassword1);
                    pagePassword.stateEncryptLoginPassword1 = false;
                } else {
                    $("#loginPassword1").html(pagePassword.morphPassword(pagePassword.localPassword.password.LoginPassword1, 1));
                }
                break;
            case 2:
                if (pagePassword.stateEncryptLoginPassword2) {
                    $("#loginPassword2").html(pagePassword.localPassword.password.LoginPassword2);
                    pagePassword.stateEncryptLoginPassword2 = false;
                } else {
                    $("#loginPassword2").html(pagePassword.morphPassword(pagePassword.localPassword.password.LoginPassword2, 2));
                }
                break;
        }
    },
    openAddPasswordModal: function () {
        document.getElementById("passwordForm").reset();

        $('#addPrivacy').attr('checked', false);
        $('#addActiveStatus').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#passwordModalHeading').empty();
        $('#passwordModalHeading').html("Add Password");

        $("#passwordModal").modal('show');
    },
    openEditPasswordModal: function () {
        document.getElementById("passwordForm").reset();
        $("#form-add-edit-mode").val("M");

        $('#passwordModalHeading').empty();
        $('#passwordModalHeading').html("Edit Password");

        $("#form-add-edit-code").val(pagePassword.localPassword.password.PasswordCode);
        pagePassword.setModalInputFields();

        $("#passwordModal").modal('show');
    },
    openDeletePasswordModal: function (passwordCode) {
        $("#form-delete-code").val(passwordCode);
        $("#deleteModal").modal("show");
    },
    setModalInputFields: function () {
        var temp = familyCode;
        familyCode = pagePassword.localPassword.password.HolderCode;
        pagePassword.setFamilyList(pagePassword.familyList);

        if (pagePassword.localPassword.password.ActiveFlag) {
            if (pagePassword.localPassword.password.ActiveFlag == 1) {
                $("#addActiveStatus").attr("checked", true);
            } else {
                $("#addActiveStatus").attr("checked", false);
            }
        } else {
            $("#addActiveStatus").attr("checked", false);
        }

        if (pagePassword.localPassword.password.PrivateFlag) {
            if (pagePassword.localPassword.password.PrivateFlag == 1) {
                $("#addPrivacy").attr("checked", true);
            } else {
                $("#addPrivacy").attr("checked", false);
            }
        } else {
            $("#addPrivacy").attr("checked", false);
        }

        if (pagePassword.localPassword.password.PasswordTypeCode) {
            $("#passwordType").val(pagePassword.localPassword.password.PasswordTypeName);
            $("#passwordTypeCode").val(pagePassword.localPassword.password.PasswordTypeCode);
        }

        if (pagePassword.localPassword.password.PasswordName) {
            $("#description").val(pagePassword.localPassword.password.PasswordName);
        }

        if (pagePassword.localPassword.password.LoginID) {
            $("#userID").val(pagePassword.localPassword.password.LoginID);
        }

        if (pagePassword.localPassword.password.LoginPassword1) {
            $("#password").val(pagePassword.localPassword.password.LoginPassword1);
        }

        if (pagePassword.localPassword.password.LoginPassword2) {
            $("#otherPassword").val(pagePassword.localPassword.password.LoginPassword2);
        }
        familyCode = temp;
    },
    getPasswordTypeList: function () {
        var url = localStorage.getItem("websiteRoot") + "passwords/getMasters.php";

        $.getJSON(url, {
            passwordType: 1
        }).done(function (data) {
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

        $("#passwordType").autocomplete({
            source: data,
            select: function (event, ui) {
                var index = $.inArray(ui.item.value, data);
                $("#passwordTypeCode").val(dataIndex[index]);
            },
            change: function (event, ui) {
                var index = $.inArray($(event.target).val(), data);
                if (index > -1) {
                    $("#passwordTypeCode").val(dataIndex[index]);
                } else {
                    $("#passwordTypeCode").val("1");
                }
            }
        });
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
                if ($("#otherPassword").attr("type") == "password")
                    $("#otherPassword").attr("type", "text");
                else
                    $("#otherPassword").attr("type", "password");
                break;
        }
    }
};

$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../");

    document.getElementById('searchBox').onkeypress = function (e) {
        if (!e)
            e = window.event;
        console.log(e);
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13') {
            // Enter pressed
            pagePassword.doSearch();
        }
    };

    $.when(pagePassword.defPasswordList).done(function (data) {
        if (data.status == 1)
            pagePassword.getPasswordDetails(data.result[0].PasswordCode);
    });

    pagePassword.getFamilyList();
    pagePassword.getPasswordList();
    pagePassword.getPasswordTypeList();

    $('#passwordModal').on('show.bs.modal', function () {
        $("#password").attr("type", "password");
        $("#otherPassword").attr("type", "password");
    });

    //Password form submit
    $("#passwordForm").ajaxForm({
        beforeSubmit: function (formData) {
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    pageIndex.showNotificationFailure("Required fields are empty");
                    return false;
                }
            }
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                setTimeout(function () {
                    pagePassword.currentPageNo = 1;
                    $("#passwordList").empty();
                    $("#passwordDetailBody").empty();
                    $("#editPasswordBtn").remove();
                    $("#deletePasswordBtn").remove();
                    pagePassword.getPasswordDetails(response.landing);
                    pagePassword.getPasswordList();
                    pageIndex.showNotificationSuccess(response.message);
                    pagePassword.getPasswordTypeList();
                    $("#passwordModal").modal("hide");
                }, 500);
            } else {
                pageIndex.showNotificationFailure(response.message);
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            }
        },
        error: function () {
            pageIndex.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $('#passwordModal').on('hidden.bs.modal', function (e) {
        $("#pageLoading").removeClass("loader");
        $(".cover").fadeOut(100);
    });

    //Password form submit
    $("#deletePasswordForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
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
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            }
        },
        error: function () {
            pageIndex.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $('#deleteModal').on('hidden.bs.modal', function (e) {
        $("#pageLoading").removeClass("loader");
        $(".cover").fadeOut(100);
    });

    $("#searchBox").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#passwordList").empty();
            pagePassword.currentPageNo = 1;
            pagePassword.firstTime = true;
            pagePassword.defPasswordList = $.Deferred();
            pagePassword.getPasswordList();
            $.when(pagePassword.defPasswordList).done(function (data) {
                if (data.status == 1)
                    pagePassword.getPasswordDetails(data.result[0].PasswordCode);
            });
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