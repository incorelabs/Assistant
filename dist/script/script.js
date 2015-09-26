//var root = "http://43.225.52.206/~chetansanghvi/";
//var root = "http://localhost/Assistant/";
var pageIndex = {
    errorStatus: [false, false, false, false, false, false, false],
    email_count: 0,
    pwd_count: 0,
    c_pwd_count: 0,
    name_count: 0,
    country_count: 0,
    mobile_count: 0,
    dob_count: 0,
    validateEmail: function (element) {
        var email = $(element).val();
        var formGroup = $(element).closest(".form-group");
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if (email.length == "" || email.length == 0) {
            formGroup.removeClass("has-success");
            formGroup.addClass("has-error");
            pageIndex.email_count = 0;
            pageIndex.errorStatus[0] = false;
            $(element).closest('.form-group').find('.info').html("Please Enter an Email Address");
        }
        else {
            if (re.test(email)) {
                formGroup.addClass("has-success");
                formGroup.removeClass("has-error");
                $(element).closest('.form-group').find('.info').empty();
                pageIndex.email_count = 1;
                pageIndex.errorStatus[0] = true;
            }
            else {
                formGroup.removeClass("has-success");
                formGroup.addClass("has-error");
                pageIndex.email_count = 0;
                pageIndex.errorStatus[0] = false;
                $(element).closest('.form-group').find('.info').html("Please Enter a Valid Email Address");
            }
        }
    },
    validatePassword: function (element) {
        var password = $(element).val();
        var formGroup = $(element).closest(".form-group");
        var letter = /[a-zA-Z]/;
        var number = /[0-9]/;
        if (password.length == 0) {
            formGroup.removeClass("has-success");
            formGroup.addClass("has-error");
            $(element).closest('.form-group').find('.info').html("Please Enter a Password");
            pageIndex.pwd_count = 0
            pageIndex.errorStatus[1] = false;
        }
        else {
            if (password.length < 8 || password.length > 16) {
                formGroup.removeClass("has-success");
                formGroup.addClass("has-error");
                $(element).closest('.form-group').find('.info').html("Password should between 8 to 16 characters");
                pageIndex.pwd_count = 0;
                pageIndex.errorStatus[1] = false;
            }
            else {
                if (number.test(password) && letter.test(password)) {
                    formGroup.addClass("has-success");
                    formGroup.removeClass("has-error");
                    $(element).closest('.form-group').find('.info').empty();
                    pageIndex.pwd_count = 1;
                    pageIndex.errorStatus[1] = true;
                }
                else {
                    formGroup.removeClass("has-success");
                    formGroup.addClass("has-error");
                    $(element).closest('.form-group').find('.info').html("Password should atleast have 1 alphabet and one number");
                    pageIndex.pwd_count = 0;
                    pageIndex.errorStatus[1] = false;
                }
            }
        }
    },
    validateConfirmPassword: function (p, element) {
        var password = $(p).val();
        var c_password = $(element).val();
        var formGroup = $(element).closest(".form-group");
        if (c_password.length == 0 || c_password.length == "") {
            formGroup.removeClass("has-success");
            formGroup.addClass("has-error");
            $(element).closest('.form-group').find('.info').html("Please Enter Confirm Password");
            pageIndex.c_pwd_count = 0;
            pageIndex.errorStatus[2] = false;
        }
        else {
            if (c_password == password) {
                formGroup.addClass("has-success");
                formGroup.removeClass("has-error");
                $(element).closest('.form-group').find('.info').empty();
                pageIndex.c_pwd_count = 1;
                pageIndex.errorStatus[2] = true;
            }
            else {
                formGroup.removeClass("has-success");
                formGroup.addClass("has-error");
                $(element).closest('.form-group').find('.info').html("Passwords do not match");
                pageIndex.c_pwd_count = 0;
                pageIndex.errorStatus[2] = false;
            }
        }
    },
    validateName: function (element) {
        var name = $(element).val();
        var formGroup = $(element).closest(".form-group");
        if (name.length == 0 || name.length == "") {
            formGroup.removeClass("has-success");
            formGroup.addClass("has-error");
            $(element).closest('.form-group').find('.info').html("Please Enter a Name");
            pageIndex.name_count = 0;
            pageIndex.errorStatus[3] = false;
        }
        else {
            if (name.length < 3 || name.length > 40) {
                formGroup.addClass("has-error");
                formGroup.removeClass("has-success");
                $(element).closest('.form-group').find('.info').html("Please Enter a Valid Name");
                pageIndex.name_count = 0;
                pageIndex.errorStatus[3] = false;
            }
            else {
                if (!name.match(/^[a-zA-Z\s]+$/)) {
                    formGroup.addClass("has-error");
                    formGroup.removeClass("has-success");
                    $(element).closest('.form-group').find('.info').html("Name must consist of alphabets only");
                    pageIndex.name_count = 0;
                    pageIndex.errorStatus[3] = false;
                }
                else {
                    formGroup.removeClass("has-error");
                    formGroup.addClass("has-success");
                    $(element).closest('.form-group').find('.info').empty();
                    pageIndex.name_count = 1;
                    pageIndex.errorStatus[3] = true;
                }
            }
        }
    },
    validateCountry: function (element) {
        var country = $(element).val();
        var formGroup = $(element).closest(".form-group");
        if (country == "") {
            formGroup.removeClass("has-success");
            formGroup.addClass("has-error");
            $(element).closest('.form-group').find('.info').html("Select a Country");
            pageIndex.country_count = 0;
            pageIndex.errorStatus[4] = false;
        }
        else {
            formGroup.removeClass("has-error");
            formGroup.addClass("has-success");
            $(element).closest('.form-group').find('.info').empty();
            pageIndex.country_count = 1;
            pageIndex.errorStatus[4] = true;
        }
    },
    validateMobile: function (element) {
        var mobile = $(element).val();
        var indNum = /^[0]?[56789]\d{9}$/;
        var country = $('#country').val();
        var formGroup = $(element).closest(".form-group");
        if (country == "") {
            formGroup.removeClass("has-success");
            formGroup.addClass("has-error");
            $(element).closest('.form-group').find('.info').html("Please Select a country");
            pageIndex.mobile_count = 0;
            pageIndex.errorStatus[5] = false;
        }
        else {
            if (mobile.length != 10 || isNaN(mobile)) {
                formGroup.removeClass("has-success");
                formGroup.addClass("has-error");
                $(element).closest('.form-group').find('.info').html("Please Enter a Valid Phone Number");
                pageIndex.mobile_count = 0;
                pageIndex.errorStatus[5] = false;
            }
            else {
                if (country == 1046) {
                    if (indNum.test(mobile)) {
                        formGroup.removeClass("has-error");
                        formGroup.addClass("has-success");
                        $(element).closest('.form-group').find('.info').empty();
                        pageIndex.mobile_count = 1;
                        pageIndex.errorStatus[5] = true;
                    }
                    else {
                        formGroup.removeClass("has-success");
                        formGroup.addClass("has-error");
                        $(element).closest('.form-group').find('.info').html("Please Enter a Valid Phone Number");
                        pageIndex.mobile_count = 0;
                        pageIndex.errorStatus[5] = false;
                    }
                }
                else {
                    formGroup.removeClass("has-error");
                    formGroup.addClass("has-success");
                    $(element).closest('.form-group').find('.info').empty();
                    pageIndex.mobile_count = 1;
                    pageIndex.errorStatus[5] = true;
                }
            }
        }
    },
    validateDate: function (element) {
        var formGroup = $(element).closest(".form-group");
        var date = new MyDate($(element).val());
        if (date.isValid()) {
            formGroup.removeClass("has-error");
            formGroup.addClass("has-success");
            $(element).closest('.form-group').find('.info').empty();
            pageIndex.dob_count = 1;
            pageIndex.errorStatus[6] = true;
        }
        else {
            formGroup.removeClass("has-success");
            formGroup.addClass("has-error");
            $(element).closest('.form-group').find('.info').html("Invalid Date. Enter Date in dd/mm/yyyy format");
            pageIndex.dob_count = 0;
            pageIndex.errorStatus[6] = false;
        }
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
    },
    openAccountProfilePictureModal: function(){
        $("#accountProfilePictureModal").modal("show");
    }
};
$(document).ready(function () {

    $(".logout").click(function (event) {
        var url = localStorage.getItem("websiteRoot") + "api/logout.php";

        $.getJSON(url).done(function (data) {
            console.log(data);
            if (data.status == 1) {
                window.location.href = localStorage.getItem("websiteRoot");
            }
            else {
                app.showNotificationFailure("Logout unsuccessful. Please try again");
            }
        }).fail(function (error) {

        });
    });

    $(".email").focusout(function () {
        pageIndex.validateEmail(this);
    });

    $(".email").focusin(function () {
        var formGroup = $(this).closest(".form-group");
        formGroup.removeClass("has-error");
        $(this).closest('.form-group').find('.info').empty();
    });

    $(".password").focusout(function () {
        pageIndex.validatePassword(this);
    });

    $(".password").focusin(function () {
        var formGroup = $(this).closest(".form-group");
        formGroup.removeClass("has-error");
        $(this).closest('.form-group').find('.info').empty();
    });

    $(".c_password").focusout(function () {
        pageIndex.validateConfirmPassword(".password", this);
    });

    $(".c_password").focusin(function () {
        var formGroup = $(this).closest(".form-group");
        formGroup.removeClass("has-error");
        $(this).closest('.form-group').find('.info').empty();
    });

    $(".name").focusout(function () {
        pageIndex.validateName(this);
    });

    $(".name").focusin(function () {
        var formGroup = $(this).closest(".form-group");
        formGroup.removeClass("has-error");
        $(this).closest('.form-group').find('.info').empty();
    });

    $("#country").focusout(function () {
        pageIndex.validateCountry(this);
    });

    $("#country").focusin(function () {
        var formGroup = $(this).closest(".form-group");
        formGroup.removeClass("has-error");
        $(this).closest('.form-group').find('.info').empty();
    });

    $(".mobile").focusout(function () {
        pageIndex.validateMobile(this);
    });

    $(".mobile").focusin(function () {
        var formGroup = $(this).closest(".form-group");
        formGroup.removeClass("has-error");
        $(this).closest('.form-group').find('.info').empty();
    });

    $(".date").focusout(function () {
        pageIndex.validateDate(this);
    });

    $(".date").focusin(function () {
        var formGroup = $(this).closest(".form-group");
        formGroup.removeClass("has-error");
        $(this).closest('.form-group').find('.info').empty();
    });
});