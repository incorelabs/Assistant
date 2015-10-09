var pageAssignTask = {
    openAddAssignTaskModal: function(){

        $('#taskModalHeading').empty().html("Add Event");
        $("#assignTaskModal").modal("show");

    },
    openEditAssignTaskModal: function(){

        $('#taskModalHeading').empty().html("Edit Event");
        $("#assignTaskModal").modal("show");

    },
    openDeleteModal: function(){

      $('#deleteModal').modal('show');
    },
    navigateBack: function(){
        window.location.href = "../";
    }
};
$(document).ready(function() {
    $('#taskAssignedTo').multiselect({
        maxHeight: 200,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        onChange: function(option, checked) {
            // Get selected options.
            var selectedOptions = $('#taskAssignedTo option:selected');

            if (selectedOptions.length >= 9) {
                // Disable all other checkboxes.
                var nonSelectedOptions = $('#taskAssignedTo option').filter(function() {
                    return !$(this).is(':selected');
                });

                var dropdown = $('#taskAssignedTo').siblings('.multiselect-container');
                nonSelectedOptions.each(function() {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', true);
                    input.parent('li').addClass('disabled');
                });
            }
            else {
                // Enable all checkboxes.
                var dropdown1 = $('#taskAssignedTo').siblings('.multiselect-container');
                $('#taskAssignedTo option').each(function() {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', false);
                    input.parent('li').addClass('disabled');
                });
            }
        }
    });
});