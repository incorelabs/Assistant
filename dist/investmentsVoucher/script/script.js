var pageInvestmentVoucher = {
    openAddVoucherModal: function () {
        document.getElementById("voucherForm").reset();

        //$("#form-add-edit-mode").val("A");
        //$("#form-add-edit-code").val(1);

        $('#voucherModalHeading').empty().html("Add Voucher");
        //$("#voucherDescription").empty().val(pageInvestmentVoucher.investmentName);
        //$("#investmentCodeForAddEditVoucher").val(pageInvestmentVoucher.investmentCode);

        //$("#voucherDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        //$("#referDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        //$("#docAmount").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $('#voucherModal').modal('show');
    },
    openEditVoucherModal: function () {
        //pageInvestmentVoucher.voucherDetails = pageInvestmentVoucher.voucherList[voucherIndex];

        //document.getElementById("voucherForm").reset();
        //$("#form-add-edit-mode").val("M");

        $('#voucherModalHeading').empty().html("Edit Voucher");
        //$("#voucherDescription").empty().val(pageInvestmentVoucher.investmentName);
        //$("#investmentCodeForAddEditVoucher").val(pageInvestmentVoucher.investmentCode);

        //$("#voucherDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        //$("#referDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        //$("#docAmount").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        //pageInvestmentVoucher.setInputFields(pageInvestmentVoucher.voucherDetails);
        //$("#form-add-edit-code").val(pageInvestmentVoucher.voucherDetails["VoucherNo"]);

        $("#voucherModal").modal('show');
    },
    openDeleteVoucherModal: function () {
        //$("#investmentCodeForDeleteVoucher").val(pageInvestmentVoucher.investmentCode);
        //$("#form-delete-code").val(voucherCode);
        $("#deleteModal").modal("show");
    },
    openLogoVoucherModal: function () {
       // pageInvestmentVoucher.voucherDetails = pageInvestmentVoucher.voucherList[voucherIndex];
        //$("#investmentVoucherUploadProgressBar").width(0 + "%");
        $("#imageModal").modal("show");
    },
    navigateBack: function () {
        window.location.href = "../";
    }
};

$(document).ready(function () {
    app.websiteRoot = "../../";
});
