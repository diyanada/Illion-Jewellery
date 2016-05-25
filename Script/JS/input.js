

function Select_Change(id) {
 id.style.color = "#000000";
}

function adjust(o){
    o.style.height = "1px";
    o.style.height = (10+o.scrollHeight)+"px";
}

function set_url(){
	var url = document.getElementById("Endurl").value;
	url = external_source_js(url);
	window.location = url;
	window.location.replace (url);
  }
  
