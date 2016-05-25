<?php 
error_reporting(0);

require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
$int_mg = new interface_magic();

require_once (dirname(__FILE__) . '/../Class/input.php');
$input = new input();

function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
    	header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}


//------------------------------------------------------------------------------------------------
$input -> table();
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("First Name", "f_name");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Last Name", "l_name");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.Alpha(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Username", "u_name");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.AlphaNumeric(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Password", "pass");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.Password(this.id, this.placeholder);"
						);
$input -> add_ex($data, "password");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Confirm Pasword", "pass2");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.PaswordCP(this.id, this.placeholder, \"pass\");"
						);
$input -> add_ex($data, "password");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Address", "user_add");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);"
						);
$input -> add_textarea_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("E-mail", "user_mail");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.isEmail(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Tel Number", "tel_mob");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.isTel(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$input->submit("Register");

$input -> drow();
//------------------------------------------------------------------------------------------------

?>

