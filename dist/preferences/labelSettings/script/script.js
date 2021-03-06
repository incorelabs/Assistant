var pageLabelSettings = {
    labelSettingList: null,
    labelDetails: null,
    getLabelList: function () {
        var url = app.websiteRoot + "preferences/labelSettings/getLabelList.php";

        $.getJSON(url).done(function (data) {
            console.log(data);
            pageLabelSettings.setLabelList(data);
        }).fail(function (error) {

        });
    },
    setLabelList: function (data) {
        pageLabelSettings.labelSettingList = data;
        var labelSettingsTableString = "";
        for (var i = 0; i < data.length; i++) {
            labelSettingsTableString += "<tr>";

            labelSettingsTableString += "<td class='text-middle col-md-1 col-sm-1 col-xs-1'>" + (i + 1) + "</td>";

            var imageURL = "";

            if (data[i]['LogoPath'])
                imageURL = app.websiteRoot + "img/getImage.php?file=" + data[i]['LogoPath'] + "&rand=" + new Date().getTime();
            else
                imageURL = "../../img/default/preferences/logo.png";

            if (data[i]['LogoAvailable'] == 1) {
                labelSettingsTableString += "<td class='text-middle col-md-1 col-sm-1 col-xs-3'><div class='image'><a onclick='pageLabelSettings.openLogoLabelSettingsModal(" + i + ");' class='clickable'><img src='" + imageURL + "' id='imageResource' alt='...' class='img-rounded img-size'/><div class='overlay img-rounded'><span class='glyphicon glyphicon-pencil overlay-icon'></span></div></a></div></td>";
            } else {
                labelSettingsTableString += "<td class='text-middle col-md-1 col-sm-1 col-xs-3'><div class='image disabledLogo'><a class='clickable disable-anchor'><img src='" + imageURL + "' id='imageResource' alt='...' class='img-rounded img-size'/><div class='overlay-default img-rounded'><span class='glyphicon glyphicon-remove overlay-icon'></span></div></a></div></td>";
            }

            labelSettingsTableString += "<td class='text-middle col-md-2 col-sm-2 col-xs-3'>" + ((data[i]['LabelName']) ? data[i]['LabelName'] : "-") + "</td>";

            labelSettingsTableString += "<td class='text-middle col-md-1 col-sm-1 hidden-xs'>" + ((data[i]['LabelInRow']) ? data[i]['LabelInRow'] : "-") + "</td>";

            labelSettingsTableString += "<td class='text-middle col-md-1 col-sm-1 hidden-xs'>" + ((data[i]['LabelInColumn']) ? data[i]['LabelInColumn'] : "-") + "</td>";

            labelSettingsTableString += "<td class='text-middle col-md-2 hidden-sm hidden-xs'>" + ((data[i]['LinesPerLabel']) ? data[i]['LinesPerLabel'] : "-") + "</td>";

            labelSettingsTableString += "<td class='text-middle col-md-2 hidden-sm hidden-xs'>" + ((data[i]['SingleContent'] == 1) ? "Multiple" : "Single") + "</td>";

            labelSettingsTableString += "<td class='text-middle col-md-1 col-sm-1 hidden-xs'>" + ((data[i]['LabelOrientation'] == 1) ? "Portrait" : "Landscape") + "</td>";

            labelSettingsTableString += "<td class='text-middle col-md-1 col-sm-1 col-xs-1'><a href='#' onclick='pageLabelSettings.openEditLabelSettingsModal(" + i + ")'><i class='fa fa-pencil fa-lg fa-green'></i></a>";

            labelSettingsTableString += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='pageLabelSettings.openDeleteLabelSettingsModal(" + data[i]['LabelCode'] + ")'><i class='fa fa-trash-o fa-lg fa-red'></i></a></td>";

            labelSettingsTableString += "</tr>";
        }
        $("#table-body").html(labelSettingsTableString);
    },
    openAddLabelSettingsModal: function () {
        document.getElementById("labelSettingsForm").reset();

        $("#form-add-edit-mode").val('A');
        $("#form-add-edit-code").val(1);

        $('#labelSettingsModalHeading').empty().html("Add Label Settings");

        $("#logoDiv").addClass("hidden");

        $("#logoTop").removeAttr("required");
        $("#logoLeft").removeAttr("required");
        $("#logoHeight").removeAttr("required");
        $("#logoWidth").removeAttr("required");

        $("#labelSettingsModal").modal('show');
    },
    openEditLabelSettingsModal: function (labelSettingsIndex) {
        pageLabelSettings.labelDetails = pageLabelSettings.labelSettingList[labelSettingsIndex];

        document.getElementById("labelSettingsForm").reset();
        $("#form-add-edit-mode").val('M');

        $('#labelSettingsModalHeading').empty().html("Edit Label Settings");

        pageLabelSettings.setInputFields(pageLabelSettings.labelDetails);
        $("#form-add-edit-code").val(pageLabelSettings.labelDetails["LabelCode"]);

        $("#labelSettingsModal").modal('show');
    },
    openDeleteLabelSettingsModal: function (labelCode) {
        $("#form-delete-code").val(labelCode);
        $("#deleteModal").modal('show');
    },
    openLogoLabelSettingsModal: function (labelSettingsIndex) {
        pageLabelSettings.labelDetails = pageLabelSettings.labelSettingList[labelSettingsIndex];
        $("#imageModal").modal('show');
        $("#labelSettingsUploadProgressBar").width(0 + "%");

    },
    deleteCurrentLogo: function () {
        var deleteLogo = confirm("Do you REALLY want to DELETE the LOGO?");
        if (deleteLogo) {
            var url = app.websiteRoot + "preferences/labelSettings/controller.php";

            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");

            $.post(url, {
                labelCode: pageLabelSettings.labelDetails.LabelCode,
                mode: "DI"
            }).done(function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.status == 1) {
                    app.showNotificationSuccess(response.message);
                    setTimeout(function () {
                        pageLabelSettings.getLabelList();
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
    setInputFields: function (labelDetails) {
        console.log(labelDetails);
        if (labelDetails["LabelName"]) {
            $("#labelName").val(labelDetails["LabelName"]);
        }

        if (labelDetails["LinesPerLabel"]) {
            $("#linesPerLabel").val(labelDetails["LinesPerLabel"]);
        }

        if (labelDetails["LabelInRow"]) {
            $("#labelInRow").val(labelDetails["LabelInRow"]);
        }

        if (labelDetails["LabelInColumn"]) {
            $("#labelInColumn").val(labelDetails["LabelInColumn"]);
        }

        if (labelDetails["LabelHeight"]) {
            $("#labelHeight").val(labelDetails["LabelHeight"]);
        }

        if (labelDetails["LabelWidth"]) {
            $("#labelWidth").val(labelDetails["LabelWidth"]);
        }

        if (labelDetails["LabelStartLeft"]) {
            $("#labelStartLeft").val(labelDetails["LabelStartLeft"]);
        }

        if (labelDetails["LabelNextLeft"]) {
            $("#labelNextLeft").val(labelDetails["LabelNextLeft"]);
        }

        if (labelDetails["LabelStartTop"]) {
            $("#labelStartTop").val(labelDetails["LabelStartTop"]);
        }

        if (labelDetails["LabelNextTop"]) {
            $("#labelNextTop").val(labelDetails["LabelNextTop"]);
        }

        if (labelDetails["SingleContent"]) {
            $("#singleContent").val(labelDetails["SingleContent"]);
        }

        if (labelDetails["LogoAvailable"] && labelDetails["LogoAvailable"] == "1") {

            $("#logoAvailable").val(labelDetails["LogoAvailable"]);

            $("#logoDiv").removeClass("hidden");

            $("#logoTop").attr("required", "");
            $("#logoLeft").attr("required", "");
            $("#logoHeight").attr("required", "");
            $("#logoWidth").attr("required", "");
        } else {
            $("#logoDiv").addClass("hidden");

            $("#logoTop").removeAttr("required");
            $("#logoLeft").removeAttr("required");
            $("#logoHeight").removeAttr("required");
            $("#logoWidth").removeAttr("required");
        }

        if (labelDetails["LogoTop"]) {
            $("#logoTop").val(labelDetails["LogoTop"]);
        }

        if (labelDetails["LogoLeft"]) {
            $("#logoLeft").val(labelDetails["LogoLeft"]);
        }

        if (labelDetails["LogoHeight"]) {
            $("#logoHeight").val(labelDetails["LogoHeight"]);
        }

        if (labelDetails["LogoWidth"]) {
            $("#logoWidth").val(labelDetails["LogoWidth"]);
        }

        if (labelDetails["LabelOrientation"]) {
            $("#labelOrientation").val(labelDetails["LabelOrientation"]);
        }
    }
};
$(document).ready(function () {
    app.websiteRoot = "../../";
    app.getLoginDetails();

    pageLabelSettings.getLabelList();

    $('#logoAvailable').change(function () {
        if ($("#logoAvailable").val() == "1") {
            $("#logoDiv").removeClass("hidden");

            $("#logoTop").attr("required", "");
            $("#logoLeft").attr("required", "");
            $("#logoHeight").attr("required", "");
            $("#logoWidth").attr("required", "");
        }
        else {
            $("#logoDiv").addClass("hidden");

            $("#logoTop").removeAttr("required");
            $("#logoLeft").removeAttr("required");
            $("#logoHeight").removeAttr("required");
            $("#logoWidth").removeAttr("required");
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
            document.getElementById("logoForm").reset();
        }
    });

    $('#imageModal').on('show.bs.modal', function () {
        console.log(pageLabelSettings.labelDetails);
        document.getElementById("logoForm").reset();
        $('#photoId').val(pageLabelSettings.labelDetails.LabelCode);
        if (pageLabelSettings.labelDetails.LogoPath) {
            $("#imagePreview").attr("src", app.websiteRoot + "img/getImage.php?file=" + pageLabelSettings.labelDetails.LogoPath + "&rand=" + new Date().getTime());
            $("#deleteImageBtn").removeClass("hidden");
        } else {
            $("#imagePreview").attr("src", "../../img/default/preferences/logo.png");
            $("#deleteImageBtn").addClass("hidden");
        }
    });

    $("#logoForm").ajaxForm({
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
            $("#labelSettingsUploadProgress").removeClass("hidden");
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $("#labelSettingsUploadProgressBar").width(percentComplete + "%");
            $("#labelSettingsUploadProgressValue").html(percentComplete + "% complete");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                $("#imageModal").modal('hide');
                setTimeout(function () {
                    pageLabelSettings.getLabelList();
                }, 200);
                $("#labelSettingsUploadProgress").addClass("hidden");
            } else {
                app.showNotificationFailure(response.message);
                $("#labelSettingsUploadProgress").addClass("hidden");
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#labelSettingsUploadProgress").addClass("hidden");
        }
    });

    $("#labelSettingsForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    app.showNotificationFailure("Required fields are empty");
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
                app.showNotificationSuccess(response.message);
                setTimeout(function () {
                    pageLabelSettings.getLabelList();
                }, 200);
                $("#labelSettingsModal").modal('hide');
            } else {
                app.showNotificationFailure(response.message);
                $("#labelSettingsModal").modal('show');
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

    $("#deleteLabelSettingsForm").ajaxForm({
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
                    pageLabelSettings.getLabelList();
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
        document.getElementById("labelImgInputPath").value = filename;
    };
});
