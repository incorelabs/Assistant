var pageForgotPassword = {
    enableToggle: function (current, other) {
        other.disabled = current.value.replace(/\s+/, '').length > 0 ? true : false;
    }
};
$(document).ready(function () {
    app.websiteRoot = "../";

    $("#forgotPasswordForm").ajaxForm({
        beforeSubmit: function (formData) {
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    app.showNotificationFailure("Required fields are empty");
                    return false;
                }
                if(formData[i].name === "email") {
                    formData[i].value = formData[i].value.toLowerCase();
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
                window.location.href = app.websiteRoot + "login.php";
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    var forgotEmail = document.getElementById('forgotEmail');
    var forgotMobile = document.getElementById('forgotMobile');

    forgotEmail.onkeyup = function () {
        pageForgotPassword.enableToggle(this, forgotMobile);
    };

    forgotMobile.onkeyup = function () {
        pageForgotPassword.enableToggle(this, forgotEmail);
    };
});