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
    addBtnMobileCount: 0,
    addBtnEmailCount: 0,
    addBtnHomePhoneCount: 0,
    addBtnWorkPhoneCount: 0,
    addBtnOtherPhoneCount: 0,
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
                var letter = data.result[i].FullName.toUpperCase()[0];
                console.log(letter);
                if (letter != letterIndex) {
                    str += "<li class='list-group-item-info li-pad'>" + letter + "</li>";
                    letterIndex = letter;
                    console.log(letterIndex);
                }
                str += "<a onclick='pageContact.getContactDetails(" + data.result[i].ContactCode + ")' class='list-group-item contacts_font'><h4 class='list-group-item-heading contacts_font'>" + data.result[i].FullName + "</h4></a>";
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
    doSearch: function () {
        pageContact.currentPageNo = 1;
        $("#contactList").empty();
        pageContact.getSearchResults();
    },
    getSearchResults: function () {
        var url = "ContactList.php";

        $.getJSON(url, {
            pageNo: pageContact.currentPageNo,
            searchType: $('#filter').val(),
            searchText: $('#searchBox').val()
        }).done(function (data) {
            console.log(data);

            console.log(pageContact.currentPageNo);
            pageContact.setSearchResults(data);
        }).fail(function (error) {

        });
    },
    setSearchResults: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageContact.currentPageNo++;
            var letterIndex = "";
            var str = "";
            for (var i = 0; i < data.result.length; i++) {
                var letter = data.result[i].FullName.toUpperCase()[0];
                console.log(letter);
                if (letter != letterIndex) {
                    str += "<li class='list-group-item-info li-pad'>" + letter + "</li>";
                    letterIndex = letter;
                    console.log(letterIndex);
                }
                str += "<a onclick='pageContact.getContactDetails(" + data.result[i].ContactCode + ")' class='list-group-item contacts_font'><h4 class='list-group-item-heading contacts_font'>" + data.result[i].FullName + "</h4></a>";
            }
            //$("#contactList").empty();
            $("#contactList").append(str);
            console.log(str);
            // Print on screen
            console.log(data.result);
            if (pageContact.currentPageNo <= data.pages) {
                // Show Load More
                var str = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageContact.getSearchResults();'>Load more..</a></div>";
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
            pageContact.localContact = data.detail;
            var headerStr = "<h12>Contact Details</h12><button class='btn btn-success pull-right' onclick='pageContact.openEditContact();'><span class='glyphicon glyphicon-pencil'></span></button><button class='btn btn-danger pull-left' onclick='pageContact.openDeleteModal(" + data.detail.contact.ContactCode + ")'><span class='glyphicon glyphicon-trash'></span></button>";
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
            pageContact.localContact = null;
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
    openAddContact: function () {
        document.getElementById("contactForm").reset();
        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(0);

        $('#contactModalHeading').empty();
        $('#contactModalHeading').html("Add Contact");

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
    openEditContact: function () {
        document.getElementById("contactForm").reset();
        $("#form-add-edit-mode").val("M");

        $('#contactModalHeading').empty();
        $('#contactModalHeading').html("Edit Contact");

        $("#form-add-edit-code").val(pageContact.localContact.contact.ContactCode);

        if (pageContact.localContact.contact.TitleName) {
            $('#addTitle').val(pageContact.localContact.contact.TitleName);
        }

        if (pageContact.localContact.contact.TitleCode) {
            $('#titleId').val(pageContact.localContact.contact.TitleCode);
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
            $('#groupId').val(pageContact.localContact.contact.GroupCode);
        }

        if (pageContact.localContact.contact.Remarks) {
            $('#addRemarks').val(pageContact.localContact.contact.Remarks);
        }

        if (pageContact.localContact.contact.Mobile1) {
            $('#addMobile1').val(pageContact.localContact.contact.Mobile1);
        }

        if (pageContact.localContact.contact.Mobile2) {
            $('#addMobile2').val(pageContact.localContact.contact.Mobile2);
        }

        if (pageContact.localContact.contact.Mobile3) {
            $('#addMobile3').val(pageContact.localContact.contact.Mobile3);
        }

        if (pageContact.localContact.contact.Email1) {
            $('#addEmail1').val(pageContact.localContact.contact.Email1);
        }

        if (pageContact.localContact.contact.Email2) {
            $('#addEmail2').val(pageContact.localContact.contact.Email2);
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
    },
    createEditAddressData: function (address, type) {

    },
    openDeleteModal: function (contactCode) {
        $("#form-delete-code").val(contactCode);
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
        pageContact.getTitles();
        pageContact.getGroups();
        pageContact.getCountry();
        pageContact.getStates();
        pageContact.getCities();
        pageContact.getAreas();
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
                    $(".addMobileDiv").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Other</span><input type='text' name='mobile"+(pageContact.addBtnMobileCount+1)+"' id='addMobile"+(pageContact.addBtnMobileCount+1)+"' class='form-control text-field-left-border' placeholder='Other Mobile' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-add-mobile' type='button' onclick='pageContact.removeBtn(this, 0)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
                }
                break;
            case 1:
                if (pageContact.addBtnEmailCount < 1) {
                    pageContact.addBtnEmailCount++;
                    $(".addEmailDiv").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Other</span><input type='email' name='email"+(pageContact.addBtnEmailCount+1)+"' id='addEmail"+(pageContact.addBtnEmailCount+1)+"' class='form-control text-field-left-border' placeholder='Other Email' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-add-email' type='button' onclick='pageContact.removeBtn(this, 1)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
                }
                break;
            case 2:
                if (pageContact.addBtnHomePhoneCount < 1) {
                    pageContact.addBtnHomePhoneCount++;
                    $(".addHomePhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='address[home][phone"+(pageContact.addBtnHomePhoneCount+1)+"]' id='homePhone"+(pageContact.addBtnHomePhoneCount+1)+"' class='form-control text-field-left-border' placeholder='Other' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-home-phone' type='button' onclick='pageContact.removeBtn(this, 2)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
                }
                break;
            case 3:
                if (pageContact.addBtnWorkPhoneCount < 1) {
                    pageContact.addBtnWorkPhoneCount++;
                    $(".addWorkPhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='address[work][phone"+pageContact.addBtnWorkPhoneCount+"]' id='workPhone"+pageContact.addBtnWorkPhoneCount+"' class='form-control text-field-left-border' placeholder='Other' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-work-phone' type='button' onclick='pageContact.removeBtn(this, 3)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
                }
                break;
            case 4:
                if (pageContact.addBtnOtherPhoneCount < 1) {
                    pageContact.addBtnOtherPhoneCount++;
                    $(".addOtherPhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='address[other][phone"+pageContact.addBtnOtherPhoneCount+"]' id='otherPhone"+pageContact.addBtnOtherPhoneCount+"' class='form-control text-field-left-border' placeholder='Other' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-other-phone' type='button' onclick='pageContact.removeBtn(this, 4)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
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
    }
};

$(document).ready(function (event) {
    pageContact.getContactList();

    $('#filter').change(function () {
        if ($(this).val() != "0") {
            $('#search_filter').hide();
        }
    });

    $('#imgInp').change(function () {
        var image = this.files[0];
        if ((image.size || image.fileSize) < 1 * 1000 * 1000) {
            console.log(image);
            var img = $("#imagepreview");
            var reader = new FileReader();
            reader.onloadend = function () {
                //img.src = reader.result;
                img.attr("src", reader.result);
            }
            reader.readAsDataURL(image);
            $("#imageErrorMsg").html("");
        }
        else {
            $("#imageErrorMsg").html("Image size is greater than 1MB");
            document.getElementById("profileForm").reset();
        }
    });

    $('#imageModal').on('show.bs.modal', function () {
        document.getElementById("profileForm").reset();
        $('#photoId').val(pageContact.localContact.contact.ContactCode);
        if (pageContact.localContact.contact.ImageURL) {
            $("#imagepreview").attr("src", pageContact.localContact.contact.ImageURL);
        }
        else {
            $("#imagepreview").attr("src", "../img/contacts/profile/profilePicture1.png");
        }
    });

    $("#profileForm").ajaxForm({
        beforeSubmit: function () {
            $(".progress").show();
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $(".progress-bar").width(percentComplete + "%");
            $("#progressValue").html(percentComplete + "% complete");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                $("#imageModal").modal('hide');
                $("#imageresource").attr("src", response.location);
                pageContact.localContact.contact.ImageURL = response.location;
                $(".progress").hide();
            }
        }
    });

    $("#deleteContact").ajaxForm({
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                showNotificationSuccess(response.message);
                getContact(response.landing);
                getContactList();
                $("#deleteModal").modal('hide');
            }
            else {
                showNotificationFailure(response.message);
            }
        }
    });

    $("#contactForm").ajaxForm({
        beforeSubmit: function (arr, $form, options) {
            console.log(arr);
            // The array of form data takes the following form:
            // [ { name: 'username', value: 'jresig' }, { name: 'password', value: 'secret' } ]

            // return false to cancel submit
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);

        }
    });
});