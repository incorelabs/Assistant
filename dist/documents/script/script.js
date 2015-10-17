var pageDocument = {
    currentPageNo: 1,
    localDocument: null,
    defDocumentList: $.Deferred(),
    defSearchResult: $.Deferred(),
    defImageList: $.Deferred(),
    documentTypeTag: [],
    documentTypeCode: [],
    issuedByTag: [],
    issuedByCode: [],
    locationTag: [],
    locationCode: [],
    familyList: null,
    documentList: null,
    firstTime: true,
    uploadImageList: [],
    imageDataList: [],
    displayImageList: null,
    currentSerialNo: null,
    getFamilyList: function () {
        var url = app.websiteRoot + "family/getFamily.php";

        $.getJSON(url, {
            list: 2
        }).done(function (data) {
            pageDocument.setFamilyList(data);
        }).fail(function (error) {

        });
    },
    setFamilyList: function (data) {
        pageDocument.familyList = data;
        var familyListString = "";
        for (var i = 0; i < data.length; i++) {
            if (data[i].FamilyCode == familyCode) {
                familyListString += "<option value = " + data[i].FamilyCode + " selected = 'selected'>" + data[i].FamilyName + "</option>";
            }
            else {
                familyListString += "<option value = " + data[i].FamilyCode + ">" + data[i].FamilyName + "</option>";
            }
        }
        $("#holderCode").html(familyListString);
    },
    getDocumentList: function () {
        var url = app.websiteRoot + "documents/getDocumentList.php";

        $.getJSON(url, {
            pageNo: pageDocument.currentPageNo
        }).done(function (data) {
            console.log(data);
            pageDocument.defDocumentList.resolve(data);
            pageDocument.setDocumentList(data);
        }).fail(function (error) {

        });
    },
    setDocumentList: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageDocument.currentPageNo++;
            var documentListString = "";
            for (var i = 0; i < data.result.length; i++) {
                documentListString += "<a onclick='pageDocument.getDocumentDetails(" + data.result[i].DocumentCode + ")' class='list-group-item contacts_font'>" + data.result[i].HolderName + " - " + data.result[i].DocumentName + "</a>";
            }
            $("#documentList").append(documentListString);
            if (pageDocument.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageDocument.getDocumentList();'>Load more..</a></div>";
                $("#documentList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#documentList").empty().html(noMoreDataString);
        }
    },
    doSearch: function () {
        $("#documentList").empty();
        pageDocument.currentPageNo = 1;
        pageDocument.firstTime = true;
        pageDocument.defSearchResult = $.Deferred();
        pageDocument.getSearchResults();
        $.when(pageDocument.defSearchResult).done(function (data) {
            if (data.status == 1)
                pageDocument.getDocumentDetails(data.result[0].DocumentCode);
        });
    },
    getSearchResults: function () {
        var url = app.websiteRoot + "documents/getDocumentList.php";

        $.getJSON(url, {
            pageNo: pageDocument.currentPageNo,
            searchType: 1,
            searchText: $('#searchBox').val().trim()
        }).done(function (data) {
            pageDocument.defSearchResult.resolve(data);
            pageDocument.setSearchResults(data);
        }).fail(function (error) {

        });
    },
    setSearchResults: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageDocument.currentPageNo++;
            var searchResultsString = "";
            for (var i = 0; i < data.result.length; i++) {
                searchResultsString += "<a onclick='pageDocument.getDocumentDetails(" + data.result[i].DocumentCode + ")' class='list-group-item contacts_font'>" + data.result[i].HolderName + " - " + data.result[i].DocumentName + "</a>";
            }
            $("#documentList").append(searchResultsString);
            if (pageDocument.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageDocument.getSearchResults();'>Load more..</a></div>";
                $("#documentList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#documentList").empty().html(noMoreDataString);
            $("#documentDetailBody").empty();
            $("#editDocumentBtn").remove();
            $("#deleteDocumentBtn").remove();
        }
    },
    getDocumentDetails: function (documentCode) {
        if (documentCode == null)
            return;
        var url = app.websiteRoot + "documents/getDocumentDetail.php";

        $.getJSON(url, {
            documentCode: documentCode
        }).done(function (data) {
            pageDocument.displayImageList = null;
            console.log(data);
            pageDocument.setDocumentDetails(data);
        }).fail(function (error) {

        });
    },
    setDocumentDetails: function (data) {
        if (data.status == 1) {
            pageDocument.getImageList(data.detail.document.DocumentCode);
            pageDocument.localDocument = data.detail;

            var documentHeaderString = "<h12 id='documentDetailsTag'>Document Details</h12><button id='editDocumentBtn' class='btn btn-success pull-right btn-header-margin-left' onclick='pageDocument.openEditDocumentModal();'><span class='glyphicon glyphicon-pencil'></span></button><button id='deleteDocumentBtn' class='btn btn-danger pull-left' onclick='pageDocument.openDeleteDocumentModal(" + data.detail.document.DocumentCode + ")'><span class='glyphicon glyphicon-trash'></span></button>";
            $("#documentDetailHeader").html(documentHeaderString);
            var documentDetailString = "";
            if (window.innerWidth < 992 && !pageDocument.firstTime) {

                //Change the Document Details Name to Document
                $('#documentDetailsTag').empty().html("Details");

                //Show the Document Details Header and hides the search header

                $("#searchDocumentHeader").addClass('hidden');
                $("#documentDetailHeaderDiv").removeClass('hidden-xs hidden-sm');

                //Show the Document Details and hides the document list
                $("#documentListDiv").addClass('hidden');
                $("#documentDetailDiv").removeClass('hidden-xs hidden-sm');

                //Show Hide of menu button with back button
                $(".menu_img").addClass('hidden');
                $("#backButton").removeClass('hidden');

                $("#backButton").click(function () {
                    //Show the Document Details Header and hides the search header
                    $("#documentDetailHeaderDiv").addClass('hidden-xs hidden-sm');
                    $("#searchDocumentHeader").removeClass('hidden');

                    //Show the Document Details and hides the document list
                    $("#documentListDiv").removeClass('hidden');
                    $("#documentDetailDiv").addClass('hidden-xs hidden-sm');

                    //Show Hide of menu button with back button
                    $(".menu_img").removeClass('hidden');
                    $("#backButton").addClass('hidden');

                });
            }
            pageDocument.firstTime = false;

            documentDetailString += "<div class='row contact-details row-top-padding'><div class='list-group-item-heading header_font'><div class='col-md-3 image-details-padding'>Images</div><value><div class='col-md-9'><div class='image'><a href='#' onclick='pageDocument.openDocumentImageModal()' class='clickable'><img src='" + app.websiteRoot + "img/default/preferences/logo.png' id='imageResource' alt='...' class='img-rounded img-size'/><div class='overlay img-rounded'><span class='glyphicon glyphicon-pencil overlay-icon'></span></div></a></div></div></value></div></div>";

            documentDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Holder's Name</div><value><div class='col-md-9'>" + ((data.detail.document.HolderName) ? data.detail.document.HolderName : "") + "</div></value></div></div>";

            documentDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Document Type</div><value><div class='col-md-9'>" + ((data.detail.document.DocumentTypeName) ? data.detail.document.DocumentTypeName : "") + "</div></value></div></div>";

            documentDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Description</div><value><div class='col-md-9'>" + ((data.detail.document.DocumentName) ? data.detail.document.DocumentName : "") + "</div></value></div></div>";

            documentDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Joint Holder Name</div><value><div class='col-md-9'>" + ((data.detail.document.JointHolder) ? data.detail.document.JointHolder : "") + "</div></value></div></div>";

            var issuedByNameString = "";
            switch (data.detail.document.DocumentTypeCode) {
                case "1009":
                    issuedByNameString = "Lab";
                    break;
                case "1010":
                    issuedByNameString = "Doctor";
                    break;
                case "1011":
                    issuedByNameString = "Reference";
                    break;
                default:
                    issuedByNameString = "Issuing Auth";
            }

            documentDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>" + issuedByNameString + "</div><value><div class='col-md-9'>" + ((data.detail.document.IssuedByName) ? data.detail.document.IssuedByName : "") + "</div></value></div></div>";

            documentDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Document Location</div><value><div class='col-md-9'>" + ((data.detail.document.LocationName) ? data.detail.document.LocationName : "") + "</div></value></div></div>";

            documentDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Issue Date</div><value><div class='col-md-9'>" + ((data.detail.document.IssueDate) ? data.detail.document.IssueDate : "") + "</div></value></div></div>";

            documentDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Expiry Date</div><value><div class='col-md-9'>" + ((data.detail.document.ExpiryDate) ? data.detail.document.ExpiryDate : "") + "</div></value></div></div>";

            documentDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-8 text-justify'>" + ((data.detail.document.Remarks) ? data.detail.document.Remarks : "") + "</div></value></div></div>";

            $("#documentDetailBody").html(documentDetailString);
        } else {
            pageDocument.localDocument = null;
        }
    },
    getImageList: function (documentCode) {
        var url = app.websiteRoot + "documents/getImageList.php";

        $.getJSON(url, {
            documentCode: documentCode
        }).done(function (data) {
            console.log(data);
            if (data.status === undefined)
                pageDocument.displayImageList = data;
            else
                pageDocument.displayImageList = null;
            pageDocument.defImageList.resolve();
        }).fail(function (error) {

        });
    },
    openAddDocumentModal: function () {
        document.getElementById("documentForm").reset();
        $('#privateFlag').attr('checked', false);
        $('#activeFlag').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $("#issueDate").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#expiryDate").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#issuedByNameLabel").html("Issuing Auth*");

        $('#documentModalHeading').empty().html("Add Document");
        $('#documentModal').modal('show');
    },
    openEditDocumentModal: function () {
        document.getElementById("documentForm").reset();
        $("#form-add-edit-mode").val("M");

        $("#issueDate").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#expiryDate").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#issuedByNameLabel").html("Issuing Auth*");

        $('#documentModalHeading').empty().html("Edit Document");

        $("#form-add-edit-code").val(pageDocument.localDocument.document.DocumentCode);
        pageDocument.setModalInputFields();

        $("#documentModal").modal('show');
    },
    setModalInputFields: function () {
        var temp = familyCode;
        familyCode = pageDocument.localDocument.document.HolderCode;
        pageDocument.setFamilyList(pageDocument.familyList);

        if (pageDocument.localDocument.document.ActiveFlag) {
            if (pageDocument.localDocument.document.ActiveFlag == 1) {
                $("#activeFlag").attr("checked", true);
            } else {
                $("#activeFlag").attr("checked", false);
            }
        } else {
            $("#activeFlag").attr("checked", false);
        }

        if (pageDocument.localDocument.document.PrivateFlag) {
            if (pageDocument.localDocument.document.PrivateFlag == 1) {
                $("#privateFlag").attr("checked", true);
            } else {
                $("#privateFlag").attr("checked", false);
            }
        } else {
            $("#privateFlag").attr("checked", false);
        }

        if (pageDocument.localDocument.document.DocumentTypeCode) {
            $("#documentTypeCode").val(pageDocument.localDocument.document.DocumentTypeCode);
            $("#documentTypeName").val(pageDocument.localDocument.document.DocumentTypeName);
            var issuedByNameString = "";
            switch (pageDocument.localDocument.document.DocumentTypeCode) {
                case "1009":
                    issuedByNameString = "Lab*";
                    break;
                case "1010":
                    issuedByNameString = "Doctor*";
                    break;
                case "1011":
                    issuedByNameString = "Reference*";
                    break;
                default:
                    issuedByNameString = "Issuing Auth*";
            }
            $("#issuedByNameLabel").html(issuedByNameString);
        }

        if (pageDocument.localDocument.document.DocumentName) {
            $("#documentName").val(pageDocument.localDocument.document.DocumentName);
        }

        if (pageDocument.localDocument.document.JointHolder) {
            $("#jointHolder").val(pageDocument.localDocument.document.JointHolder);
        }

        if (pageDocument.localDocument.document.IssuedBy) {
            $("#issuedBy").val(pageDocument.localDocument.document.IssuedBy);
            $("#issuedByName").val(pageDocument.localDocument.document.IssuedByName);
        }

        if (pageDocument.localDocument.document.LocationCode) {
            $("#locationCode").val(pageDocument.localDocument.document.LocationCode);
            $("#locationName").val(pageDocument.localDocument.document.LocationName);
        }

        if (pageDocument.localDocument.document.IssueDate) {
            $("#issueDate").val(pageDocument.localDocument.document.IssueDate);
        }

        if (pageDocument.localDocument.document.ExpiryDate) {
            $("#expiryDate").val(pageDocument.localDocument.document.ExpiryDate);
        }

        if (pageDocument.localDocument.document.Remarks) {
            $("#remarks").val(pageDocument.localDocument.document.Remarks);
        }

        familyCode = temp;
    },
    openDeleteDocumentModal: function (documentCode) {
        $("#form-delete-code").val(documentCode);
        $("#deleteModal").modal("show");
    },
    openDocumentImageModal: function () {
        $("#documentUploadProgressBar").width(0 + "%");
        $("#imageModal").modal('show');
    },
    deleteDocumentImage: function (typeOfDeletion) {
        var deleteOptions = null;
        var deleteString = "";
        switch (typeOfDeletion) {
            case 1:
                deleteOptions = {
                    documentCode: pageDocument.localDocument.document.DocumentCode,
                    serialNo: pageDocument.currentSerialNo
                };
                deleteString = "the current image?";
                break;
            case 2:
                deleteOptions = {
                    documentCode: pageDocument.localDocument.document.DocumentCode
                };
                deleteString = "all the images?";
                break;
        }
        var deletePic = confirm("Do you REALLY want to DELETE " + deleteString);
        if (deletePic) {
            var url = app.websiteRoot + "documents/deleteImage.php";

            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");

            $.post(url, deleteOptions).done(function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.status == 1) {
                    switch (typeOfDeletion) {
                        case 1:
                            pageDocument.defImageList = $.Deferred();
                            pageDocument.getImageList(pageDocument.localDocument.document.DocumentCode);
                            $.when(pageDocument.defImageList).done(function () {
                                pageDocument.setImageModal();
                            });
                            break;
                        case 2:
                            pageDocument.defImageList = $.Deferred();
                            pageDocument.displayImageList = null;
                            $("#imageModal").modal('hide');
                            break;
                    }
                    app.showNotificationSuccess(response.message);
                } else {
                    $("#imageModal").modal('hide');
                    app.showNotificationFailure(response.message);
                }
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
    setImageModal: function () {
        $("#smallImagePreview").empty();
        pageDocument.imageDataList = [];
        if (pageDocument.displayImageList) {
            console.log(pageDocument.displayImageList);
            $(".modal-footer").removeClass("hidden");
            $("#deleteImageBtn").removeClass("hidden");
            $("#deleteAllImageBtn").removeClass("hidden");
            var firstImagePreview = false;
            for (var i = 0; i < pageDocument.displayImageList.length; i++) {
                $("#smallImagePreview").append("<a href='#' onclick='pageDocument.changeImage(" + i + ",2)' class='clickable'><img src='" + app.websiteRoot + "img/getImage.php?file=" + pageDocument.displayImageList[i].ImagePath + "' class='img-thumbnail modal-img-size'/></a>");
                if (!firstImagePreview) {
                    pageDocument.changeImage(i, 2);
                    firstImagePreview = true;
                }
            }
        } else {
            $("#deleteImageBtn").addClass("hidden");
            $("#deleteAllImageBtn").addClass("hidden");
            $("#imagePreview").attr("src", "../img/default/preferences/logo.png");
            $(".modal-footer").addClass("hidden");
        }
    },
    changeImage: function (imageIndex, typeOfMethod) {
        switch (typeOfMethod) {
            case 1:
                $("#imagePreview").attr("src", pageDocument.imageDataList[imageIndex]);
                break;
            case 2:
                pageDocument.currentSerialNo = pageDocument.displayImageList[imageIndex].SerialNo;
                $("#imagePreview").attr("src", app.websiteRoot + "img/getImage.php?file=" + pageDocument.displayImageList[imageIndex].ImagePath);
                break;
        }
    },
    getDocumentTypeList: function () {
        var url = app.websiteRoot + "documents/getMasters.php";

        $.getJSON(url, {
            type: 'documentType'
        }).done(function (documentTypeList) {
            console.log(documentTypeList);
            for (var i = 0; i < documentTypeList.length; i++) {
                pageDocument.documentTypeTag[i] = documentTypeList[i].DocumentTypeName;
                pageDocument.documentTypeCode[i] = documentTypeList[i].DocumentTypeCode;
            }
            console.log(pageDocument.documentTypeCode);
            console.log(pageDocument.documentTypeTag);
            pageDocument.setDocumentTypeAutoComplete();
        }).fail(function (error) {

        });
    },
    setDocumentTypeAutoComplete: function () {
        $("#documentTypeName").autocomplete({
            source: pageDocument.documentTypeTag,
            change: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageDocument.documentTypeTag);
                if (index > -1) {
                    switch (pageDocument.documentTypeCode[index]) {
                        case "1009":
                            $("#issuedByNameLabel").html("Lab*");
                            break;
                        case "1010":
                            $("#issuedByNameLabel").html("Doctor*");
                            break;
                        case "1011":
                            $("#issuedByNameLabel").html("Reference*");
                            break;
                        default:
                            $("#issuedByNameLabel").html("Issuing Auth*");
                    }
                    console.log("not selected but value is in array");
                    $("#documentTypeCode").val(pageDocument.documentTypeCode[index]);
                } else {
                    $("#issuedByNameLabel").html("Issuing Auth");
                    console.log("Change triggered");
                    $("#documentTypeCode").val(1);
                }
            },
            select: function (event, ui) {
                console.log(ui);
                console.log("Selected");
                var index = $.inArray(ui.item.value, pageDocument.documentTypeTag);
                switch (pageDocument.documentTypeCode[index]) {
                    case "1009":
                        $("#issuedByNameLabel").html("Lab*");
                        break;
                    case "1010":
                        $("#issuedByNameLabel").html("Doctor*");
                        break;
                    case "1011":
                        $("#issuedByNameLabel").html("Reference*");
                        break;
                    default:
                        $("#issuedByNameLabel").html("Issuing Auth*");
                }
                $("#documentTypeCode").val(pageDocument.documentTypeCode[index]);
                console.log($("#documentTypeCode").val());
            }
        });
    },
    getIssuedByList: function () {
        var url = app.websiteRoot + "documents/getMasters.php";

        $.getJSON(url, {
            type: 'contactList'
        }).done(function (issuedByList) {
            console.log(issuedByList);
            for (var i = 0; i < issuedByList.length; i++) {
                pageDocument.issuedByTag[i] = issuedByList[i].FullName;
                pageDocument.issuedByCode[i] = issuedByList[i].ContactCode;
            }
            console.log(pageDocument.issuedByCode);
            console.log(pageDocument.issuedByTag);
            pageDocument.setIssuedByAutoComplete();
        }).fail(function (error) {

        });
    },
    setIssuedByAutoComplete: function () {
        $("#issuedByName").autocomplete({
            source: pageDocument.issuedByTag,
            response: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageDocument.issuedByTag);
                var formGroup = $(this).closest(".form-group");
                if (index > -1) {
                    formGroup.addClass("has-warning");
                    $(this).closest('.form-group').find('.info').html("A New Contact Will Be Created.");
                    console.log("new contact will be created");
                    // show a red error that new contact will be created.
                    console.log("not selected but value is in array");
                } else {
                    formGroup.removeClass("has-warning");
                    $(this).closest('.form-group').find('.info').empty();
                }
                $("#issuedBy").val(1);
            },
            select: function (event, ui) {
                console.log(ui);
                console.log("Selected");

                var formGroup = $(this).closest(".form-group");
                formGroup.removeClass("has-warning");
                $(this).closest('.form-group').find('.info').empty();

                var index = $.inArray(ui.item.value, pageDocument.issuedByTag);
                console.log(index);
                $("#issuedBy").val(pageDocument.issuedByCode[index]);
                console.log($("#issuedBy").val());
            }
        });
    },
    getLocationList: function () {
        var url = app.websiteRoot + "documents/getMasters.php";

        $.getJSON(url, {
            type: 'locationList'
        }).done(function (locationList) {
            console.log(locationList);
            for (var i = 0; i < locationList.length; i++) {
                pageDocument.locationTag[i] = locationList[i].LocationName;
                pageDocument.locationCode[i] = locationList[i].LocationCode;
            }
            console.log(pageDocument.locationCode);
            console.log(pageDocument.locationTag);
            pageDocument.setLocationAutoComplete();
        }).fail(function (error) {

        });
    },
    setLocationAutoComplete: function () {
        $("#locationName").autocomplete({
            source: pageDocument.locationTag,
            change: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageDocument.locationTag);
                if (index > -1) {
                    console.log("not selected but value is in array");
                    $("#locationCode").val(pageDocument.locationCode[index]);
                } else {
                    if ($(event.target).val().trim() == "")
                        $("#expiryDate").removeAttr("required");
                    console.log("Change triggered");
                    $("#locationCode").val(1);
                }
            },
            select: function (event, ui) {
                console.log(ui);
                console.log("Selected");
                var index = $.inArray(ui.item.value, pageDocument.locationTag);
                $("#locationCode").val(pageDocument.locationCode[index]);
                console.log($("#locationCode").val());
            }
        });
    }
};

$(document).ready(function () {
    app.websiteRoot = "../";
    app.getLoginDetails();

    document.getElementById("imgInput").onchange = function () {
        var path = this.value;
        var filename = path.replace(/^.*\\/, "");
        document.getElementById("documentImgInputPath").value = filename;
    };

    document.getElementById('searchBox').onkeypress = function (e) {
        if (!e)
            e = window.event;
        console.log(e);
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13') {
            // Enter pressed
            pageDocument.doSearch();
        }
    };

    $.when(pageDocument.defDocumentList).done(function (data) {
        if (data.status == 1)
            pageDocument.getDocumentDetails(data.result[0].DocumentCode);
    });

    pageDocument.getFamilyList();
    pageDocument.getDocumentList();
    pageDocument.getDocumentTypeList();
    pageDocument.getIssuedByList();
    pageDocument.getLocationList();

    $("#searchBox").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#documentList").empty();
            pageDocument.currentPageNo = 1;
            pageDocument.firstTime = true;
            pageDocument.defDocumentList = $.Deferred();
            pageDocument.getDocumentList();
            $.when(pageDocument.defDocumentList).done(function (data) {
                if (data.status == 1)
                    pageDocument.getDocumentDetails(data.result[0].DocumentCode);
            });
        }
    });

    $("#documentTypeName").focusout(function () {
        if (this.value.trim() === "") {
            $("#issuedByNameLabel").html("Issuing Auth*");
        }
    });

    $("#issueDate").focusin(function () {
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

    $("#expiryDate").focusin(function () {
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

    $('#imgInput').change(function () {
        if (($("#smallImagePreview a").length + this.files.length) < 1) {
            app.showNotificationFailure("No image is selected");
            return;
        }
        $(".modal-footer").removeClass("hidden");
        var initLength = pageDocument.imageDataList.length === 0 ? 0 : (pageDocument.imageDataList.length);
        pageDocument.imageDataList = pageDocument.imageDataList.concat(new Array(this.files.length));
        var firstImagePreview = false;
        for (var i = 0; i < this.files.length; i++) {
            var image = this.files[i];
            if ((image.size || image.fileSize) < 1 * 1000 * 1000) {
                pageDocument.uploadImageList.push(image);
                var reader = new FileReader();
                (function (closureInitLength) {
                    reader.onloadend = function () {
                        pageDocument.imageDataList[closureInitLength] = this.result;
                        $("#smallImagePreview").append("<a href='#' onclick='pageDocument.changeImage(" + closureInitLength + ",1)' class='clickable'><img src='" + this.result + "' class='img-thumbnail modal-img-size'/></a>");
                        if (!firstImagePreview) {
                            pageDocument.changeImage(closureInitLength, 1);
                            firstImagePreview = true;
                        }
                    };
                })(initLength);
                initLength++;
                reader.readAsDataURL(image);
            } else {
                pageDocument.imageDataList[initLength] = null;
                initLength++;
                app.showNotificationFailure("Some images are greater than 1 MB");
            }
        }
    });

    $('#imageModal').on('show.bs.modal', function () {
        document.getElementById("imageForm").reset();
        $("#documentCodeForImage").val(pageDocument.localDocument.document.DocumentCode);
        pageDocument.uploadImageList = [];
        pageDocument.setImageModal();
    });

    $("#imageForm").ajaxForm({
        beforeSubmit: function (formData) {
            if (pageDocument.uploadImageList.length === 0) {
                app.showNotificationFailure("No images selected to UPLOAD");
                return false;
            }
            for (var i = formData.length - 1; i > 0; i--) {
                formData.splice(formData.length - 1, 1);
            }
            for (var i = 0; i < pageDocument.uploadImageList.length; i++) {
                var fileObject = {
                    name: "fileToUpload[]",
                    type: "file",
                    value: pageDocument.uploadImageList[i]
                };
                formData.push(fileObject);
            }
            console.log(formData);
            $("#documentUploadProgress").removeClass("hidden");
            pageDocument.uploadImageList = [];
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $("#documentUploadProgressBar").width(percentComplete + "%");
            $("#documentUploadProgressValue").html(percentComplete + "% complete");
        },
        complete: function (xhr) {
            var responseText = xhr.responseText;
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                pageDocument.getImageList(pageDocument.localDocument.document.DocumentCode);
                $("#imageModal").modal('hide');
                $("#documentUploadProgress").addClass("hidden");
            } else {
                app.showNotificationFailure(response.message);
                $("#documentUploadProgress").addClass("hidden");
            }
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#documentUploadProgress").addClass("hidden");
        }
    });

    $("#documentForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            var isValid = false;
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    console.log(i);
                    app.showNotificationFailure("Required fields are empty");
                    return false;
                }
                if (formData[i].name == "issueDate") {
                    if (formData[i].value.trim() != "") {
                        if (app.validateDate(formData[i].value) === app.dateValidationState.SUCCESS)
                            isValid = true;
                        else {
                            isValid = false;
                            break;
                        }
                    } else {
                        isValid = true;
                    }
                } else if (formData[i].name == "expiryDate") {
                    if (formData[i].value.trim() != "") {
                        if (app.validateDate(formData[i].value) === app.dateValidationState.SUCCESS)
                            isValid = true;
                        else {
                            isValid = false;
                            break;
                        }
                    } else {
                        isValid = true;
                    }
                }
            }
            console.log(isValid);
            if (!isValid) {
                app.showNotificationFailure("Validation Failed for some input field");
                return false;
            }
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                setTimeout(function () {
                    pageDocument.currentPageNo = 1;
                    $("#documentList").empty();
                    $("#documentDetailBody").empty();
                    $("#editDocumentBtn").remove();
                    $("#deleteDocumentBtn").remove();
                    pageDocument.getDocumentDetails(response.landing);
                    pageDocument.getDocumentList();
                    app.showNotificationSuccess(response.message);
                    pageDocument.getDocumentTypeList();
                    pageDocument.getIssuedByList();
                    pageDocument.getLocationList();
                    $("#documentModal").modal("hide");
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

    $('#documentModal').on('hidden.bs.modal', function (e) {
        $("#pageLoading").removeClass("loader");
        $(".cover").fadeOut(100);
    });

    $("#deleteDocumentForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                setTimeout(function () {
                    pageDocument.currentPageNo = 1;
                    $("#documentList").empty();
                    $("#documentDetailBody").empty();
                    $("#editDocumentBtn").remove();
                    $("#deleteDocumentBtn").remove();
                    app.showNotificationSuccess(response.message);
                    pageDocument.getDocumentList();
                    pageDocument.getDocumentDetails(response.landing);
                    $("#deleteModal").modal("hide");
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

});