<?php

require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Create Offer Type");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Type Name", "_Name");
$data["onkeyup"] = array(   "cheker_inline.isNotEmpty(this.id, this.placeholder);", 
                            "cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input->makeAR("Tax or Discount", "_IsIncrease");
$data["onchange"] = array("cheker_inline.isNotEmpty(this.id, \"Tax or Discount\");", "Select_Change(this);");
$option = array("placeholder" => "Tax or Discount", "Discount" => "Discount", "Tax" => "Tax");
$input->select_normal_ex($data, $option);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Percentage", "_Percentage");
$data["onkeyup"] = array(   "cheker_inline.isNotEmpty(this.id, this.placeholder);",
                            "cheker_inline.isBetween(this.id, this.placeholder, \"0\", \"100\");");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = array("onclick" => "submit_offer_type();");

$input->submit("Save Type", $data);
$input -> drow();
//------------------------------------------------------------------------------------------------