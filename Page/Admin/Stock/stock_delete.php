<?php
require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

require_once (dirname(__FILE__) . '/../../../Class/CommonAction.php');
$Action = new CommonAction();

$Action ->MakeObj("Quantity");

$Action -> _Obj -> _ItemId = $view -> _prams["ID"];

$quantity= $Action -> ObjFunction("Select");

//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("Stock Destroy");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Quantity", "_Quantity");
$data["onkeyup"] = array("cheker_inline.isNotEmpty(this.id, this.placeholder);", 
		"cheker_inline.isBetween(this.id, this.placeholder, this.min, this.max);"
		);
$data["onchange"] = $data["onkeyup"];
$data["onkeydown"] = array("save_act();");
$data["min"] = 1;
$data["max"] = $quantity -> _Quantity;
$input -> add_ex($data, "number");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("User Password", "pass");
$data["onkeyup"] = array(   "cheker_inline.isNotEmpty(this.id, this.placeholder);", 
                            "cheker_inline.Password(this.id, this.placeholder);"    );
$input -> add_ex($data, "password");
//------------------------------------------------------------------------------------------------
$data = array("onclick" => "stock_delete();");

$input->submit("Destroy", $data);
$input -> drow();
//------------------------------------------------------------------------------------------------