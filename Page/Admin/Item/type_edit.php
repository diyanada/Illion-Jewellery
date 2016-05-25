<?php
require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

require_once (dirname(__FILE__) . '/../../../Class/system_strings.php');
$sql = new system_strings();

require_once (dirname(__FILE__) . '/../../../DbClass/ItemType.php');
$ItemType = new ItemType();
$ItemTypeMapper = new ItemTypeMapper();

$Connection = $sql -> connect();
if($Connection == false){
    exit ($sql -> error());
}

$ItemType -> _Id = $view -> _prams["ID"];

$ItemType = $ItemTypeMapper ->Select($ItemType, $Connection);

if($ItemType == false){
    exit($ItemTypeMapper -> error());
}
//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Create Item Type");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Type Name", "name", $ItemType -> _Name);
$data["onkeyup"] = array(	
    "cheker_inline.isNotEmpty(this.id, this.placeholder);", 
    "cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);"
);
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = array("onclick" => "edit_type();");

$input->submit("Edit Type", $data);
$input -> drow();
//------------------------------------------------------------------------------------------------