<?php

require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Search Item");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Item Id", "item_id");
$data["onkeyup"] = array(	
                            "cheker_inline.AlphaNumericOrWhitespace(this.id, this.placeholder);"
                        );
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Name", "name");
$data["onkeyup"] = array(	
							"cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Display Name", "d_name");
$data["onkeyup"] = array(	
							"cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Item Type", "type");
$data["onchange"] = array("cheker_inline.isNotEmpty(this.id, \"Item Type\");", "Select_Change(this);");
$input ->select_ex($data, "ITEM_TYPE");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Discription", "disc");
$input -> add_textarea_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Price", "price");
$data["onkeyup"] = array(	
                            "cheker_inline.isPrice(this.id, this.placeholder);"
                    );
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$input-> search("Search");
//------------------------------------------------------------------------------------------------
$input-> searchDIV();
//------------------------------------------------------------------------------------------------
$input -> drow();
//------------------------------------------------------------------------------------------------