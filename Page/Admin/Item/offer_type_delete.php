<?php

require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Delete Offer Type");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("User Password", "pass");
$data["onkeyup"] = array(   "cheker_inline.isNotEmpty(this.id, this.placeholder);", 
                            "cheker_inline.Password(this.id, this.placeholder);"    );
$input -> add_ex($data, "password");
//------------------------------------------------------------------------------------------------
$data = array("onclick" => "delete_offer_type();");

$input->submit("Delete", $data);
$input -> drow();
//------------------------------------------------------------------------------------------------