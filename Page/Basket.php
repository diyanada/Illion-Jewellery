<?php 

require_once (dirname(__FILE__) . '/../Class/CommonAction.php');
$Action = new CommonAction();

require_once (dirname(__FILE__) . '/../Class/search.php');
$Search = new search();

require_once (dirname(__FILE__) . '/../Class/input.php');
$input = new input();

$Action ->MakeObj("Basket");

$Action -> _Obj -> _UserId = $_SESSION["userid"];

$ObjArray = $Action -> ObjFunction("Search");
        
$Feald = array("_Name", "_DisplayName", "_Quantity");

$Des = $view -> _prams["DES"];

$Action -> _Obj -> _IsPerches = 1;

$ObjArray2 = $Action -> ObjFunction("Search");
//------------------------------------------------------------------------------------------------
$input -> table();
$input -> topic("To Pay");
//------------------------------------------------------------------------------------------------ 
echo "<tr><td><div class='inputTB'>"; 
$Search -> SearchBox($ObjArray, $Des, $Feald);
echo "</div></td></tr>";
//------------------------------------------------------------------------------------------------
$input -> topic("Payed");
//------------------------------------------------------------------------------------------------   
echo "<tr><td><div class='inputTB'>"; 
$Search -> SearchBox($ObjArray2, $Des, $Feald, array(), array());
echo "</div></td></tr>";
//------------------------------------------------------------------------------------------------
$input ->drow();