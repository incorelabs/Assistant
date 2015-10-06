pageEventsInvite = {

};
$(document).ready(function() {
    $("#fixTable").tableHeadFixer({"left" : 1});
    $('.eventCheckbox').change(function(){
        $(this).closest('td').find(".eventTextbox").prop("disabled", !$(this).is(':checked'));
    });
});