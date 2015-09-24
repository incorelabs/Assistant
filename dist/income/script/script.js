var pageIncome = {
    currentPageNo: 1,
    localIncome: null,
    defIncomeList: $.Deferred(),
    defSearchResult: $.Deferred(),
    familyList: null,
    incomeList: null,
    firstTime: true,
    getFamilyList: function () {
        var url = localStorage.getItem("websiteRoot") + "family/getFamily.php";

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
        var url = localStorage.getItem("websiteRoot") + "income/getIncomeList.php";

        $.getJSON(url, {
            pageNo: pageIncome.currentPageNo
        }).done(function (data) {
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
                incomeListString += "<a onclick='pageIncome.getIncomeDetails(" + data.result[i].IncomeCode + ")' class='list-group-item contacts_font'>" + data.result[i].IncomeName + "</a>";
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
        var url = localStorage.getItem("websiteRoot") + "income/getIncomeList.php";

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
                searchResultsString += "<a onclick='pageIncome.getIncomeDetails(" + data.result[i].IncomeCode + ")' class='list-group-item contacts_font'>" + data.result[i].IncomeName + "</a>";
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
        }
    },
    getIncomeDetails: function (incomeCode) {
        if (incomeCode == null)
            return;
        var url = localStorage.getItem("websiteRoot") + "income/getIncomeDetail.php";

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

            var incomeHeaderString = "<h12>Income Details</h12><button id='editIncomeBtn' class='btn btn-success pull-right btn-header-margin-left' onclick='pageIncome.openEditIncomeModal();'><span class='glyphicon glyphicon-pencil'></span></button><button id='deleteIncomeBtn' class='btn btn-danger pull-left' onclick='pageIncome.openDeleteIncomeModal(" + data.detail.income.IncomeCode + ")'><span class='glyphicon glyphicon-trash'></span></button><button id='voucherIncomeBtn' class='btn btn-info pull-right' onclick='pageIncome.openVoucherIncomeModal()'><span class='fa fa-sticky-note-o fa-lg'></span></button>";
            var incomeDetailString = "";
            if (window.innerWidth < 992 && !pageIncome.firstTime) {
                //Show the Income Details Header and hides the search header
                $("#searchIncomeHeader").addClass('hidden');
                $("#incomeDetailHeader").removeClass('hidden-xs hidden-sm');

                //Show the Income Details and hides the income list
                $("#incomeListDiv").addClass('hidden');
                $("#incomeDetailDiv").removeClass('hidden-xs hidden-sm');

                //Show Hide of menu button with back button
                $(".menu_img").addClass('hidden');
                $("#backButton").removeClass('hidden');

                $("#backButton").click(function () {
                    //Show the Income Details Header and hides the search header
                    $("#incomeDetailHeader").addClass('hidden-xs hidden-sm');
                    $("#searchIncomeHeader").removeClass('hidden');

                    //Show the Income Details and hides the income list
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

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Due To</div><value><div class='col-md-9'>" + ((data.detail.income.FullName) ? data.detail.income.FullName : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Joint Holder Name</div><value><div class='col-md-9'>" + ((data.detail.income.JointHolder) ? data.detail.income.JointHolder : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>" + ((data.detail.income.IncomeRemarks) ? data.detail.income.IncomeRemarks : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Billing Day</div><value><div class='col-md-9'>" + ((data.detail.income.BillingDay) ? data.detail.income.BillingDay : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Due Day</div><value><div class='col-md-9'>" + ((data.detail.income.DueDay) ? data.detail.income.DueDay : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Payment Frequency</div><value><div class='col-md-9'>" + ((data.detail.income.IncomeFrequency) ? data.detail.income.IncomeFrequency : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Loan Due Date</div><value><div class='col-md-9'>" + ((data.detail.income.ExpiryDate) ? data.detail.income.ExpiryDate : "") + "</div></value></div></div>";

            incomeDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Payment URL</div><value><div class='col-md-9'>" + ((data.detail.income.PayWebsite) ? data.detail.income.PayWebsite : "") + "</div></value></div></div>";

            $("#incomeDetailHeader").html(incomeHeaderString);
            $("#incomeDetailBody").html(incomeDetailString);

        } else {
            pageIncome.localIncome = null;
        }
    },
    openAddIncomeModal: function(){
        document.getElementById("incomeForm").reset();
        $('#privateFlag').attr('checked', false);
        $('#activeFlag').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#incomeModalHeading').empty().html("Add Income");
        $('#incomeModal').modal('show');
    },
    openEditIncomeModal: function(){
        document.getElementById("incomeForm").reset();
        $("#form-add-edit-mode").val("M");

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
    openVoucherIncomeModal: function (){
        window.location.href = "../income/voucher/";
    }
};

$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../");

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
