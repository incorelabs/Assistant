var pageEvents = {
    subEventsCount: 0,
    openAddEventsModal: function(){
        document.getElementById("eventsForm").reset();

        //clear the submenu divs
        pageEvents.subEventsCount = 0;
        $('.removeDiv').remove();

        //hide the submenu & button
        $(".mainEventDiv").removeClass("hidden");
        $("#subEventsAddDiv").addClass("hidden");

        $('#eventsModalHeading').empty().html("Add Event");
        $("#eventsModal").modal("show");
    },
    openEventsInviteListModal: function(){
        $("#inviteListModal").modal("show");
    },
    subEventConfirmation: function(){
        var eventConfirm = $("#subEventConfirmation").val();
        console.log(eventConfirm);
        if(eventConfirm == 0) {

            $(".mainEventDiv").addClass("hidden");
            $("#subEventsAddDiv").removeClass("hidden");

        } else{

            $(".mainEventDiv").removeClass("hidden");
            $("#subEventsAddDiv").addClass("hidden");

            //clear the Added Divs
            pageEvents.subEventsCount = 0;
            $('.removeDiv').remove();

        }
    },
    addSubDiv: function(type)
    {
      switch(type){
          case 1:
              if(pageEvents.subEventsCount <= 5) {
                  var newSubEvent = "<div class='removeDiv'><hr/><div class='row'><div class='col-md-11 col-sm-11 col-xs-12'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Name*</span><div class='inner-addon right-addon'><i class='fa fa-sticky-note-o hidden-xs fa-size'></i><input type='text' class='form-control text-field-left-border' id=' name='placeholder='Sub Event Name' required/></div></div></div><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Venue*</span><div class='inner-addon right-addon'><i class='fa fa-sticky-note-o hidden-xs fa-size'></i><input type='text' class='form-control text-field-left-border' id=' name='placeholder='Sub Event Venue' required/></div></div></div><div class='col-md-6 col-sm-6 col-xs-12 col-padding-left-remove col-padding-right-remove col-padding-remove'><div class='form-group margin-right-none '><div class='input-group'><span class='input-group-addon input-group-addon-label two-col-span-label'>Date*</span><div class='inner-addon right-addon'><i class='fa fa-calendar hidden-xs fa-size'></i><input type='text' class='form-control text-field-left-border date' id='name=' placeholder='DD/MM/YYYY' required/></div></div></div></div><div class='col-md-6 col-sm-6 col-xs-12 col-padding-right-remove col-padding-remove'><div class='form-group margin-left-none'><div class='input-group'><span class='input-group-addon input-group-addon-label two-col-span-label'>Time*</span><span class='input-group-btn select-inline'><div class='inner-addon right-addon'><i class='fa fa-caret-down fa-size'></i><select class='form-control select-field-left-border select-right-radius-none'><option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option></select></div></span><span class='input-group-btn select-inline'><div class='inner-addon right-addon'><i class='fa fa-caret-down fa-size'></i><select class='form-control select-field-left-border'><option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='00'>24</option><option value='01'>25</option><option value='02'>26</option><option value='03'>27</option><option value='04'>28</option><option value='05'>29</option><option value='06'>30</option><option value='07'>31</option><option value='08'>32</option><option value='09'>33</option><option value='10'>34</option><option value='11'>35</option><option value='12'>36</option><option value='13'>37</option><option value='14'>38</option><option value='15'>39</option><option value='16'>40</option><option value='17'>41</option><option value='18'>42</option><option value='19'>43</option><option value='20'>44</option><option value='21'>45</option><option value='22'>46</option><option value='23'>47</option><option value='00'>48</option><option value='01'>49</option><option value='02'>50</option><option value='03'>51</option><option value='04'>52</option><option value='05'>53</option><option value='06'>54</option><option value='07'>55</option><option value='08'>56</option><option value='09'>57</option><option value='10'>58</option><option value='11'>59</option></select></div></span></div></div></div></div><div class='col-md-1 col-sm-1 col-xs-12'><center><button type='button' class='btn btn-danger subEventsBtn' onclick='pageEvents.deleteSubDiv(this,1)'><i class='fa fa-trash-o fa-lg'></i></button></center></div></div></div>";
                  $(".add-event-modal-body").append(newSubEvent);
                  pageEvents.subEventsCount++;
              }
              break;
      }
    },
    deleteSubDiv: function(selected,type)
    {
        switch(type){
            case 1:
                $(selected).closest('.removeDiv').remove();
                pageEvents.subEventsCount--;
                break;
        }
    },
    openAssignTaskPage: function () {
        window.location.href = "assignTask/";
    },
    openAccommodationPage: function () {
        window.location.href = "accommodation/";
    },
    openGuestConfirmationPage: function () {
        window.location.href = "guestConfirmation/";
    },
    openRoomAllocationPage: function(){
        window.location.href = "roomAllocation/"
    },
    openVehicleAllocationPage: function () {
        window.location.href = "vehicleAllocation/"
    },
    openServiceProviderPage: function() {
        window.location.href = "serviceProvider/"
    }
};
$(document).ready(function(){
    //To call the multiselect Boxes
    $('#statesSelection').multiselect({
        maxHeight: 200,
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true
    });
    $('#citiesSelection').multiselect({
        maxHeight: 200,
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true
    });
    $('#groupsSelection').multiselect({
        maxHeight: 200,
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true
    });
});
