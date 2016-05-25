<?php

require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

//------------------------------------------------------------------------------------------------
$input->table();
$input->topic("Search Item Type");
//------------------------------------------------------------------------------------------------
$data = $input->makeAR("Item Id", "item_id");
$data["onkeyup"] = array("cheker_inline.AlphaNumericOrWhitespace(this.id, this.placeholder);");
$input->add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input->makeAR("Image Type", "img_type");
$data["onchange"] = array("Select_Change(this);");
$input->select_ex($data, "ITEM_IMAGE_TYPE", NULL, "Image Type");
//------------------------------------------------------------------------------------------------
$input->search("Search", array("onclick" => "search_iamge();"));
//------------------------------------------------------------------------------------------------
$input->searchDIV();
//------------------------------------------------------------------------------------------------
$input->drow();
//------------------------------------------------------------------------------------------------