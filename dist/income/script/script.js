var pageIncome = {
    currentPageNo: 1,
    localIncome: null,
    defIncomeList: $.Deferred(),
    defSearchResult: $.Deferred(),
    incomeTypeTag: [],
    incomeTypeCode: [],
    dueFromTag: [],
    dueFromCode: [],
    familyList: null,
    incomeList: null,
    firstTime: true,
    getFamilyList: function () {
        var url = app.websiteRoot + "family/getFamily.php";

        $.getJSON(url, {
            list: 2
        }).done(function (data) {
            pageIncome.setFamilyList(data);
        }).fail(function (error) {

        });
    },
    setFamilyList: function (data) {
        pageIncome.familyList = data;
        var familyListString = "";
        for (var i = 0; i < data.length; i++) {
            if (data[i].FamilyCode == familyCode) {
                familyListString += "<option value = " + data[i].FamilyCode + " selected = 'selected'>" + data[i].FamilyName + "</option>";
            }
            else {
                familyListString += "<option value = " + data[i].FamilyCode + ">" + data[i].FamilyName + "</option>";
            }
        }
        $("#holderCode").html(familyListString);
    },
    getIncomeList: function () {
        var url = app.websiteRoot + "income/getIncomeList.php";

        $.getJSON(url, {
            pageNo: pageIncome.currentPageNo
        }).done(function (data) {
            console.log(data);
            pageIncome.defIncomeList.resolve(data);
            pageIncome.setIncomeList(data);
        }).fail(function (error) {

        });
    },
    setIncomeList: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageIncome.currentPageNo++;
            var incomeListString = "";
            for (var i = 0; i < data.result.length; i++) {
                incomeListString += "<a onclick='pageIncome.getIncomeDetails(" + data.result[i].IncomeCode + ")' class='list-group-item contacts_font'>" + data.result[i].HolderName + " - " + data.result[i].IncomeName + "</a>";
            }
            $("#incomeList").append(incomeListString);
            if (pageIncome.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageIncome.getIncomeList();'>Load more..</a></div>";
                $("#incomeList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#incomeList").empty().html(noMoreDataString);
        }
    },
    doSearch: function () {
        $("#incomeList").empty();
        pageIncome.currentPageNo = 1;
        pageIncome.firstTime = true;
        pageIncome.defSearchResult = $.Deferred();
        pageIncome.getSearchResults();
        $.when(pageIncome.defSearchResult).done(function (data) {
            if (data.status == 1)
                pageIncome.getIncomeDetails(data.result[0].IncomeCode);
        });
    },
    getSearchResults: function () {
        var url = app.websiteRoot + "income/getIncomeList.php";

        $.getJSON(url, {
            pageNo: pageIncome.currentPageNo,
            searchType: 1,
            searchText: $('#searchBox').val().trim()
        }).done(function (data) {
            pageIncome.defSearchResult.resolve(data);
            pageIncome.setSearchResults(data);
        }).fail(function (error) {

        });
    },
    setSearchResults: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageIncome.currentPageNo++;
            var searchResultsString = "";
            for (var i = 0; i < data.result.length; i++) {
                searchResultsString += "<a onclick='pageIncome.getIncomeDetails(" + data.result[i].IncomeCode + ")' class='list-group-item contacts_font'>" + data.result[i].HolderName + " - " + data.result[i].IncomeName + "</a>";
            }
            $("#incomeList").append(searchResultsString);
            if (pageIncome.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageIncome.getSearchResults();'>Load more..</a></div>";
                $("#incomeList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#incomeList").empty().html(noMoreDataString);
            $("#incomeDetailBody").empty();
            $("#editIncomeBtn").remove();
            $("#deleteIncomeBtn").remove();
            $("#voucherIncomeBtn").remove();
        }
    },
    getIncomeDetails: function (incomeCode) {
        if (incomeCode == null)
            return;
        var url = app.websiteRoot + "income/getIncomeDetail.php";

        $.getJSON(url, {
            incomeCode: incomeCode
        }).done(function (data) {
            pageIncome.setIncomeDetails(data);
        }).fail(function (error) {

        });
    },
    setIncomeDetails: function (data) {
        if (data.status == 1) {
            pageIncome.localIncome = data.detail;

            var incomeHeaderString = "<h12>Income Details</h12><button id='editIncomeBtn' class='btn btn-success pull-right btn-header-margin-left' onclick='pageIncome.openEditIncomeModal();'><span class='glyphicon glyphicon-pencil'></span></button><button id='deleteIncomeBtn' class='btn btn-danger pull-left' onclick='pageIncome.openDeleteIncomeModal(" + data.detail.income.IncomeCode + ")'><span class='glyphicon glyphicon-trash'></span></button><button id='voucherIncomeBtn' class='btn btn-info pull-right' onclick='pageIncome.openVoucherIncomeModal(" + data.detail.income.IncomeCode + ")'><span class='fa fa-sticky-note-o fa-lg'></span></button>";
            var incomeDetailString = "";
            if (window.innerWidth < 992 && !pageIncome.firstTime) {
                //Change the Expense Details Name to Expense
                $('#incomeDetailsTag').empty().html("Details");

                //Show the Expense Details Header and hides the search header

                $("#searchIncomeHeader").addClass('hidden');
                $("#incomeDetailHeaderDiv").removeClass('hidden-xs hidden-sm');

                //Show the Expense Details and hides the expense list
                $("#incomeListDiv").addClass('hidden');
                $("#incomeDetailDiv").removeClass('hidden-xs hidden-sm');

                //Show Hide of menu button with back button
                $(".menu_img").addClass('hidden');
                $("#backButton").removeClass('hidden');

                $("#backButton").click(function () {
                    //Show the Expense Details Header and hides the search header
                    $("#incomeDetailHeaderDiv").addClass('hidden-xs hidden-sm');
                    $("#searchIncomeHeader").removeClass('hidden');

                    //Show the Expense Details and hides the expense list
                    $("#incomeListDiv").removeClass('hidden');
                    $("#incomeDetailDiv").addClass('hidden-xs hidden-sm');

                    //Show Hide of menu button with back button
                    $(".menu_img").removeClass('hidden');
                    $("#backButton").addClass('hidden');
                });
            }
            pageIncome.firstTime = false;

            incomeDetailString += "<div class='row contact-details row-top-padding'><div class='list-group-item-heading header_font'><div class='col-md-3'>Holder's Name</div><value><div class='col-md-9'>" + ((data.detail.income.HolderName) ? data.detail.income.HolderName : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Income Type</div><value><div class='col-md-9'>" + ((data.detail.income.IncomeTypeName) ? data.detail.income.IncomeTypeName : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Description</div><value><div class='col-md-9'>" + ((data.detail.income.IncomeName) ? data.detail.income.IncomeName : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Due From</div><value><div class='col-md-9'>" + ((data.detail.income.FullName) ? data.detail.income.FullName : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Joint Holder Name</div><value><div class='col-md-9'>" + ((data.detail.income.JointHolder) ? data.detail.income.JointHolder : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>" + ((data.detail.income.IncomeRemarks) ? data.detail.income.IncomeRemarks : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Billing Day</div><value><div class='col-md-9'>" + ((data.detail.income.BillingDay) ? data.detail.income.BillingDay : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Due Day</div><value><div class='col-md-9'>" + ((data.detail.income.DueDay) ? data.detail.income.DueDay : "") + "</div></value></div></div>";

            var frequency = "";

            switch (data.detail.income.IncomeFrequency) {
                case "1":
                    frequency = "Daily";
                    break;
                case "2":
                    frequency = "Weekly";
                    break;
                case "3":
                    frequency = "Fort Night";
                    break;
                case "4":
                    frequency = "Monthly";
                    break;
                case "5":
                    frequency = "Bi-Monthly";
                    break;
                case "6":
                    frequency = "Quarterly";
                    break;
                case "7":
                    frequency = "Half Yearly";
                    break;
                case "8":
                    frequency = "Yearly";
                    break;
            }

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Payment Frequency</div><value><div class='col-md-9'>" + frequency + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Loan Expiry Date</div><value><div class='col-md-9'>" + ((data.detail.income.ExpiryDate) ? data.detail.income.ExpiryDate : "") + "</div></value></div></div>";

            $("#incomeDetailHeader").html(incomeHeaderString);
            $("#incomeDetailBody").html(incomeDetailString);

        } else {
            pageIncome.localIncome = null;
        }
    },
    openAddIncomeModal: function () {
        document.getElementById("incomeForm").reset();
        $('#privateFlag').attr('checked', false);
        $('#activeFlag').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $("#fullName").closest(".form-group").removeClass("has-warning").find('.info').empty();
        $("#expiryDate").removeAttr("required").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $('#incomeModalHeading').empty().html("Add Income");
        $('#incomeModal').modal('show');
    },
    openEditIncomeModal: function () {
        document.getElementById("incomeForm").reset();
        $("#form-add-edit-mode").val("M");

        $("#fullName").closest(".form-group").removeClass("has-warning").find('.info').empty();
        $("#expiryDate").removeAttr("required").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $('#incomeModalHeading').empty().html("Edit Income");

        $("#form-add-edit-code").val(pageIncome.localIncome.income.IncomeCode);
        pageIncome.setModalInputFields();

        $("#incomeModal").modal('show');
    },
    setModalInputFields: function () {
        var temp = familyCode;
        familyCode = pageIncome.localIncome.income.HolderCode;
        pageIncome.setFamilyList(pageIncome.familyList);

        if (pageIncome.localIncome.income.ActiveFlag) {
            if (pageIncome.localIncome.income.ActiveFlag == 1) {
                $("#activeFlag").attr("checked", true);
            } else {
                $("#activeFlag").attr("checked", false);
            }
        } else {
            $("#activeFlag").attr("checked", false);
        }

        if (pageIncome.localIncome.income.PrivateFlag) {
            if (pageIncome.localIncome.income.PrivateFlag == 1) {
                $("#privateFlag").attr("checked", true);
            } else {
                $("#privateFlag").attr("checked", false);
            }
        } else {
            $("#privateFlag").attr("checked", false);
        }

        if (pageIncome.localIncome.income.ContactCode) {
            $("#contactCode").val(pageIncome.localIncome.income.ContactCode);
        }

        if (pageIncome.localIncome.income.IncomeTypeCode) {
            $("#incomeTypeName").val(pageIncome.localIncome.income.IncomeTypeName);
            $("#incomeTypeCode").val(pageIncome.localIncome.income.IncomeTypeCode);
            if (pageIncome.localIncome.income.IncomeTypeCode == 1002)
                $("#expiryDate").attr("required", "");
        }

        if (pageIncome.localIncome.income.IncomeName) {
            $("#incomeName").val(pageIncome.localIncome.income.IncomeName);
        }

        if (pageIncome.localIncome.income.FullName) {
            $("#fullName").val(pageIncome.localIncome.income.FullName);
        }

        if (pageIncome.localIncome.income.JointHolder) {
            $("#jointHolder").val(pageIncome.localIncome.income.JointHolder);
        }

        if (pageIncome.localIncome.income.IncomeRemarks) {
            $("#incomeRemarks").val(pageIncome.localIncome.income.IncomeRemarks);
        }

        if (pageIncome.localIncome.income.BillingDay) {
            $("#billingDay").val(pageIncome.localIncome.income.BillingDay);
        }

        if (pageIncome.localIncome.income.DueDay) {
            $("#dueDay").val(pageIncome.localIncome.income.DueDay);
        }

        if (pageIncome.localIncome.income.IncomeFrequency) {
            $("#incomeFrequency").val(pageIncome.localIncome.income.IncomeFrequency);
        }

        if (pageIncome.localIncome.income.ExpiryDate) {
            $("#expiryDate").val(pageIncome.localIncome.income.ExpiryDate);
        }

        familyCode = temp;
    },
    openDeleteIncomeModal: function (incomeCode) {
        $("#form-delete-code").val(incomeCode);
        $("#deleteModal").modal("show");
    },
    openVoucherIncomeModal: function (incomeCode) {
        window.location.href = app.websiteRoot + "income/voucher/index.php?incomeCode=" + incomeCode;
    },
    getIncomeTypeList: function () {
        var url = app.websiteRoot + "income/getMasters.php";

        $.getJSON(url, {
            type: 'incomeType'
        }).done(function (incomeTypeList) {
            console.log(incomeTypeList);
            for (var i = 0; i < incomeTypeList.length; i++) {
                pageIncome.incomeTypeTag[i] = incomeTypeList[i].IncomeTypeName;
                pageIncome.incomeTypeCode[i] = incomeTypeList[i].IncomeTypeCode;
            }
            console.log(pageIncome.incomeTypeCode);
            console.log(pageIncome.incomeTypeTag);
            pageIncome.setIncomeTypeAutoComplete();
        }).fail(function (error) {

        });
    },
    setIncomeTypeAutoComplete: function () {
        $("#incomeTypeName").autocomplete({
            source: pageIncome.incomeTypeTag,
            change: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageIncome.incomeTypeTag);
                if (index > -1) {
                    console.log("not selected but value is in array");
                    if (pageIncome.incomeTypeCode[index] == 1002)
                        $("#expiryDate").attr("required", "");
                    else
                        $("#expiryDate").removeAttr("required");
                    $("#incomeTypeCode").val(pageIncome.incomeTypeCode[index]);
                } else {
                    if ($(event.target).val().trim() == "")
                        $("#expiryDate").removeAttr("required");
                    console.log("Change triggered");
                    $("#incomeTypeCode").val(1);
                }
            },
            select: function (event, ui) {
                console.log(ui);
                console.log("Selected");
                var index = $.inArray(ui.item.value, pageIncome.incomeTypeTag);
                if (pageIncome.incomeTypeCode[index] == 1002)
                    $("#expiryDate").attr("required", "");
                else
                    $("#expiryDate").removeAttr("required");
                $("#incomeTypeCode").val(pageIncome.incomeTypeCode[index]);
                console.log($("#incomeTypeCode").val());
            }
        });
    },
    getDueFromList: function () {
        var url = app.websiteRoot + "income/getMasters.php";

        $.getJSON(url, {
            type: 'contactList'
        }).done(function (dueFromList) {
            console.log(dueFromList);
            for (var i = 0; i < dueFromList.length; i++) {
                pageIncome.dueFromTag[i] = dueFromList[i].FullName;
                pageIncome.dueFromCode[i] = dueFromList[i].ContactCode;
            }
            console.log(pageIncome.dueFromCode);
            console.log(pageIncome.dueFromTag);
            pageIncome.setDueFromAutoComplete();
        }).fail(function (error) {

        });
    },
    setDueFromAutoComplete: function () {
        $("#fullName").autocomplete({
            source: pageIncome.dueFromTag,
            response: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageIncome.dueFromTag);
                var formGroup = $(this).closest(".form-group");
                if (index > -1) {
                    formGroup.addClass("has-warning");
                    $(this).closest('.form-group').find('.info').html("A New Contact Will Be Created.");
                    console.log("new contact will be created");
                    // show a red error that new contact will be created.
                    console.log("not selected but value is in array");
                } else {
                    formGroup.removeClass("has-warning");
                    $(this).closest('.form-group').find('.info').empty();
                }
                $("#contactCode").val(1);
            },
            select: function (event, ui) {
                console.log(ui);
                console.log("Selected");

                var formGroup = $(this).closest(".form-group");
                formGroup.removeClass("has-warning");
                $(this).closest('.form-group').find('.info').empty();

                var index = $.inArray(ui.item.value, pageIncome.dueFromTag);
                console.log(index);
                $("#contactCode").val(pageIncome.dueFromCode[index]);
                console.log($("#contactCode").val());
            }
        });
    }
};

$(document).ready(function () {
    app.websiteRoot = "../";
    app.setAccountProfilePicture();

    document.getElementById('searchBox').onkeypress = function (e) {
        if (!e)
            e = window.event;
        console.log(e);
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13') {
            // Enter pressed
            pageIncome.doSearch();
        }
    };

    $.when(pageIncome.defIncomeList).done(function (data) {
        if (data.status == 1)
            pageIncome.getIncomeDetails(data.result[0].IncomeCode);
    });

    pageIncome.getFamilyList();
    pageIncome.getIncomeList();
    pageIncome.getIncomeTypeList();
    pageIncome.getDueFromList();

    $("#searchBox").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#incomeList").empty();
            pageIncome.currentPageNo = 1;
            pageIncome.firstTime = true;
            pageIncome.defIncomeList = $.Deferred();
            pageIncome.getIncomeList();
            $.when(pageIncome.defIncomeList).done(function (data) {
                if (data.status == 1)
                    pageIncome.getIncomeDetails(data.result[0].IncomeCode);
            });
        }
    });

    $("#expiryDate").focusin(function () {
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

    $("#fullName").focusout(function () {
        if ($(this).val().trim() == "") {
            var formGroup = $(this).closest(".form-group");
            formGroup.removeClass("has-warning");
            $(this).closest('.form-group').find('.info').empty();
            $("#contactCode").val(1);
        }
    });

    $("#incomeForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            var isValid = false;
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    app.showNotificationFailure("Required fields are empty");
                    return false;
                }
                if (formData[i].name == "expiryDate") {
                    if (formData[i].value.trim() != "") {
                        if (app.validateDate(formData[i].value) === app.dateValidationState.SUCCESS)
                            isValid = true;
                        else {
                            isValid = false;
                            break;
                        }
                    } else {
                        isValid = true;
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
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                setTimeout(function () {
                    pageIncome.currentPageNo = 1;
                    $("#incomeList").empty();
                    $("#incomeDetailBody").empty();
                    $("#editIncomeBtn").remove();
                    $("#deleteIncomeBtn").remove();
                    $("#voucherIncomeBtn").remove();
                    pageIncome.getIncomeDetails(response.landing);
                    pageIncome.getIncomeList();
                    app.showNotificationSuccess(response.message);
                    pageIncome.getIncomeTypeList();
                    pageIncome.getDueFromList();
                    $("#incomeModal").modal("hide");
                }, 500);
            } else {
                app.showNotificationFailure(response.message);
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $('#incomeModal').on('hidden.bs.modal', function (e) {
        $("#pageLoading").removeClass("loader");
        $(".cover").fadeOut(100);
    });

    $("#deleteIncomeForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                setTimeout(function () {
                    pageIncome.currentPageNo = 1;
                    $("#incomeList").empty();
                    $("#incomeDetailBody").empty();
                    $("#editIncomeBtn").remove();
                    $("#deleteIncomeBtn").remove();
                    $("#voucherIncomeBtn").remove();
                    app.showNotificationSuccess(response.message);
                    pageIncome.getIncomeList();
                    pageIncome.getIncomeDetails(response.landing);
                    $("#deleteModal").modal("hide");
                }, 500);
            } else {
                app.showNotificationFailure(response.message);
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $('#deleteModal').on('hidden.bs.modal', function (e) {
        $("#pageLoading").removeClass("loader");
        $(".cover").fadeOut(100);
    });

    if (window.innerWidth < 992) {
        //Mobile View list & detaills
        $("body").css("overflow", "auto");
        $("#incomeListScroll").removeClass("panelHeight");
        $("#incomeList").addClass("mobile-list");
        $("#incomeListDiv").addClass("mobileBody");
        $("#searchIncomeHeader").addClass("mobileHeader");

        $("#incomeDetail").removeClass("panelHeight");
        $("#incomeDetailDiv").addClass("mobileBody");
        $("#incomeDetailHeaderDiv").addClass("mobileHeader");

        //For Modal Text field resize
        $("#billingDayDiv").removeClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").removeClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").addClass("mobile-col-padding-remove");
        $("#dueDayDiv").addClass("mobile-col-top-padding mobile-col-padding-remove");
    }
});

$(window).resize(function () {
    if (window.innerWidth < 992) {
        //Mobile View list & detaills
        $("body").css("overflow", "auto");
        $("#incomeListScroll").removeClass("panelHeight");
        $("#incomeList").addClass("mobile-list");
        $("#incomeListDiv").addClass("mobileBody");
        $("#searchIncomeHeader").addClass("mobileHeader");

        $("#incomeDetail").removeClass("panelHeight");
        $("#incomeDetailDiv").addClass("mobileBody");
        $("#incomeDetailHeaderDiv").addClass("mobileHeader");

        $("#billingDayDiv").removeClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").removeClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").addClass("mobile-col-padding-remove");
        $("#dueDayDiv").addClass("mobile-col-top-padding mobile-col-padding-remove");
    } else {
        $("body").css("overflow", "hidden");
        $("#incomeListScroll").addClass("panelHeight");
        $("#incomeList").removeClass("mobile-list");
        $("#incomeListDiv").removeClass("mobileBody");
        $("#searchIncomeHeader").removeClass("mobileHeader");

        $("#incomeDetail").addClass("panelHeight");
        $("#incomeDetailDiv").removeClass("mobileBody");
        $("#incomeDetailHeaderDiv").removeClass("mobileHeader");

        //Show the Expense Details Header and hides the search header
        $("#incomeDetailHeaderDiv").addClass('hidden-xs hidden-sm');
        $("#searchIncomeHeader").removeClass('hidden');

        //Show the Expense Details and hides the password list
        $("#incomeListDiv").removeClass('hidden');
        $("#incomeDetailDiv").addClass('hidden-xs hidden-sm');

        //Show Hide of menu button with back button
        $(".menu_img").removeClass('hidden');
        $("#backButton").addClass('hidden');

        $("#billingDayDiv").addClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").addClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").removeClass("mobile-col-padding-remove");
        $("#dueDayDiv").removeClass("mobile-col-top-padding mobile-col-padding-remove");
    }
});
