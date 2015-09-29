var app = {
    websiteRoot: "",
    dateValidationState: {
        SUCCESS: 0,
        INVALID: 1
    },
    validateDate: function (inputDate) {
        var date = new MyDate(inputDate);
        if (date.isValid())
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
    openAccountProfilePictureModal: function () {
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
        extensions: ['effect-slide-menu', 'pageshadow'],
        searchfield: true
    });
    document.getElementById("accountProfileImgInput").onchange = function () {
        var path = this.value;
        var filename = path.replace(/^.*\\/, "");
        document.getElementById("accountImgInputPath").value = filename;
    };
});