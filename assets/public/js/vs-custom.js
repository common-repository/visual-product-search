var jncVS = jQuery.noConflict();

//if click visual search button, show modal for visual search
function vsShowFormModal() {
    //console.log("Show Modal");
    var vsFormModal;
    //  vsFormModal = $("#vsFormModal");
    vsFormModal = jncVS("#vsFormModal");

    vsFormModal.find(".vsFrmModalTitle").text("Search by image");
    // vsFormModal.find(".modal-backdrop").removeClass();

    // $('.modal-backdrop').remove();
    jncVS('.modal-backdrop').remove();

    vsFormModal.modal('show');
}

function vsVisualSearchByImageOption() {
    //console.log("Show Modal");
    var vsFormModal;
    //  vsFormModal = $("#vsFormModal");
    vsFormModal = jncVS("#vsFormModal");

    vsFormModal.find(".vsFrmModalTitle").text("Search by image");
    // vsFormModal.find(".modal-backdrop").removeClass();

    //  $('.modal-backdrop').remove();
    jncVS('.modal-backdrop').remove();

    vsFormModal.modal('show');
}

function vsUplaodFileTypeSize() {

    // vs_visualsearch_upload_picture
    // document.getElementById('file').files[0].name

    var fileName = document.getElementById('vs_visualsearch_upload_picture').files[0].name;
    var fileSize = document.getElementById('vs_visualsearch_upload_picture').files[0].size;
    var fileType = document.getElementById('vs_visualsearch_upload_picture').files[0].type;

    var vsUPimage = document.getElementById("vs_visualsearch_upload_picture").value;
    if (vsUPimage != '')
    {
        var checkimg = vsUPimage.toLowerCase();
        if (!checkimg.match(/(\.jpg|\.png|\.JPG|\.PNG|\.jpeg|\.JPEG)$/)) { // validation of file extension using regular expression before file upload
            document.getElementById("vs_visualsearch_upload_picture").focus();
            document.getElementById("vs_visualsearch_upload_pictureErr").innerHTML = "Invalid file type.Only JPEG or PNG files are allowed to upload";
            document.getElementById("vsImgUpbtn").disabled = true;
            return false;
        } else {
            document.getElementById("vs_visualsearch_upload_pictureErr").innerHTML = "";
        }




        //10485760 //10 MB
        // 1048576  // 1MB
        // 2097152 // 2MB
        // 3145728 //2MB
        // 5242880   // 5MB
        // 1048576
        //   echo "Sorry, File too large.";

        if (fileSize > 5242880)  // validation according to file size
        {
            document.getElementById("vs_visualsearch_upload_pictureErr").innerHTML = "Sorry, File size too large";
            document.getElementById("vsImgUpbtn").disabled = true;
            return false;
        } else {
            document.getElementById("vs_visualsearch_upload_pictureErr").innerHTML = "";
        }
        document.getElementById("vsImgUpbtn").disabled = false;
        return true;

    } else {
        document.getElementById("vsImgUpbtn").disabled = true;
        return false;
    }
}

function vsCheckUplaodProductFromFront() {
    jncVS("#cover-spin").show();
    return true;
}


function vsCheckURLProductFromFront() {
    jncVS("#cover-spinURL").show();
    return true;
}

function vsCheckClickProductFromFront() {
    jncVS("#cover-spinClick").show();
    return true;
}

function vsCheckClickProductAfterSearchFromFront() {
    console.log("vsCheckClickProductAfterSearchFromFront");
    jncVS("#cover-spinAfterClick").show();
    return true;
}


function vsFileChange(e) {
    document.getElementById('inp_img').value = '';

    var file = e.target.files[0];

    if (file.type == "image/jpeg" || file.type == "image/png") {

        var reader = new FileReader();
        reader.onload = function (readerEvent) {

            var image = new Image();
            image.onload = function (imageEvent) {
                var max_size = 300;
                var w = image.width;
                var h = image.height;

                if (w > h) {
                    if (w > max_size) {
                        h *= max_size / w;
                        w = max_size;
                    }
                } else {
                    if (h > max_size) {
                        w *= max_size / h;
                        h = max_size;
                    }
                }

                var canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;
                canvas.getContext('2d').drawImage(image, 0, 0, w, h);

                if (file.type == "image/jpeg") {
                    var dataURL = canvas.toDataURL("image/jpeg", 1.0);
                } else {
                    var dataURL = canvas.toDataURL("image/png");
                }
                document.getElementById('inp_img').value = dataURL;
            }
            image.src = readerEvent.target.result;
        }
        reader.readAsDataURL(file);
        document.getElementById("vsImgUpbtn").disabled = false;
        document.getElementById("vs_visualsearch_upload_pictureErr").innerHTML = "";
    } else {
        document.getElementById('vs_visualsearch_upload_picture').value = '';
        // alert('Please only select images in JPG- or PNG-format.');

        document.getElementById("vs_visualsearch_upload_pictureErr").innerHTML = "Please only select images in JPG- or PNG-format.";
        document.getElementById("vsImgUpbtn").disabled = true;
    }
}

document.getElementById('vs_visualsearch_upload_picture').addEventListener('change', vsFileChange, false);


function vsFileExtentionCheck(e) {

    var filename = document.getElementById('vs_visualsearch_upload_url').value;

    var fileType = filename.substring(filename.lastIndexOf('.') + 1, filename.length) || filename;

    var fileType1 = fileType.toLowerCase();

    //  console.log("fileType:: " + fileType);
    //   console.log("fileType1:: " + fileType1);

    if (fileType1 == "jpg" || fileType1 == "jpeg" || fileType1 == "png") {


        document.getElementById("vsUrlUpBtn").disabled = false;
        document.getElementById("vs_visualsearch_upload_urlErr").innerHTML = "";

    } else {
        document.getElementById('vs_visualsearch_upload_url').value = '';
        // alert('Please only select images in JPG- or PNG-format.');

        document.getElementById("vs_visualsearch_upload_urlErr").innerHTML = "Please only select images in JPG- or PNG-format.";
        document.getElementById("vsUrlUpBtn").disabled = true;
    }
}



document.getElementById('vs_visualsearch_upload_url').addEventListener('change', vsFileExtentionCheck, false);

//document.getElementById('vs_visualsearch_upload_url').addEventListener('input', vsFileExtentionCheck, false);






