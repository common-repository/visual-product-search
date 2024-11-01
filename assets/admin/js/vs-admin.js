/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var jncVS = jQuery.noConflict();

//if click visual search button, show modal for visual search
function vsShowFormModal() {
    //console.log("Show Modal");
    var vsFormModal;
    vsFormModal = jncVS("#vsFormModal");
    vsFormModal.find(".vsFrmModalTitle").text("Search by image");
    vsFormModal.modal('show');
}

//function vs_visualSearchNumberOfThreadNumaricCheck(arg1){
//    console.log("arg1"+arg1);
//    jncVS("#errVSSearchNbrThread").html("Numaric value only");
//    jncVS("#vs_visualsearch_number_of_thread").focus();
//    
//}

function checkNumericintVal(sText) {
    var ValidChars = "0123456789";
    var IsNumber = true;
    var Char;
    for (i = 0; i < sText.length && IsNumber == true; i++) {
        Char = sText.charAt(i);
        if (ValidChars.indexOf(Char) == -1) {
            IsNumber = false;
        }
    }
    return IsNumber;
}

function vs_visualSearchNumberOfThreadNumaricCheck(textvalue, returnidname) {

    if (checkNumericintVal(textvalue) == false) {
        document.getElementById(returnidname).value = '';
        document.getElementById(returnidname).focus();
        return false;
    }
    return true;

    // return isValid;
}



function vsCheckAccelxCredentialFromSetting() {
    jncVS("#cover-spin").show();
    return true;
}




