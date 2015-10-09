var pageRoomAllocation = {
    openAddRoomAllocationModal: function(){

        $('#roomAllocationModalHeading').empty().html("Add Allocation");
        $("#roomAllocationModal").modal("show");

    },
    openEditRoomAllocationModal: function(){

        $('#roomAllocationModalHeading').empty().html("Edit Allocation");
        $("#roomAllocationModal").modal("show");

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