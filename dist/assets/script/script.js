var pageAsset = {
    currentPageNo: 1,
    localAsset: null,
    defAssetList: $.Deferred(),
    defSearchResult: $.Deferred(),
    assetTypeTag: [],
    assetTypeCode: [],
    boughtFromTag: [],
    boughtFromCode: [],
    serviceCenterTag: [],
    serviceCenterCode: [],
    locationTag: [],
    locationCode: [],
    familyList: null,
    assetList: null,
    firstTime: true,
    getFamilyList: function () {
        var url = app.websiteRoot + "family/getFamily.php";

        $.getJSON(url, {
            list: 2
        }).done(function (data) {
            pageAsset.setFamilyList(data);
        }).fail(function (error) {

        });
    },
    setFamilyList: function (data) {
        pageAsset.familyList = data;
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
    getAssetList: function () {
        var url = app.websiteRoot + "assets/getAssetList.php";

        $.getJSON(url, {
            pageNo: pageAsset.currentPageNo
        }).done(function (data) {
            console.log(data);
            pageAsset.defAssetList.resolve(data);
            pageAsset.setAssetList(data);
        }).fail(function (error) {

        });
    },
    setAssetList: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageAsset.currentPageNo++;
            var assetListString = "";
            for (var i = 0; i < data.result.length; i++) {
                assetListString += "<a onclick='pageAsset.getAssetDetails(" + data.result[i].AssetCode + ")' class='list-group-item contacts_font'>" + data.result[i].HolderName + " - " + data.result[i].AssetName + "</a>";
            }
            $("#assetList").append(assetListString);
            if (pageAsset.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageAsset.getAssetList();'>Load more..</a></div>";
                $("#assetList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#assetList").empty().html(noMoreDataString);
        }
    },
    doSearch: function () {
        $("#assetList").empty();
        pageAsset.currentPageNo = 1;
        pageAsset.firstTime = true;
        pageAsset.defSearchResult = $.Deferred();
        pageAsset.getSearchResults();
        $.when(pageAsset.defSearchResult).done(function (data) {
            if (data.status == 1)
                pageAsset.getAssetDetails(data.result[0].AssetCode);
        });
    },
    getSearchResults: function () {
        var url = app.websiteRoot + "assets/getAssetList.php";

        $.getJSON(url, {
            pageNo: pageAsset.currentPageNo,
            searchType: 1,
            searchText: $('#searchBox').val().trim()
        }).done(function (data) {
            pageAsset.defSearchResult.resolve(data);
            pageAsset.setSearchResults(data);
        }).fail(function (error) {

        });
    },
    setSearchResults: function (data) {
        if (data.status == 1) {
            $('#loadMore').remove();
            pageAsset.currentPageNo++;
            var searchResultsString = "";
            for (var i = 0; i < data.result.length; i++) {
                searchResultsString += "<a onclick='pageAsset.getAssetDetails(" + data.result[i].AssetCode + ")' class='list-group-item contacts_font'>" + data.result[i].HolderName + " - " + data.result[i].AssetName + "</a>";
            }
            $("#assetList").append(searchResultsString);
            if (pageAsset.currentPageNo <= data.pages) {
                // Show Load More
                var loadMoreString = "<div id='loadMore' class='list-group-item' align='center'><a class='list-group-item-text header_font' style='cursor: pointer;' onclick='pageAsset.getSearchResults();'>Load more..</a></div>";
                $("#assetList").append(loadMoreString);
            }
        } else {
            var noMoreDataString = "<div class='list-group-item list-border-none'><li class='list-group-item-text header_font'>";
            noMoreDataString += data.message + "</li></div>";
            $("#assetList").empty().html(noMoreDataString);
            $("#assetDetailBody").empty();
            $("#editAssetBtn").remove();
            $("#deleteAssetBtn").remove();
            $("#voucherAssetBtn").remove();
        }
    },
    getAssetDetails: function (assetCode) {
        if (assetCode == null)
            return;
        var url = app.websiteRoot + "assets/getAssetDetail.php";

        $.getJSON(url, {
            assetCode: assetCode
        }).done(function (data) {
            console.log(data);
            pageAsset.setAssetDetails(data);
        }).fail(function (error) {

        });
    },
    setAssetDetails: function (data) {
        if (data.status == 1) {
            pageAsset.localAsset = data.detail;

            var assetHeaderString = "<h12 id='assetDetailsTag'>Asset Details</h12><button id='editAssetBtn' class='btn btn-success pull-right btn-header-margin-left' onclick='pageAsset.openEditAssetModal();'><span class='glyphicon glyphicon-pencil'></span></button><button id='deleteAssetBtn' class='btn btn-danger pull-left' onclick='pageAsset.openDeleteAssetModal(" + data.detail.asset.AssetCode + ")'><span class='glyphicon glyphicon-trash'></span></button><button id='voucherAssetBtn' class='btn btn-info pull-right' onclick='pageAsset.openVoucherAssetModal(" + data.detail.asset.AssetCode + ")'><span class='fa fa-sticky-note-o fa-lg'></span></button>";
            $("#assetDetailHeader").html(assetHeaderString);
            var assetDetailString = "";
            if (window.innerWidth < 992 && !pageAsset.firstTime) {

                //Change the Asset Details Name to Asset
                $('#assetDetailsTag').empty().html("Details");

                //Show the Asset Details Header and hides the search header

                $("#searchAssetHeader").addClass('hidden');
                $("#assetDetailHeaderDiv").removeClass('hidden-xs hidden-sm');

                //Show the Asset Details and hides the asset list
                $("#assetListDiv").addClass('hidden');
                $("#assetDetailDiv").removeClass('hidden-xs hidden-sm');

                //Show Hide of menu button with back button
                $(".menu_img").addClass('hidden');
                $("#backButton").removeClass('hidden');

                $("#backButton").click(function () {
                    //Show the Asset Details Header and hides the search header
                    $("#assetDetailHeaderDiv").addClass('hidden-xs hidden-sm');
                    $("#searchAssetHeader").removeClass('hidden');

                    //Show the Asset Details and hides the asset list
                    $("#assetListDiv").removeClass('hidden');
                    $("#assetDetailDiv").addClass('hidden-xs hidden-sm');

                    //Show Hide of menu button with back button
                    $(".menu_img").removeClass('hidden');
                    $("#backButton").addClass('hidden');

                });
            }
            pageAsset.firstTime = false;

            assetDetailString += "<div class='row contact-details row-top-padding'><div class='list-group-item-heading header_font'><div class='col-md-3 image-details-padding'>Images</div><value><div class='col-md-9'><div class='image'><a href='#' onclick='pageAsset.openAssetImageModal()' class='clickable'><img src='"+ app.websiteRoot +"img/default/preferences/logo.png' id='imageResource' alt='...' class='img-rounded img-size'/><div class='overlay img-rounded'><span class='glyphicon glyphicon-pencil overlay-icon'></span></div></a></div></div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Holder's Name</div><value><div class='col-md-9'>" + ((data.detail.asset.HolderName) ? data.detail.asset.HolderName : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Asset Type</div><value><div class='col-md-9'>" + ((data.detail.asset.AssetTypeName) ? data.detail.asset.AssetTypeName : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Description</div><value><div class='col-md-9'>" + ((data.detail.asset.AssetName) ? data.detail.asset.AssetName : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Bought From</div><value><div class='col-md-9'>" + ((data.detail.asset.BoughtFromName) ? data.detail.asset.BoughtFromName : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Joint Holder Name</div><value><div class='col-md-9'>" + ((data.detail.asset.JointHolder) ? data.detail.asset.JointHolder : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Model Number</div><value><div class='col-md-9'>" + ((data.detail.asset.ModelName) ? data.detail.asset.ModelName : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Serial Number</div><value><div class='col-md-9'>" + ((data.detail.asset.SerialNo) ? data.detail.asset.SerialNo : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Remarks</div><value><div class='col-md-9'>" + ((data.detail.asset.Remarks) ? data.detail.asset.Remarks : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Bill No.</div><value><div class='col-md-9'>" + ((data.detail.asset.BillNo) ? data.detail.asset.BillNo : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Bill Date</div><value><div class='col-md-9'>" + ((data.detail.asset.BillDate) ? data.detail.asset.BillDate : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Asset Cost</div><value><div class='col-md-9'>" + ((data.detail.asset.PurchaseAmount) ? data.detail.asset.PurchaseAmount : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Warranty Upto</div><value><div class='col-md-9'>" + ((data.detail.asset.WarrantyUpto) ? data.detail.asset.WarrantyUpto : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Service Center</div><value><div class='col-md-9'>" + ((data.detail.asset.ServiceCentreName) ? data.detail.asset.ServiceCentreName : "") + "</div></value></div></div>";

            assetDetailString += "<div class='row contact-details'><div class='list-group-item-heading header_font'><div class='col-md-3'>Document Location</div><value><div class='col-md-9'>" + ((data.detail.asset.LocationName) ? data.detail.asset.LocationName : "") + "</div></value></div></div>";

            $("#assetDetailBody").html(assetDetailString);
        } else {
            pageAsset.localAsset = null;
        }
    },
    openAddAssetModal: function () {
        document.getElementById("assetForm").reset();
        $('#privateFlag').attr('checked', false);
        $('#activeFlag').attr('checked', true);

        $("#form-add-edit-mode").val("A");
        $("#form-add-edit-code").val(1);

        $("#boughtFromName").closest(".form-group").removeClass("has-warning").find('.info').empty();
        $("#serviceCentreName").closest(".form-group").removeClass("has-warning").find('.info').empty();
        $("#billDate").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#purchaseAmount").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#warrantyUpto").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $('#assetModalHeading').empty().html("Add Asset");
        $('#assetModal').modal('show');
    },
    openEditAssetModal: function () {
        document.getElementById("assetForm").reset();
        $("#form-add-edit-mode").val("M");

        $("#boughtFromName").closest(".form-group").removeClass("has-warning").find('.info').empty();
        $("#serviceCentreName").closest(".form-group").removeClass("has-warning").find('.info').empty();
        $("#billDate").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#purchaseAmount").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
        $("#warrantyUpto").closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();

        $('#assetModalHeading').empty().html("Edit Asset");

        $("#form-add-edit-code").val(pageAsset.localAsset.asset.AssetCode);
        pageAsset.setModalInputFields();

        $("#assetModal").modal('show');
    },
    setModalInputFields: function () {
        var temp = familyCode;
        familyCode = pageAsset.localAsset.asset.HolderCode;
        pageAsset.setFamilyList(pageAsset.familyList);

        if (pageAsset.localAsset.asset.ActiveFlag) {
            if (pageAsset.localAsset.asset.ActiveFlag == 1) {
                $("#activeFlag").attr("checked", true);
            } else {
                $("#activeFlag").attr("checked", false);
            }
        } else {
            $("#activeFlag").attr("checked", false);
        }

        if (pageAsset.localAsset.asset.PrivateFlag) {
            if (pageAsset.localAsset.asset.PrivateFlag == 1) {
                $("#privateFlag").attr("checked", true);
            } else {
                $("#privateFlag").attr("checked", false);
            }
        } else {
            $("#privateFlag").attr("checked", false);
        }

        if (pageAsset.localAsset.asset.AssetTypeCode) {
            $("#assetTypeCode").val(pageAsset.localAsset.asset.AssetTypeCode);
            $("#assetTypeName").val(pageAsset.localAsset.asset.AssetTypeName);
        }

        if (pageAsset.localAsset.asset.AssetName) {
            $("#assetName").val(pageAsset.localAsset.asset.AssetName);
        }

        if (pageAsset.localAsset.asset.BoughtFrom) {
            $("#boughtFrom").val(pageAsset.localAsset.asset.BoughtFrom);
            $("#boughtFromName").val(pageAsset.localAsset.asset.BoughtFromName);
        }

        if (pageAsset.localAsset.asset.JointHolder) {
            $("#jointHolder").val(pageAsset.localAsset.asset.JointHolder);
        }

        if (pageAsset.localAsset.asset.ServiceCentre) {
            $("#serviceCentre").val(pageAsset.localAsset.asset.ServiceCentre);
            $("#serviceCentreName").val(pageAsset.localAsset.asset.ServiceCentreName);
        }

        if (pageAsset.localAsset.asset.LocationCode) {
            $("#locationCode").val(pageAsset.localAsset.asset.LocationCode);
            $("#locationName").val(pageAsset.localAsset.asset.LocationName);
        }

        if (pageAsset.localAsset.asset.BillNo) {
            $("#billNo").val(pageAsset.localAsset.asset.BillNo);
        }

        if (pageAsset.localAsset.asset.BillDate) {
            $("#billDate").val(pageAsset.localAsset.asset.BillDate);
        }

        if (pageAsset.localAsset.asset.PurchaseAmount) {
            $("#purchaseAmount").val(pageAsset.localAsset.asset.PurchaseAmount);
        }

        if (pageAsset.localAsset.asset.WarrantyUpto) {
            $("#warrantyUpto").val(pageAsset.localAsset.asset.WarrantyUpto);
        }

        if (pageAsset.localAsset.asset.ModelName) {
            $("#modelName").val(pageAsset.localAsset.asset.ModelName);
        }

        if (pageAsset.localAsset.asset.SerialNo) {
            $("#serialNo").val(pageAsset.localAsset.asset.SerialNo);
        }
        if (pageAsset.localAsset.asset.Remarks) {
            $("#remarks").val(pageAsset.localAsset.asset.Remarks);
        }

        familyCode = temp;

    },
    openDeleteAssetModal: function(assetCode){
        $("#form-delete-code").val(assetCode);
        $("#deleteModal").modal("show");
    },
    openVoucherAssetModal: function(assetCode){
        window.location.href = app.websiteRoot + "assets/voucher/index.php?assetCode=" + assetCode;
    },
    openAssetImageModal: function(){
        $("#imageModal").modal('show');
    },
    changeImage: function(image){
        $("#imagePreview").attr("src",image);
    },
    getAssetTypeList: function () {
        var url = app.websiteRoot + "assets/getMasters.php";

        $.getJSON(url, {
            type: 'assetType'
        }).done(function (assetTypeList) {
            console.log(assetTypeList);
            for (var i = 0; i < assetTypeList.length; i++) {
                pageAsset.assetTypeTag[i] = assetTypeList[i].AssetTypeName;
                pageAsset.assetTypeCode[i] = assetTypeList[i].AssetTypeCode;
            }
            console.log(pageAsset.assetTypeCode);
            console.log(pageAsset.assetTypeTag);
            pageAsset.setAssetTypeAutoComplete();
        }).fail(function (error) {

        });
    },
    setAssetTypeAutoComplete: function () {
        $("#assetTypeName").autocomplete({
            source: pageAsset.assetTypeTag,
            change: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageAsset.assetTypeTag);
                if (index > -1) {
                    console.log("not selected but value is in array");
                    $("#assetTypeCode").val(pageAsset.assetTypeCode[index]);
                } else {
                    if ($(event.target).val().trim() == "")
                        $("#expiryDate").removeAttr("required");
                    console.log("Change triggered");
                    $("#assetTypeCode").val(1);
                }
            },
            select: function (event, ui) {
                console.log(ui);
                console.log("Selected");
                var index = $.inArray(ui.item.value, pageAsset.assetTypeTag);
                $("#assetTypeCode").val(pageAsset.assetTypeCode[index]);
                console.log($("#assetTypeCode").val());
            }
        });
    },
    getBoughtFromList: function () {
        var url = app.websiteRoot + "assets/getMasters.php";

        $.getJSON(url, {
            type: 'contactList'
        }).done(function (boughtFromList) {
            console.log(boughtFromList);
            for (var i = 0; i < boughtFromList.length; i++) {
                pageAsset.boughtFromTag[i] = boughtFromList[i].FullName;
                pageAsset.boughtFromCode[i] = boughtFromList[i].ContactCode;
            }
            console.log(pageAsset.boughtFromCode);
            console.log(pageAsset.boughtFromTag);
            pageAsset.setBoughtFromAutoComplete();
        }).fail(function (error) {

        });
    },
    setBoughtFromAutoComplete: function () {
        $("#boughtFromName").autocomplete({
            source: pageAsset.boughtFromTag,
            response: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageAsset.boughtFromTag);
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
                $("#boughtFrom").val(1);
            },
            select: function (event, ui) {
                console.log(ui);
                console.log("Selected");

                var formGroup = $(this).closest(".form-group");
                formGroup.removeClass("has-warning");
                $(this).closest('.form-group').find('.info').empty();

                var index = $.inArray(ui.item.value, pageAsset.boughtFromTag);
                console.log(index);
                $("#boughtFrom").val(pageAsset.boughtFromCode[index]);
                console.log($("#boughtFrom").val());
            }
        });
    },
    getServiceCenterList: function () {
        var url = app.websiteRoot + "assets/getMasters.php";

        $.getJSON(url, {
            type: 'contactList'
        }).done(function (serviceCenterList) {
            console.log(serviceCenterList);
            for (var i = 0; i < serviceCenterList.length; i++) {
                pageAsset.serviceCenterTag[i] = serviceCenterList[i].FullName;
                pageAsset.serviceCenterCode[i] = serviceCenterList[i].ContactCode;
            }
            console.log(pageAsset.serviceCenterCode);
            console.log(pageAsset.serviceCenterTag);
            pageAsset.setServiceCenterAutoComplete();
        }).fail(function (error) {

        });
    },
    setServiceCenterAutoComplete: function () {
        $("#serviceCentreName").autocomplete({
            source: pageAsset.serviceCenterTag,
            response: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageAsset.serviceCenterTag);
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
                $("#serviceCentre").val(1);
            },
            select: function (event, ui) {
                console.log(ui);
                console.log("Selected");

                var formGroup = $(this).closest(".form-group");
                formGroup.removeClass("has-warning");
                $(this).closest('.form-group').find('.info').empty();

                var index = $.inArray(ui.item.value, pageAsset.serviceCenterTag);
                console.log(index);
                $("#serviceCentre").val(pageAsset.serviceCenterCode[index]);
                console.log($("#serviceCentre").val());
            }
        });
    },
    getLocationList: function () {
        var url = app.websiteRoot + "assets/getMasters.php";

        $.getJSON(url, {
            type: 'locationList'
        }).done(function (locationList) {
            console.log(locationList);
            for (var i = 0; i < locationList.length; i++) {
                pageAsset.locationTag[i] = locationList[i].LocationName;
                pageAsset.locationCode[i] = locationList[i].LocationCode;
            }
            console.log(pageAsset.locationCode);
            console.log(pageAsset.locationTag);
            pageAsset.setLocationAutoComplete();
        }).fail(function (error) {

        });
    },
    setLocationAutoComplete: function () {
        $("#locationName").autocomplete({
            source: pageAsset.locationTag,
            change: function (event, ui) {
                var index = $.inArray($(event.target).val(), pageAsset.locationTag);
                if (index > -1) {
                    console.log("not selected but value is in array");
                    $("#locationCode").val(pageAsset.locationCode[index]);
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
                var index = $.inArray(ui.item.value, pageAsset.locationTag);
                $("#locationCode").val(pageAsset.locationCode[index]);
                console.log($("#locationCode").val());
            }
        });
    }
};

$(document).ready(function () {
    app.websiteRoot = "../";
    app.setAccountProfilePicture();

    document.getElementById('searchBox').onkeypress = function (e) {
        if (!e)
            e = window.event;
        console.log(e);
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13') {
            // Enter pressed
            pageAsset.doSearch();
        }
    };

    $.when(pageAsset.defAssetList).done(function (data) {
        if (data.status == 1)
            pageAsset.getAssetDetails(data.result[0].AssetCode);
    });

    pageAsset.getFamilyList();
    pageAsset.getAssetList();
    pageAsset.getAssetTypeList();
    pageAsset.getBoughtFromList();
    pageAsset.getServiceCenterList();
    pageAsset.getLocationList();

    $("#searchBox").on('input propertychange', function () {
        if ($(this).val().trim() == "") {
            $("#assetList").empty();
            pageAsset.currentPageNo = 1;
            pageAsset.firstTime = true;
            pageAsset.defAssetList = $.Deferred();
            pageAsset.getAssetList();
            $.when(pageAsset.defAssetList).done(function (data) {
                if (data.status == 1)
                    pageAsset.getAssetDetails(data.result[0].AssetCode);
            });
        }
    });

    $("#boughtFromName").focusout(function () {
        if ($(this).val().trim() == "") {
            $(this).closest(".form-group").removeClass("has-warning").find('.info').empty();
            $("#boughtFrom").val(1);
        }
    });

    $("#serviceCentreName").focusout(function () {
        if ($(this).val().trim() == "") {
            $(this).closest(".form-group").removeClass("has-warning").find('.info').empty();
            $("#serviceCentre").val(1);
        }
    });

    $("#billDate").focusin(function () {
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

    $("#purchaseAmount").on('input propertychange', function () {
        app.validate(this, 6);
    }).focusout(function () {
        if (this.value.trim() === "") {
            if (!this.required) {
                $(this).closest(".form-group").removeClass("has-success").removeClass("has-error").find('.info').empty();
            }
        }
    });

    $("#warrantyUpto").focusin(function () {
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

    $("#assetForm").ajaxForm({
        beforeSubmit: function (formData) {
            console.log(formData);
            var isValid = false;
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() == "") {
                    console.log(i);
                    app.showNotificationFailure("Required fields are empty");
                    return false;
                }
                if (formData[i].name == "billDate") {
                    if (app.validateDate(formData[i].value) === app.dateValidationState.SUCCESS)
                        isValid = true;
                    else {
                        isValid = false;
                        break;
                    }
                } else if (formData[i].name == "purchaseAmount") {
                    if (formData[i].value.trim() != "") {
                        if (app.validateAmount(formData[i].value) === app.amountValidationState.SUCCESS)
                            isValid = true;
                        else {
                            isValid = false;
                            break;
                        }
                    } else {
                        isValid = true;
                    }
                } else if (formData[i].name == "warrantyUpto") {
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
                    pageAsset.currentPageNo = 1;
                    $("#assetList").empty();
                    $("#assetDetailBody").empty();
                    $("#editAssetBtn").remove();
                    $("#deleteAssetBtn").remove();
                    $("#voucherAssetBtn").remove();
                    pageAsset.getAssetDetails(response.landing);
                    pageAsset.getAssetList();
                    app.showNotificationSuccess(response.message);
                    pageAsset.getAssetTypeList();
                    pageAsset.getBoughtFromList();
                    pageAsset.getServiceCenterList();
                    pageAsset.getLocationList();
                    $("#assetModal").modal("hide");
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

    $('#assetModal').on('hidden.bs.modal', function (e) {
        $("#pageLoading").removeClass("loader");
        $(".cover").fadeOut(100);
    });

    $("#deleteAssetForm").ajaxForm({
        beforeSubmit: function () {
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            var response = JSON.parse(responseText);
            if (response.status == 1) {
                setTimeout(function () {
                    pageAsset.currentPageNo = 1;
                    $("#assetList").empty();
                    $("#assetDetailBody").empty();
                    $("#editAssetBtn").remove();
                    $("#deleteAssetBtn").remove();
                    $("#voucherAssetBtn").remove();
                    app.showNotificationSuccess(response.message);
                    pageAsset.getAssetList();
                    pageAsset.getAssetDetails(response.landing);
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
