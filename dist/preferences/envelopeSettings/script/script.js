$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../../");

    $('#envelopeFrom').change(function () {
        if ($("#envelopeFrom").val() == "0") {
            $("#fromDiv").css("display", "block");
        }
        else {
            $("#fromDiv").css("display", "none");
        }
    });
    $('#logoPrint').change(function () {
        if ($("#logoPrint").val() == "0") {
            $("#logoDiv").css("display", "block");
        }
        else {
            $("#logoDiv").css("display", "none");
        }
    });
    $('#envelopeTitleSelect').change(function () {
        if ($("#envelopeTitleSelect").val() == "0") {
            $("#envelopeCaptionDiv").css("display", "block");
            $("#envelopeTitle").addClass("col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding");
        }
        else {
            $("#envelopeCaptionDiv").css("display", "none");
            $("#envelopeTitle").removeClass("col-md-6 col-sm-6 col-xs-6 first-col-left-padding first-col-right-padding");
        }
    });
});