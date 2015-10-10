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
    $('#venueRooms').multiselect({
        maxHeight: 200,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        onChange: function(option, checked) {
            // Get selected options.
            var selectedOptions = $('#venueRooms option:selected');

            if (selectedOptions.length >= 9) {
                // Disable all other checkboxes.
                var nonSelectedOptions = $('#venueRooms option').filter(function() {
                    return !$(this).is(':selected');
                });

                var dropdown = $('#venueRooms').siblings('.multiselect-container');
                nonSelectedOptions.each(function() {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', true);
                    input.parent('li').addClass('disabled');
                });
            }
            else {
                // Enable all checkboxes.
                var dropdown1 = $('#venueRooms').siblings('.multiselect-container');
                $('#venueRooms option').each(function() {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', false);
                    input.parent('li').addClass('disabled');
                });
            }
        }
    });
});