//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************


var cheker_inline = new validator();
cheker_inline.alerting = false;

function submit() {  
  
  var cheker = new validator();
  
  cheker.isNotEmpty("f_name", "First name");
  cheker.AlphaOrWhitespace("f_name", "First name");
  
  cheker.isNotEmpty("l_name", "Last name");
  cheker.Alpha("l_name", "Last name");
  
  cheker.isNotEmpty("u_name", "Username");
  cheker.AlphaNumeric("u_name", "Username");
  
  cheker.isNotEmpty("pass", "Password");
  cheker.Password("pass", "Password");
  
  cheker.isNotEmpty("pass2", "Confirm Password" );
  cheker.PaswordCP("pass2", "Confirm Password", "pass");
  
  cheker.isNotEmpty("user_add", "Address" );
  
  cheker.isNotEmpty("user_mail", "E-mail" );
  cheker.isEmail("user_mail", "E-mail" );
  
  cheker.isNotEmpty("tel_mob", "Tel Number" );
  cheker.isTel("tel_mob", "Tel Number" );
  
  //cheker.ret = true;
  
  if(cheker.ret){
  
  	var url= external_source_js("Actions/MEPZXFXOBQ");
  
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
          if (xmlhttp.readyState ===4 && xmlhttp.status===200)
            {
                document.getElementById("resoult").innerHTML=xmlhttp.responseText;
            }
        
       };
       
       xmlhttp.open("GET",url 
           +"?f_name="+document.getElementById('f_name').value
           +"&l_name=" + document.getElementById('l_name').value 
           +"&u_name="+document.getElementById('u_name').value
           +"&pass=" + encodeURIComponent( document.getElementById('pass').value )
           +"&pass2=" + encodeURIComponent( document.getElementById('pass2').value )
           +"&user_add="+ encodeURIComponent( document.getElementById('user_add').value )
           +"&user_mail=" + document.getElementById('user_mail').value 
           +"&tel_mob=" + document.getElementById('tel_mob').value 
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

