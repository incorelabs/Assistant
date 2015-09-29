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
});