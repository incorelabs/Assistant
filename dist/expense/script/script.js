var pageExpense = {
    currentPageNo: 1,
    localExpense: null,
    defExpenseList: $.Deferred(),
    defSearchResult: $.Deferred(),
    expenseTypeTag: [],
    expenseTypeCode: [],
    dueToTag: [],
    dueToCode: [],
    familyList: null,
    expenseList: null,
    firstTime: true,
    getFamilyList: function () {
        var url = app.websiteRoot + "family/getFamily.php";

        $.getJSON(url, {
            list: 2
        }).done(function (data) {
            pageExpense.setFamilyList(data);
        }).fail(function (error) {

        });
    },
    setFamilyList: function (data) {
        pageExpense.familyList = data;
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
    getExpenseList: function () {
        var url = app.websiteRoot + "expense/getExpenseList.php";

        $.getJSON(url, {
            pageNo: pageExpense.currentPageNo
        }).done(function (data) {
            console.log(data);
            pageExpense.defExpenseList.resolve(data);
            pageExpense.setExpenseList(data);
        }).fail(function (error) {

        });
    },
    setExpenseList: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageExpense.currentPageNo++;
            var expenseListString = "";
            for (var i = 0; i < data.result.length; i++) {
                expenseListString += "<a onclick='pageExpense.getExpenseDetails(" + data.result[i].ExpenseCode + ")' class='list-group-item contacts_font'>" + data.result[i].ExpenseName + "</a>";
            }
            $("#expenseList").append(expenseListString);
            if (pageExpense.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageExpense.getExpenseList();'>Load more..</a></div>";
                $("#expenseList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#expenseList").empty().html(noMoreDataString);
        }
    },
    doSearch: function () {
        $("#expenseList").empty();
        pageExpense.currentPageNo = 1;
        pageExpense.firstTime = true;
        pageExpense.defSearchResult = $.Deferred();
        pageExpense.getSearchResults();
        $.when(pageExpense.defSearchResult).done(function (data) {
            if (data.status == 1)
                pageExpense.getExpenseDetails(data.result[0].ExpenseCode);
        });
    },
    getSearchResults: function () {
        var url = app.websiteRoot + "expense/getExpenseList.php";

        $.getJSON(url, {
            pageNo: pageExpense.currentPageNo,
            searchType: 1,
            searchText: $('#searchBox').val().trim()
        }).done(function (data) {
            pageExpense.defSearchResult.resolve(data);
            pageExpense.setSearchResults(data);
        }).fail(function (error) {

        });
    },
    setSearchResults: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageExpense.currentPageNo++;
            var searchResultsString = "";
            for (var i = 0; i < data.result.length; i++) {
                searchResultsString += "<a onclick='pageExpense.getExpenseDetails(" + data.result[i].ExpenseCode + ")' class='list-group-item contacts_font'>" + data.result[i].ExpenseName + "</a>";
            }
            $("#expenseList").append(searchResultsString);
            if (pageExpense.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageExpense.getSearchResults();'>Load more..</a></div>";
                $("#expenseList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#expenseList").empty().html(noMoreDataString);
            $("#expenseDetailBody").empty();
            $("#editExpenseBtn").remove();
            $("#deleteExpenseBtn").remove();
            $("#voucherExpenseBtn").remove();
        }
    },
    getExpenseDetails: function (expenseCode) {
        if (expenseCode == null)
            return;
        var url = app.websiteRoot + "expense/getExpenseDetail.php";

        $.getJSON(url, {
            expenseCode: expenseCode
        }).done(function (data) {
            console.log(data);
            pageExpense.setExpenseDetails(data);
        }).fail(function (error) {

        });
    },
    setExpenseDetails: function (data) {
        if (data.status == 1) {
            pageExpense.localExpense = data.detail;

            var expenseHeaderString = "<h12 id='expenseDetailsTag'>Expense Details</h12><button id='editExpenseBtn' class='btn btn-success pull-right btn-header-margin-left' onclick='pageExpense.openEditExpenseModal();'><span class='glyphicon glyphicon-pencil'></span></button><button id='deleteExpenseBtn' class='btn btn-danger pull-left' onclick='pageExpense.openDeleteExpenseModal(" + data.detail.expense.ExpenseCode + ")'><span class='glyphicon glyphicon-trash'></span></button><button id='voucherExpenseBtn' class='btn btn-info pull-right' onclick='pageExpense.openVoucherExpenseModal(" + data.detail.expense.ExpenseCode + ")'><span class='fa fa-sticky-note-o fa-lg'></span></button>";
            $("#expenseDetailHeader").html(expenseHeaderString);
            var expenseDetailString = "";
            if (window.innerWidth < 992 && !pageExpense.firstTime) {

                //Change the Expense Details Name to Expense
                $('#expenseDetailsTag').empty().html("Details");

                //Show the Expense Details Header and hides the search header

                $("#searchExpenseHeader").addClass('hidden');
                $("#expenseDetailHeaderDiv").removeClass('hidden-xs hidden-sm');

                //Show the Expense Details and hides the expense list
                $("#expenseListDiv").addClass('hidden');
                $("#expenseDetailDiv").removeClass('hidden-xs hidden-sm');

                //Show Hide of menu button with back button
                $(".menu_img").addClass('hidden');
                $("#backButton").removeClass('hidden');

                $("#backButton").click(function () {
                    //Show the Expense Details Header and hides the search header
                    $("#expenseDetailHeaderDiv").addClass('hidden-xs hidden-sm');
                    $("#searchExpenseHeader").removeClass('hidden');

                    //Show the Expense Details and hides the expense list
                    $("#expenseListDiv").removeClass('hidden');
                    $("#expenseDetailDiv").addClass('hidden-xs hidden-sm');

                    //Show Hide of menu button with back button
                    $(".menu_img").removeClass('hidden');
                    $("#backButton").addClass('hidden');

                });
            }
            pageExpense.firstTime = false;

            expenseDetailString += "<div class='row contact-details row-top-padding'><div class='list-group-item-heading header_font'><div class='col-md-3'>Holder's Name</div><value><div class='col-md-9'>" + ((data.detail.expense.HolderName) ? data.detail.expense.HolderName : "") + "</div></value></div></div>";

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Expense Type</div><value><div class='col-md-9'>" + ((data.detail.expense.ExpenseTypeName) ? data.detail.expense.ExpenseTypeName : "") + "</div></value></div></div>";

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Description</div><value><div class='col-md-9'>" + ((data.detail.expense.ExpenseName) ? data.detail.expense.ExpenseName : "") + "</div></value></div></div>";

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Due To</div><value><div class='col-md-9'>" + ((data.detail.expense.FullName) ? data.detail.expense.FullName : "") + "</div></value></div></div>";

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Joint Holder Name</div><value><div class='col-md-9'>" + ((data.detail.expense.JointHolder) ? data.detail.expense.JointHolder : "") + "</div></value></div></div>";

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>" + ((data.detail.expense.ExpenseRemarks) ? data.detail.expense.ExpenseRemarks : "") + "</div></value></div></div>";

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Billing Day</div><value><div class='col-md-9'>" + ((data.detail.expense.BillingDay) ? data.detail.expense.BillingDay : "") + "</div></value></div></div>";

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Due Day</div><value><div class='col-md-9'>" + ((data.detail.expense.DueDay) ? data.detail.expense.DueDay : "") + "</div></value></div></div>";

            var frequency = "";

            switch (data.detail.expense.ExpenseFrequency) {
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

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Payment Frequency</div><value><div class='col-md-9'>" + frequency + "</div></value></div></div>";

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Loan Expiry Date</div><value><div class='col-md-9'>" + ((data.detail.expense.ExpiryDate) ? data.detail.expense.ExpiryDate : "") + "</div></value></div></div>";

            expenseDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Payment URL</div><value><div class='col-md-9'>" + ((data.detail.expense.PayWebsite) ? data.detail.expense.PayWebsite : "") + "</div></value></div></div>";

            $("#expenseDetailBody").html(expenseDetailString);

        } else {
            pageExpense.localExpense = null;
        }
    },
    openAddExpenseModal: function () {
        document.getElementById("expenseForm").reset();
        $('#privateFlag').attr('checked', false);
        $('#activeFlag').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $("#fullName").closest(".form-group").removeClass("has-warning");
        $("#fullName").closest('.form-group').find('.info').empty();

        $('#expenseModalHeading').empty().html("Add Expense");
        $('#expenseModal').modal('show');
    },
    openEditExpenseModal: function () {
        document.getElementById("expenseForm").reset();
        $("#form-add-edit-mode").val("M");

        $("#fullName").closest(".form-group").removeClass("has-warning");
        $("#fullName").closest('.form-group').find('.info').empty();

        $('#expenseModalHeading').empty().html("Edit Expense");

        $("#form-add-edit-code").val(pageExpense.localExpense.expense.ExpenseCode);
        pageExpense.setModalInputFields();

        $("#expenseModal").modal('show');
    },
    setModalInputFields: function () {
        var temp = familyCode;
        familyCode = pageExpense.localExpense.expense.HolderCode;
        pageExpense.setFamilyList(pageExpense.familyList);

        if (pageExpense.localExpense.expense.ActiveFlag) {
            if (pageExpense.localExpense.expense.ActiveFlag == 1) {
                $("#activeFlag").attr("checked", true);
            } else {
                $("#activeFlag").attr("checked", false);
            }
        } else {
            $("#activeFlag").attr("checked", false);
        }

        if (pageExpense.localExpense.expense.PrivateFlag) {
            if (pageExpense.localExpense.expense.PrivateFlag == 1) {
                $("#privateFlag").attr("checked", true);
            } else {
                $("#privateFlag").attr("checked", false);
            }
        } else {
            $("#privateFlag").attr("checked", false);
        }

        if (pageExpense.localExpense.expense.ContactCode) {
            $("#contactCode").val(pageExpense.localExpense.expense.ContactCode);
        }

        if (pageExpense.localExpense.expense.ExpenseTypeCode) {
            $("#expenseTypeName").val(pageExpense.localExpense.expense.ExpenseTypeName);
            $("#expenseTypeCode").val(pageExpense.localExpense.expense.ExpenseTypeCode);
        }

        if (pageExpense.localExpense.expense.ExpenseName) {
            $("#expenseName").val(pageExpense.localExpense.expense.ExpenseName);
        }

        if (pageExpense.localExpense.expense.FullName) {
            $("#fullName").val(pageExpense.localExpense.expense.FullName);
        }

        if (pageExpense.localExpense.expense.JointHolder) {
            $("#jointHolder").val(pageExpense.localExpense.expense.JointHolder);
        }

        if (pageExpense.localExpense.expense.ExpenseRemarks) {
            $("#expenseRemarks").val(pageExpense.localExpense.expense.ExpenseRemarks);
        }

        if (pageExpense.localExpense.expense.BillingDay) {
            $("#billingDay").val(pageExpense.localExpense.expense.BillingDay);
        }

        if (pageExpense.localExpense.expense.DueDay) {
            $("#dueDay").val(pageExpense.localExpense.expense.DueDay);
        }

        if (pageExpense.localExpense.expense.ExpenseFrequency) {
            $("#expenseFrequency").val(pageExpense.localExpense.expense.ExpenseFrequency);
        }

        if (pageExpense.localExpense.expense.ExpiryDate) {
            $("#expiryDate").val(pageExpense.localExpense.expense.ExpiryDate);
        }

        if (pageExpense.localExpense.expense.PayWebsite) {
            $("#payWebsite").val(pageExpense.localExpense.expense.PayWebsite);
        }

        familyCode = temp;
    },
    openDeleteExpenseModal: function (expenseCode) {
        $("#form-delete-code").val(expenseCode);
        $("#deleteModal").modal("show");
    },
    openVoucherExpenseModal: function (expenseCode) {
        window.location.href = app.websiteRoot + "expense/voucher/index.php?expenseCode=" + expenseCode;
    },
    getExpenseTypeList: function () {
        var url = app.websiteRoot + "expense/getMasters.php";

        $.getJSON(url, {
            type: 'expenseType'
        }).done(function (expenseTypeList) {
            console.log(expenseTypeList);
            for (var i = 0; i < expenseTypeList.length; i++) {
                pageExpense.expenseTypeTag[i] = expenseTypeList[i].ExpenseTypeName;
                pageExpense.expenseTypeCode[i] = expenseTypeList[i].ExpenseTypeCode;
            }
            console.log(pageExpense.expenseTypeCode);
            console.log(pageExpense.expenseTypeTag);
            pageExpense.setExpenseTypeAutoComplete();
        }).fail(function (error) {

        });
    },
    setExpenseTypeAutoComplete: function () {
        $("#expenseTypeName").autocomplete({
            source: pageExpense.expenseTypeTag,
            change: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageExpense.expenseTypeTag);
                if (index > -1) {
                    console.log("not selected but value is in array");
                    $("#expenseTypeCode").val(pageExpense.expenseTypeCode[index]);
                } else {
                    console.log("Change triggered");
                    $("#expenseTypeCode").val(1);
                }
            },
            select: function (event, ui) {
                console.log(ui);
                console.log("Selected");
                var index = $.inArray(ui.item.value, pageExpense.expenseTypeTag);
                console.log(index);
                $("#expenseTypeCode").val(pageExpense.expenseTypeCode[index]);
                console.log($("#expenseTypeCode").val());
            }
        });
    },
    getDueToList: function () {
        var url = app.websiteRoot + "expense/getMasters.php";

        $.getJSON(url, {
            type: 'contactList'
        }).done(function (dueToList) {
            console.log(dueToList);
            for (var i = 0; i < dueToList.length; i++) {
                pageExpense.dueToTag[i] = dueToList[i].FullName;
                pageExpense.dueToCode[i] = dueToList[i].ContactCode;
            }
            console.log(pageExpense.dueToCode);
            console.log(pageExpense.dueToTag);
            pageExpense.setDueToAutoComplete();
        }).fail(function (error) {

        });
    },
    setDueToAutoComplete: function () {
        $("#fullName").autocomplete({
            source: pageExpense.dueToTag,
            response: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageExpense.dueToTag);
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

                var index = $.inArray(ui.item.value, pageExpense.dueToTag);
                console.log(index);
                $("#contactCode").val(pageExpense.dueToCode[index]);
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
            pageExpense.doSearch();
        }
    };

    $.when(pageExpense.defExpenseList).done(function (data) {
        if (data.status == 1)
            pageExpense.getExpenseDetails(data.result[0].ExpenseCode);
    });

    pageExpense.getFamilyList();
    pageExpense.getExpenseList();
    pageExpense.getExpenseTypeList();
    pageExpense.getDueToList();

    $("#searchBox").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#expenseList").empty();
            pageExpense.currentPageNo = 1;
            pageExpense.firstTime = true;
            pageExpense.defExpenseList = $.Deferred();
            pageExpense.getExpenseList();
            $.when(pageExpense.defExpenseList).done(function (data) {
                if (data.status == 1)
                    pageExpense.getExpenseDetails(data.result[0].ExpenseCode);
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

    $("#expenseForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            var isValid = false;
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    app.showNotificationFailure("Required fields are empty");
                    return false;
                }
                if (formData[i].name == "expiryDate") {
                    if(formData[i].value.trim() != "") {
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
                    pageExpense.currentPageNo = 1;
                    $("#expenseList").empty();
                    $("#expenseDetailBody").empty();
                    $("#editExpenseBtn").remove();
                    $("#deleteExpenseBtn").remove();
                    $("#voucherExpenseBtn").remove();
                    pageExpense.getExpenseDetails(response.landing);
                    pageExpense.getExpenseList();
                    app.showNotificationSuccess(response.message);
                    pageExpense.getExpenseTypeList();
                    pageExpense.getDueToList();
                    $("#expenseModal").modal("hide");
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

    $('#expenseModal').on('hidden.bs.modal', function (e) {
        $("#pageLoading").removeClass("loader");
        $(".cover").fadeOut(100);
    });

    $("#deleteExpenseForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                setTimeout(function () {
                    pageExpense.currentPageNo = 1;
                    $("#expenseList").empty();
                    $("#expenseDetailBody").empty();
                    $("#editExpenseBtn").remove();
                    $("#deleteExpenseBtn").remove();
                    $("#voucherExpenseBtn").remove();
                    app.showNotificationSuccess(response.message);
                    pageExpense.getExpenseList();
                    pageExpense.getExpenseDetails(response.landing);
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
        $("body").css("overflow", "auto");
        $("#expenseListScroll").removeClass("panelHeight");
        $("#expenseList").addClass("mobile-list");
        $("#expenseListDiv").addClass("mobileBody");
        $("#searchExpenseHeader").addClass("mobileHeader");

        $("#expenseDetail").removeClass("panelHeight");
        $("#expenseDetailDiv").addClass("mobileBody");
        $("#expenseDetailHeaderDiv").addClass("mobileHeader");

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
        $("#expenseListScroll").removeClass("panelHeight");
        $("#expenseList").addClass("mobile-list");
        $("#expenseListDiv").addClass("mobileBody");
        $("#searchExpenseHeader").addClass("mobileHeader");

        $("#expenseDetail").removeClass("panelHeight");
        $("#expenseDetailDiv").addClass("mobileBody");
        $("#expenseDetailHeaderDiv").addClass("mobileHeader");

        //For Modal Text field resize
        $("#billingDayDiv").removeClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").removeClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").addClass("mobile-col-padding-remove");
        $("#dueDayDiv").addClass("mobile-col-top-padding mobile-col-padding-remove");
    } else {
        $("body").css("overflow", "hidden");
        $("#expenseListScroll").addClass("panelHeight");
        $("#expenseList").removeClass("mobile-list");
        $("#expenseListDiv").removeClass("mobileBody");
        $("#searchExpenseHeader").removeClass("mobileHeader");

        $("#expenseDetail").addClass("panelHeight");
        $("#expenseDetailDiv").removeClass("mobileBody");
        $("#expenseDetailHeaderDiv").removeClass("mobileHeader");

        //Show the Expense Details Header and hides the search header
        $("#expenseDetailHeaderDiv").addClass('hidden-xs hidden-sm');
        $("#searchExpenseHeader").removeClass('hidden');

        //Show the Expense Details and hides the password list
        $("#expenseListDiv").removeClass('hidden');
        $("#expenseDetailDiv").addClass('hidden-xs hidden-sm');

        //Show Hide of menu button with back button
        $(".menu_img").removeClass('hidden');
        $("#backButton").addClass('hidden');

        //For Modal Text field resize
        $("#billingDayDiv").addClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").addClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").removeClass("mobile-col-padding-remove");
        $("#dueDayDiv").removeClass("mobile-col-top-padding mobile-col-padding-remove");
    }
});
