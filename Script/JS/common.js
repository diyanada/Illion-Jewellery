//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

function Ajax(div) {

    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            document.getElementById(div).innerHTML = xmlhttp.responseText;
        }
    };

}

function UrlSetup(func, submit){
    
    var url = "?func=" + func;
    url += "&Endurl=" + document.getElementById('Endurl').value;
    url += "&submit=" + document.getElementById(submit).value;
    url += "&submit_on=" + document.getElementById(submit).getAttribute("onclick");
    
    return url;
}

function UrlSetupValue(func){
    
    var url = "?func=" + func;
    
    return url;
}

function UrlValue(id, value){
    
    var url = "&" + id + "=" + value;
    
    return url;
}


function UrlAdd(id){
    
    return "&" + id + "=" + encodeURIComponent(document.getElementById(id).value);
}

function set_url(){
    var url = document.getElementById("Endurl").value;
    url = external_source_js(url);
    window.location = url;
    window.location.replace (url);
}
