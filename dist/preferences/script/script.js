$(document).ready(function () {
    //console.log("Hi");
    $("#change-password").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                showNotificationFailure(response.message);
            }
            else {
                showNotificationSuccess(response.message);
                window.location.href = root;
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });
});