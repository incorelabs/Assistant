var pageEnvelopeSettings = {
    envelopeSettingList: null,
    envelopeDetails: null,
    getEnvelopeList: function () {
        var url = localStorage.getItem("websiteRoot") + "preferences/envelopeSettings/getEnvelopeList.php";

        $.getJSON(url).done(function (data) {
            console.log(data);
            pageEnvelopeSettings.setEnvelopeList(data);
        }).fail(function (error) {

        });
    },
    setEnvelopeList: function (data) {
        pageEnvelopeSettings.envelopeSettingList = data;
        var envelopeSettingsTableString = "";
        for (var i = 0; i < data.length; i++) {
            envelopeSettingsTableString += "<tr class='text-left'>";

            envelopeSettingsTableString += "<td class='text-center col-md-1 col-sm-1 col-xs-1'>" + (i + 1) + "</td>";

            envelopeSettingsTableString += "<td class='text-center col-md-1 col-sm-1 col-xs-1'>" + ((data[i]['CoverName']) ? data[i]['CoverName'] : "-") + "</td>";

            envelopeSettingsTableString += "<td class='text-center col-md-1 col-sm-1 hidden-xs'>" + ((data[i]['FromRequired'] == 1) ? "Yes" : "No") + "</td>";

            envelopeSettingsTableString += "<td class='text-center col-md-1 col-sm-1 hidden-xs'>" + ((data[i]['Caption']) ? data[i]['Caption'] : "-") + "</td>";

            var coverFeedDirection = "";

            switch (data[i]['CoverFeed']) {
                case "1":
                    coverFeedDirection = "Left";
                    break;
                case "2":
                    coverFeedDirection = "Center";
                    break;
                case "3":
                    coverFeedDirection = "Right";
                    break;
            }
            envelopeSettingsTableString += "<td class='text-center col-md-1 col-sm-1 col-xs-1'>" + coverFeedDirection + "</td>";

            envelopeSettingsTableString += "<td class='text-center col-md-1 col-sm-1 col-xs-1'>" + ((data[i]['LogoAvailable'] == 1) ? "Yes" : "No") + "</td>";

            envelopeSettingsTableString += "<td class='text-center col-md-1 col-sm-1 col-xs-1'><a href='#' onclick='pageEnvelopeSettings.openEditEnvelopeSettingsModal(" + i + ")'><i class='fa fa-pencil fa-lg fa-green'></i></a>";

            envelopeSettingsTableString += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='pageEnvelopeSettings.openDeleteEnvelopeSettingsModal(" + data[i].CoverCode + ")'><i class='fa fa-trash-o fa-lg fa-red'></i></a></td>";

            envelopeSettingsTableString += "</tr>";
        }
        $("#table-body").html(envelopeSettingsTableString);
    },
    openAddEnvelopeSettingsModal: function () {
        document.getElementById("envelopeSettingsForm").reset();

        $("#form-add-edit-mode").val('A');
        $("#form-add-edit-code").val(1);

        $('#envelopeSettingsModalHeading').empty().html("Add Envelope Settings");

        $("#fromDiv").addClass("hidden");

        $("#fromTop").removeAttr("required");
        $("#fromLeft").removeAttr("required");
        $("#fromName").removeAttr("required");

        $("#logoDiv").addClass("hidden");

        $("#logoTop").removeAttr("required");
        $("#logoLeft").removeAttr("required");
        $("#logoHeight").removeAttr("required");
        $("#logoWidth").removeAttr("required");

        $("#envelopeSettingsModal").modal('show');
    },
    openEditEnvelopeSettingsModal: function (envelopeSettingsIndex) {
        pageEnvelopeSettings.envelopeDetails = pageEnvelopeSettings.envelopeSettingList[envelopeSettingsIndex];

        document.getElementById("envelopeSettingsForm").reset();
        $("#form-add-edit-mode").val('M');

        $('#envelopeSettingsModalHeading').empty().html("Edit Envelope Settings");

        pageEnvelopeSettings.setInputFields(pageEnvelopeSettings.envelopeDetails);
        $("#form-add-edit-code").val(pageEnvelopeSettings.envelopeDetails["CoverCode"]);

        $("#envelopeSettingsModal").modal('show');
    },
    openDeleteEnvelopeSettingsModal: function (coverCode) {
        console.log(coverCode);
        $("#form-delete-code").val(coverCode);
        $("#deleteModal").modal('show');
    },
    setInputFields: function (envelopeDetails) {
        console.log(envelopeDetails);
        if (envelopeDetails["CoverName"]) {
            $("#coverName").val(envelopeDetails["CoverName"]);
        }

        if (envelopeDetails["FromRequired"] && envelopeDetails["FromRequired"] == "1") {

            $("#fromRequired").val(envelopeDetails["FromRequired"]);

            $("#fromDiv").removeClass("hidden");

            $("#fromTop").attr("required", "");
            $("#fromLeft").attr("required", "");
            $("#fromName").attr("required", "");
        } else {
            $("#fromDiv").addClass("hidden");

            $("#fromTop").removeAttr("required");
            $("#fromLeft").removeAttr("required");
            $("#fromName").removeAttr("required");
        }

        if (envelopeDetails["FromTop"]) {
            $("#fromTop").val(envelopeDetails["FromTop"]);
        }

        if (envelopeDetails["FromLeft"]) {
            $("#fromLeft").val(envelopeDetails["FromLeft"]);
        }

        if (envelopeDetails["FromName"]) {
            $("#fromName").val(envelopeDetails["FromName"]);
        }

        if (envelopeDetails["FromAdd1"]) {
            $("#fromAdd1").val(envelopeDetails["FromAdd1"]);
        }

        if (envelopeDetails["FromAdd2"]) {
            $("#fromAdd2").val(envelopeDetails["FromAdd2"]);
        }

        if (envelopeDetails["FromAdd3"]) {
            $("#fromAdd3").val(envelopeDetails["FromAdd3"]);
        }

        if (envelopeDetails["FromAdd4"]) {
            $("#fromAdd4").val(envelopeDetails["FromAdd4"]);
        }

        if (envelopeDetails["ToTop"]) {
            $("#toTop").val(envelopeDetails["ToTop"]);
        }

        if (envelopeDetails["ToLeft"]) {
            $("#toLeft").val(envelopeDetails["ToLeft"]);
        }

        if (envelopeDetails["Caption"]) {
            $("#caption").val(envelopeDetails["Caption"]);
        }

        if (envelopeDetails["LogoAvailable"] && envelopeDetails["LogoAvailable"] == "1") {

            $("#logoAvailable").val(envelopeDetails["LogoAvailable"]);

            $("#logoDiv").removeClass("hidden");

            $("#logoTop").attr("required", "");
            $("#logoLeft").attr("required", "");
            $("#logoHeight").attr("required", "");
            $("#logoWidth").attr("required", "");
        } else {
            $("#logoDiv").addClass("hidden");

            $("#logoTop").removeAttr("required");
            $("#logoLeft").removeAttr("required");
            $("#logoHeight").removeAttr("required");
            $("#logoWidth").removeAttr("required");
        }

        if (envelopeDetails["LogoTop"]) {
            $("#logoTop").val(envelopeDetails["LogoTop"]);
        }

        if (envelopeDetails["LogoLeft"]) {
            $("#logoLeft").val(envelopeDetails["LogoLeft"]);
        }

        if (envelopeDetails["LogoHeight"]) {
            $("#logoHeight").val(envelopeDetails["LogoHeight"]);
        }

        if (envelopeDetails["LogoWidth"]) {
            $("#logoWidth").val(envelopeDetails["LogoWidth"]);
        }

        if (envelopeDetails["CoverFeed"]) {
            $("#coverFeed").val(envelopeDetails["CoverFeed"]);
        }
    }
};
$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../../");

    pageEnvelopeSettings.getEnvelopeList();

    $('#fromRequired').change(function () {
        if ($("#fromRequired").val() == "1") {
            $("#fromDiv").removeClass("hidden");

            $("#fromTop").attr("required", "");
            $("#fromLeft").attr("required", "");
            $("#fromName").attr("required", "");
        }
        else {
            $("#fromDiv").addClass("hidden");

            $("#fromTop").removeAttr("required");
            $("#fromLeft").removeAttr("required");
            $("#fromName").removeAttr("required");
        }
    });

    $('#logoAvailable').change(function () {
        if ($("#logoAvailable").val() == "1") {
            $("#logoDiv").removeClass("hidden");

            $("#logoTop").attr("required", "");
            $("#logoLeft").attr("required", "");
            $("#logoHeight").attr("required", "");
            $("#logoWidth").attr("required", "");
        }
        else {
            $("#logoDiv").addClass("hidden");

            $("#logoTop").removeAttr("required");
            $("#logoLeft").removeAttr("required");
            $("#logoHeight").removeAttr("required");
            $("#logoWidth").removeAttr("required");
        }
    });

    $("#envelopeSettingsForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    pageIndex.showNotificationFailure("Required fields are empty");
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
                pageIndex.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageEnvelopeSettings.getEnvelopeList();
                }, 200);
                $("#envelopeSettingsModal").modal('hide');
            } else {
                pageIndex.showNotificationFailure(response.message);
                $("#envelopeSettingsModal").modal('show');
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            pageIndex.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $("#deleteEnvelopeSettingsForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                pageIndex.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageEnvelopeSettings.getEnvelopeList();
                }, 200);
            } else {
                pageIndex.showNotificationFailure(response.message);
            }
            $("#deleteModal").modal('hide');
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            pageIndex.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });
});