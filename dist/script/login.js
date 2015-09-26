var pageLogin = {};
$(document).ready(function () {
    app.websiteRoot = "";
    $("#loginForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                app.showNotificationFailure(response.message);
            }
            else {
                if (response.status == 1) {
                    app.showNotificationSuccess(response.message);
                    window.location.href = app.websiteRoot + "preferences/changePassword.php";
                }
                else {
                    app.showNotificationSuccess(response.message);
                    window.location.href = app.websiteRoot + "index.php";
                }
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
});