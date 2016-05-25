<?php

require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Search Item Type");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Type Id", "type_id");
$data["onkeyup"] = array(	
                            "cheker_inline.AlphaNumericOrWhitespace(this.id, this.placeholder);"
                        );
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Type Name", "name");
$data["onkeyup"] = array(	
                            "cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);"
                        );
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------

$input-> search("Search", array("onclick" => "search_type();"));
//------------------------------------------------------------------------------------------------
$input-> searchDIV();
//------------------------------------------------------------------------------------------------
$input -> drow();
//------------------------------------------------------------------------------------------------