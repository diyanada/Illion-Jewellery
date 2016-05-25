//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************


var cheker_inline = new validator();
cheker_inline.alerting = false;

function to_basket(){
    
    var cheker = new validator();
  
    var quantity = document.getElementById("_Quantity");
    
    cheker.isNotEmpty("_Quantity", "Quantity");    
    cheker.isBetween("_Quantity", "Quantity", quantity.min, quantity.max);
    
    cheker.isNotEmpty("ID", "ID"); 
    
    if (cheker.ret) {

        var url = external_source_js("Actions/SPMOYAMOAS");
        
        Ajax("resoult");
        
        url += UrlSetup("ToBasket", "submit");
        url += UrlAdd("_Quantity");
        url += UrlAdd("ID");
        url += UrlAdd("DES");

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

