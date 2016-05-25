<?php

require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Create Item Type");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Type Name", "name");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = array("onclick" => "submit_type();");

$input->submit("Save Type", $data);
$input -> drow();
//------------------------------------------------------------------------------------------------