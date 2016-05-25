<?php 

//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

$url = filter_input(INPUT_GET, "_url");


require_once (dirname(__FILE__) . "/HostageMain.php");
require_once (dirname(__FILE__) . "/HostageStock.php");
require_once (dirname(__FILE__) . "/HostageItem.php");

$_Obj = new HostageMain($url);

if ($_Obj -> _Return == false){
    
    unset($_Obj);
    $_Obj = new HostageItem($url);
}

if ($_Obj -> _Return == false){
    
    unset($_Obj);
    $_Obj = new HostageItemType($url);
}

if ($_Obj -> _Return == false){
    
    unset($_Obj);
    $_Obj = new HostageItemOffer($url);
}

if ($_Obj -> _Return == false){
    
    unset($_Obj);
    $_Obj = new HostageItemImage($url);
}

if ($_Obj -> _Return == false){
    
    unset($_Obj);
    $_Obj = new HostageStock($url);
}

if ($_Obj -> _Return == false){    
    
    $_Obj -> _Hostage -> _404();
    unset($_Obj);
}