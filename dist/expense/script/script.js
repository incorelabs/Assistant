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
        $("#voucherModal").modal("show");
    }
};

$(document).ready(function () {
    $("#paymentMode").change(function () {
        var online = $("#paymentMode").val();
        if(online == 2) {
            $("#paymentSiteDiv").removeClass("hidden");
        } else{
            $("#paymentSiteDiv").addClass("hidden");
        }
    });
    $("#voucherPaymentMode").change(function () {
        var voucherPaymentMode = $("#voucherPaymentMode").val();
        if(voucherPaymentMode == 3 || voucherPaymentMode == 4) {
            $("#receiptNumberDiv").removeClass("hidden");
            $("#receiptDateDiv").removeClass("hidden");
        } else{
            $("#receiptNumberDiv").addClass("hidden");
            $("#receiptDateDiv").addClass("hidden");
        }
    });
});
