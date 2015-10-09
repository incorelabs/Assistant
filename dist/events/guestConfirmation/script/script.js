var pageGuestConfirmation = {
    openAddGuestConfirmationModal: function(){

        $('.removeDiv').remove();

        $('#guestConfirmationHeading').empty().html("Add Guest Confirmation");
        $("#guestConfirmationModal").modal("show");

    },
    openEditGuestConfirmationModal: function(){

        $('#guestConfirmationHeading').empty().html("Edit Guest Confirmation");
        $("#guestConfirmationModal").modal("show");

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
                var newSubEvent = "<div class='removeDiv'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Rooms*</span><input type='text' class='form-control text-field-left-border' id='venueRooms' name='venueRooms' placeholder='Room Number' required/><span class='input-group-btn'><button class='btn btn-danger button-addon-custom' type='button' onclick='pageAccomodation.deleteSubDiv(this,1)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>";
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