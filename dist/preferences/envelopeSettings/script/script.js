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
        $("#envelopeSettingsModal").modal('show');
    },
    openEditEnvelopeSettingsModal: function (envelopeSettingsIndex) {
        pageEnvelopeSettings.envelopeDetails = pageEnvelopeSettings.envelopeSettingList[envelopeSettingsIndex];
        $("#envelopeSettingsModal").modal('show');
    },
    openDeleteEnvelopeSettingsModal: function () {
        $("#deleteModal").modal('show');
    },
    setInputFields: function () {

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
    $('#envelopeTitleSelect').change(function () {
        if ($("#envelopeTitleSelect").val() == "1") {
            $("#envelopeCaptionDiv").css("display", "block");
            $("#envelopeTitle").addClass("col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding");
        }
        else {
            $("#envelopeCaptionDiv").css("display", "none");
            $("#envelopeTitle").removeClass("col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding");
        }
    });
});