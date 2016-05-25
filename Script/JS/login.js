//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

var cheker_inline = new validator();
cheker_inline.alerting = false;

function submit() {

    var cheker = new validator();
    
    cheker.isNotEmpty("u_name", "Usernamee");
    cheker.AlphaNumeric("u_name", "Usernamee");
    
    cheker.isNotEmpty("pass", "Password");  
    cheker.Password("pass", "Password"); 
    
    cheker.ret = true; 

    if(cheker.ret){
    	
        var url= external_source_js("Actions/ZNLGDXSJLE");
  
          if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            }
          else
            {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
          xmlhttp.onreadystatechange=function()
            {
              if (xmlhttp.readyState===4 && xmlhttp.status===200)
                {
                    document.getElementById("resoult").innerHTML=xmlhttp.responseText;
                }
            
           };
           
           xmlhttp.open("GET",url 
               +"?func="+ "user"
               +"&u_name="+document.getElementById('u_name').value
               +"&pass=" + encodeURIComponent( document.getElementById('pass').value )
               +"&Endurl=" + document.getElementById('Endurl').value 
               +"&submit=" + document.getElementById('submit').value 
               ,true);
          xmlhttp.send(); 
    }
}

function submit_admin() {

    var cheker = new validator();
    
    cheker.isNotEmpty("u_name", "Usernamee");
    cheker.AlphaNumeric("u_name", "Usernamee");
    
    cheker.isNotEmpty("pass", "Password");  
    cheker.Password("pass", "Password"); 
    
    cheker.ret = true; 

    if(cheker.ret){
    	
        var url= external_source_js("Actions/ZNLGDXSJLE");
  
          if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            }
          else
            {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
          xmlhttp.onreadystatechange=function()
            {
              if (xmlhttp.readyState===4 && xmlhttp.status===200)
                {
                    document.getElementById("resoult").innerHTML=xmlhttp.responseText;
                }
            
           };
           
           xmlhttp.open("GET",url 
               +"?func="+ "admin"
               +"&u_name="+document.getElementById('u_name').value
               +"&pass=" + encodeURIComponent( document.getElementById('pass').value )
               +"&Endurl=" + document.getElementById('Endurl').value 
               +"&submit=" + document.getElementById('submit').value 
               ,true);
          xmlhttp.send(); 
    }
}

function set_url(){
    var url = document.getElementById("Endurl").value;
    url = external_source_js(url);
    window.location = url;
    window.location.replace (url);
}

