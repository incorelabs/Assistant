var pageEvents = {
    openAddEventsModal: function(){
        $("#eventsModal").modal("show");
    },
    openEventsInviteListModal: function(){
        $("#inviteListModal").modal("show");
    }
};
$(document).ready(function(){
    $('#statesBtn').click(function() {
        $('#statesSelection option').prop('selected', true);
    });
    $('#citiesBtn').click(function() {
        $('#citiesSelection option').prop('selected', true);
    });
    $('#groupsBtn').click(function() {
        $('#groupsSelection option').prop('selected', true);
    });
});