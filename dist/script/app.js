var app = {
    websiteRoot: "",
    logout: function () {
        var url = app.websiteRoot + "api/logout.php";

        $.getJSON(url).done(function (data) {
            console.log(data);
            if (data.status == 1) {
                window.location.href = app.websiteRoot;
            } else {
                app.showNotificationFailure("Logout unsuccessful. Please try again");
            }
        }).fail(function (error) {

        });
    },
    setAccountProfilePicture: function () {
        console.log(app.websiteRoot);
        $('#navbarProfilePicture').attr("src", app.websiteRoot + "img/default/contact/profilePicture.png");
        $('#accountProfileImagePreview').attr("src", app.websiteRoot + "img/default/contact/profilePicture.png");
    },
    openAccountProfilePictureModal: function(){
        $("#accountProfilePictureModal").modal("show");
    },
    showNotificationSuccess: function (successMessage) {
        $("#notification_success").html(successMessage);
        document.getElementById('notification_success').style.display = "block";
        $("#notification_success").delay(2000).fadeOut("slow");
    },
    showNotificationFailure: function (failureMessage) {
        $("#notification_failure").html(failureMessage);
        document.getElementById('notification_failure').style.display = "block";
        $("#notification_failure").delay(2000).fadeOut("slow");
    }
};
$(document).ready(function () {
    $('nav#menu').mmenu({
        extensions	: ['effect-slide-menu', 'pageshadow'],
        searchfield	: true
    });
});