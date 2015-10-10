var pageDocuments = {
    openAddDocumentsModal: function () {
        document.getElementById("documentsForm").reset();

        $('#documentsModalHeading').empty().html("Add Document");
        $('#documentsModal').modal('show');
    },
    openEditDocumentsModal: function () {
        document.getElementById("documentsForm").reset();
        $('#documentsModalHeading').empty().html("Edit Document");

        $("#documentsModal").modal('show');
    },
    openDeleteDocumentsModal: function(){
        $("#deleteModal").modal("show");
    },
    openDocumentsImageModal: function(){
        $("#imageModal").modal("show");
    }
};

$(document).ready(function () {

});