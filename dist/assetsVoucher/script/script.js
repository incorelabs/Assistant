var pageAssetsVoucher = {
    openAddVoucherModal: function () {
        document.getElementById("voucherForm").reset();

        $('#voucherModalHeading').empty().html("Add Voucher");

        $('#voucherModal').modal('show');
    },
    openEditVoucherModal: function (voucherIndex) {
        document.getElementById("voucherForm").reset();

        $('#voucherModalHeading').empty().html("Edit Voucher");

        $("#voucherModal").modal('show');
    },
    openDeleteVoucherModal: function (voucherCode) {
        $("#deleteModal").modal("show");
    },
    openLogoVoucherModal: function (voucherIndex) {

        $("#imageModal").modal("show");
    },
    navigateBack: function () {
        window.location.href = "../";
    }
};

$(document).ready(function () {

});
