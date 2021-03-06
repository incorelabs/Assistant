var pageContact = {
    currentPageNo: 1,
    contactListLetterIndex: "",
    searchListLetterIndex: "",
    localContact: null,
    isContactFormValid: false,
    defContactList: $.Deferred(),
    defSearchResult: $.Deferred(),
    titleTag: [],
    titleCode: [],
    groupTag: [],
    groupCode: [],
    emergencyTag: [],
    emergencyCode: [],
    countryTag: [],
    countryCode: [],
    countryData: [],
    stateTag: [],
    stateCode: [],
    stateData: [],
    cityTag: [],
    cityCode: [],
    cityData: [],
    areaTag: [],
    areaCode: [],
    areaData: [],
    addBtnMobileCount: 0,
    addBtnEmailCount: 0,
    addBtnHomePhoneCount: 0,
    addBtnWorkPhoneCount: 0,
    addBtnOtherPhoneCount: 0,
    firstTime: true,
    getContactList: function (isLoadMore) {
        var url = app.websiteRoot + "contacts/getContactList.php";
        if (!isLoadMore)
            pageContact.contactListLetterIndex = "";

        $.getJSON(url, {
            pageNo: pageContact.currentPageNo
        }).done(function (data) {
            pageContact.defContactList.resolve(data);
            pageContact.setContactList(data);
        }).fail(function (error) {

        });
    },
    setContactList: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageContact.currentPageNo++;
            var contactListString = "";
            for (var i = 0; i < data.result.length; i++) {
                var letter = data.result[i].FullName.toUpperCase()[0];
                console.log(letter);
                if (letter != pageContact.contactListLetterIndex) {
                    contactListString += "<li class='list-group-item-info li-pad'>" + letter + "</li>";
                    pageContact.contactListLetterIndex = letter;
                    console.log(pageContact.contactListLetterIndex);
                }
                contactListString += "<a onclick='pageContact.getContactDetails(" + data.result[i].ContactCode + ")' class='list-group-item contacts_font'>" + data.result[i].FullName + "</a>";
            }
            $("#contactList").append(contactListString);
            if (pageContact.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageContact.getContactList(true);'>Load more..</a></div>";
                $("#contactList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#contactList").empty().html(noMoreDataString);
        }
    },
    doSearch: function () {
        $("#contactList").empty();
        pageContact.currentPageNo = 1;
        pageContact.firstTime = true;
        pageContact.searchListLetterIndex = "";
        pageContact.defSearchResult = $.Deferred();
        pageContact.getSearchResults();
        $.when(pageContact.defSearchResult).done(function (data) {
            if (data.status == 1)
                pageContact.getContactDetails(data.result[0].ContactCode);
        });
    },
    getSearchResults: function () {
        var url = app.websiteRoot + "contacts/getContactList.php";

        $.getJSON(url, {
            pageNo: pageContact.currentPageNo,
            searchType: $('#filter').val(),
            searchText: $('#searchBox').val().trim()
        }).done(function (data) {
            pageContact.defSearchResult.resolve(data);
            pageContact.setSearchResults(data);
        }).fail(function (error) {

        });
    },
    setSearchResults: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageContact.currentPageNo++;
            var searchResultsString = "";
            for (var i = 0; i < data.result.length; i++) {
                var letter = data.result[i].FullName.toUpperCase()[0];
                console.log(letter);
                if (letter != pageContact.searchListLetterIndex) {
                    searchResultsString += "<li class='list-group-item-info li-pad'>" + letter + "</li>";
                    pageContact.searchListLetterIndex = letter;
                    console.log(pageContact.searchListLetterIndex);
                }
                searchResultsString += "<a onclick='pageContact.getContactDetails(" + data.result[i].ContactCode + ")' class='list-group-item contacts_font'>" + data.result[i].FullName + "</a>";
            }
            $("#contactList").append(searchResultsString);
            if (pageContact.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageContact.getSearchResults();'>Load more..</a></div>";
                $("#contactList").append(loadMoreString);
            }

        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#contactList").empty().html(noMoreDataString);
            $("#contactDetailBody").empty();
            $("#editContactBtn").remove();
            $("#deleteContactBtn").remove();
        }
    },
    getContactDetails: function (contactCode) {
        if (contactCode == null)
            return;
        var url = app.websiteRoot + "contacts/getContactDetail.php";

        $.getJSON(url, {
            contactCode: contactCode
        }).done(function (data) {
            pageContact.setContactDetails(data);
        }).fail(function (error) {

        });
    },
    setContactDetails: function (data) {
        if (data.status == 1) {
            pageContact.localContact = data.detail;

            var contactHeaderString = "<h12>Contact Details</h12><button id='editContactBtn' class='btn btn-success pull-right' onclick='pageContact.openEditContactModal();'><span class='glyphicon glyphicon-pencil'></span></button><button id='deleteContactBtn' class='btn btn-danger pull-left' onclick='pageContact.openDeleteContactModal(" + data.detail.contact.ContactCode + ")'><span class='glyphicon glyphicon-trash'></span></button>";
            var contactDetailsString = "";
            var imageURL = "";

            if (window.innerWidth < 992 && !pageContact.firstTime) {
                console.log("width less than 992");

                //Show the Details Header and hides the search header
                $("#searchHeaderDiv").addClass('hidden');
                $("#contactDetailHeaderDiv").removeClass('hidden-xs hidden-sm');

                //Show the contact Details and hides the contact list
                $("#contactListDiv").addClass('hidden');
                $("#contactDetailDiv").removeClass('hidden-xs hidden-sm');

                //Show Hide of menu button with back button
                $(".menu_img").addClass('hidden');
                $("#backButton").removeClass('hidden');

                $("#backButton").click(function () {
                    //Show the contact Details Header and hides the search header
                    $("#contactDetailHeaderDiv").addClass('hidden-xs hidden-sm');
                    $("#searchHeaderDiv").removeClass('hidden');

                    //Show the contact Details and hides the contact list
                    $("#contactListDiv").removeClass('hidden');
                    $("#contactDetailDiv").addClass('hidden-xs hidden-sm');

                    //Show Hide of menu button with back button
                    $(".menu_img").removeClass('hidden');
                    $("#backButton").addClass('hidden');

                });
            }
            pageContact.firstTime = false;
            if (data.detail.contact.ImageURL != null)
                imageURL = app.websiteRoot + "img/getImage.php?file=" + data.detail.contact.ImageURL;
            else
                imageURL = "../img/default/contact/profilePicture.png";

            contactDetailsString += "<div class='row contact-details'><div class='image'><a class='clickable' onclick='pageContact.openProfilePicModal();' class='clickable'><img src='" + imageURL + "' id='imageResource' alt='...' class='img-rounded pull-left img-size'/><div class='overlay img-rounded pull-left'><span class='glyphicon glyphicon-pencil' style='padding-top:10px'></span></div></a></div><div class='header_font'>Name</div><h5 class='list-group-item-heading'>" + ((data.detail.contact.TitleName) ? data.detail.contact.TitleName + " " : "") + ((data.detail.contact.FullName) ? data.detail.contact.FullName : "") + "</h5></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Guardian</div><value><div class='col-md-9'>" + ((data.detail.contact.GuardianName) ? data.detail.contact.GuardianName : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Company</div><value><div class='col-md-9'>" + ((data.detail.contact.Company) ? data.detail.contact.Company : "" ) + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Designation</div><value><div class='col-md-9'>" + ((data.detail.contact.Designation) ? data.detail.contact.Designation : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Alias</div><value><div class='col-md-9'>" + ((data.detail.contact.Alias) ? data.detail.contact.Alias : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.B</div><value><div class='col-md-9'>" + ((data.detail.contact.Dob) ? data.detail.contact.Dob : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>D.O.M</div><value><div class='col-md-9'>" + ((data.detail.contact.Dom) ? data.detail.contact.Dom : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Group</div><value><div class='col-md-9'>" + ((data.detail.contact.GroupName) ? data.detail.contact.GroupName : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Emergency</div><value><div class='col-md-9'>" + ((data.detail.contact.EmergencyName) ? data.detail.contact.EmergencyName : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>" + ((data.detail.contact.Remarks) ? data.detail.contact.Remarks : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Mobile</div><value><div class='col-md-8'>";

            if (data.detail.contact.Mobile1 != null || data.detail.contact.Mobile2 != null || data.detail.contact.Mobile3) {
                if (data.detail.contact.Mobile1 != null)
                    contactDetailsString += data.detail.contact.Mobile1 + "<span class='pull-right' id='mobileSmsIcon'><a href='tel:" + data.detail.contact.Mobile1 + "'><i class='fa fa-phone fa-green fa-lg'></i></a>&nbsp;&nbsp;&nbsp;<a href='sms:" + data.detail.contact.Mobile1 + "'><i class='fa fa-comment fa-green fa-lg'></i></a></span>";
                if (data.detail.contact.Mobile1 != null && data.detail.contact.Mobile2 !== null)
                    contactDetailsString += "<br/>";

                if (data.detail.contact.Mobile1 != null && data.detail.contact.Mobile2 == null && data.detail.contact.Mobile3 !== null)
                    contactDetailsString += "<br/>";

                if (data.detail.contact.Mobile2 != null)
                    contactDetailsString += data.detail.contact.Mobile2 + "<span class='pull-right' id='mobileSmsIcon1'><a href='tel:" + data.detail.contact.Mobile2 + "'><i class='fa fa-phone fa-green fa-lg'></i></a>&nbsp;&nbsp;&nbsp;<a href='sms:" + data.detail.contact.Mobile2 + "'><i class='fa fa-comment fa-green fa-lg'></i></a></span>";

                if (data.detail.contact.Mobile2 != null && data.detail.contact.Mobile3 !== null)
                    contactDetailsString += "<br/>";

                if (data.detail.contact.Mobile3 != null)
                    contactDetailsString += data.detail.contact.Mobile3 + "<span class='pull-right' id='mobileSmsIcon2'><a href='tel:" + data.detail.contact.Mobile3 + "'><i class='fa fa-phone fa-green fa-lg'></i></a>&nbsp;&nbsp;&nbsp;<a href='sms:" + data.detail.contact.Mobile3 + "'><i class='fa fa-comment fa-green fa-lg'></i></a></span>";
            }

            contactDetailsString += "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Email</div><value><div class='col-md-9'>";

            if (data.detail.contact.Email1 != null || data.detail.contact.Email2 != null) {

                if (data.detail.contact.Email1 != null)
                    contactDetailsString += "<a href= 'mailto:" + data.detail.contact.Email1 + "'>" + data.detail.contact.Email1 + "</a>";

                if (data.detail.contact.Email1 != null && data.detail.contact.Email2 != null)
                    contactDetailsString += "<br/>";

                if (data.detail.contact.Email2 != null)
                    contactDetailsString += "<a href= 'mailto:" + data.detail.contact.Email2 + "'>" + data.detail.contact.Email2 + "</a>";
            }

            contactDetailsString += "</div></value></div></div>";

            var homeAddress = "";
            var workAddress = "";
            var otherAddress = "";
            if (data.detail.address) {
                if (data.detail.address.home) {
                    var home = data.detail.address.home;
                    homeAddress += ((home.Address1) ? (home.Address1 + "<br/>") : "");
                    homeAddress += ((home.Address2) ? (home.Address2 + "<br/>") : "");
                    homeAddress += ((home.Address3) ? (home.Address3 + "<br/>") : "");
                    homeAddress += ((home.Address4) ? (home.Address4 + "<br/>") : "");
                    homeAddress += ((home.Address5) ? (home.Address5 + "<br/>") : "");
                    homeAddress += ((home.CityName) ? home.CityName : "");
                    if (home.CityName != null && home.Pincode != null) {
                        homeAddress += " - ";
                    }
                    homeAddress += ((home.Pincode) ? home.Pincode : "");
                    if (home.CityName != null || home.Pincode != null)
                        homeAddress += "<br/>";
                    homeAddress += ((home.AreaName) ? ("(Area) " + home.AreaName + "<br/>") : "");
                }

                if (data.detail.address.work) {
                    var work = data.detail.address.work;
                    workAddress += ((work.Address1) ? (work.Address1 + "<br/>") : "");
                    workAddress += ((work.Address2) ? (work.Address2 + "<br/>") : "");
                    workAddress += ((work.Address3) ? (work.Address3 + "<br/>") : "");
                    workAddress += ((work.Address4) ? (work.Address4 + "<br/>") : "");
                    workAddress += ((work.Address5) ? (work.Address5 + "<br/>") : "");
                    workAddress += ((work.CityName) ? work.CityName : "");
                    if (work.CityName != null && work.Pincode != null) {
                        workAddress += " - ";
                    }
                    workAddress += ((work.Pincode) ? work.Pincode : "");
                    if (work.CityName != null || work.Pincode != null)
                        workAddress += "<br/>";
                    workAddress += ((work.AreaName) ? ("(Area) " + work.AreaName + "<br/>") : "");
                }

                if (data.detail.address.other) {
                    var other = data.detail.address.other;
                    otherAddress += ((other.Address1) ? (other.Address1 + "<br/>") : "");
                    otherAddress += ((other.Address2) ? (other.Address2 + "<br/>") : "");
                    otherAddress += ((other.Address3) ? (other.Address3 + "<br/>") : "");
                    otherAddress += ((other.Address4) ? (other.Address4 + "<br/>") : "");
                    otherAddress += ((other.Address5) ? (other.Address5 + "<br/>") : "");
                    otherAddress += ((other.CityName) ? other.CityName : "");
                    if (other.CityName != null && other.Pincode != null) {
                        otherAddress += " - ";
                    }
                    otherAddress += ((other.Pincode) ? other.Pincode : "");
                    if (other.CityName != null || other.Pincode != null)
                        otherAddress += "<br/>";
                    otherAddress += ((other.AreaName) ? ("(Area) " + other.AreaName + "<br/>") : "");
                }
            }

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Home Address</div><value><div class='col-md-9'>" + homeAddress + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Home Phone</div><value><div class='col-md-9'>" + ((data.detail.contact.HomePhone1) ? (data.detail.contact.HomePhone1 + " ") : "") + "<br/>" + ((data.detail.contact.HomePhone2) ? (data.detail.contact.HomePhone2) : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Work Address</div><value><div class='col-md-9'>" + workAddress + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Work Phone</div><value><div class='col-md-9'>" + ((data.detail.contact.WorkPhone1) ? (data.detail.contact.WorkPhone1 + " ") : "") + "<br/>" + ((data.detail.contact.WorkPhone2) ? (data.detail.contact.WorkPhone2) : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Other Address</div><value><div class='col-md-9'>" + otherAddress + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Other Phone</div><value><div class='col-md-9'>" + ((data.detail.contact.OtherPhone1) ? (data.detail.contact.OtherPhone1 + " ") : "") + "<br/>" + ((data.detail.contact.OtherPhone2) ? (data.detail.contact.OtherPhone2) : "") + "</div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Facebook</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Facebook) ? data.detail.contact.Facebook : "") + "' target='_blank'>" + ((data.detail.contact.Facebook) ? data.detail.contact.Facebook : "") + "</a></div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Twitter</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Twitter) ? data.detail.contact.Twitter : "") + "' target='_blank'>" + ((data.detail.contact.Twitter) ? data.detail.contact.Twitter : "") + "</a></div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Google</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Google) ? data.detail.contact.Google : "") + "' target='_blank'>" + ((data.detail.contact.Google) ? data.detail.contact.Google : "") + "</a></div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Linkedin</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Linkedin) ? data.detail.contact.Linkedin : "") + "' target='_blank'>" + ((data.detail.contact.Linkedin) ? data.detail.contact.Linkedin : "") + "</a></div></value></div></div>";

            contactDetailsString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Website</div><value><div class='col-md-9'><a href='" + ((data.detail.contact.Website) ? data.detail.contact.Website : "") + "' target='_blank'>" + ((data.detail.contact.Website) ? data.detail.contact.Website : "") + "</a></div></value></div></div>";

            $("#contactDetailHeader").empty().html(contactHeaderString);
            $("#contactDetailBody").empty().html(contactDetailsString);

            if (window.innerWidth > 992) {
                //To hide the call & sms icons
                $("#mobileSmsIcon").addClass("hidden");
                $("#mobileSmsIcon1").addClass("hidden");
                $("#mobileSmsIcon2").addClass("hidden");
            }
        } else {
            pageContact.localContact = null;
        }
    },
    getTitleData: function () {
        var url = app.websiteRoot + "contacts/getMasters.php";

        $.getJSON(url, {
            type: 'title'
        }).done(function (titleData) {
            for (var i = 0; i < titleData.length; i++) {
                pageContact.titleTag[i] = titleData[i].TitleName;
                pageContact.titleCode[i] = titleData[i].TitleCode;
            }
            pageContact.setTitleAutoComplete();
        }).fail(function (error) {

        });
    },
    getGroupData: function () {
        var url = app.websiteRoot + "contacts/getMasters.php";

        $.getJSON(url, {
            type: 'group'
        }).done(function (groupData) {
            for (var i = 0; i < groupData.length; i++) {
                pageContact.groupTag[i] = groupData[i].GroupName;
                pageContact.groupCode[i] = groupData[i].GroupCode;
            }
            pageContact.setGroupAutoComplete();
        }).fail(function (error) {

        });
    },
    getEmergencyData: function () {
        var url = app.websiteRoot + "contacts/getMasters.php";

        $.getJSON(url, {
            type: 'emergency'
        }).done(function (emergencyData) {
            for (var i = 0; i < emergencyData.length; i++) {
                pageContact.emergencyTag[i] = emergencyData[i].EmergencyName;
                pageContact.emergencyCode[i] = emergencyData[i].EmergencyCode;
            }
            pageContact.setEmergencyAutoComplete();
        }).fail(function (error) {

        });
    },
    getCountryData: function () {
        var url = app.websiteRoot + "contacts/getMasters.php";

        $.getJSON(url, {
            type: 'country'
        }).done(function (data) {
            pageContact.countryData = data;
            for (var i = 0; i < pageContact.countryData.length; i++) {
                pageContact.countryTag[i] = pageContact.countryData[i].CountryName;
                pageContact.countryCode[i] = pageContact.countryData[i].CountryCode;
            }
            pageContact.setCountryAutoComplete();
        }).fail(function (error) {

        });
    },
    getStateData: function () {
        var url = app.websiteRoot + "contacts/getMasters.php";

        $.getJSON(url, {
            type: 'state'
        }).done(function (data) {
            pageContact.stateData = data;
            for (var i = 0; i < pageContact.stateData.length; i++) {
                pageContact.stateTag[i] = pageContact.stateData[i].StateName;
                pageContact.stateCode[i] = pageContact.stateData[i].StateCode;
            }
            pageContact.setStateAutoComplete();
        }).fail(function (error) {

        });
    },
    getCityData: function () {
        var url = app.websiteRoot + "contacts/getMasters.php";

        $.getJSON(url, {
            type: 'city'
        }).done(function (data) {
            pageContact.cityData = data;
            for (var i = 0; i < pageContact.cityData.length; i++) {
                pageContact.cityTag[i] = pageContact.cityData[i].CityName;
                pageContact.cityCode[i] = pageContact.cityData[i].CityCode;
            }
            pageContact.setCityAutoComplete();
        }).fail(function (error) {

        });
    },
    getAreaData: function () {
        var url = app.websiteRoot + "contacts/getMasters.php";

        $.getJSON(url, {
            type: 'area'
        }).done(function (data) {
            pageContact.areaData = data;
            for (var i = 0; i < pageContact.areaData.length; i++) {
                pageContact.areaTag[i] = pageContact.areaData[i].AreaName;
                pageContact.areaCode[i] = pageContact.areaData[i].AreaCode;
            }
            pageContact.setAreaAutoComplete();
        }).fail(function (error) {

        });
    },
    openAddContactModal: function () {
        document.getElementById("contactForm").reset();

        $('#addPrivacy').attr('checked', false);
        $('#addActiveStatus').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $('#contactModalHeading').empty().html("Add Contact");

        $("#homeState").attr('readonly', false);
        $("#workState").attr('readonly', false);
        $("#otherState").attr('readonly', false);
        $("#homeCountry").attr('readonly', false);
        $("#workCountry").attr('readonly', false);
        $("#otherCountry").attr('readonly', false);

        $(".phoneValidation").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $(".emailValidation").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#addDOB").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#addDOM").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#homePincode").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#workPincode").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#otherPincode").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $('.addMobileDiv').empty();
        pageContact.addBtnMobileCount = 0;
        $('.addEmailDiv').empty();
        pageContact.addBtnEmailCount = 0;
        $('.addHomePhone').empty();
        pageContact.addBtnHomePhoneCount = 0;
        $('.addWorkPhone').empty();
        pageContact.addBtnWorkPhoneCount = 0;
        $('.addOtherPhone').empty();
        pageContact.addBtnOtherPhoneCount = 0;

        $("#contactModal").modal('show');

        // To close the tab pane and to remove the active border

        $(".tab-pane").removeClass('active');
        $("li").removeClass('active');
    },
    openEditContactModal: function () {
        document.getElementById("contactForm").reset();
        $("#form-add-edit-mode").val("M");

        $('#contactModalHeading').empty().html("Edit Contact");

        $('.addMobileDiv').empty();
        pageContact.addBtnMobileCount = 0;
        $('.addEmailDiv').empty();
        pageContact.addBtnEmailCount = 0;
        $('.addHomePhone').empty();
        pageContact.addBtnHomePhoneCount = 0;
        $('.addWorkPhone').empty();
        pageContact.addBtnWorkPhoneCount = 0;
        $('.addOtherPhone').empty();
        pageContact.addBtnOtherPhoneCount = 0;

        $(".phoneValidation").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $(".emailValidation").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#addDOB").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#addDOM").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#homePincode").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#workPincode").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#otherPincode").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $("#form-add-edit-code").val(pageContact.localContact.contact.ContactCode);

        switch (pageContact.localContact.contact.PrivateFlag) {
            case "1":
                $('#addPrivacy').attr('checked', true);
                break;
            case "2":
            default:
                $('#addPrivacy').attr('checked', false);
                break;
        }

        switch (pageContact.localContact.contact.ActiveFlag) {
            case "1":
                $('#addActiveStatus').attr('checked', true);
                break;
            case "2":
            default:
                $('#addActiveStatus').attr('checked', false);
                break;
        }

        if (pageContact.localContact.contact.TitleName) {
            $('#addTitle').val(pageContact.localContact.contact.TitleName);
        }

        if (pageContact.localContact.contact.TitleCode) {
            $('#titleCode').val(pageContact.localContact.contact.TitleCode);
        }

        if (pageContact.localContact.contact.FirstName) {
            $('#addFirstName').val(pageContact.localContact.contact.FirstName);
        }

        if (pageContact.localContact.contact.MiddleName) {
            $('#addMiddleName').val(pageContact.localContact.contact.MiddleName);
        }

        if (pageContact.localContact.contact.LastName) {
            $('#addLastName').val(pageContact.localContact.contact.LastName);
        }

        if (pageContact.localContact.contact.GuardianName) {
            $('#addGuardianName').val(pageContact.localContact.contact.GuardianName);
        }

        if (pageContact.localContact.contact.Company) {
            $('#addCompany').val(pageContact.localContact.contact.Company);
        }

        if (pageContact.localContact.contact.Designation) {
            $('#addDesignation').val(pageContact.localContact.contact.Designation);
        }

        if (pageContact.localContact.contact.Alias) {
            $('#addAlias').val(pageContact.localContact.contact.Alias);
        }

        if (pageContact.localContact.contact.Dob) {
            $('#addDOB').val(pageContact.localContact.contact.Dob);
        }

        if (pageContact.localContact.contact.Dom) {
            $('#addDOM').val(pageContact.localContact.contact.Dom);
        }

        if (pageContact.localContact.contact.GroupName) {
            $('#addGroup').val(pageContact.localContact.contact.GroupName);
        }

        if (pageContact.localContact.contact.GroupCode) {
            $('#groupCode').val(pageContact.localContact.contact.GroupCode);
        }

        if (pageContact.localContact.contact.EmergencyName) {
            $('#addEmergency').val(pageContact.localContact.contact.EmergencyName);
        }

        if (pageContact.localContact.contact.EmergencyCode) {
            $('#emergencyCode').val(pageContact.localContact.contact.EmergencyCode);
        }

        if (pageContact.localContact.contact.Remarks) {
            $('#addRemarks').val(pageContact.localContact.contact.Remarks);
        }

        if (pageContact.localContact.contact.Mobile1) {
            $('#addMobile1').val(pageContact.localContact.contact.Mobile1);
        }

        if (pageContact.localContact.contact.Mobile2 != null || pageContact.localContact.contact.Mobile3 != null) {
            pageContact.addBtnMobileCount++;
            $(".addMobileDiv").append(pageContact.appendMobileString());
            $(".phoneValidation").off().on('input propertychange', function () {
                app.validate(this, 3);
            }).focusout(function () {
                if (this.value.trim() === "") {
                    if (!this.required) {
                        $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                    }
                }
            });

            if (pageContact.localContact.contact.Mobile2) {
                $('#addMobile2').val(pageContact.localContact.contact.Mobile2);
            }

            if (pageContact.localContact.contact.Mobile3) {
                pageContact.addBtnMobileCount++;
                $(".addMobileDiv").append(pageContact.appendMobileString());
                $('#addMobile3').val(pageContact.localContact.contact.Mobile3);
                $(".phoneValidation").off().on('input propertychange', function () {
                    app.validate(this, 3);
                }).focusout(function () {
                    if (this.value.trim() === "") {
                        if (!this.required) {
                            $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                        }
                    }
                });
            }
        }


        if (pageContact.localContact.contact.Email1) {
            $('#addEmail1').val(pageContact.localContact.contact.Email1);
        }

        if (pageContact.localContact.contact.Email2) {
            pageContact.addBtnEmailCount++;
            $(".addEmailDiv").append(pageContact.appendEmailString());
            $('#addEmail2').val(pageContact.localContact.contact.Email2);
            $(".emailValidation").off().on('input propertychange', function () {
                app.validate(this, 2);
            }).focusout(function () {
                if (this.value.trim() === "") {
                    if (!this.required) {
                        $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                    }
                }
            });
        }

        if (pageContact.localContact.contact.Facebook) {
            $('#addFacebook').val(pageContact.localContact.contact.Facebook);
        }

        if (pageContact.localContact.contact.Twitter) {
            $('#addTwitter').val(pageContact.localContact.contact.Twitter);
        }

        if (pageContact.localContact.contact.Google) {
            $('#addGoogle').val(pageContact.localContact.contact.Google);
        }

        if (pageContact.localContact.contact.Linkedin) {
            $('#addLinkedin').val(pageContact.localContact.contact.Linkedin);
        }

        if (pageContact.localContact.contact.Website) {
            $('#addWebsite').val(pageContact.localContact.contact.Website);
        }

        if (pageContact.localContact.contact.HomePhone1) {
            $("#homePhone1").val(pageContact.localContact.contact.HomePhone1);
        }

        if (pageContact.localContact.contact.WorkPhone1) {
            $("#workPhone1").val(pageContact.localContact.contact.WorkPhone1);
        }

        if (pageContact.localContact.contact.OtherPhone1) {
            $("#otherPhone1").val(pageContact.localContact.contact.OtherPhone1);
        }

        if (pageContact.localContact.contact.HomePhone2) {
            pageContact.addBtnHomePhoneCount++;
            $(".addHomePhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='address[home][phone" + (pageContact.addBtnHomePhoneCount + 1) + "]' id='homePhone" + (pageContact.addBtnHomePhoneCount + 1) + "' class='form-control text-field-left-border phoneValidation' placeholder='Other'/><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-home-phone' type='button' onclick='pageContact.removeBtn(this, 2)'><i class='fa fa-minus fa-lg'></i></button></span></div><div class='info'></div></div></div>");
            $("#homePhone2").val(pageContact.localContact.contact.HomePhone2);
            $(".phoneValidation").off().on('input propertychange', function () {
                app.validate(this, 3);
            }).focusout(function () {
                if (this.value.trim() === "") {
                    if (!this.required) {
                        $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                    }
                }
            });
        }

        if (pageContact.localContact.contact.WorkPhone2) {
            pageContact.addBtnWorkPhoneCount++;
            $(".addWorkPhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='address[work][phone" + pageContact.addBtnWorkPhoneCount + "]' id='workPhone" + pageContact.addBtnWorkPhoneCount + "' class='form-control text-field-left-border phoneValidation' placeholder='Other'/><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-work-phone' type='button' onclick='pageContact.removeBtn(this, 3)'><i class='fa fa-minus fa-lg'></i></button></span></div><div class='info'></div></div></div>");
            $("#workPhone2").val(pageContact.localContact.contact.WorkPhone2);
            $(".phoneValidation").off().on('input propertychange', function () {
                app.validate(this, 3);
            }).focusout(function () {
                if (this.value.trim() === "") {
                    if (!this.required) {
                        $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                    }
                }
            });
        }

        if (pageContact.localContact.contact.OtherPhone2) {
            pageContact.addBtnOtherPhoneCount++;
            $(".addOtherPhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='address[other][phone" + pageContact.addBtnOtherPhoneCount + "]' id='otherPhone" + pageContact.addBtnOtherPhoneCount + "' class='form-control text-field-left-border phoneValidation' placeholder='Other'/><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-other-phone' type='button' onclick='pageContact.removeBtn(this, 4)'><i class='fa fa-minus fa-lg'></i></button></span></div><div class='info'></div></div></div>");
            $("#otherPhone2").val(pageContact.localContact.contact.OtherPhone2);
            $(".phoneValidation").off().on('input propertychange', function () {
                app.validate(this, 3);
            }).focusout(function () {
                if (this.value.trim() === "") {
                    if (!this.required) {
                        $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                    }
                }
            });
        }

        if (pageContact.localContact.address) {
            var address = pageContact.localContact.address;
            var type = "";
            if (address.home) {
                type = "home";
                pageContact.createEditAddressData(address, type);
            }

            if (address.work) {
                type = "work";
                pageContact.createEditAddressData(address, type);
            }

            if (address.other) {
                type = "other";
                pageContact.createEditAddressData(address, type);
            }
        }

        $("#contactModal").modal('show');

        // To close the tab pane and to remove the active border

        $(".tab-pane").removeClass('active');
        $("li").removeClass('active');
    },
    appendMobileString: function () {
        var tabIndexCount = 5;
        tabIndexCount++;
        console.log(tabIndexCount);
        return "<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Other</span><input type='text' name='mobile" + (pageContact.addBtnMobileCount + 1) + "' id='addMobile" + (pageContact.addBtnMobileCount + 1) + "' class='form-control text-field-left-border phoneValidation' placeholder='Other Mobile' tabindex='" + tabIndexCount + "'/><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-add-mobile' type='button' onclick='pageContact.removeBtn(this, 0)'><i class='fa fa-minus fa-lg'></i></button></span></div><div class='info'></div></div></div>";
    },
    appendEmailString: function () {
        return "<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Other</span><input type='email' name='email" + (pageContact.addBtnEmailCount + 1) + "' id='addEmail" + (pageContact.addBtnEmailCount + 1) + "' class='form-control text-field-left-border emailValidation' placeholder='Other Email' tabindex='9'/><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-add-email' type='button' onclick='pageContact.removeBtn(this, 1)'><i class='fa fa-minus fa-lg'></i></button></span></div><div class='info'></div></div></div>";
    },
    createEditAddressData: function (address, type) {
        if (address[type].CountryCode) {
            $("#" + type + "Country").val(address[type].CountryName);
            $("#" + type + "CountryCode").val(address[type].CountryCode);
        }

        if (address[type].StateCode) {
            $("#" + type + "State").val(address[type].StateName);
            $("#" + type + "StateCode").val(address[type].StateCode);
        }

        if (address[type].CityCode) {
            $("#" + type + "City").val(address[type].CityName);
            $("#" + type + "CityCode").val(address[type].CityCode);
        }

        if (address[type].AreaCode) {
            $("#" + type + "Area").val(address[type].AreaName);
            $("#" + type + "AreaCode").val(address[type].AreaCode);
        }

        if (address[type].Address1) {
            $("#" + type + "Address1").val(address[type].Address1);
        }

        if (address[type].Address2) {
            $("#" + type + "Address2").val(address[type].Address2);
        }

        if (address[type].Address3) {
            $("#" + type + "Address3").val(address[type].Address3);
        }

        if (address[type].Address4) {
            $("#" + type + "Address4").val(address[type].Address4);
        }

        if (address[type].Address5) {
            $("#" + type + "Address5").val(address[type].Address5);
        }

        if (address[type].Pincode) {
            $("#" + type + "Pincode").val(address[type].Pincode);
        }
    },
    openDeleteContactModal: function (contactCode) {
        $("#form-delete-code").val(contactCode);
        $("#deleteModal").modal('show');
    },
    openProfilePicModal: function () {
        $("#contactUploadProgressBar").width(0 + "%");
        $("#imageModal").modal('show');
    },
    deleteProfilePic: function () {
        var deletePic = confirm("Do you REALLY want to DELETE the Profile Picture?");
        if (deletePic) {
            var url = app.websiteRoot + "contacts/controller.php";

            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");

            $.post(url, {
                contactCode: pageContact.localContact.contact.ContactCode,
                mode: "DI"
            }).done(function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.status == 1) {
                    app.showNotificationSuccess(response.message);
                    pageContact.localContact.contact.ImageURL = null;
                    $("#imageResource").attr("src", "../img/default/contact/profilePicture.png");
                } else {
                    app.showNotificationFailure(response.message);
                }
                $("#imageModal").modal('hide');
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            }).fail(function () {
                app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            });

        } else {
            return;
        }
    },
    setTitleAutoComplete: function () {
        pageContact.setAutoComplete("#addTitle", "#titleCode", pageContact.titleTag, pageContact.titleCode);
    },
    setGroupAutoComplete: function () {
        pageContact.setAutoComplete("#addGroup", "#groupCode", pageContact.groupTag, pageContact.groupCode);
    },
    setEmergencyAutoComplete: function () {
        pageContact.setAutoComplete("#addEmergency", "#emergencyCode", pageContact.emergencyTag, pageContact.emergencyCode);
    },
    setCountryAutoComplete: function () {
        pageContact.setAutoComplete("#homeCountry", "#homeCountryCode", pageContact.countryTag, pageContact.countryCode);
        pageContact.setAutoComplete("#workCountry", "#workCountryCode", pageContact.countryTag, pageContact.countryCode);
        pageContact.setAutoComplete("#otherCountry", "#otherCountryCode", pageContact.countryTag, pageContact.countryCode);
    },
    setStateAutoComplete: function () {
        pageContact.setStateAutoCompleteWithOptions("#homeState", "#homeStateCode", "#homeCountry", "#homeCountryCode");
        pageContact.setStateAutoCompleteWithOptions("#workState", "#workStateCode", "#workCountry", "#workCountryCode");
        pageContact.setStateAutoCompleteWithOptions("#otherState", "#otherStateCode", "#otherCountry", "#otherCountryCode");
    },
    setStateAutoCompleteWithOptions: function (autoCompleteId, changeCodeId, countryId, countryCodeId) {
        $(autoCompleteId).autocomplete({
            source: pageContact.stateTag,
            response: function (event, ui) {
                console.log($(event.target).val());
                var index = $.inArray($(event.target).val(), pageContact.stateTag);
                if (index > -1) {
                    console.log("not selected but value is in array");
                    $(changeCodeId).val(pageContact.stateCode[index]);
                } else {
                    $(countryId).val('');
                    $(countryCodeId).val(0);
                    $(countryId).attr('readonly', false);
                    console.log("Different Value");
                    $(changeCodeId).val(1);
                }
            },
            select: function (event, ui) {
                var index = $.inArray(ui.item.value, pageContact.stateTag);
                var code = pageContact.stateCode[index];
                $(changeCodeId).val(pageContact.stateCode[index]);
                var countryCodeValue = 0;
                for (var i = 0; i < pageContact.stateData.length; i++) {
                    if (pageContact.stateData[i].StateCode == code) {
                        countryCodeValue = pageContact.stateData[i].CountryCode;
                        break;
                    }
                }
                $(countryCodeId).val(countryCodeValue);
                var countryIndex = $.inArray(countryCodeValue, pageContact.countryCode);
                $(countryId).val(pageContact.countryTag[countryIndex]);
                $(countryId).attr('readonly', true);
            }
        });
    },
    setCityAutoComplete: function () {
        pageContact.setCityAutoCompleteWithOptions("#homeCity", "#homeCityCode", "#homeCountry", "#homeCountryCode", "#homeState", "#homeStateCode");
        pageContact.setCityAutoCompleteWithOptions("#workCity", "#workCityCode", "#workCountry", "#workCountryCode", "#workState", "#workStateCode");
        pageContact.setCityAutoCompleteWithOptions("#otherCity", "#otherCityCode", "#otherCountry", "#otherCountryCode", "#otherState", "#otherStateCode");
    },
    setCityAutoCompleteWithOptions: function (autoCompleteId, changeCodeId, countryId, countryCodeId, stateId, stateCodeId) {
        $(autoCompleteId).autocomplete({
            source: pageContact.cityTag,
            response: function (event, ui) {
                console.log($(event.target).val());
                var index = $.inArray($(event.target).val(), pageContact.cityTag);
                if (index > -1) {
                    console.log("not selected but value is in array");
                    $(changeCodeId).val(pageContact.cityCode[index]);
                } else {
                    $(stateId).val('');
                    $(stateCodeId).val(0);
                    $(stateId).attr('readonly', false);
                    $(countryId).val('');
                    $(countryCodeId).val(0);
                    $(countryId).attr('readonly', false);
                    console.log("Different Value");
                    $(changeCodeId).val(1);
                }
            },
            select: function (event, ui) {
                console.log(ui);
                var index = $.inArray(ui.item.value, pageContact.cityTag);
                var code = pageContact.cityCode[index];
                $(changeCodeId).val(pageContact.cityCode[index]);
                var stateCodeValue = 0;
                var countryCodeValue = 0;
                for (var i = 0; i < pageContact.cityData.length; i++) {
                    if (pageContact.cityData[i].CityCode == code) {
                        stateCodeValue = pageContact.cityData[i].StateCode;
                        countryCodeValue = pageContact.cityData[i].CountryCode;
                        break;
                    }
                }
                $(stateCodeId).val(stateCodeValue);
                var stateIndex = $.inArray(stateCodeValue, pageContact.stateCode);
                $(stateId).val(pageContact.stateTag[stateIndex]);
                $(stateId).attr('readonly', true);
                console.log(pageContact.stateTag[stateIndex]);
                $(countryCodeId).val(countryCodeValue);
                var countryIndex = $.inArray(countryCodeValue, pageContact.countryCode);
                $(countryId).val(pageContact.countryTag[countryIndex]);
                $(countryId).attr('readonly', true);
            }
        });
    },
    setAreaAutoComplete: function () {
        pageContact.setAutoComplete("#homeArea", "#homeAreaCode", pageContact.areaTag, pageContact.areaCode);
        pageContact.setAutoComplete("#workArea", "#workAreaCode", pageContact.areaTag, pageContact.areaCode);
        pageContact.setAutoComplete("#otherArea", "#otherAreaCode", pageContact.areaTag, pageContact.areaCode);
    },
    setAutoComplete: function (autoCompleteId, changeCodeId, autoCompleteArray, changeCodeArray) {
        $(autoCompleteId).autocomplete({
            source: autoCompleteArray,
            change: function (event, ui) {
                var index = $.inArray($(event.target).val(), autoCompleteArray);
                if (index > -1) {
                    console.log("not selected but value is in array");
                    $(changeCodeId).val(changeCodeArray[index]);
                } else {
                    console.log("Change triggered");
                    $(changeCodeId).val(1);
                }
            },
            select: function (event, ui) {
                console.log(ui);
                var index = $.inArray(ui.item.value, autoCompleteArray);
                console.log(index);
                $(changeCodeId).val(changeCodeArray[index]);
                console.log($(changeCodeId).val());
            }
        });
    },
    refreshMasterList: function () {
        pageContact.getTitleData();
        pageContact.getGroupData();
        pageContact.getEmergencyData();
        pageContact.getCountryData();
        pageContact.getStateData();
        pageContact.getCityData();
        pageContact.getAreaData();
    },
    showFilters: function () {
        //Function to show hide the filter Option.
        var e = document.getElementById('search_filter');
        if (e.style.display == "block")
            document.getElementById('search_filter').style.display = "none";
        else
            document.getElementById('search_filter').style.display = "block";
    },
    addBtn: function (btnType) {
        /*
         mobile: 0 => 3,
         email: 1 => 2,
         home-phone: 2 => 2,
         work-phone: 3 => 2,
         other-phone: 4 => 2
         */
        switch (btnType) {
            case 0:
                if (pageContact.addBtnMobileCount < 2) {
                    pageContact.addBtnMobileCount++;
                    $(".addMobileDiv").append(pageContact.appendMobileString());
                    $(".phoneValidation").off().on('input propertychange', function () {
                        app.validate(this, 3);
                    }).focusout(function () {
                        if (this.value.trim() === "") {
                            if (!this.required) {
                                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                            }
                        }
                    });
                }
                break;
            case 1:
                if (pageContact.addBtnEmailCount < 1) {
                    pageContact.addBtnEmailCount++;
                    $(".addEmailDiv").append(pageContact.appendEmailString());
                    $(".emailValidation").off().on('input propertychange', function () {
                        app.validate(this, 2);
                    }).focusout(function () {
                        if (this.value.trim() === "") {
                            if (!this.required) {
                                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                            }
                        }
                    });
                }
                break;
            case 2:
                if (pageContact.addBtnHomePhoneCount < 1) {
                    pageContact.addBtnHomePhoneCount++;
                    $(".addHomePhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='address[home][phone" + (pageContact.addBtnHomePhoneCount + 1) + "]' id='homePhone" + (pageContact.addBtnHomePhoneCount + 1) + "' class='form-control text-field-left-border phoneValidation' placeholder='Other' tabindex='39'/><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-home-phone' type='button' onclick='pageContact.removeBtn(this, 2)'><i class='fa fa-minus fa-lg'></i></button></span></div><div class='info'></div></div></div>");
                    $(".phoneValidation").off().on('input propertychange', function () {
                        app.validate(this, 3);
                    }).focusout(function () {
                        if (this.value.trim() === "") {
                            if (!this.required) {
                                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                            }
                        }
                    });
                }
                break;
            case 3:
                if (pageContact.addBtnWorkPhoneCount < 1) {
                    pageContact.addBtnWorkPhoneCount++;
                    $(".addWorkPhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='address[work][phone" + pageContact.addBtnWorkPhoneCount + "]' id='workPhone" + pageContact.addBtnWorkPhoneCount + "' class='form-control text-field-left-border phoneValidation' placeholder='Other'  tabindex='52'/><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-work-phone' type='button' onclick='pageContact.removeBtn(this, 3)'><i class='fa fa-minus fa-lg'></i></button></span></div><div class='info'></div></div></div>");
                    $(".phoneValidation").off().on('input propertychange', function () {
                        app.validate(this, 3);
                    }).focusout(function () {
                        if (this.value.trim() === "") {
                            if (!this.required) {
                                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                            }
                        }
                    });
                }
                break;
            case 4:
                if (pageContact.addBtnOtherPhoneCount < 1) {
                    pageContact.addBtnOtherPhoneCount++;
                    $(".addOtherPhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='address[other][phone" + pageContact.addBtnOtherPhoneCount + "]' id='otherPhone" + pageContact.addBtnOtherPhoneCount + "' class='form-control text-field-left-border phoneValidation' placeholder='Other'  tabindex='64'/><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-other-phone' type='button' onclick='pageContact.removeBtn(this, 4)'><i class='fa fa-minus fa-lg'></i></button></span></div><div class='info'></div></div></div>");
                    $(".phoneValidation").off().on('input propertychange', function () {
                        app.validate(this, 3);
                    }).focusout(function () {
                        if (this.value.trim() === "") {
                            if (!this.required) {
                                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
                            }
                        }
                    });
                }
                break;
        }
    },
    removeBtn: function (btnToRemove, btnType) {
        $(btnToRemove).closest('.addedBtn').remove();
        switch (btnType) {
            case 0:
                pageContact.addBtnMobileCount--;
                break;
            case 1:
                pageContact.addBtnEmailCount--;
                break;
            case 2:
                pageContact.addBtnHomePhoneCount--;
                break;
            case 3:
                pageContact.addBtnWorkPhoneCount--;
                break;
            case 4:
                pageContact.addBtnOtherPhoneCount--;
                break;
        }
    },
    validateContactFormNumber: function (formData) {
        if (formData.value.trim() != "") {
            if (app.validateNumber(formData.value.trim()) === app.numberValidationState.SUCCESS)
                pageContact.isContactFormValid = true;
            else {
                pageContact.isContactFormValid = false;
                return false;
            }
        } else {
            pageContact.isContactFormValid = true;
        }
        return true;
    },
    validateContactFormEmail: function (formData) {
        if (formData.value.trim() != "") {
            if (app.validateEmail(formData.value.trim()) === app.emailValidationState.SUCCESS)
                pageContact.isContactFormValid = true;
            else {
                pageContact.isContactFormValid = false;
                return false;
            }
        } else {
            pageContact.isContactFormValid = true;
        }
        return true;
    },
    validateContactFormDate: function (formData) {
        if (formData.value.trim() != "") {
            if (app.validateDate(formData.value.trim()) === app.dateValidationState.SUCCESS)
                pageContact.isContactFormValid = true;
            else {
                pageContact.isContactFormValid = false;
                return false;
            }
        } else {
            pageContact.isContactFormValid = true;
        }
        return true;
    }
};

$(document).ready(function (event) {
    app.websiteRoot = "../";
    app.getLoginDetails();

    document.getElementById('searchBox').onkeypress = function (e) {
        if (!e)
            e = window.event;
        console.log(e);
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13') {
            // Enter pressed
            pageContact.doSearch();
        }
    };

    $.when(pageContact.defContactList).done(function (data) {
        if (data.status == 1)
            pageContact.getContactDetails(data.result[0].ContactCode);
    });

    pageContact.getContactList(false);
    pageContact.refreshMasterList();


    $('#filter').change(function () {
        if ($(this).val() != "0") {
            $('#search_filter').hide();
        }
    });

    //To open and close the tab on click over it again

    $('#myTab a').click(function (e) {
        var tab = $(this);
        if (tab.parent('li').hasClass('active')) {
            window.setTimeout(function () {
                $(".tab-pane").removeClass('active');
                tab.parent('li').removeClass('active');
            }, 1);
        }
    });

    $('#imgInput').change(function () {
        var image = this.files[0];
        if ((image.size || image.fileSize) < 1 * 1000 * 1000) {
            console.log(image);
            var img = $("#imagePreview");
            var reader = new FileReader();
            reader.onloadend = function () {
                img.attr("src", reader.result);
            };
            reader.readAsDataURL(image);
            $("#imageErrorMsg").html("");
        } else {
            $("#imageErrorMsg").html("Image size is greater than 1MB");
            document.getElementById("profileForm").reset();
        }
    });

    $('#imageModal').on('show.bs.modal', function () {
        document.getElementById("profileForm").reset();
        $("#imageErrorMsg").html("");
        $('#photoId').val(pageContact.localContact.contact.ContactCode);
        if (pageContact.localContact.contact.ImageURL) {
            $("#imagePreview").attr("src", app.websiteRoot + "img/getImage.php?file=" + pageContact.localContact.contact.ImageURL);
            $("#deleteImageBtn").removeClass("hidden");
        } else {
            $("#imagePreview").attr("src", "../img/default/contact/profilePicture.png");
            $("#deleteImageBtn").addClass("hidden");
        }
    });

    $("#profileForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            for (var i = 0; i < formData.length; i++) {
                console.log(formData[i]);
                if (formData[i].name == "fileToUpload") {
                    if (formData[i].value == "") {
                        app.showNotificationFailure("No Image Selected");
                        return false;
                    }
                }
            }
            $("#contactUploadProgress").removeClass("hidden");
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $("#contactUploadProgressBar").width(percentComplete + "%");
            $("#contactUploadProgressValue").html(percentComplete + "% complete");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                $("#imageModal").modal('hide');
                $("#imageResource").attr("src", app.websiteRoot + "img/getImage.php?file=" + response.location + "&rand=" + new Date().getTime());
                pageContact.localContact.contact.ImageURL = response.location;
                $("#contactUploadProgress").addClass("hidden");
            } else {
                app.showNotificationFailure(response.message);
                $("#contactUploadProgress").addClass("hidden");
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#contactUploadProgress").addClass("hidden");
        }
    });

    $('#contactModal').on('shown.bs.modal', function () {
        if (window.innerWidth > 992) {
            $('#addTitle').focus();
        }
    });

    $("#deleteContactForm").ajaxForm({
        beforeSubmit: function (formData, $form, options) {
            console.log(formData);
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            console.log(response);
            if (response.status == 1) {
                setTimeout(function () {
                    pageContact.currentPageNo = 1;
                    $("#contactList").empty();
                    $("#contactDetailBody").empty();
                    $("#editContactBtn").remove();
                    $("#deleteContactBtn").remove();
                    app.showNotificationSuccess(response.message);
                    pageContact.getContactList(false);
                    pageContact.getContactDetails(response.landing);
                    $("#deleteModal").modal('hide');
                }, 500);
            } else {
                app.showNotificationFailure(response.message);
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $('#deleteModal').on('hidden.bs.modal', function (e) {
        $("#pageLoading").removeClass("loader");
        $(".cover").fadeOut(100);
    });

    $("#contactForm").ajaxForm({
        beforeSubmit: function (formData, $form, options) {
            console.log(formData);
            pageContact.isContactFormValid = false;
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    app.showNotificationFailure("Required fields are empty");
                    return false;
                }
                if (formData[i].name === "mobile1") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "mobile2") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "mobile3") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "email1") {
                    formData[i].value = formData[i].value.toLowerCase();
                    if (pageContact.validateContactFormEmail(formData[i]) === false)
                        break;
                } else if (formData[i].name === "email2") {
                    formData[i].value = formData[i].value.toLowerCase();
                    if (pageContact.validateContactFormEmail(formData[i]) === false)
                        break;
                } else if (formData[i].name === "dob") {
                    if (pageContact.validateContactFormDate(formData[i]) === false)
                        break;
                } else if (formData[i].name === "dom") {
                    if (pageContact.validateContactFormDate(formData[i]) === false)
                        break;
                } else if (formData[i].name === "address[home][pincode]") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "address[home][phone1]") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "address[home][phone2]") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "address[work][pincode]") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "address[work][phone1]") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "address[work][phone2]") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "address[other][pincode]") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "address[other][phone1]") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                } else if (formData[i].name === "address[other][phone2]") {
                    if (pageContact.validateContactFormNumber(formData[i]) === false)
                        break;
                }
            }
            if ($("#homeCity").val().trim() != "") {
                // If city has a value then state and country also should
                if ($("#homeState").val().trim() == "") {
                    app.showNotificationFailure("The \"Home\" state field is empty");
                    return false;
                } else if ($("#homeCountry").val().trim() == "") {
                    app.showNotificationFailure("The \"Home\" country field is empty");
                    return false;
                }
            } else if ($("#homeState").val().trim() != "") {
                // If city does not have a value check if state has a value
                // If state does then country should also
                if ($("#homeCountry").val().trim() == "") {
                    app.showNotificationFailure("The \"Home\" country field is empty");
                    return false;
                }
            }

            if ($("#workCity").val().trim() != "") {
                // If city has a value then state and country also should
                if ($("#workState").val().trim() == "") {
                    app.showNotificationFailure("The \"Work\" state field is empty");
                    return false;
                } else if ($("#workCountry").val().trim() == "") {
                    app.showNotificationFailure("The \"Work\" country field is empty");
                    return false;
                }
            } else if ($("#workState").val().trim() != "") {
                // If city does not have a value check if state has a value
                // If state does then country should also
                if ($("#workCountry").val().trim() == "") {
                    app.showNotificationFailure("The \"Work\" country field is empty");
                    return false;
                }
            }

            if ($("#otherCity").val().trim() != "") {
                // If city has a value then state and country also should
                if ($("#otherState").val().trim() == "") {
                    app.showNotificationFailure("The \"Other\" state field is empty");
                    return false;
                } else if ($("#otherCountry").val().trim() == "") {
                    app.showNotificationFailure("The \"Other\" country field is empty");
                    return false;
                }
            } else if ($("#otherState").val().trim() != "") {
                // If city does not have a value check if state has a value
                // If state does then country should also
                if ($("#otherCountry").val().trim() == "") {
                    app.showNotificationFailure("The \"Other\" country field is empty");
                    return false;
                }
            }

            console.log(pageContact.isContactFormValid);
            if (!pageContact.isContactFormValid) {
                app.showNotificationFailure("Validation Failed for some input field");
                return false;
            }
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            console.log(response);
            console.log(response.status);
            if (response.status == 1) {
                setTimeout(function () {
                    pageContact.currentPageNo = 1;
                    $("#contactList").empty();
                    $("#contactDetailBody").empty();
                    $("#editContactBtn").remove();
                    $("#deleteContactBtn").remove();
                    pageContact.getContactDetails(response.landing);
                    pageContact.getContactList(false);
                    app.showNotificationSuccess(response.message);
                    pageContact.refreshMasterList();
                    $("#contactModal").modal('hide');
                }, 500);
            } else {
                app.showNotificationFailure(response.message);
                $("#pageLoading").removeClass("loader");
                $(".cover").fadeOut(100);
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    //remove loading cover after modal closes
    $('#contactModal').on('hidden.bs.modal', function (e) {
        $("#pageLoading").removeClass("loader");
        $(".cover").fadeOut(100);
    });

    $("#searchBox").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#contactList").empty();
            pageContact.currentPageNo = 1;
            pageContact.firstTime = true;
            pageContact.defContactList = $.Deferred();
            pageContact.getContactList(false);
            $.when(pageContact.defContactList).done(function (data) {
                if (data.status == 1)
                    pageContact.getContactDetails(data.result[0].ContactCode);
            });
        }
    });

    $(".phoneValidation").off().on('input propertychange', function () {
        app.validate(this, 3);
    }).focusout(function () {
        if (this.value.trim() === "") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $(".emailValidation").off().on('input propertychange', function () {
        app.validate(this, 2);
    }).focusout(function () {
        if (this.value.trim() === "") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#addDOB").focusin(function () {
        if (this.value.indexOf('_') > -1) {
            this.value = "";
        }
    }).focusout(function () {
        app.validate(this, 1);
        if (this.value.trim() === "" || this.value.trim() === "__/__/____") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#addDOM").focusin(function () {
        if (this.value.indexOf('_') > -1) {
            this.value = "";
        }
    }).focusout(function () {
        app.validate(this, 1);
        if (this.value.trim() === "" || this.value.trim() === "__/__/____") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#homePincode").on('input propertychange', function () {
        app.validate(this, 3);
    }).focusout(function () {
        if (this.value.trim() === "") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#workPincode").on('input propertychange', function () {
        app.validate(this, 3);
    }).focusout(function () {
        if (this.value.trim() === "") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#otherPincode").on('input propertychange', function () {
        app.validate(this, 3);
    }).focusout(function () {
        if (this.value.trim() === "") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#homeCity").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#homeState").val('');
            $("#homeStateCode").val(0);
            $("#homeState").attr('readonly', false);
            $("#homeCountry").val('');
            $("#homeCountryCode").val(0);
            $("#homeCountry").attr('readonly', false);
        }
    });

    $("#homeState").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#homeCountry").val('');
            $("#homeCountryCode").val(0);
            $("#homeCountry").attr('readonly', false);
        }
    });

    $("#workCity").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#workState").val('');
            $("#workStateCode").val(0);
            $("#workState").attr('readonly', false);
            $("#workCountry").val('');
            $("#workCountryCode").val(0);
            $("#workCountry").attr('readonly', false);
        }
    });

    $("#workState").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#workCountry").val('');
            $("#workCountryCode").val(0);
            $("#workCountry").attr('readonly', false);
        }
    });

    $("#otherCity").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#otherState").val('');
            $("#otherStateCode").val(0);
            $("#otherState").attr('readonly', false);
            $("#otherCountry").val('');
            $("#otherCountryCode").val(0);
            $("#otherCountry").attr('readonly', false);
        }
    });

    $("#otherState").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#otherCountry").val('');
            $("#otherCountryCode").val(0);
            $("#otherCountry").attr('readonly', false);
        }
    });

    if (window.innerWidth < 992) {
        $("body").css("overflow", "auto");
        $("#contactListScroll").removeClass("panelHeight");
        $("#contactList").addClass("mobile-list");
        $("#contactListDiv").addClass("mobileBody");
        $("#searchHeaderDiv").addClass("mobileHeader");

        $("#contactDetail").removeClass("panelHeight");
        $("#contactDetailDiv").addClass("mobileBody");
        $("#contactDetailHeaderDiv").addClass("mobileHeader");
    }
    document.getElementById("imgInput").onchange = function () {
        var path = this.value;
        var filename = path.replace(/^.*\\/, "");
        document.getElementById("imgInputPath").value = filename;
    };
});
$(window).resize(function () {
    if (window.innerWidth < 992) {

        $("body").css("overflow", "auto");
        $("#contactListScroll").removeClass("panelHeight");
        $("#contactList").addClass("mobile-list");
        $("#contactListDiv").addClass("mobileBody");
        $("#searchHeaderDiv").addClass("mobileHeader");

        $("#contactDetail").removeClass("panelHeight");
        $("#contactDetailDiv").addClass("mobileBody");
        $("#contactDetailHeaderDiv").addClass("mobileHeader");

        //To hide the call & sms icons
        $("#mobileSmsIcon").removeClass("hidden");
        $("#mobileSmsIcon1").removeClass("hidden");
        $("#mobileSmsIcon2").removeClass("hidden");
    } else {
        $("body").css("overflow", "hidden");
        $("#contactListScroll").addClass("panelHeight");
        $("#contactList").removeClass("mobile-list");
        $("#contactListDiv").removeClass("mobileBody");
        $("#searchHeaderDiv").removeClass("mobileHeader");

        $("#contactDetail").addClass("panelHeight");
        $("#contactDetailDiv").removeClass("mobileBody");
        $("#contactDetailHeaderDiv").removeClass("mobileHeader");

        //Show the contact Details Header and hides the search header
        $("#contactDetailHeaderDiv").addClass('hidden-xs hidden-sm');
        $("#searchHeaderDiv").removeClass('hidden');

        //Show the contact Details and hides the contact list
        $("#contactListDiv").removeClass('hidden');
        $("#contactDetailDiv").addClass('hidden-xs hidden-sm');

        //Show Hide of menu button with back button
        $(".menu_img").removeClass('hidden');
        $("#backButton").addClass('hidden');

        //To show the call & sms icons
        $("#mobileSmsIcon").addClass("hidden");
        $("#mobileSmsIcon1").addClass("hidden");
        $("#mobileSmsIcon2").addClass("hidden");
    }
});