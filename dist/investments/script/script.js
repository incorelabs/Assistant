var pageInvestment = {
    mediclaimFamily: 0,
    openAddInvestmentModal: function () {

        $('#investmentModalHeading').empty().html("Add Investment");
        $('#investmentModal').modal('show');
    },
    openEditInvestmentModal: function () {
        document.getElementById("investmentForm").reset();

        $('#investmentModalHeading').empty().html("Edit Asset");
        $("#investmentModal").modal('show');
    },
    openDeleteInvestmentModal: function(){

        $("#deleteModal").modal("show");
    },
    openVoucherInvestmentModal: function(){

        window.location.href = app.websiteRoot + "investments/voucher";
    },
    openInvestmentImageModal: function(){
        $("#assetUploadProgressBar").width(0 + "%");
        $("#imageModal").modal('show');
    },
    openInvestmentTypeModal: function(){

        $('.removeDiv').remove();
        pageInvestment.mediclaimFamily = 0;

        $("#investmentTypeModal").modal("show");
    },
    addSubDiv: function(type){
        switch (type)
        {
            case 1:
                if(pageInvestment.mediclaimFamily <= 7) {
                    var newDiv = "<div class='removeDiv'><div class='row'><div class='col-md-11 col-sm-11 col-xs-12'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Family Member</span><div class='inner-addon right-addon'><i class='fa fa-caret-down fa-size'></i><select class='form-control select-field-left-border'> <!-- Family Member List--><option>Darshan</option></select></div></div></div><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label two-col-span-label'>Details</span><span class='input-group-btn select-inline'><input type='number' class='form-control select-field-left-border input-no-radius'name='acctNumber' id='acctNumber' placeholder='A/C Number'/></span><span class='input-group-btn select-inline'><input type='number' class='form-control select-field-left-border input-right-radius' name='amountValue' id='amountValue' placeholder='Amount'/></span></div></div></div><div class='col-md-1 col-sm-1 col-xs-12'><div class='col-md-1 col-sm-1 col-xs-12'><center><button type='button' class='btn btn-danger subEventsBtn'onclick='pageInvestment.deleteSubDiv(this,1)'><i class='fa fa-minus fa-lg'></i></button></center></div></div></div></div>";
                    $(".investment-details-body").append(newDiv);
                    pageInvestment.mediclaimFamily ++;
                }
                break;
        }
    },
    deleteSubDiv: function(selected,type){
        switch (type)
        {
            case 1:
                $(selected).closest('.removeDiv').remove();
                pageInvestment.mediclaimFamily--;
                break;
        }
    }
};

$(document).ready(function () {
    app.websiteRoot = "../";
    app.getLoginDetails();

    document.getElementById("imgInput").onchange = function () {
        var path = this.value;
        var filename = path.replace(/^.*\\/, "");
        document.getElementById("investmentsImgInputPath").value = filename;
    };

});

/* This is if the value of the investment autocomplete value changes

    switch(type)
    {
        case 1:
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#coverageDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#quantityDiv').addClass('hidden');
            $('#purchaseRateDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 2:
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#coverageDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#quantityDiv').addClass('hidden');
            $('#purchaseRateDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 3:
            $('#coverageDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#quantityDiv').addClass('hidden');
            $('#purchaseRateDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 4:
            $('#coverageDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#quantityDiv').addClass('hidden');
            $('#purchaseRateDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 5:
            $('#durationDiv').addClass('hidden');
            $('#coverageDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#maturityDateDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#quantityDiv').addClass('hidden');
            $('#purchaseRateDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 6:
            $('#durationDiv').addClass('hidden');
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#coverageDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#interestRateDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#maturityDateDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 7:
            $('#durationDiv').addClass('hidden');
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#coverageDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 8:
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#coverageDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#interestRateDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#quantityDiv').addClass('hidden');
            $('#purchaseRateDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            break;
        case 9:
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#coverageDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#interestRateDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#quantityDiv').addClass('hidden');
            $('#purchaseRateDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            break;
        case 10:
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#coverageDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#interestRateDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 11:
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#coverageDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#interestRateDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 12:
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#interestRateDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#quantityDiv').addClass('hidden');
            $('#purchaseRateDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            $('#familyMemberDiv').addClass('hidden');
            break;
        case 13:
            $('#paymentFrequencyDiv').addClass('hidden');
            $('#nextDueDateDiv').addClass('hidden');
            $('#interestRateDiv').addClass('hidden');
            $('#interestFreqDiv').addClass('hidden');
            $('#interestFirstDueDiv').addClass('hidden');
            $('#maturityAmountDiv').addClass('hidden');
            $('#quantityDiv').addClass('hidden');
            $('#purchaseRateDiv').addClass('hidden');
            $('#formHEnclosedDiv').addClass('hidden');
            break;
    }


*/
