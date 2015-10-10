var app = {
    websiteRoot: "",
    loginDetails: null,
    dateValidationState: {
        SUCCESS: 0,
        EMPTY: 1,
        INVALID: 2
    },
    validateDate: function (inputDate) {
        if (inputDate === "" || inputDate === "__/__/____")
            return app.dateValidationState.EMPTY;
        if (new MyDate(inputDate).isValid())
            return app.dateValidationState.SUCCESS;
        else
            return app.dateValidationState.INVALID;
    },
    emailValidationState: {
        SUCCESS: 0,
        EMPTY: 1,
        INVALID: 2
    },
    validateEmail: function (inputEmail) {
        var regEx = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if (inputEmail.length == 0)
            return app.emailValidationState.EMPTY;
        if (regEx.test(inputEmail))
            return app.emailValidationState.SUCCESS;
        else
            return app.emailValidationState.INVALID;
    },
    numberValidationState: {
        SUCCESS: 0,
        EMPTY: 1,
        INVALID: 2
    },
    validateNumber: function (inputNumber) {
        var regEx = /^[0-9]*$/g;
        if (inputNumber.length == 0)
            return app.numberValidationState.EMPTY;
        if (regEx.test((inputNumber)))
            return app.numberValidationState.SUCCESS;
        else
            return app.numberValidationState.INVALID;
    },
    passwordValidationState: {
        SUCCESS: 0,
        EMPTY: 1,
        SHORT: 2,
        ATLEAST: 3
    },
    validatePassword: function (inputPassword) {
        var letter = /[a-zA-Z]/;
        var number = /[0-9]/;
        if (inputPassword.length == 0)
            return app.passwordValidationState.EMPTY;
        if (inputPassword.length < 8 || inputPassword.length > 16)
            return app.passwordValidationState.SHORT;
        else {
            if (number.test(inputPassword) && letter.test(inputPassword))
                return app.passwordValidationState.SUCCESS;
            else
                return app.passwordValidationState.ATLEAST;
        }
    },
    confirmPasswordValidationState: {
        SUCCESS: 0,
        MISMATCH: 1,
        INVALID: 2
    },
    validateConfirmPassword: function (originalPassword, confirmPassword) {
        if (app.validatePassword(confirmPassword) === 0) {
            if (confirmPassword === originalPassword)
                return app.confirmPasswordValidationState.SUCCESS;
            else
                return app.confirmPasswordValidationState.MISMATCH;
        } else
            return app.confirmPasswordValidationState.INVALID;
    },
    amountValidationState: {
        SUCCESS: 0,
        EMPTY: 1,
        INVALID: 2
    },
    validateAmount: function (inputAmount) {
        var regEx = /^[0-9]+(\.[0-9]{1,2})?$/;
        if (inputAmount.length == 0)
            return app.amountValidationState.EMPTY;
        if (regEx.test((inputAmount)))
            return app.amountValidationState.SUCCESS;
        else
            return app.amountValidationState.INVALID;
    },
    validate: function (uiElement, typeOfValidation) {
        var valueToValidate = $(uiElement).val().trim();
        var errorString = "";
        var errorCode = null;
        switch (typeOfValidation) {
            case 1:
                errorCode = app.validateDate(valueToValidate);
                switch (errorCode) {
                    case app.dateValidationState.EMPTY:
                        errorString = "Please Enter a Date";
                        break;
                    case app.dateValidationState.INVALID:
                        errorString = "Invalid Date. Enter Date in DD/MM/YYYY format";
                        break;
                }
                break;
            case 2:
                errorCode = app.validateEmail(valueToValidate);
                switch (errorCode) {
                    case app.emailValidationState.EMPTY:
                        errorString = "Please Enter an Email Address";
                        break;
                    case app.emailValidationState.INVALID:
                        errorString = "Please Enter a Valid Email Address";
                        break;
                }
                break;
            case 3:
                errorCode = app.validateNumber(valueToValidate);
                switch (errorCode) {
                    case app.numberValidationState.EMPTY:
                        errorString = "Please Enter a Number";
                        break;
                    case app.numberValidationState.INVALID:
                        errorString = "Please Enter a Valid Number";
                        break;
                }
                break;
            case 4:
                errorCode = app.validatePassword(valueToValidate);
                switch (errorCode) {
                    case app.passwordValidationState.EMPTY:
                        errorString = "Please Enter a Password";
                        break;
                    case app.passwordValidationState.SHORT:
                        errorString = "Password should between 8 to 16 characters";
                        break;
                    case app.passwordValidationState.ATLEAST:
                        errorString = "Password should have at least ONE alphabet and ONE number";
                        break;
                }
                break;
            case 5:
                errorCode = app.validateConfirmPassword($("#password").val().trim(), valueToValidate);
                switch (errorCode) {
                    case app.confirmPasswordValidationState.MISMATCH:
                        errorString = "Passwords do not MATCH";
                        break;
                    case app.confirmPasswordValidationState.INVALID:
                        errorString = "Password does not comply with our policies";
                        break;
                }
                break;
            case 6:
                errorCode = app.validateAmount(valueToValidate);
                switch (errorCode) {
                    case app.amountValidationState.EMPTY:
                        errorString = "Please Enter an Amount";
                        break;
                    case app.amountValidationState.INVALID:
                        errorString = "Please Enter a Valid Amount";
                        break;
                }
                break;
        }
        if (errorCode === 0)
            $(uiElement).closest(".form-group").addClass("has-success").removeClass("has-error").find('.info').empty();
        else
            $(uiElement).closest(".form-group").removeClass("has-success").addClass("has-error").find('.info').html(errorString);
    },
    getLoginDetails: function () {
        var url = app.websiteRoot + "navbar/getLoginDetail.php";

        $.getJSON(url).done(function (data) {
            app.setLoginDetails(data);
        }).fail(function (error) {
            if (error.status === 401) {
                app.loginDetails = null;
            }
        });
    },
    setLoginDetails: function (data) {
        app.loginDetails = data;
        app.setAccountProfilePicture();
    },
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
        if (app.loginDetails.PhotoUploaded)
            $('#navbarProfilePicture').attr("src", app.websiteRoot + "img/getImage.php?file=" + app.loginDetails.ImagePath + "&rand=" + new Date().getTime());
        else
            $('#navbarProfilePicture').attr("src", app.websiteRoot + "img/default/contact/profilePicture.png");
    },
    openAccountProfilePictureModal: function () {
        $("#navbarProgress").addClass("hidden");
        $("#accountProfilePictureModal").modal("show");
    },
    deleteAccountProfilePicture: function () {
        var deleteProfilePicture = confirm("Do you REALLY want to DELETE the Profile Picture?");
        if (deleteProfilePicture) {
            var url = app.websiteRoot + "navbar/profileController.php";

            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");

            $.post(url, {
                mode: "D"
            }).done(function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.status == 1) {
                    app.loginDetails.PhotoUploaded = null;
                    app.getLoginDetails();
                    app.showNotificationSuccess(response.message);
                } else {
                    app.showNotificationFailure(response.message);
                }
                $("#accountProfilePictureModal").modal('hide');
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            }).fail(function () {
                app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            });
        } else {
            return;
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
    }
};
$(document).ready(function () {
    $('nav#menu').mmenu({
        extensions: ['effect-slide-menu', 'pageshadow'],
        searchfield: true
    });
    if (document.getElementById("accountProfileImgInput")) {
        document.getElementById("accountProfileImgInput").onchange = function () {
            var path = this.value;
            var filename = path.replace(/^.*\\/, "");
            document.getElementById("accountImgInputPath").value = filename;
        };
    }

    $('#accountProfileImgInput').change(function () {
        var image = this.files[0];
        if ((image.size || image.fileSize) < 1 * 1000 * 1000) {
            console.log(image);
            var img = $("#accountProfileImagePreview");
            var reader = new FileReader();
            reader.onloadend = function () {
                img.attr("src", reader.result);
            };
            reader.readAsDataURL(image);
            $("#accountProfileImageErrorMsg").html("");
        } else {
            $("#accountProfileImageErrorMsg").html("Image size is greater than 1MB");
            document.getElementById("imageForm").reset();
        }
    });

    $('#accountProfilePictureModal').on('show.bs.modal', function () {
        document.getElementById("accountProfilePictureForm").reset();
        if (app.loginDetails.PhotoUploaded) {
            $('#accountProfileImagePreview').attr("src", app.websiteRoot + "img/getImage.php?file=" + app.loginDetails.ImagePath + "&rand=" + new Date().getTime());
            $("#accountProfileDeleteImageBtn").removeClass("hidden");
        } else {
            $("#accountProfileImagePreview").attr("src", app.websiteRoot + "img/default/contact/profilePicture.png");
            $("#accountProfileDeleteImageBtn").addClass("hidden");
        }
    });

    $("#accountProfilePictureForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            for (var i = 0; i < formData.length; i++) {
                console.log(formData[i]);
                if (formData[i].name == "fileToUpload") {
                    if (formData[i].value == "") {
                        app.showNotificationFailure("No Image Selected");
                        return false;
                    }
                }
            }
            $("#navbarProgress").removeClass("hidden");
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $("#navbarProgressBar").width(percentComplete + "%");
            $("#navbarProgressValue").html(percentComplete + "% complete");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                app.getLoginDetails();
                $("#accountProfilePictureModal").modal('hide');
                $("#navbarProgress").addClass("hidden");
            } else {
                app.showNotificationFailure(response.message);
                $("#navbarProgress").addClass("hidden");
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#navbarProgress").addClass("hidden");
        }
    });
});