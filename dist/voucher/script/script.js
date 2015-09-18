var pageVoucher = {
    currentPageNo: 1,
    localVoucher: null,
    defVoucherList: $.Deferred(),
    defSearchResult: $.Deferred(),
    firstTime: true,
    openAddVoucherModal: function(){
        document.getElementById("voucherForm").reset();
        $('#addPrivacy').attr('checked', false);
        $('#addActiveStatus').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#voucherModalHeading').empty().html("Add Voucher");
        $('#voucherModal').modal('show');
    },
    openEditVoucherModal: function(){
        document.getElementById("voucherForm").reset();
        // $("#form-add-edit-mode").val("M");

        $('#voucherModalHeading').empty().html("Edit Voucher");

        //$("#form-add-edit-code").val(pageExpense.localExpense.expense.ExpenseCode);
        //pageExpense.setModalInputFields();

        $("#voucherModal").modal('show');
    },
    openDeleteExpenseModal: function (expenseCode) {
        $("#form-delete-code").val(expenseCode);
        $("#deleteModal").modal("show");
    },
    navigateBack: function () {
        window.location.href = "../expense/";
    }
};

$(document).ready(function () {

});
