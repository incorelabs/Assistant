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

        $('#envelopeSettingsModalHeading').empty();
        $('#envelopeSettingsModalHeading').html("Add Envelope");

        $("#envelopeSettingsModal").modal('show');
    },
    openEditEnvelopeSettingsModal: function (envelopeSettingsIndex) {
        pageEnvelopeSettings.envelopeDetails = pageEnvelopeSettings.envelopeSettingList[envelopeSettingsIndex];

        document.getElementById("envelopeSettingsForm").reset();
        $("#form-add-edit-mode").val('M');

        pageEnvelopeSettings.setInputFields(pageEnvelopeSettings.envelopeDetails);
        $("#form-add-edit-code").val(pageEnvelopeSettings.envelopeDetails["FamilyCode"]);

        $("#envelopeSettingsModal").modal('show');
    },
    openDeleteEnvelopeSettingsModal: function (coverCode) {
        console.log(coverCode);
        $("#form-delete-code").val(coverCode);
        $("#deleteModal").modal('show');
    },
    setInputFields: function (envelopeDetails) {
        console.log(envelopeDetails);
    }
};
$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../../");

    pageEnvelopeSettings.getEnvelopeList();

    $('#envelopeFrom').change(function () {
        if ($("#envelopeFrom").val() == "1") {
            $("#fromDiv").css("display", "block");
        }
        else {
            $("#fromDiv").css("display", "none");
        }
    });

    $('#logoPrint').change(function () {
        if ($("#logoPrint").val() == "1") {
            $("#logoDiv").css("display", "block");
        }
        else {
            $("#logoDiv").css("display", "none");
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
            return false;
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