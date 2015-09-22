var pageExpense = {
    currentPageNo: 1,
    localExpense: null,
    defExpenseList: $.Deferred(),
    defSearchResult: $.Deferred(),
    familyList: null,
    expenseList: null,
    firstTime: true,
    getFamilyList: function () {
        var url = localStorage.getItem("websiteRoot") + "family/getFamily.php";

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
        var url = localStorage.getItem("websiteRoot") + "expense/getExpenseList.php";

        $.getJSON(url, {
            pageNo: pageExpense.currentPageNo
        }).done(function (data) {
            pageExpense.defExpenseList.resolve(data);
            pageExpense.setExpenseList(data);
        }).fail(function (error) {

        });
    },
    setExpenseList: function (data) {

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
        var url = localStorage.getItem("websiteRoot") + "expense/getExpenseList.php";

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

    },
    getExpenseDetails: function (expenseCode) {
        if (expenseCode == null)
            return;
        var url = localStorage.getItem("websiteRoot") + "expense/getExpenseDetail.php";

        $.getJSON(url, {
            expenseCode: expenseCode
        }).done(function (data) {
            pageExpense.setExpenseDetails(data);
        }).fail(function (error) {

        });
    },
    setExpenseDetails: function (data) {

    },
    openAddExpenseModal: function () {
        document.getElementById("expenseForm").reset();
        $('#addPrivacy').attr('checked', false);
        $('#addActiveStatus').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#expenseModalHeading').empty().html("Add Expense");
        $('#expenseModal').modal('show');
    },
    openEditExpenseModal: function () {
        document.getElementById("expenseForm").reset();
        $("#form-add-edit-mode").val("M");

        $('#expenseModalHeading').empty().html("Edit Expense");

        $("#form-add-edit-code").val(pageExpense.localExpense.expense.ExpenseCode);
        pageExpense.setModalInputFields();

        $("#expenseModal").modal('show');
    },
    openDeleteExpenseModal: function (expenseCode) {
        $("#form-delete-code").val(expenseCode);
        $("#deleteModal").modal("show");
    },
    openVoucherExpenseModal: function () {
        window.location.href = "../expense/voucher/";
    },
    getExpenseTypeList: function () {
        var url = localStorage.getItem("websiteRoot") + "expense/getMasters.php";

        $.getJSON(url, {
            expenseType: 1
        }).done(function (data) {
            pageExpense.setExpenseTypeAutoComplete(data);
        }).fail(function (error) {

        });
    },
    setExpenseTypeAutoComplete: function (tags) {

    },
    getDueToList: function () {
        var url = localStorage.getItem("websiteRoot") + "expense/getMasters.php";

        $.getJSON(url, {
            expenseType: 2
        }).done(function (data) {
            pageExpense.setDueToAutoComplete(data);
        }).fail(function (error) {

        });
    },
    setDueToAutoComplete: function (tags) {

    }
};

$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../");

    pageExpense.getFamilyList();

    if (window.innerWidth < 992) {
        $("#billingDayDiv").removeClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").removeClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").addClass("mobile-col-padding-remove");
        $("#dueDayDiv").addClass("mobile-col-top-padding mobile-col-padding-remove");
    }
});

$(window).resize(function () {
    if (window.innerWidth < 992) {
        $("#billingDayDiv").removeClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").removeClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").addClass("mobile-col-padding-remove");
        $("#dueDayDiv").addClass("mobile-col-top-padding mobile-col-padding-remove");
    } else {
        $("#billingDayDiv").addClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").addClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").removeClass("mobile-col-padding-remove");
        $("#dueDayDiv").removeClass("mobile-col-top-padding mobile-col-padding-remove");
    }
});
