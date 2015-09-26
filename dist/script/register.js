var pageRegister = {};
$(document).ready(function () {
    app.websiteRoot = "";
    $("#signUpForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
            /*if (app.email_count == 1 && app.pwd_count == 1 && app.c_pwd_count == 1 && app.name_count == 1 && app.country_count == 1 && app.mobile_count == 1) {
                $(".cover").fadeIn(100);
                $("#pageLoading").addClass("loader");
                return true;
            }
            else {
                app.validateEmail(".email");
                app.validatePassword(".password");
                app.validateConfirmPassword(".password", ".c_password");
                app.validateName(".name");
                app.validateMobile(".mobile");
                app.validateCountry("#country");
                return false;
            }*/
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                app.showNotificationFailure(response.message);
            }
            else {
                app.showNotificationSuccess(response.message);
                window.location.href = "login.php";
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