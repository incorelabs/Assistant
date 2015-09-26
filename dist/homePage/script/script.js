$(document).ready(function () {
    localStorage.setItem("websiteRoot", "");

    $('#navbarProfilePicture').attr("src",localStorage.getItem("websiteRoot")+"img/default/contact/profilePicture.png");
    $('#accountProfileImagePreview').attr("src",localStorage.getItem("websiteRoot")+"img/default/contact/profilePicture.png");

    $("#signUpForm").ajaxForm({
        beforeSubmit: function () {
            if (pageIndex.email_count == 1 && pageIndex.pwd_count == 1 && pageIndex.c_pwd_count == 1 && pageIndex.name_count == 1 && pageIndex.country_count == 1 && pageIndex.mobile_count == 1) {
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
                return false;
            }

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
        }
    });

    $("#loginForm").ajaxForm({
        beforeSubmit: function () {
            console.log("Test");
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
                    window.location.href = localStorage.getItem("websiteRoot") + "preferences/changePassword.php";
                }
                else {
                    app.showNotificationSuccess(response.message);
                    window.location.href = localStorage.getItem("websiteRoot") + "index.php";
                }
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });
});