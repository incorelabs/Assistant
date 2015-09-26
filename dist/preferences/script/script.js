$(document).ready(function () {
    app.websiteRoot = "../";
    app.setAccountProfilePicture();

    $("#changePasswordForm").ajaxForm({
        beforeSubmit: function (formData) {
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
            if (response.status == 0) {
                app.showNotificationFailure(response.message);
            }
            else {
                app.showNotificationSuccess(response.message);
                window.location.href = app.websiteRoot;
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });
});