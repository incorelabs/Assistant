var pageVehicleAllocation = {
    openAddVehicelAllocationModal: function(){

        $('#vehicleAllocationModalHeading').empty().html("Add Allocation");
        $("#vehicleAllocationModal").modal("show");

    },
    openEditVehicelAllocationModal: function(){

        $('#vehicleAllocationModalHeading').empty().html("Edit Allocation");
        $("#vehicleAllocationModal").modal("show");

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