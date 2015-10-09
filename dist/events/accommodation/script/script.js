var pageAccommodation = {
    openAddAccommodationModal: function(){

        $('.removeDiv').remove();

        $('#taskModalHeading').empty().html("Add Accommodation");
        $("#assignTaskModal").modal("show");

    },
    openEditAccommodationModal: function(){

        $('#taskModalHeading').empty().html("Edit Accommodation");
        $("#assignTaskModal").modal("show");

    },
    openDeleteModal: function(){

        $('#deleteModal').modal('show');
    },
    navigateBack: function(){
        window.location.href = "../";
    },
    addSubDiv: function(type)
    {
        switch(type){
            case 1:
                var newSubEvent = "<div class='removeDiv'><hr><div class='row'><div class='col-md-11 col-sm-11 col-xs-12'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Rooms*</span><input type='text' class='form-control text-field-left-border' id='' name='' placeholder='Room Number' required/></div></div><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Occupancy*</span><input type='text' class='form-control text-field-left-border' id='' name='' placeholder='Occupancy Limit' required/></div></div></div><div class='col-md-1 col-sm-1 col-xs-12'><div class='col-md-1 col-sm-1 col-xs-12'><center><button type='button' class='btn btn-danger twoTextBtn' onclick='pageAccommodation.deleteSubDiv(this,1)'><i class='fa fa-minus fa-lg'></i></button></center></div></div></div></div>";
                $(".add-room-modal-body").append(newSubEvent);
                break;
        }
    },
    deleteSubDiv: function(selected,type)
    {
        switch(type){
            case 1:
                $(selected).closest('.removeDiv').remove();
                break;
        }
    },
};
$(document).ready(function(){

});