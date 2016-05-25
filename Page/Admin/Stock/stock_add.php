<?php
require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();
//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Stock Add");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Quantity", "_Quantity");
$data["onkeyup"] = array("cheker_inline.isNotEmpty(this.id, this.placeholder);", 
			"cheker_inline.PositiveNumber(this.id, this.placeholder);");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = array("onclick" => "submit_add();");

$input->submit("Stock Add", $data);
$input -> drow();
//------------------------------------------------------------------------------------------------