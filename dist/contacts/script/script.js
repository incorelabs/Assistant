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
        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(0);

        $('#contactModalHeading').empty();
        $('#contactModalHeading').html("Add Contact");

        $('.addMobileDiv').empty();
        this.addBtnMobileCount = 0;
        $('.addEmailDiv').empty();
        this.addBtnEmailCount = 0;
        $('.addHomePhone').empty();
        this.addBtnHomePhoneCount = 0;
        $('.addWorkPhone').empty();
        this.addBtnWorkPhoneCount = 0;
        $('.addOtherPhone').empty();
        this.addBtnOtherPhoneCount = 0;
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

        $("#form-add-edit-code").val(this.localContact.contact.ContactCode);

        if (this.localContact.contact.TitleName) {
            $('#addTitle').val(this.localContact.contact.TitleName);
        }

        if (this.localContact.contact.TitleCode) {
            $('#titleId').val(this.localContact.contact.TitleCode);
        }

        if (this.localContact.contact.FirstName) {
            $('#addFirstName').val(this.localContact.contact.FirstName);
        }

        if (this.localContact.contact.MiddleName) {
            $('#addMiddleName').val(this.localContact.contact.MiddleName);
        }

        if (this.localContact.contact.LastName) {
            $('#addLastName').val(this.localContact.contact.LastName);
        }

        if (this.localContact.contact.GuardianName) {
            $('#addGuardianName').val(this.localContact.contact.GuardianName);
        }

        if (this.localContact.contact.Company) {
            $('#addCompany').val(this.localContact.contact.Company);
        }

        if (this.localContact.contact.Designation) {
            $('#addDesignation').val(this.localContact.contact.Designation);
        }

        if (this.localContact.contact.Alias) {
            $('#addAlias').val(this.localContact.contact.Alias);
        }

        if (this.localContact.contact.Dob) {
            $('#addDOB').val(this.localContact.contact.Dob);
        }

        if (this.localContact.contact.Dom) {
            $('#addDOM').val(this.localContact.contact.Dom);
        }

        if (this.localContact.contact.GroupName) {
            $('#addGroup').val(this.localContact.contact.GroupName);
        }

        if (this.localContact.contact.GroupCode) {
            $('#groupId').val(this.localContact.contact.GroupCode);
        }

        if (this.localContact.contact.Remarks) {
            $('#addRemarks').val(this.localContact.contact.Remarks);
        }

        if (this.localContact.contact.Mobile1) {
            $('#addMobile1').val(this.localContact.contact.Mobile1);
        }

        if (this.localContact.contact.Mobile2) {
            $('#addMobile2').val(this.localContact.contact.Mobile2);
        }

        if (this.localContact.contact.Mobile3) {
            $('#addMobile3').val(this.localContact.contact.Mobile3);
        }

        if (this.localContact.contact.Email1) {
            $('#addEmail1').val(this.localContact.contact.Email1);
        }

        if (this.localContact.contact.Email2) {
            $('#addEmail2').val(this.localContact.contact.Email2);
        }

        if (this.localContact.contact.Facebook) {
            $('#addFacebook').val(this.localContact.contact.Facebook);
        }

        if (this.localContact.contact.Twitter) {
            $('#addTwitter').val(this.localContact.contact.Twitter);
        }

        if (this.localContact.contact.Google) {
            $('#addGoogle').val(this.localContact.contact.Google);
        }

        if (this.localContact.contact.Linkedin) {
            $('#addLinkedin').val(this.localContact.contact.Linkedin);
        }

        if (this.localContact.contact.Website) {
            $('#addWebsite').val(this.localContact.contact.Website);
        }

        if (this.localContact.address) {
            var address = this.localContact.address;
            var type = "";
            if (address.home) {
                type = "home";
                this.createEditAddressData(address, type);
            }

            if (address.work) {
                type = "work";
                this.createEditAddressData(address, type);
            }

            if (address.other) {
                type = "other";
                this.createEditAddressData(address, type);
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
                if (this.addBtnMobileCount < 2) {
                    $(".addMobileDiv").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Other</span><input type='text' name='' id='' class='form-control text-field-left-border' placeholder='Other Mobile' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-add-mobile' type='button' onclick='pageContact.removeBtn(this, 0)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
                    this.addBtnMobileCount++;
                }
                break;
            case 1:
                if (this.addBtnEmailCount < 1) {
                    $(".addEmailDiv").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Other</span><input type='email' name='' id='' class='form-control text-field-left-border' placeholder='Other Email' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-add-email' type='button' onclick='pageContact.removeBtn(this, 1)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
                    this.addBtnEmailCount++;
                }
                break;
            case 2:
                if (this.addBtnHomePhoneCount < 1) {
                    $(".addHomePhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='' id='' class='form-control text-field-left-border' placeholder='Other' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-home-phone' type='button' onclick='pageContact.removeBtn(this, 2)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
                    this.addBtnHomePhoneCount++;
                }
                break;
            case 3:
                if (this.addBtnWorkPhoneCount < 1) {
                    $(".addWorkPhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='' id='' class='form-control text-field-left-border' placeholder='Other' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-work-phone' type='button' onclick='pageContact.removeBtn(this, 3)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
                    this.addBtnWorkPhoneCount++;
                }
                break;
            case 4:
                if (this.addBtnOtherPhoneCount < 1) {
                    $(".addOtherPhone").append("<div class='addedBtn'><div class='form-group form-group-margin'><div class='input-group'><span class='input-group-addon input-group-addon-label'>Phone</span><input type='text' name='' id='' class='form-control text-field-left-border' placeholder='Other' /><span class='input-group-btn'><button class='btn btn-danger button-addon-custom btn-other-phone' type='button' onclick='pageContact.removeBtn(this, 4)'><i class='fa fa-minus fa-lg'></i></button></span></div></div></div>");
                    this.addBtnOtherPhoneCount++;
                }
                break;
        }
    },
    removeBtn: function (btnToRemove, btnType) {
        $(btnToRemove).closest('.addedBtn').remove();
        switch (btnType) {
            case 0:
                this.addBtnMobileCount--;
                break;
            case 1:
                this.addBtnEmailCount--;
                break;
            case 2:
                this.addBtnHomePhoneCount--;
                break;
            case 3:
                this.addBtnWorkPhoneCount--;
                break;
            case 4:
                this.addBtnOtherPhoneCount--;
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
});