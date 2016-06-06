<?php 

//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************


$url = filter_input(INPUT_GET, "_url");

require_once (dirname(__FILE__) . "/HostageMain.php");
$_Obj = new HostageMain($url);

if ($_Obj -> _Return == false){
    
    $_Obj -> _Hostage -> _404();
}

unset ($_Obj);

//thestsadasdfsadsd



