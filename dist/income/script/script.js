var pageIncome = {
    currentPageNo: 1,
    localIncome: null,
    defIncomeList: $.Deferred(),
    defSearchResult: $.Deferred(),
    firstTime: true,
    openAddIncomeModal: function(){
        document.getElementById("incomeForm").reset();
        $('#addPrivacy').attr('checked', false);
        $('#addActiveStatus').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#incomeModalHeading').empty().html("Add Income");
        $('#incomeModal').modal('show');
    },
    openEditIncomeModal: function(){
        document.getElementById("incomeForm").reset();
        // $("#form-add-edit-mode").val("M");

        $('#incomeModalHeading').empty().html("Edit Income");

        //$("#form-add-edit-code").val(pageIncome.localIncome.income.IncomeCode);
        //pageIncome.setModalInputFields();

        $("#incomeModal").modal('show');
    },
    openDeleteIncomeModal: function (incomeCode) {
        $("#form-delete-code").val(incomeCode);
        $("#deleteModal").modal("show");
    },
    openVoucherIncomeModal: function (){
        window.location.href = "../income/voucher/";
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
