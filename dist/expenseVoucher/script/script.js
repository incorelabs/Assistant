var pageExpenseVoucher = {
    voucherList: null,
    voucherDetails: null,
    expenseCode: window.location.search.split("=").pop(),
    expenseName: "",
    getVoucherList: function () {
        var url = localStorage.getItem("websiteRoot") + "expense/voucher/getVoucherList.php";

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
                imageURL = localStorage.getItem("websiteRoot") + "img/getImage.php?file=" + data[i]['ImagePath'] + "&rand=" + new Date().getTime();
            else
                imageURL = localStorage.getItem("websiteRoot") + "img/default/preferences/logo.png";

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
        var url = localStorage.getItem("websiteRoot") + "expense/getExpenseDetail.php";

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

        $('#voucherModal').modal('show');
    },
    openEditVoucherModal: function (voucherIndex) {
        pageExpenseVoucher.voucherDetails = pageExpenseVoucher.voucherList[voucherIndex];

        document.getElementById("voucherForm").reset();
        $("#form-add-edit-mode").val("M");

        $('#voucherModalHeading').empty().html("Edit Voucher");
        $("#voucherDescription").empty().val(pageExpenseVoucher.expenseName);
        $("#expenseCodeForAddEditVoucher").val(pageExpenseVoucher.expenseCode);

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
            var url = localStorage.getItem("websiteRoot") + "expense/voucher/controller.php";

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
                    pageIndex.showNotificationSuccess(response.message);
                    setTimeout(function () {
                        pageExpenseVoucher.getVoucherList();
                    }, 200);
                } else {
                    pageIndex.showNotificationFailure(response.message);
                }
                $("#imageModal").modal('hide');
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            }).fail(function () {
                pageIndex.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
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
    localStorage.setItem("websiteRoot", "../../");

    $('#navbarProfilePicture').attr("src", localStorage.getItem("websiteRoot") + "img/default/contact/profilePicture.png");
    $('#accountProfileImagePreview').attr("src", localStorage.getItem("websiteRoot") + "img/default/contact/profilePicture.png");

    pageExpenseVoucher.getExpenseDetails();
    pageExpenseVoucher.getVoucherList();

    console.log(pageExpenseVoucher.expenseCode);

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
            $("#imagePreview").attr("src", localStorage.getItem("websiteRoot") + "img/getImage.php?file=" + pageExpenseVoucher.voucherDetails.ImagePath + "&rand=" + new Date().getTime());
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
                        pageIndex.showNotificationFailure("No Image Selected");
                        return false;
                    }
                }
            }
            $(".progress").show();
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $(".progress-bar").width(percentComplete + "%");
            $("#progressValue").html(percentComplete + "% complete");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                $("#imageModal").modal('hide');
                setTimeout(function () {
                    pageExpenseVoucher.getVoucherList();
                }, 200);
                $(".progress").hide();
            } else {
                pageIndex.showNotificationFailure(response.message);
                $(".progress").hide();
            }
        },
        error: function () {
            pageIndex.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $(".progress").hide();
        }
    });

    $(".progress").hide();

    $("#voucherForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    pageIndex.showNotificationFailure("Required fields are empty");
                    return false;
                }
            }
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                pageIndex.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageExpenseVoucher.getVoucherList();
                }, 200);
                $("#voucherModal").modal('hide');
            } else {
                pageIndex.showNotificationFailure(response.message);
                $("#voucherModal").modal('show');
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            pageIndex.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
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
                pageIndex.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageExpenseVoucher.getVoucherList();
                }, 200);
            } else {
                pageIndex.showNotificationFailure(response.message);
            }
            $("#deleteModal").modal('hide');
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            pageIndex.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });
});
