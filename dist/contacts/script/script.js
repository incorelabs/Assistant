var pageContact = {
    currentPageNo: 1,
    localContact: null,
    contactList: {},
    searchList: {},
    titleTags: [],
    titleCode: [],
    groupTag: [],
    groupCode: [],
    countryTag: [],
    countryCode: [],
    country: [],
    stateTag: [],
    stateCode: [],
    state: [],
    cityTag: [],
    cityCode: [],
    city: [],
    areaTag: [],
    areaCode: [],
    area: [],
    mobileAddCount: 0,
    emailAddCount: 1,
    homePhoneCount: 1,
    workPhoneCount: 1,
    otherPhoneCount: 1,
    getContactList: function () {
        var url = "ContactList.php";

        $.getJSON(url, {
            pageNo: pageContact.currentPageNo
        }).done(function (data) {
            console.log(data);

            console.log(pageContact.currentPageNo);
            pageContact.setContactList(data);
        }).fail(function (error) {

        });
    },
    setContactList: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageContact.currentPageNo++;
            var letterIndex = "";
            var str = "";
            for (var i = 0; i < data.result.length; i++) {
                var letter = data.result[i][1].toUpperCase()[0];
                console.log(letter);
                if (letter != letterIndex) {
                    str += "<li class='list-group-item-info li-pad'>" + letter + "</li>";
                    letterIndex = letter;
                    console.log(letterIndex);
                }
                str += "<a onclick='pageContact.getContactDetails(" + data.result[i][0] + ")' class='list-group-item contacts_font'><h4 class='list-group-item-heading contacts_font'>" + data.result[i][1] + "</h4></a>";
            }
            //$("#contactList").empty();
            $("#contactList").append(str);
            console.log(str);
            // Print on screen
            console.log(data.result);
            if (pageContact.currentPageNo <= data.pages) {
                // Show Load More
                var str = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageContact.getContactList();'>Load more..</a></div>";
                $("#contactList").append(str);
            }

        } else {
            var str = "<div class='list-group-item'><li class='list-group-item-text header_font'>";
            str += data.message + "</li></div>";
            $("#contactList").empty();
            $("#contactList").html(str);
        }
    },
    getContactDetails: function (contactCode) {
        var url = "ContactDetails.php";

        $.getJSON(url, {
            contactCode: contactCode
        }).done(function (data) {
            console.log(data);
            console.log(data.detail.contact);
            pageContact.setContactDetails(data);
        }).fail(function (error) {

        });
    },
    setContactDetails: function (data) {
        if (data.status == 1) {
            this.localContact = data.detail;
            var headerStr = "<h12>Contact Details</h12><button class='btn btn-success pull-right' onclick='openEditContact();'><span class='glyphicon glyphicon-pencil'></span></button><button class='btn btn-danger pull-left' onclick='openDeleteModal(" + data.detail.contact.ContactCode + ")'><span class='glyphicon glyphicon-trash'></span></button>";
            var str = "";
            var imgLocation = "";
            if (data.detail.contact.imageLocation) {
                imgLocation = data.detail.contact.imageLocation;
            }
            else {
                imgLocation = "../img/contacts/profile/profilePicture1.png";
            }


            str += "<div class='list-group-item'><div class='image'><a data-toggle='modal' data-target='#imageModal' id='pop'><img src='" + imgLocation + "' id='imageresource' alt='...' class='img-rounded pull-left'/><div class='overlay img-rounded pull-left'><span class='glyphicon glyphicon-pencil' style='padding-top:10px'></span></div></a></div><div class='header_font'>Name</div><h5 class='list-group-item-heading'>" + ((data.detail.contact.TitleName) ? data.detail.contact.TitleName + " " : "") + ((data.detail.contact.FullName) ? data.detail.contact.FullName : "") + "</h5></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Guardian</div><value><div class='col-md-9'>" + ((data.detail.contact.GuardianName) ? data.detail.contact.GuardianName : "") + "</div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Company</div><value><div class='col-md-9'>" + ((data.detail.contact.Company) ? data.detail.contact.Company : "" ) + "</div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Designation</div><value><div class='col-md-9'>" + ((data.detail.contact.Designation) ? data.detail.contact.Designation : "") + "</div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Alias</div><value><div class='col-md-9'>" + ((data.detail.contact.Alias) ? data.detail.contact.Alias : "") + "</div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.B</div><value><div class='col-md-9'>" + ((data.detail.contact.Dob) ? data.detail.contact.Dob : "") + "</div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.M</div><value><div class='col-md-9'>" + ((data.detail.contact.Dom) ? data.detail.contact.Dom : "") + "</div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Group</div><value><div class='col-md-9'>" + ((data.detail.contact.GroupName) ? data.detail.contact.GroupName : "") + "</div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>" + ((data.detail.contact.Remarks) ? data.detail.contact.Remarks : "") + "</div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Mobile (1)</div><value><div class='col-md-9'><a href='tel:" + ((data.detail.contact.Mobile1) ? data.detail.contact.Mobile1 : "") + "'>" + ((data.detail.contact.Mobile1) ? data.detail.contact.Mobile1 : "") + "</a></div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Mobile (2)</div><value><div class='col-md-9'><a href='tel:" + ((data.detail.contact.Mobile2) ? data.detail.contact.Mobile2 : "") + "'>" + ((data.detail.contact.Mobile2) ? data.detail.contact.Mobile2 : "") + "</a></div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Mobile (3)</div><value><div class='col-md-9'><a href='tel:" + ((data.detail.contact.Mobile3) ? data.detail.contact.Mobile3 : "") + "'>" + ((data.detail.contact.Mobile3) ? data.detail.contact.Mobile3 : "") + "</a></div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Email (1)</div><value><div class='col-md-9'><a href= 'mailto:" + ((data.detail.contact.Email1) ? data.detail.contact.Email1 : "") + "'>" + ((data.detail.contact.Email1) ? data.detail.contact.Email1 : "") + "</a></div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Email (2)</div><value><div class='col-md-9'><a href= 'mailto:" + ((data.detail.contact.Email2) ? data.detail.contact.Email2 : "") + "'>" + ((data.detail.contact.Email2) ? data.detail.contact.Email2 : "") + "</a></div></value></div></div>";

            var homeAddress = "";
            if (data.detail.address) {
                if (data.detail.address.home) {
                    var home = data.detail.address.home;
                    homeAddress = home.address;
                    homeAddress = homeAddress.replace(/(?:\r\n|\r|\n)/g, '<br />');
                    homeAddress += "(Area) " + ((home.area) ? ("<br />" + home.area) : "");
                    homeAddress += ((home.city) ? ("<br />" + home.city + " - ") : "");
                    homeAddress += ((home.pincode) ? (home.pincode) : "");
                    homeAddress += ((home.state) ? ("<br />" + home.state) : "");
                    homeAddress += ((home.country) ? ("<br />" + home.country) : "");
                    homeAddress += ((home.phone) ? ("<br />" + home.phone) : "");
                }
                else {
                    homeAddress = "No home address details";
                }
            }
            else {
                homeAddress = "No details";
            }

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Home Address</div><value><div class='col-md-9'>" + homeAddress + "</div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Facebook</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Facebook) ? data.detail.contact.Facebook : "") + "' target='_blank'>" + ((data.detail.contact.Facebook) ? data.detail.contact.Facebook : "") + "</a></div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Twitter</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Twitter) ? data.detail.contact.Twitter : "") + "' target='_blank'>" + ((data.detail.contact.Twitter) ? data.detail.contact.Twitter : "") + "</a></div></value></div></div>";

            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Google</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Google) ? data.detail.contact.Google : "") + "' target='_blank'>" + ((data.detail.contact.Google) ? data.detail.contact.Google : "") + "</a></div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Linkedin</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Linkedin) ? data.detail.contact.Linkedin : "") + "' target='_blank'>" + ((data.detail.contact.Linkedin) ? data.detail.contact.Linkedin : "") + "</a></div></value></div></div>";


            str += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Website</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Website) ? data.detail.contact.Website : "") + "' target='_blank'>" + ((data.detail.contact.Website) ? data.detail.contact.Website : "") + "</a></div></value></div></div>";

            $("#contactDetailHeader").empty();
            $("#contactDetailHeader").html(headerStr);
            $("#contactDetailBody").empty();
            $("#contactDetailBody").html(str);

        } else {
            this.localContact = null;
        }
    },
    getTitles: function () {
        var url = "getMasters.php";

        $.getJSON(url, {
            type: 'title'
        }).done(function (data) {
            var title = JSON.parse(data);
            for (var i = 0; i < title.length; i++) {
                pageContact.titleTags[i] = title[i]['description'];
                pageContact.titleCode[i] = title[i]['code'];
            }
            pageContact.setTitleAutoComplete();
        }).fail(function (error) {

        });
    },
    getGroups: function () {
        var url = "getMasters.php";

        $.getJSON(url, {
            type: 'group'
        }).done(function (data) {
            var group = JSON.parse(data);
            for (var i = 0; i < group.length; i++) {
                pageContact.groupTag[i] = group[i]['description'];
                pageContact.groupCode[i] = group[i]['code'];
            }
            pageContact.setGroupAutoComplete();
        }).fail(function (error) {

        });
    },
    getCountry: function () {
        var url = "getMasters.php";

        $.getJSON(url, {
            type: 'country'
        }).done(function (data) {
            var country = JSON.parse(data);
            for (var i = 0; i < country.length; i++) {
                pageContact.countryTag[i] = country[i]['description'];
                pageContact.countryCode[i] = country[i]['code'];
            }
            pageContact.setCountryAutoComplete();
        }).fail(function (error) {

        });
    },
    getStates: function () {
        var url = "getMasters.php";

        $.getJSON(url, {
            type: 'state'
        }).done(function (data) {
            var state = JSON.parse(data);
            for (var i = 0; i < state.length; i++) {
                pageContact.stateTag[i] = state[i]['description'];
                pageContact.stateCode[i] = state[i]['code'];
            }
            pageContact.setStateAutoComplete();
        }).fail(function (error) {

        });
    },
    getCities: function () {
        var url = "getMasters.php";

        $.getJSON(url, {
            type: 'city'
        }).done(function (data) {
            var city = JSON.parse(data);
            for (var i = 0; i < city.length; i++) {
                pageContact.cityTag[i] = city[i]['description'];
                pageContact.cityCode[i] = city[i]['code'];
            }
            pageContact.setCityAutoComplete();
        }).fail(function (error) {

        });
    },
    getAreas: function () {
        var url = "getMasters.php";

        $.getJSON(url, {
            type: 'area'
        }).done(function (data) {
            var area = JSON.parse(data);
            for (var i = 0; i < area.length; i++) {
                pageContact.areaTag[i] = area[i]['description'];
                pageContact.areaCode[i] = area[i]['code'];
            }
            pageContact.setAreaAutoComplete();
        }).fail(function (error) {

        });
    },
    doSearch: function () {

    },
    openAddContact: function () {
        document.getElementById("contactForm").reset();
        $("#mode").val("A");
        $("#contactCode").val(0);

        $('#contactModalHeading').empty();
        $('#contactModalHeading').html("Add Contact");

        $('.addMobileDiv').empty();
        this.mobileAddCount = 0;
        $('.addEmailDiv').empty();
        this.emailAddCount = 1;
        $('.addHomePhone').empty();
        this.homePhoneCount = 1;
        $('.addWorkPhone').empty();
        this.workPhoneCount = 1;
        $('.addOtherPhone').empty();
        this.otherPhoneCount = 1;
        $("#contactModal").modal('show');

        // To close the tab pane and to remove the active border

        $(".tab-pane").removeClass('active');
        $("li").removeClass('active');
    },
    openEditContact: function () {

    },
    createEditAddressData: function (address, type) {

    },
    openDeleteModal: function (contactCode) {
        $("#deleteContact").val(contactCode);
        $("#deleteModal").modal("show");
    },
    setTitleAutoComplete: function () {
        pageContact.setAutoComplete("#addTitle", "#titleId", pageContact.titleTags, pageContact.titleCode);
    },
    setGroupAutoComplete: function () {
        pageContact.setAutoComplete("#addGroup", "#groupId", pageContact.groupTag, pageContact.groupCode);
    },
    setCountryAutoComplete: function () {

    },
    setStateAutoComplete: function () {

    },
    setStateAutoCompleteWithOptions: function (autoCompleteId, changeCodeId, countryId, countryCodeId) {

    },
    setCityAutoComplete: function () {

    },
    setCityAutoCompleteWithOptions: function (autoCompleteId, changeCodeId, countryId, countryCodeId, stateId, stateCodeId) {

    },
    setAreaAutoComplete: function () {

    },
    setAreaAutoCompleteWithOptions: function (autoCompleteId, changeCodeId, countryId, countryCodeId, stateId, stateCodeId, cityId, cityCodeId) {

    },
    setAutoComplete: function (autoCompleteId, changeCodeId, autoCompleteArray, changeCodeArray) {

    },
    submitContactForm: function (event) {

    },
    showNotificationSuccess: function (msg) {
        $("#notification_success").html(msg);
        document.getElementById('notification_success').style.display = "block";
        $("#notification_success").delay(2000).fadeOut("slow");
    },
    showNotificationFailure: function (msg) {
        $("#notification_failure").html(msg);
        document.getElementById('notification_failure').style.display = "block";
        $("#notification_failure").delay(2000).fadeOut("slow");
    },
    showLoadingInContactDetail: function () {
        var contactDetailStr = "<div class='list-group-item loading'></div>";
        $("#contactDetailBody").html(contactDetailStr);
    },
    refreshMasterList: function () {
        this.getTitles();
        this.getGroups();
        this.getCountry();
        this.getStates();
        this.getCities();
        this.getAreas();
    }
};

$(document).ready(function (event) {
    pageContact.getContactList();

});
