$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../../");

    $('#logoPrint').change(function () {
        if ($("#logoPrint").val() == "0") {
            $("#logoDiv").css("display", "block");
        }
        else {
            $("#logoDiv").css("display", "none");
        }
    });
});
