<?php 

require_once (dirname(__FILE__) . '/../../Class/pitures.php');
$pitures = new pitures();

require_once (dirname(__FILE__) . '/../../Class/CommonAction.php');
$Action = new CommonAction(); 

require_once (dirname(__FILE__) . '/../../Class/interface_magic.php');
$int_mg = new interface_magic();

$data = array();
$data["value"] = "Go back";
$data["onclick"] = "window.history.back();";

$Action -> ErButton($data);

$ID = $Action -> GetId("ITEM_IMAGE");

$pic = $pitures ->save($_FILES["avatar"], "Item", "IJAVPIC", "ORIGINAL", filter_input(INPUT_POST, "old_pic"));

if($pic == FALSE){        
    echo $pitures ->errors();
    exit( $Action -> _Ermsg);
}

$pitures -> data = array(
    "CP_width" => filter_input(INPUT_POST, "CP_width") ,
    "CP_height" => filter_input(INPUT_POST, "CP_height") ,
    "CP_x" => filter_input(INPUT_POST, "CP_x") ,
    "CP_y" => filter_input(INPUT_POST, "CP_y")
);

if($pitures ->resize($pic, "Item", 800, 600) == false){
    echo $pitures ->errors();
    exit( $Action -> _Ermsg);
}

if($pitures ->resize($pic, "Item", 400, 300) == false){
    echo $pitures ->errors();
    exit( $Action -> _Ermsg);
}

if($pitures ->resize($pic, "Item", 200, 150) == false){
    echo $pitures ->errors();
    exit( $Action -> _Ermsg);
}

if($pitures ->resize($pic, "Item", 100, 75) == false){
    echo $pitures ->errors();
    exit( $Action -> _Ermsg);
}

$Action -> MakeObj("ItemImage");

$Action -> _Obj -> _Id = $ID;
$Action -> _Obj -> _ItemId = filter_input(INPUT_POST, "ID");
$Action -> _Obj -> _TypeId = filter_input(INPUT_POST, "image_type");
$Action -> _Obj -> _Image = $pic;
$Action -> _Obj -> _CreateBy = $_SESSION["userid"];

$Action -> ObjFunction("Insert");

header("Location: " . $int_mg ->external_source("Admin/Main"));
exit();
    
    
    
			
    
	  
