<?php 

require_once (dirname(__FILE__) . '/../Class/CommonAction.php');
$Action = new CommonAction();

require_once (dirname(__FILE__) . '/../Class/input.php');
$input = new input();

$Action ->MakeObj("Item");

$Action -> _Obj -> _Id = $view -> _prams["ID"];

$item = $Action -> ObjFunction("Select");

$Action ->MakeObj("ItemImage");

$Action -> _Obj -> _ItemId = $view -> _prams["ID"];

$slide = $Action -> ObjFunction("SelectSlide");

$Action ->MakeObj("Quantity");

$Action -> _Obj -> _ItemId = $view -> _prams["ID"];

$quantity= $Action -> ObjFunction("Select");

//------------------------------------------------------------------------------------------------
$input -> table();
//------------------------------------------------------------------------------------------------
foreach ($slide as $value){
    
    $ret = '<div id="imgconitemfull">'
            . '<img id="image" src="' 
            . $int_mg->external_item($value) 
            . '" alt="Item Image" /> '
    . '</div>';
    
    echo $input ->tr($ret);
}
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Display Name", "_DisplayName", $item -> _DisplayName);
$data["readonly"] = "true";
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Description", "_Description");
$data["readonly"] = "true";
$input -> add_textarea_ex($data, $item -> _Description);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Price", "_Price", $item -> _Price);
$data["readonly"] = "true";
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------

if($quantity -> _Quantity == 0){
    $data = $input -> makeAR ("Stock", "Stock", "Out of Stock");
    $data["readonly"] = "true";
    $input -> add_ex($data);
    die();
}

//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Quantity", "_Quantity");
$data["onkeyup"] = array("cheker_inline.isNotEmpty(this.id, this.placeholder);", 
		"cheker_inline.isBetween(this.id, this.placeholder, this.min, this.max);"
		);
$data["onchange"] = $data["onkeyup"];
$data["min"] = 1;
$data["max"] = $quantity -> _Quantity;
$input -> add_ex($data, "number");
//------------------------------------------------------------------------------------------------
$data = array("onclick" => "to_basket();");

$input->submit("Basket", $data);

$input -> drow();
//------------------------------------------------------------------------------------------------
