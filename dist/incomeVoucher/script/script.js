var pageIncomeVoucher = {
    voucherList: null,
    voucherDetails: null,
    incomeCode: window.location.search.split("=").pop(),
    incomeName: "",
    getVoucherList: function () {
        var url = app.websiteRoot + "income/voucher/getVoucherList.php";

        $.getJSON(url, {
            incomeCode: pageIncomeVoucher.incomeCode
        }).done(function (data) {
            console.log(data);
            pageIncomeVoucher.setVoucherList(data);
        }).fail(function (error) {

        });
    },
    setVoucherList: function (data) {
        pageIncomeVoucher.voucherList = data;
        var voucherTableString = "";
        for (var i = 0; i < data.length; i++) {
            voucherTableString += "<tr class='text-left'>";

            voucherTableString += "<td class='col-md-1 col-sm-1 col-xs-1 text-left text-middle'>" + (i + 1) + "</td>";

            var imageURL = "";

            if (data[i]['ImagePath'])
                imageURL = app.websiteRoot + "img/getImage.php?file=" + data[i]['ImagePath'] + "&rand=" + new Date().getTime();
            else
                imageURL = app.websiteRoot + "img/default/preferences/logo.png";

            voucherTableString += "<td class='col-md-1 col-sm-1 col-xs-1 text-left text-middle'><div class='image'><a onclick='pageIncomeVoucher.openLogoVoucherModal(" + i + ");' class='clickable'><img src='" + imageURL + "' id='imageResource' alt='...' class='img-rounded img-size'/><div class='overlay img-rounded'><span class='glyphicon glyphicon-pencil overlay-icon'></span></div></a></div></td>";

            voucherTableString += "<td class='col-md-1 hidden-xs hidden-sm text-left text-middle'>" + ((data[i]['VoucherDt']) ? data[i]['VoucherDt'] : "-") + "</td>";

            var payMode = "";

            switch (data[i]['PayMode']) {
                case "1":
                    payMode = "Cash";
                    break;
                case "2":
                    payMode = "Debit/Credit Card";
                    break;
                case "3":
                    payMode = "Cheque";
                    break;
                case "4":
                    payMode = "Demand Draft";
                    break;
            }

            voucherTableString += "<td class='col-md-1 hidden-xs hidden-sm text-left text-middle'>" + payMode + "</td>";

            voucherTableString += "<td class='col-md-1 hidden-xs hidden-sm text-left text-middle'>" + ((data[i]['ReferNo']) ? data[i]['ReferNo'] : "-") + "</td>";

            voucherTableString += "<td class='col-md-1 hidden-xs hidden-sm text-left text-middle'>" + ((data[i]['ReferDt']) ? data[i]['ReferDt'] : "-") + "</td>";

            voucherTableString += "<td class='col-md-1 hidden-xs hidden-sm text-left text-middle'>" + ((data[i]['DocNo']) ? data[i]['DocNo'] : "-") + "</td>";

            voucherTableString += "<td class='col-md-1 col-sm-1 col-xs-1 text-left text-middle'>" + ((data[i]['DocAmount']) ? data[i]['DocAmount'] : "-") + "</td>";

            voucherTableString += "<td class='col-md-1 hidden-xs hidden-sm text-left text-middle'>" + ((data[i]['Remarks']) ? data[i]['Remarks'] : "-") + "</td>";

            voucherTableString += "<td class='col-md-1 col-sm-1 col-xs-1 text-middle'><a href='#' onclick='pageIncomeVoucher.openEditVoucherModal(" + i + ")'><i class='fa fa-pencil fa-lg fa-green'></i></a>";

            voucherTableString += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='pageIncomeVoucher.openDeleteVoucherModal(" + data[i]['VoucherNo'] + ")'><i class='fa fa-trash-o fa-lg fa-red'></i></a></td>";

            voucherTableString += "</tr>";
        }
        $("#table-body").html(voucherTableString);
    },
    getIncomeDetails: function () {
        var url = app.websiteRoot + "income/getIncomeDetail.php";

        $.getJSON(url, {
            incomeCode: pageIncomeVoucher.incomeCode
        }).done(function (data) {
            console.log(data);
            pageIncomeVoucher.setIncomeDetails(data);
        }).fail(function (error) {

        });
    },
    setIncomeDetails: function (data) {
        if (data.status == 1) {
            pageIncomeVoucher.incomeName = ((data.detail.income.IncomeName) ? data.detail.income.IncomeName : "");
            $("#voucherHeader").html(((data.detail.income.IncomeName) ? data.detail.income.IncomeName : "Income Description"));
        } else
            $("#voucherHeader").html("Income Description");
    },
    openAddVoucherModal: function () {
        document.getElementById("voucherForm").reset();

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#voucherModalHeading').empty().html("Add Voucher");
        $("#voucherDescription").empty().val(pageIncomeVoucher.incomeName);
        $("#incomeCodeForAddEditVoucher").val(pageIncomeVoucher.incomeCode);

        $("#voucherDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#referDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#docAmount").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $('#voucherModal').modal('show');
    },
    openEditVoucherModal: function (voucherIndex) {
        pageIncomeVoucher.voucherDetails = pageIncomeVoucher.voucherList[voucherIndex];

        document.getElementById("voucherForm").reset();
        $("#form-add-edit-mode").val("M");

        $('#voucherModalHeading').empty().html("Edit Voucher");
        $("#voucherDescription").empty().val(pageIncomeVoucher.incomeName);
        $("#incomeCodeForAddEditVoucher").val(pageIncomeVoucher.incomeCode);

        $("#voucherDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#referDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#docAmount").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        pageIncomeVoucher.setInputFields(pageIncomeVoucher.voucherDetails);
        $("#form-add-edit-code").val(pageIncomeVoucher.voucherDetails["VoucherNo"]);

        $("#voucherModal").modal('show');
    },
    setInputFields: function (voucherDetails) {
        console.log(voucherDetails);
        if (voucherDetails["VoucherDt"]) {
            $("#voucherDt").val(voucherDetails["VoucherDt"]);
        }

        if (voucherDetails["PayMode"]) {
            $("#payMode").val(voucherDetails["PayMode"]);
        }

        if (voucherDetails["ReferNo"]) {
            $("#referNo").val(voucherDetails["ReferNo"]);
        }

        if (voucherDetails["ReferDt"]) {
            $("#referDt").val(voucherDetails["ReferDt"]);
        }

        if (voucherDetails["DocNo"]) {
            $("#docNo").val(voucherDetails["DocNo"]);
        }

        if (voucherDetails["DocAmount"]) {
            $("#docAmount").val(voucherDetails["DocAmount"]);
        }

        if (voucherDetails["Remarks"]) {
            $("#remarks").val(voucherDetails["Remarks"]);
        }
    },
    openDeleteVoucherModal: function (voucherCode) {
        $("#incomeCodeForDeleteVoucher").val(pageIncomeVoucher.incomeCode);
        $("#form-delete-code").val(voucherCode);
        $("#deleteModal").modal("show");
    },
    openLogoVoucherModal: function (voucherIndex) {
        pageIncomeVoucher.voucherDetails = pageIncomeVoucher.voucherList[voucherIndex];
        $("#imageModal").modal("show");
        $("#incomeVoucherUploadProgressBar").width(0 + "%");
    },
    deleteCurrentLogo: function () {
        var deleteLogo = confirm("Do you REALLY want to DELETE the LOGO?");
        if (deleteLogo) {
            var url = app.websiteRoot + "income/voucher/controller.php";

            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");

            $.post(url, {
                incomeCode: pageIncomeVoucher.incomeCode,
                voucherNo: pageIncomeVoucher.voucherDetails.VoucherNo,
                mode: "DI"
            }).done(function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.status == 1) {
                    app.showNotificationSuccess(response.message);
                    setTimeout(function () {
                        pageIncomeVoucher.getVoucherList();
                    }, 200);
                } else {
                    app.showNotificationFailure(response.message);
                }
                $("#imageModal").modal('hide');
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
    navigateBack: function () {
        window.location.href = "../";
    }
};

$(document).ready(function () {
    app.websiteRoot = "../../";
    app.getLoginDetails();

    pageIncomeVoucher.getIncomeDetails();
    pageIncomeVoucher.getVoucherList();

    $("#voucherDt").focusin(function () {
        if (this.value.indexOf('_') > -1) {
            this.value = "";
        }
    }).focusout(function () {
        app.validate(this, 1);
        if (this.value.trim() === "" || this.value.trim() === "__/__/____") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#referDt").focusin(function () {
        if (this.value.indexOf('_') > -1) {
            this.value = "";
        }
    }).focusout(function () {
        app.validate(this, 1);
        if (this.value.trim() === "" || this.value.trim() === "__/__/____") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#docAmount").on('input propertychange', function () {
        app.validate(this, 6);
    }).focusout(function () {
        if (this.value.trim() === "") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $('#imgInput').change(function () {
        var image = this.files[0];
        if ((image.size || image.fileSize) < 1 * 1000 * 1000) {
            console.log(image);
            var img = $("#imagePreview");
            var reader = new FileReader();
            reader.onloadend = function () {
                img.attr("src", reader.result);
            };
            reader.readAsDataURL(image);
            $("#imageErrorMsg").html("");
        } else {
            $("#imageErrorMsg").html("Image size is greater than 1MB");
            document.getElementById("imageForm").reset();
        }
    });

    $('#imageModal').on('show.bs.modal', function () {
        console.log(pageIncomeVoucher.voucherDetails);
        document.getElementById("imageForm").reset();
        $("#incomeCodeForImage").val(pageIncomeVoucher.incomeCode);
        $('#photoId').val(pageIncomeVoucher.voucherDetails.VoucherNo);
        if (pageIncomeVoucher.voucherDetails.ImagePath) {
            $("#imagePreview").attr("src", app.websiteRoot + "img/getImage.php?file=" + pageIncomeVoucher.voucherDetails.ImagePath + "&rand=" + new Date().getTime());
            $("#deleteImageBtn").removeClass("hidden");
        } else {
            $("#imagePreview").attr("src", "../../img/default/preferences/logo.png");
            $("#deleteImageBtn").addClass("hidden");
        }
    });

    $("#imageForm").ajaxForm({
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
            $("#incomeVoucherUploadProgress").removeClass("hidden");
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $("#incomeVoucherUploadProgressBar").width(percentComplete + "%");
            $("#incomeVoucherUploadProgressValue").html(percentComplete + "% complete");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                $("#imageModal").modal('hide');
                setTimeout(function () {
                    pageIncomeVoucher.getVoucherList();
                }, 200);
                $("#incomeVoucherUploadProgress").addClass("hidden");
            } else {
                app.showNotificationFailure(response.message);
                $("#incomeVoucherUploadProgress").addClass("hidden");
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#incomeVoucherUploadProgress").addClass("hidden");
        }
    });

    $("#voucherForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            var isValid = false;
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    app.showNotificationFailure("Required fields are empty");
                    return false;
                }
                if (formData[i].name == "voucherDt") {
                    if (app.validateDate(formData[i].value) === app.dateValidationState.SUCCESS)
                        isValid = true;
                    else {
                        isValid = false;
                        break;
                    }
                } else if (formData[i].name == "referDt") {
                    if (formData[i].value.trim() != "") {
                        if (app.validateDate(formData[i].value) === app.dateValidationState.SUCCESS)
                            isValid = true;
                        else {
                            isValid = false;
                            break;
                        }
                    } else {
                        isValid = true;
                    }
                } else if (formData[i].name == "docAmount") {
                    if (app.validateAmount(formData[i].value) === app.amountValidationState.SUCCESS)
                        isValid = true;
                    else {
                        isValid = false;
                        break;
                    }
                }
            }
            console.log(isValid);
            if (!isValid) {
                app.showNotificationFailure("Validation Failed for some input field");
                return false;
            }
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                app.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageIncomeVoucher.getVoucherList();
                }, 200);
                $("#voucherModal").modal('hide');
            } else {
                app.showNotificationFailure(response.message);
                $("#voucherModal").modal('show');
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

    $("#deleteVoucherForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                app.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageIncomeVoucher.getVoucherList();
                }, 200);
            } else {
                app.showNotificationFailure(response.message);
            }
            $("#deleteModal").modal('hide');
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    document.getElementById("imgInput").onchange = function () {
        var path = this.value;
        var filename = path.replace(/^.*\\/, "");
        document.getElementById("incomeImgInputPath").value = filename;
    };
});
