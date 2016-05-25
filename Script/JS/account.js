var cheker_inline = new validator();
cheker_inline.alerting = false;

function submit() {

  var cheker = new validator();
  
  cheker.isNotEmpty("f_name", "First name");
  cheker.AlphaOrWhitespace("f_name", "First name");
  
  cheker.isNotEmpty("l_name", "Last name");
  cheker.Alpha("l_name", "Last name");
  
  cheker.isNotEmpty("user_add", "Address" );
  
  cheker.isNotEmpty("user_mail", "E-mail" );
  cheker.isEmail("user_mail", "E-mail" );
  
  cheker.isNotEmpty("tel_mob", "Tel Number" );
  cheker.isTel("tel_mob", "Tel Number" );
  
  
  if(cheker.ret){
  
  	var url= external_source_js("Actions/RVFUHCRWOZ");
  
      if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        }
      else{// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttp.onreadystatechange=function(){
          if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                document.getElementById("resoult").innerHTML = xmlhttp.responseText;
            }
        
       };
       
       xmlhttp.open("GET",url 
           +"?func="+ "save"
           +"&f_name="+document.getElementById('f_name').value
           +"&l_name=" + document.getElementById('l_name').value 
           +"&user_add="+ encodeURIComponent( document.getElementById('user_add').value )
           +"&user_mail=" + document.getElementById('user_mail').value 
           +"&tel_mob=" + document.getElementById('tel_mob').value 
           +"&Endurl=" + document.getElementById('Endurl').value 
           +"&submit=" + document.getElementById('submit').value 
           ,true);
      xmlhttp.send();  
  }
}

function save_act() {

  document.getElementById('submit').disabled = false;

}

function save_act_pass() {

  document.getElementById('submit2').disabled = false;

}

function set_url(){
	var url = document.getElementById("Endurl").value;
	url = external_source_js(url);
	window.location = url;
	window.location.replace (url);
  }
  
function PreviewImage() {

  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("avatar").files[0]);
  
  $('#image').cropper({
            aspectRatio: 1 / 1,
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
  
  oFReader.onload = function (oFREvent) {  
    $('#image').cropper("replace", oFREvent.target.result);
  };

};

function image_validate(){
    var cheker = new validator();
    
    cheker.isImage("avatar", 'Avatar');
    
    return (cheker.ret);
}

function submit_pass() {
  var cheker = new validator();
  
  cheker.isNotEmpty("pass_old", "Old Password");
  cheker.Password("pass_old", "Old Password");
  
  cheker.isNotEmpty("pass", "Password");
  cheker.Password("pass", "Password");
  
  cheker.isNotEmpty("pass2", "Confirm Password" );
  cheker.PaswordCP("pass2", "Confirm Password", "pass");
  
  //cheker.ret = true;
  
  if(cheker.ret){
  
  	var url= external_source_js("Actions/RVFUHCRWOZ");
  
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
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("resoult2").innerHTML=xmlhttp.responseText;
            }
        
       }
       
       xmlhttp.open("GET",url 
           +"?func="+ "save_pass"
           +"&pass=" + encodeURIComponent( document.getElementById('pass').value )
           +"&pass2=" + encodeURIComponent( document.getElementById('pass2').value )
           +"&pass_old=" + encodeURIComponent( document.getElementById('pass_old').value )
           +"&Endurl=" + document.getElementById('Endurl').value 
           +"&submit=" + document.getElementById('submit2').value 
           ,true);
      xmlhttp.send();  
  }
  
}

