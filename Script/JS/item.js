//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************


var cheker_inline = new validator();
cheker_inline.alerting = false;

function submit_type() {

    var cheker = new validator();

    cheker.isNotEmpty("name", "Type name");
    cheker.AlphaOrWhitespace("name", "Type name");

    if (cheker.ret) {

        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("resoult");
        
        url += UrlSetup("TypeSave", "submit");
        url += UrlAdd("name");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function search_type() {

    var cheker = new validator();
    
    cheker.AlphaNumericOrWhitespace("type_id", "Type Id");
    cheker.AlphaOrWhitespace("name", "Type name");

    if (cheker.ret) {
        
        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("serdiv");
        
        url += UrlSetup("TypeSearch", "submit");
        url += UrlAdd("type_id");
        url += UrlAdd("name");
        url += UrlAdd("DES");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function edit_type() {

    var cheker = new validator();

    cheker.isNotEmpty("name", "Type name");
    cheker.AlphaOrWhitespace("name", "Type name");

    if (cheker.ret) {
        
        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("resoult");
        
        url += UrlSetup("TypeEdit", "submit");
        url += UrlAdd("ID");
        url += UrlAdd("name");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function submit() {

    var cheker = new validator();

    cheker.isNotEmpty("name", "Name");
    cheker.AlphaOrWhitespace("name", "Name");

    cheker.isNotEmpty("d_name", "Display name");
    cheker.AlphaOrWhitespace("d_name", "Display name");

    cheker.isNotEmpty("type", "Item Type");

    cheker.isNotEmpty("disc", "Description");

    cheker.isNotEmpty("price", "Price");
    cheker.isPrice("price", "Price");

    if (cheker.ret) {

        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("resoult");
        
        url += UrlSetup("Save", "submit");
        url += UrlAdd("name");
        url += UrlAdd("d_name");
        url += UrlAdd("type");
        url += UrlAdd("name");
        url += UrlAdd("disc");
        url += UrlAdd("price");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function search() {

    var cheker = new validator();

    cheker.AlphaNumericOrWhitespace("item_id", "Item Id");
    cheker.AlphaOrWhitespace("name", "Name");
    cheker.AlphaOrWhitespace("d_name", "Display name");
    cheker.isPrice("price", "Price");

    if (cheker.ret) {

        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("serdiv");
        
        url += UrlSetup("Search", "submit");
        url += UrlAdd("item_id");
        url += UrlAdd("name");
        url += UrlAdd("d_name");
        url += UrlAdd("type");
        url += UrlAdd("name");
        url += UrlAdd("disc");
        url += UrlAdd("price");
        url += UrlAdd("DES");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function edit() {

    var cheker = new validator();

    cheker.isNotEmpty("name", "Name");
    cheker.AlphaOrWhitespace("name", "Name");

    cheker.isNotEmpty("d_name", "Display name");
    cheker.AlphaOrWhitespace("d_name", "Display name");

    cheker.isNotEmpty("type", "Item Type");

    cheker.isNotEmpty("disc", "Description");

    cheker.isNotEmpty("price", "Price");
    cheker.isPrice("price", "Price");

    if (cheker.ret) {

        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("resoult");
        
        url += UrlSetup("Edit", "submit");
        url += UrlAdd("ID");
        url += UrlAdd("name");
        url += UrlAdd("d_name");
        url += UrlAdd("type");
        url += UrlAdd("name");
        url += UrlAdd("disc");
        url += UrlAdd("price");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function PreviewImage() {

    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("avatar").files[0]);

    $('#image').cropper({
        aspectRatio: 8 / 6,
        zoomable: false,
        crop: function(e) {

            document.getElementById("CP_width").value = e.width;
            document.getElementById("CP_height").value = e.height;

            document.getElementById("CP_x").value = e.x;
            document.getElementById("CP_y").value = e.y;

            document.getElementById("CP_scaleX").value = e.scaleX;
            document.getElementById("CP_scaleY").value = e.scaleY;

        }
    });

    oFReader.onload = function(oFREvent) {
        $('#image').cropper("replace", oFREvent.target.result);
        
    };

};

function image_validate() {
    var cheker = new validator();

    cheker.isImage("avatar", 'Avatar');
    cheker.isNotEmpty("image_type", 'Image Type');

    return cheker.ret;
}

function search_iamge() {

    var cheker = new validator();

    cheker.AlphaNumericOrWhitespace("item_id", "Item Id");
    
    if (cheker.ret) {

        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("serdiv");
        
        url += UrlSetup("SearchImage", "submit");
        url += UrlAdd("item_id");
        url += UrlAdd("img_type");
        url += UrlAdd("DES");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function delete_image(){
    
    var cheker = new validator();
  
    cheker.isNotEmpty("pass", "Password");
    cheker.Password("pass", "Password");
    
    if (cheker.ret) {

        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("resoult");
        
        url += UrlSetup("ImageDelete", "submit");
        url += UrlAdd("pass");
        url += UrlAdd("ID");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function submit_offer_type() {

    var cheker = new validator();

    cheker.isNotEmpty("_Name", "Type name");
    cheker.AlphaOrWhitespace("_Name", "Type name");
    
    cheker.isNotEmpty("_IsIncrease", "Tax or Discount");
    
    cheker.isNotEmpty("_Percentage", "Tax or Discount");
    cheker.isBetween("_Percentage", "Tax or Discount", 0, 100);
    
    if (cheker.ret) {

        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("resoult");
        
        url += UrlSetup("OfferTypeSave", "submit");
        url += UrlAdd("_Name");
        url += UrlAdd("_IsIncrease");
        url += UrlAdd("_Percentage");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function Offer_type_Search() {

    var cheker = new validator();

    cheker.AlphaNumericOrWhitespace("_Id", "Type Id");
    cheker.AlphaOrWhitespace("_Name", "Type name");
    cheker.isBetween("_Percentage", "Tax or Discount", 0, 100);

    if (cheker.ret) {
        
        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("serdiv");
        
        url += UrlSetup("OfferTypeSearch", "submit");
        url += UrlAdd("_Id");
        url += UrlAdd("_Name");
        url += UrlAdd("_IsIncrease");
        url += UrlAdd("_Percentage");
        url += UrlAdd("DES");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function delete_offer_type(){
    
    var cheker = new validator();
  
    cheker.isNotEmpty("pass", "Password");
    cheker.Password("pass", "Password");
    
    if (cheker.ret) {

        var url = external_source_js("Actions/RJHVEQXBPZ");
        
        Ajax("resoult");
        
        url += UrlSetup("OfferTypeDelete", "submit");
        url += UrlAdd("pass");
        url += UrlAdd("ID");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}



