var pageImportContacts = {};
$(document).ready(function () {
    document.getElementById("AssistantUploadBtn").onchange = function () {
        var path = this.value;
        var filename = path.replace(/^.*\\/, "");
        document.getElementById("AssistantUpload").value = filename;
    };

    document.getElementById("outlookUploadBtn").onchange = function () {
        var path = this.value;
        var filename = path.replace(/^.*\\/, "");
        document.getElementById("outlookUpload").value = filename;
    };

    $("#outlookForm").ajaxForm({
        beforeSubmit: function (formData) {
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].name == "fileToUpload") {
                    if (formData[i].value == "") {
                        app.showNotificationFailure("No Image Selected");
                        return false;
                    }
                }
            }
            $("#outlookUploadProgress").removeClass("hidden");
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $("#outlookUploadProgressBar").width(percentComplete + "%");
            $("#outlookUploadProgressValue").html(percentComplete + "% complete");
        },
        success: function (responseText, statusText, xhr, $form) {
            var response = JSON.parse(responseText);
            $("#outlookUploadProgress").addClass("hidden");
            $("#importContactSummaryDiv").removeClass("hidden");
            var importContactString = "<div>Total Contacts: " + response.noOfContacts + "</div><div>Success: " + response.noOfContactsImported + "</div><div>Failed: " + response.noOfContactsRejected + "</div>";
            if (response.status == 1) {
                $("#successDiv").html(importContactString).removeClass("hidden");
            } else {
                $("#failureDiv").html(response.message).removeClass("hidden");
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#outlookUploadProgress").addClass("hidden");
        }
    });
});