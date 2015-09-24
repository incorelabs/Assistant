$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../");

    $('#navbarProfilePicture').attr("src",localStorage.getItem("websiteRoot")+"img/default/contact/profilePicture.png");
    $('#accountProfileImagePreview').attr("src",localStorage.getItem("websiteRoot")+"img/default/contact/profilePicture.png");

    $("#forgotPasswordForm").ajaxForm({
        beforeSubmit: function () {
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
                pageIndex.showNotificationSuccess(response.message);
                window.location.href = localStorage.getItem("websiteRoot") + "login.php";
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });
});