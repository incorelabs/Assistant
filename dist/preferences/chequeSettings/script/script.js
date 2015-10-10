var pageChequeSettings = {
    chequeSettingList: null,
    chequeDetails: null,
    getChequeList: function () {
        var url = app.websiteRoot + "preferences/chequeSettings/getChequeList.php";

        $.getJSON(url).done(function (data) {
            console.log(data);
            pageChequeSettings.setChequeList(data);
        }).fail(function (error) {

        });
    },
    setChequeList: function (data) {
        pageChequeSettings.chequeSettingList = data;
        var chequeSettingsTableString = "";
        for (var i = 0; i < data.length; i++) {
            chequeSettingsTableString += "<tr>";

            chequeSettingsTableString += "<td class='text-middle col-md-1 col-sm-1 col-xs-1''>" + (i + 1) + "</td>";

            chequeSettingsTableString += "<td class='text-middle col-md-3 col-sm-3 col-xs-3''>" + ((data[i]['ChequeName']) ? data[i]['ChequeName'] : "-") + "</td>";

            chequeSettingsTableString += "<td class='text-middle col-md-2 hidden-sm hidden-xs'>" + ((data[i]['ForAcName']) ? data[i]['ForAcName'] : "-") + "</td>";

            chequeSettingsTableString += "<td class='text-middle col-md-2 hidden-sm hidden-xs'>" + ((data[i]['ContinousFeed'] == 1) ? "Yes" : "No") + "</td>";

            var chequeFeedDirection = "";

            switch (data[i]['ChequeFeed']) {
                case "1":
                    chequeFeedDirection = "Left";
                    break;
                case "2":
                    chequeFeedDirection = "Middle";
                    break;
                case "3":
                    chequeFeedDirection = "Right";
                    break;
            }

            chequeSettingsTableString += "<td class='text-middle col-md-2 col-sm-3 col-xs-3'>" + chequeFeedDirection + "</td>";

            chequeSettingsTableString += "<td class='text-middle col-md-2 col-sm-3 col-xs-3'><a href='#' onclick='pageChequeSettings.openEditChequeSettingsModal(" + i + ")'><i class='fa fa-pencil fa-lg fa-green'></i></a>";

            chequeSettingsTableString += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='pageChequeSettings.openDeleteChequeSettingsModal(" + data[i].ChequeCode + ")'><i class='fa fa-trash-o fa-lg fa-red'></i></a></td>";

            chequeSettingsTableString += "</tr>";
        }
        $("#table-body").html(chequeSettingsTableString);
    },
    resetRequiredFields: function () {
        $("#bearerTop").removeAttr("required");
        $("#bearerLeft").removeAttr("required");
        $("#bearerWidth").removeAttr("required");

        $("#acPayeeTop").removeAttr("required");
        $("#acPayeeLeft").removeAttr("required");

        $("#notExceedTop").removeAttr("required");
        $("#notExceedLeft").removeAttr("required");

        $("#forAcName").removeAttr("required");
        $("#forAcNameTop").removeAttr("required");
        $("#forAcNameLeft").removeAttr("required");

        $("#signatoryName").removeAttr("required");
        $("#signatoryNameTop").removeAttr("required");
        $("#signatoryNameLeft").removeAttr("required");
    },
    openAddChequeSettingsModal: function () {
        document.getElementById("chequeSettingsForm").reset();

        $("#form-add-edit-mode").val('A');
        $("#form-add-edit-code").val(1);

        $('#chequeSettingsModalHeading').empty().html("Add Cheque Settings");

        pageChequeSettings.resetRequiredFields();

        $("#chequeSettingsModal").modal('show');
    },
    openEditChequeSettingsModal: function (chequeSettingsIndex) {
        pageChequeSettings.chequeDetails = pageChequeSettings.chequeSettingList[chequeSettingsIndex];

        document.getElementById("chequeSettingsForm").reset();
        $("#form-add-edit-mode").val('M');

        $('#chequeSettingsModalHeading').empty().html("Edit Cheque Settings");

        pageChequeSettings.setInputFields(pageChequeSettings.chequeDetails);
        $("#form-add-edit-code").val(pageChequeSettings.chequeDetails["ChequeCode"]);

        pageChequeSettings.resetRequiredFields();

        $("#chequeSettingsModal").modal('show');
    },
    openDeleteChequeSettingsModal: function (chequeCode) {
        console.log(chequeCode);
        $("#form-delete-code").val(chequeCode);
        $("#deleteModal").modal('show');
    },
    setInputFields: function (chequeDetails) {
        console.log(chequeDetails);
        if (chequeDetails["ChequeName"]) {
            $("#chequeName").val(chequeDetails["ChequeName"]);
        }

        if (chequeDetails["DateTop"]) {
            $("#dateTop").val(chequeDetails["DateTop"]);
        }

        if (chequeDetails["DateLeft"]) {
            $("#dateLeft").val(chequeDetails["DateLeft"]);
        }

        if (chequeDetails["NameTop"]) {
            $("#nameTop").val(chequeDetails["NameTop"]);
        }

        if (chequeDetails["NameLeft"]) {
            $("#nameLeft").val(chequeDetails["NameLeft"]);
        }

        if (chequeDetails["NameWidth"]) {
            $("#nameWidth").val(chequeDetails["NameWidth"]);
        }

        if (chequeDetails["BearerTop"]) {
            $("#bearerTop").val(chequeDetails["BearerTop"]);
        }

        if (chequeDetails["BearerLeft"]) {
            $("#bearerLeft").val(chequeDetails["BearerLeft"]);
        }

        if (chequeDetails["BearerWidth"]) {
            $("#bearerWidth").val(chequeDetails["BearerWidth"]);
        }

        if (chequeDetails["Rupee1Top"]) {
            $("#rupee1Top").val(chequeDetails["Rupee1Top"]);
        }

        if (chequeDetails["Rupee1Left"]) {
            $("#rupee1Left").val(chequeDetails["Rupee1Left"]);
        }

        if (chequeDetails["Rupee1Width"]) {
            $("#rupee1Width").val(chequeDetails["Rupee1Width"]);
        }

        if (chequeDetails["Rupee2Top"]) {
            $("#rupee2Top").val(chequeDetails["Rupee2Top"]);
        }

        if (chequeDetails["Rupee2Left"]) {
            $("#rupee2Left").val(chequeDetails["Rupee2Left"]);
        }

        if (chequeDetails["Rupee2Width"]) {
            $("#rupee2Width").val(chequeDetails["Rupee2Width"]);
        }

        if (chequeDetails["RsTop"]) {
            $("#rsTop").val(chequeDetails["RsTop"]);
        }

        if (chequeDetails["RsLeft"]) {
            $("#rsLeft").val(chequeDetails["RsLeft"]);
        }

        if (chequeDetails["AcPayeeTop"]) {
            $("#acPayeeTop").val(chequeDetails["AcPayeeTop"]);
        }

        if (chequeDetails["AcPayeeLeft"]) {
            $("#acPayeeLeft").val(chequeDetails["AcPayeeLeft"]);
        }

        if (chequeDetails["NotExceedTop"]) {
            $("#notExceedTop").val(chequeDetails["NotExceedTop"]);
        }

        if (chequeDetails["NotExceedLeft"]) {
            $("#notExceedLeft").val(chequeDetails["NotExceedLeft"]);
        }

        if (chequeDetails["ForAcName"]) {
            $("#forAcName").val(chequeDetails["ForAcName"]);
        }

        if (chequeDetails["ForAcNameTop"]) {
            $("#forAcNameTop").val(chequeDetails["ForAcNameTop"]);
        }

        if (chequeDetails["ForAcNameLeft"]) {
            $("#forAcNameLeft").val(chequeDetails["ForAcNameLeft"]);
        }

        if (chequeDetails["SignatoryName"]) {
            $("#signatoryName").val(chequeDetails["SignatoryName"]);
        }

        if (chequeDetails["SignatoryNameTop"]) {
            $("#signatoryNameTop").val(chequeDetails["SignatoryNameTop"]);
        }

        if (chequeDetails["SignatoryNameLeft"]) {
            $("#signatoryNameLeft").val(chequeDetails["SignatoryNameLeft"]);
        }

        if (chequeDetails["DateSplit"]) {
            $("#dateSplit").val(chequeDetails["DateSplit"]);
        }

        if (chequeDetails["ChequeFeed"]) {
            $("#chequeFeed").val(chequeDetails["ChequeFeed"]);
        }

        if (chequeDetails["ContinousFeed"]) {
            $("#continousFeed").val(chequeDetails["ContinousFeed"]);
        }
    }
};

$(document).ready(function () {
    app.websiteRoot = "../../";
    app.getLoginDetails();

    console.log(window.innerWidth);
    if (window.innerWidth < 500) {
        $(':input').removeAttr('placeholder');
    }

    pageChequeSettings.getChequeList();

    $("#chequeSettingsForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    app.showNotificationFailure("Required fields are empty");
                    return false;
                }
            }
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                app.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageChequeSettings.getChequeList();
                }, 200);
                $("#chequeSettingsModal").modal('hide');
            } else {
                app.showNotificationFailure(response.message);
                $("#chequeSettingsModal").modal('show');
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $("#deleteChequeSettingsForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                app.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageChequeSettings.getChequeList();
                }, 200);
            } else {
                app.showNotificationFailure(response.message);
            }
            $("#deleteModal").modal('hide');
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $("#bearerTop, #bearerLeft, #bearerWidth").focusin(function () {
        $("#bearerTop").attr("required", "");
        $("#bearerLeft").attr("required", "");
        $("#bearerWidth").attr("required", "");
    }).focusout(function () {
        if ($("#bearerTop").val().trim() == "" && $("#bearerLeft").val().trim() == "" && $("#bearerWidth").val().trim() == "") {
            $("#bearerTop").removeAttr("required");
            $("#bearerLeft").removeAttr("required");
            $("#bearerWidth").removeAttr("required");
        }
    });


    $("#acPayeeTop, #acPayeeLeft").focusin(function () {
        $("#acPayeeTop").attr("required", "");
        $("#acPayeeLeft").attr("required", "");
    }).focusout(function () {
        if ($("#acPayeeTop").val().trim() == "" && $("#acPayeeLeft").val().trim() == "") {
            $("#acPayeeTop").removeAttr("required");
            $("#acPayeeLeft").removeAttr("required");
        }
    });


    $("#notExceedTop, #notExceedLeft").focusin(function () {
        $("#notExceedTop").attr("required", "");
        $("#notExceedLeft").attr("required", "");
    }).focusout(function () {
        if ($("#notExceedTop").val().trim() == "" && $("#notExceedLeft").val().trim() == "") {
            $("#notExceedTop").removeAttr("required");
            $("#notExceedLeft").removeAttr("required");
        }
    });


    $("#forAcName, #forAcNameTop, #forAcNameLeft").focusin(function () {
        $("#forAcName").attr("required", "");
        $("#forAcNameTop").attr("required", "");
        $("#forAcNameLeft").attr("required", "");
    }).focusout(function () {
        if ($("#forAcName").val().trim() == "" && $("#forAcNameTop").val().trim() == "" && $("#forAcNameLeft").val().trim() == "") {
            $("#forAcName").removeAttr("required");
            $("#forAcNameTop").removeAttr("required");
            $("#forAcNameLeft").removeAttr("required");
        }
    });


    $("#signatoryName, #signatoryNameTop, #signatoryNameLeft").focusin(function () {
        $("#signatoryName").attr("required", "");
        $("#signatoryNameTop").attr("required", "");
        $("#signatoryNameLeft").attr("required", "");
    }).focusout(function () {
        if ($("#signatoryName").val().trim() == "" && $("#signatoryNameTop").val().trim() == "" && $("#signatoryNameLeft").val().trim() == "") {
            $("#signatoryName").removeAttr("required");
            $("#signatoryNameTop").removeAttr("required");
            $("#signatoryNameLeft").removeAttr("required");
        }
    });

});