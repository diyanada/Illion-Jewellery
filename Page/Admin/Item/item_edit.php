<?php
require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

require_once (dirname(__FILE__) . '/../../../Class/system_strings.php');
$sql = new system_strings();

require_once (dirname(__FILE__) . '/../../../DbClass/Item.php');
$Item = new Item();
$ItemMapper = new ItemMapper();

$Connection = $sql -> connect();
if($Connection == false){
    exit ($sql -> error());
}

$Item -> _Id = $view -> _prams["ID"];

$Item = $ItemMapper ->Select($Item, $Connection);

if($Item == false){
    exit($ItemMapper -> error());
}
//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Edit Item");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Name", "name", $Item -> _Name);
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Display Name", "d_name", $Item -> _DisplayName);
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Item Type", "type");
$data["onchange"] = array("cheker_inline.isNotEmpty(this.id, \"Item Type\");", "Select_Change(this);");
$input ->select_ex($data, "ITEM_TYPE", $Item -> _TypeId);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Discription", "disc");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);"
						);
$input -> add_textarea_ex($data, $Item -> _Description);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Price", "price", $Item -> _Price);
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.isPrice(this.id, this.placeholder);"
						);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = array("onclick" => "edit();");

$input->submit("Edit Item", $data);
$input -> drow();
//------------------------------------------------------------------------------------------------