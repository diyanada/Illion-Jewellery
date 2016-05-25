<?php 
error_reporting(0);

require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
$int_mg = new interface_magic();

require_once (dirname(__FILE__) . '/../Class/input.php');
$input = new input();


//------------------------------------------------------------------------------------------------
$input -> table();
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
$input->submit("Login");
$input -> drow();
//------------------------------------------------------------------------------------------------
	?>
</div>
