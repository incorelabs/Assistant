var pageServiceProvider = {
    openAddServiceProviderModal: function(){

        $('#serviceProviderModalHeading').empty().html("Add Service");
        $("#serviceProviderModal").modal("show");

    },
    openEditServiceProviderModal: function(){

        $('#serviceProviderModalHeading').empty().html("Edit Service");
        $("#serviceProviderModal").modal("show");

    },
    openDeleteModal: function(){

        $('#deleteModal').modal('show');
    },
    navigateBack: function(){
        window.location.href = "../";
    }
};
$(document).ready(function(){

});