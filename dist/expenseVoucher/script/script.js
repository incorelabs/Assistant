var pageExpenseVoucher = {
    voucherList: null,
    voucherDetails: null,
    expenseCode: window.location.search.split("=").pop(),
    expenseName: "",
    getVoucherList: function () {
        var url = app.websiteRoot + "expense/voucher/getVoucherList.php";

        $.getJSON(url, {
            expenseCode: pageExpenseVoucher.expenseCode
        }).done(function (data) {
            console.log(data);
            pageExpenseVoucher.setVoucherList(data);
        }).fail(function (error) {

        });
    },
    setVoucherList: function (data) {
        pageExpenseVoucher.voucherList = data;
        var voucherTableString = "";
        for (var i = 0; i < data.length; i++) {
            voucherTableString += "<tr class='text-left'>";

            voucherTableString += "<td class='col-md-1 col-sm-1 col-xs-1 text-left text-middle'>" + (i + 1) + "</td>";

            var imageURL = "";

            if (data[i]['ImagePath'])
                imageURL = app.websiteRoot + "img/getImage.php?file=" + data[i]['ImagePath'] + "&rand=" + new Date().getTime();
            else
                imageURL = app.websiteRoot + "img/default/preferences/logo.png";

            voucherTableString += "<td class='col-md-1 col-sm-1 col-xs-1 text-left text-middle'><div class='image'><a onclick='pageExpenseVoucher.openLogoVoucherModal(" + i + ");' class='clickable'><img src='" + imageURL + "' id='imageResource' alt='...' class='img-rounded img-size'/><div class='overlay img-rounded'><span class='glyphicon glyphicon-pencil overlay-icon'></span></div></a></div></td>";

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

            voucherTableString += "<td class='col-md-1 col-sm-1 col-xs-1 text-middle'><a href='#' onclick='pageExpenseVoucher.openEditVoucherModal(" + i + ")'><i class='fa fa-pencil fa-lg fa-green'></i></a>";

            voucherTableString += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='pageExpenseVoucher.openDeleteVoucherModal(" + data[i]['VoucherNo'] + ")'><i class='fa fa-trash-o fa-lg fa-red'></i></a></td>";

            voucherTableString += "</tr>";
        }
        $("#table-body").html(voucherTableString);
    },
    getExpenseDetails: function () {
        var url = app.websiteRoot + "expense/getExpenseDetail.php";

        $.getJSON(url, {
            expenseCode: pageExpenseVoucher.expenseCode
        }).done(function (data) {
            console.log(data);
            pageExpenseVoucher.setExpenseDetails(data);
        }).fail(function (error) {

        });
    },
    setExpenseDetails: function (data) {
        if (data.status == 1) {
            pageExpenseVoucher.expenseName = ((data.detail.expense.ExpenseName) ? data.detail.expense.ExpenseName : "");
            $("#voucherHeader").html(((data.detail.expense.ExpenseName) ? data.detail.expense.ExpenseName : "Expense Description"));
        } else
            $("#voucherHeader").html("Expense Description");
    },
    openAddVoucherModal: function () {
        document.getElementById("voucherForm").reset();

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#voucherModalHeading').empty().html("Add Voucher");
        $("#voucherDescription").empty().val(pageExpenseVoucher.expenseName);
        $("#expenseCodeForAddEditVoucher").val(pageExpenseVoucher.expenseCode);

        $("#voucherDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#referDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#docAmount").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $('#voucherModal').modal('show');
    },
    openEditVoucherModal: function (voucherIndex) {
        pageExpenseVoucher.voucherDetails = pageExpenseVoucher.voucherList[voucherIndex];

        document.getElementById("voucherForm").reset();
        $("#form-add-edit-mode").val("M");

        $('#voucherModalHeading').empty().html("Edit Voucher");
        $("#voucherDescription").empty().val(pageExpenseVoucher.expenseName);
        $("#expenseCodeForAddEditVoucher").val(pageExpenseVoucher.expenseCode);

        $("#voucherDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#referDt").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#docAmount").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        pageExpenseVoucher.setInputFields(pageExpenseVoucher.voucherDetails);
        $("#form-add-edit-code").val(pageExpenseVoucher.voucherDetails["VoucherNo"]);

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
        $("#expenseCodeForDeleteVoucher").val(pageExpenseVoucher.expenseCode);
        $("#form-delete-code").val(voucherCode);
        $("#deleteModal").modal("show");
    },
    openLogoVoucherModal: function (voucherIndex) {
        pageExpenseVoucher.voucherDetails = pageExpenseVoucher.voucherList[voucherIndex];
        $("#imageModal").modal("show");
    },
    deleteCurrentLogo: function () {
        var deleteLogo = confirm("Do you REALLY want to DELETE the LOGO?");
        if (deleteLogo) {
            var url = app.websiteRoot + "expense/voucher/controller.php";

            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");

            $.post(url, {
                expenseCode: pageExpenseVoucher.expenseCode,
                voucherNo: pageExpenseVoucher.voucherDetails.VoucherNo,
                mode: "DI"
            }).done(function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.status == 1) {
                    app.showNotificationSuccess(response.message);
                    setTimeout(function () {
                        pageExpenseVoucher.getVoucherList();
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

    pageExpenseVoucher.getExpenseDetails();
    pageExpenseVoucher.getVoucherList();

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
        console.log(pageExpenseVoucher.voucherDetails);
        document.getElementById("imageForm").reset();
        $("#expenseCodeForImage").val(pageExpenseVoucher.expenseCode);
        $('#photoId').val(pageExpenseVoucher.voucherDetails.VoucherNo);
        if (pageExpenseVoucher.voucherDetails.ImagePath) {
            $("#imagePreview").attr("src", app.websiteRoot + "img/getImage.php?file=" + pageExpenseVoucher.voucherDetails.ImagePath + "&rand=" + new Date().getTime());
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
            $("#expenseVoucherUploadProgress").removeClass("hidden");
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $("#expenseVoucherUploadProgressBar").width(percentComplete + "%");
            $("#expenseVoucherUploadProgressValue").html(percentComplete + "% complete");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                $("#imageModal").modal('hide');
                setTimeout(function () {
                    pageExpenseVoucher.getVoucherList();
                }, 200);
                $("#expenseVoucherUploadProgress").addClass("hidden");
            } else {
                app.showNotificationFailure(response.message);
                $("#expenseVoucherUploadProgress").addClass("hidden");
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#expenseVoucherUploadProgress").addClass("hidden");
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
                    pageExpenseVoucher.getVoucherList();
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
                    pageExpenseVoucher.getVoucherList();
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
        document.getElementById("expenseImgInputPath").value = filename;
    };
});
