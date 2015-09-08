$(document).ready(function () {
    $("#form-signup").ajaxForm({
        beforeSubmit: function () {

            if (email_count == 1 && pwd_count == 1 && c_pwd_count == 1 && name_count == 1 && country_count == 1 && mobile_count == 1 && dob_count == 1) {
                $(".cover").fadeIn(100);
                $("#pageLoading").addClass("loader");
                return true;
            }
            else {
                validateEmail(".email");
                validatePassword(".password");
                validateConfirmPassword(".password", ".c_password");
                validateName(".name");
                validateMobile(".mobile");
                validateCountry("#country");
                validateDate(".date");
                return false;
            }

        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                showNotificationFailure(response.message);
            }
            else {
                showNotificationSuccess(response.message);
                window.location.href = "login.php";
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
    });

    $("#form-login").ajaxForm({
        beforeSubmit: function () {
            console.log("Test");
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
                if (response.status == 1) {
                    showNotificationSuccess(response.message);
                    window.location.href = root + "preferences/changePassword.php";
                }
                else {
                    showNotificationSuccess(response.message);
                    window.location.href = "index.php";
                }
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
    });
});