$(document).ready(function () {
    localStorage.setItem("websiteRoot", "");

    $("#form-signup").ajaxForm({
        beforeSubmit: function () {
            if (pageIndex.email_count == 1 && pageIndex.pwd_count == 1 && pageIndex.c_pwd_count == 1 && pageIndex.name_count == 1 && pageIndex.country_count == 1 && pageIndex.mobile_count == 1 && pageIndex.dob_count == 1) {
                $(".cover").fadeIn(100);
                $("#pageLoading").addClass("loader");
                return true;
            }
            else {
                pageIndex.validateEmail(".email");
                pageIndex.validatePassword(".password");
                pageIndex.validateConfirmPassword(".password", ".c_password");
                pageIndex.validateName(".name");
                pageIndex.validateMobile(".mobile");
                pageIndex.validateCountry("#country");
                pageIndex.validateDate(".date");
                return false;
            }

        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                pageIndex.showNotificationFailure(response.message);
            }
            else {
                pageIndex.showNotificationSuccess(response.message);
                window.location.href = "login.php";
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
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
                pageIndex.showNotificationFailure(response.message);
            }
            else {
                if (response.status == 1) {
                    pageIndex.showNotificationSuccess(response.message);
                    window.location.href = localStorage.getItem("websiteRoot") + "preferences/changePassword.php";
                }
                else {
                    pageIndex.showNotificationSuccess(response.message);
                    window.location.href = localStorage.getItem("websiteRoot") + "index.php";
                }
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });
});