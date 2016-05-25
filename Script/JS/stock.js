//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************


var cheker_inline = new validator();
cheker_inline.alerting = false;

function submit_add() {

    var cheker = new validator();

    cheker.isNotEmpty("_Quantity", "Quantity");
    cheker.PositiveNumber("_Quantity", "Quantity");

    if (cheker.ret) {

        var url = external_source_js("Actions/SBXASKGEPB");
        
        Ajax("resoult");
        
        url += UrlSetup("Add", "submit");
        url += UrlAdd("_Quantity");
        url += UrlAdd("ID");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function stock_delete() {

    var cheker = new validator();
    
    var quantity = document.getElementById("_Quantity");

    cheker.isNotEmpty("_Quantity", "Quantity");
    cheker.PositiveNumber("_Quantity", "Quantity");
    cheker.isBetween("_Quantity", "Quantity", quantity.min, quantity.max);
    
    cheker.isNotEmpty("pass", "User Password");
    cheker.Password("pass", "Password");
    
    cheker.isNotEmpty("ID", "ID");

    if (cheker.ret) {

        var url = external_source_js("Actions/SBXASKGEPB");
        
        Ajax("resoult");
        
        url += UrlSetup("Delete", "submit");
        url += UrlAdd("_Quantity");
        url += UrlAdd("pass");
        url += UrlAdd("ID");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

