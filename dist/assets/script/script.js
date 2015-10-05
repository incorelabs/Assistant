var pageAssets = {
    openAddAssetsModal: function () {
        document.getElementById("assetsForm").reset();

        $('#assetsModalHeading').empty().html("Add Asset");
        $('#assetsModal').modal('show');
    },
    openEditAssetsModal: function () {
        document.getElementById("assetsForm").reset();

        $('#assetsModalHeading').empty().html("Edit Asset");
        $("#assetsModal").modal('show');
    },
    openDeleteAssetsModal: function(){
        $("#deleteModal").modal('show');
    },
    openVoucherAssetsModal: function(){
        window.location.href = app.websiteRoot + "voucher/index.php";
    },
    openAssetImageModal: function(){
        $("#imageModal").modal('show');
    },
    changeImage: function(image){
        $("#imagePreview").attr("src",image);
    }
};

$(document).ready(function () {

});
