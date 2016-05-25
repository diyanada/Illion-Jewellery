<?php

require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Search Offer Type");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Type Id", "_Id");
$data["onkeyup"] = array("cheker_inline.AlphaNumericOrWhitespace(this.id, this.placeholder);");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Type Name", "_Name");
$data["onkeyup"] = array("cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input->makeAR("Tax or Discount", "_IsIncrease");
$data["onchange"] = array("Select_Change(this);");
$option = array("placeholder" => "Tax or Discount", "Discount" => "Discount", "Tax" => "Tax");
$input->select_normal_ex($data, $option);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Percentage", "_Percentage");
$data["onkeyup"] = array("cheker_inline.isBetween(this.id, this.placeholder, \"0\", \"100\");");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$input->search("Search", array("onclick" => "Offer_type_Search();"));
//------------------------------------------------------------------------------------------------
$input-> searchDIV();
//------------------------------------------------------------------------------------------------
$input -> drow();
//------------------------------------------------------------------------------------------------