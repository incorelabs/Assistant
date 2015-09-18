var pageExpense = {
    currentPageNo: 1,
    localExpense: null,
    defExpenseList: $.Deferred(),
    defSearchResult: $.Deferred(),
    firstTime: true,
    openAddExpenseModal: function(){
        document.getElementById("expenseForm").reset();
        $('#addPrivacy').attr('checked', false);
        $('#addActiveStatus').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#expenseModalHeading').empty().html("Add Expense");
        $('#expenseModal').modal('show');
    },
    openEditExpenseModal: function(){
        document.getElementById("expenseForm").reset();
       // $("#form-add-edit-mode").val("M");

        $('#expenseModalHeading').empty().html("Edit Password");

        //$("#form-add-edit-code").val(pageExpense.localExpense.expense.ExpenseCode);
        //pageExpense.setModalInputFields();

        $("#expenseModal").modal('show');
    },
    openDeleteExpenseModal: function (expenseCode) {
        $("#form-delete-code").val(expenseCode);
        $("#deleteModal").modal("show");
    },
    openVoucherExpenseModal: function (){
        window.location.href = "../voucher/";
    }
};

$(document).ready(function () {
    if(window.innerWidth < 992)
    {
        $("#billingDayDiv").removeClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").removeClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").addClass("mobile-col-padding-remove");
        $("#dueDayDiv").addClass("mobile-col-top-padding mobile-col-padding-remove");
    }
});

$(window).resize(function(){
    if(window.innerWidth < 992) {
        $("#billingDayDiv").removeClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").removeClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").addClass("mobile-col-padding-remove");
        $("#dueDayDiv").addClass("mobile-col-top-padding mobile-col-padding-remove");
    } else{
        $("#billingDayDiv").addClass("first-col-left-padding first-col-right-padding");
        $("#dueDayDiv").addClass("second-col-left-padding second-col-right-padding");

        $("#billingDayDiv").removeClass("mobile-col-padding-remove");
        $("#dueDayDiv").removeClass("mobile-col-top-padding mobile-col-padding-remove");
    }
});
