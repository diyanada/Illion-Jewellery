//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************


validator.prototype.NonValidate = function(ermsg, chdiv, id) {
    this.ret = false;

    if(this.alerting){	
        alert (ermsg);	
        this.alerting = false;
    }

    if(this.SecID){	

        if (!document.getElementById(chdiv)){

            var innerDiv = document.createElement('a');
            innerDiv.id = chdiv;
            innerDiv.className = 'er_line';
            innerDiv.innerHTML = "* " + ermsg + "<br />";
            document.getElementById(id + "_ex").appendChild(innerDiv);	
        }
    }
};

validator.prototype.YesValidate = function(chdiv) {
    if(this.SecID) 	 {	
        if (document.getElementById(chdiv)){
            document.getElementById(chdiv).remove();
        }

    }
}   

function validator() {
    this.alerting = true;
    this.SecID = true;
    this.ret = true;
}

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.isNotEmpty = function(id, name) {

    var input = document.getElementById(id);
    var ermsg = name + " can't be empty.";
    var chdiv = id + "_isNotEmpty_a";
	
	
    if(input.value === ""){
    this.NonValidate(ermsg, chdiv, id);		  
    }
    else {
            this.YesValidate(chdiv);	
    }
};

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.AlphaOrWhitespace = function(id, name) {

    var input = document.getElementById(id);
    var ermsg = name + " can't contain non alpha characters.";
    var chdiv = id + "AlphaOrWhitespace_a";
	
    if(( /^[a-z\s]*$/i.test(input.value)) === false){
    this.NonValidate(ermsg, chdiv, id);		  
    }
    else{
            this.YesValidate(chdiv);	
    }
};

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.Alpha = function(id, name) {
	
    var input = document.getElementById(id);
    var ermsg = name + " can't contain non alpha characters or spaces.";
    var chdiv = id + "Alpha_a";
    
    if(( /^[a-z]+$/i.test(input.value)) === false){
    this.NonValidate(ermsg, chdiv, id);		  
    }
    else {
            this.YesValidate(chdiv);	
    }
};

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.AlphaNumeric = function(id, name) {
	
    var input = document.getElementById(id);
    var ermsg = name + " can't contain non alphanumeric characters.";
    var chdiv = id + "AlphaNumeric";
    
    if(( /^[a-z0-9]+$/i.test(input.value)) === false){
        this.NonValidate(ermsg, chdiv, id);		  
    }
    else {
        this.YesValidate(chdiv);	
    }
};

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.Password = function(id, name) {
	
    var input = document.getElementById(id);
    
    var chdiv = id + "Pasword";
	

    if(/[0-9]/.test(input.value) === false) {
    	var ermsg = name + " must contain at least one number (0-9)!.";
        this.NonValidate(ermsg, chdiv + "1", id);	
      }
    else {
        this.YesValidate(chdiv + "1");	
    }
    
    if(/[a-z]/.test(input.value) === false) {
        var ermsg = name + " must contain at least one lowercase letter (a-z)!.";
        this.NonValidate(ermsg, chdiv + "2", id);	
      }
    else {
        this.YesValidate(chdiv + "2");
	}
    if(/[A-Z]/.test(input.value) === false) {
        var ermsg = name + " must contain at least one uppercase letter (A-Z)!.";
        this.NonValidate(ermsg, chdiv + "3", id);	
      }
    else {
        this.YesValidate(chdiv + "3");
    }
};

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.PaswordCP = function(id, name, id2) {
	
    var input = document.getElementById(id);
    var inputs = document.getElementById(id2);
    
    var chdiv = id + "PaswordCP";	

    if(input.value !== inputs.value) {
    	var ermsg = name + " must match with password.";
        this.NonValidate(ermsg, chdiv, id);	
    }
    else {
        this.YesValidate(chdiv);
    }
};

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.AlphaNumericOrWhitespace = function(id, name) {
	
    var input = document.getElementById(id);
    var ermsg = name + " can't contain non alphanumeric characters.";
    var chdiv = id + "AlphaNumericOrWhitespace";
    
    if(( /^[a-z0-9\s]*$/i.test(input.value)) === false){
    this.NonValidate(ermsg, chdiv, id);		  
    }
    else {
        this.YesValidate(chdiv);	
    }
};
//----------------------------------------------------------------------------------------------------------------------

validator.prototype.PositiveNumber = function(id, name) {

    var input = document.getElementById(id);
    var ermsg = name + " is not a positive number.";
    var chdiv = id + "AlphaOrWhitespace_a";
	
    if(( /^\+?(0|[1-9]\d*)$/.test(input.value)) === false){
    this.NonValidate(ermsg, chdiv, id);		  
    }
    else{
            this.YesValidate(chdiv);	
    }
};
//----------------------------------------------------------------------------------------------------------------------

validator.prototype.isPrice = function(id, name) {
	
    var input = document.getElementById(id);
    var ermsg = name + " is not valid.";
    var chdiv = id + "Price";
    
    if(( /^(\d{1,3})?(,?\d{3})*(\.\d{2})?$/.test(input.value)) === false){
    this.NonValidate(ermsg, chdiv, id);		  
    }
    else {
        this.YesValidate(chdiv);	
    }
};

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.isEmail = function(id, name) {
	
    var input = document.getElementById(id);
    var ermsg = name + " is not valid.";
    var chdiv = id + "isEmail";
    
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    
    if(( re.test(input.value)) === false){
    this.NonValidate(ermsg, chdiv, id);		  
    }
    else{
        this.YesValidate(chdiv);	
    }
};

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.isTel = function(id, name) {
	
    var input = document.getElementById(id);
    var ermsg = name + " is not valid.";
    var chdiv = id + "isTel";
    
    var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
    
    
    if(( re.test(input.value)) === false){
    this.NonValidate(ermsg, chdiv, id);		  
    }
    else{
        this.YesValidate(chdiv);	
    }
};

//----------------------------------------------------------------------------------------------------------------------

validator.prototype.isImage = function(id, name) {
	
    var input = document.getElementById(id);
    
    var chdiv = id + "isImage";
    
    var FileUploadPath = input.value;
    
    
    if(FileUploadPath === ""){
    var ermsg = "Please upload an image.";
        this.NonValidate(ermsg, chdiv, id);		  
    }
    else{
        this.YesValidate(chdiv);	
    }

    var chdiv = id + "isImage2";
    
    var Extension = FileUploadPath.substring(
    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
    
    if(!(Extension === "jpg")){
        var ermsg = name + " only allows file types of JPG and JPEG .";
        this.NonValidate(ermsg, chdiv, id);		  
    }
    else {
        this.YesValidate(chdiv);	
    }
    
};
//----------------------------------------------------------------------------------------------------------------------
validator.prototype.isBetween = function(id, name, min, max) {
	
    var input = document.getElementById(id).value;      
    
    var chdiv = id + "isBetween";    
    
    if (isNaN(input)){
        var ermsg = name + " is not a number.";
        this.NonValidate(ermsg, chdiv, id);		  
    }
    else{
        this.YesValidate(chdiv);	
    }
    
    var data = parseInt(input);
    
    var chdiv = id + "isBetween3"; 
    
    if(data < parseInt(min)){
        
        var ermsg = name + " must grater than to " + min + ".";
        this.NonValidate(ermsg, chdiv, id);		  
    }
    else{
        this.YesValidate(chdiv);	
    }

    var chdiv = id + "isBetween2";
    
    if(data > parseInt(max)){
    var ermsg = name + " must less than to " + max + ".";
        this.NonValidate(ermsg, chdiv, id);		  
    }
    else{
        this.YesValidate(chdiv);	
    }
    
};



