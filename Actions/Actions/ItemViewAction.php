<?php

//error_reporting(0);
require_once (dirname(__FILE__) . '/Common.php');

class ItemViewAction extends Common{
    
    function __construct() {
        
        parent::__construct();       
        
        $function = $this -> Action -> GetVarb("func");
        
        switch ($function) {
            case "Tumb":                
                $this -> Tumb();
                break;
            default :
                $this -> _404();
                break;
            
        }
    }
    
    private function Tumb(){
    
        $this -> Action -> MakeObj("Item");
        
        $this -> Action -> _Obj -> _TypeId = $this -> Action -> GetVarb("_TypeId");

        $ObjArray = $this -> Action -> ObjFunction("Search");
        
        $Feald = array("_Id", "_Name", "_DisplayName", "_Description", "_Price");
        $Des = $this -> Action -> GetVarb("DES");
        $button = array(
            array($Des, "_Id", array("value" => "More"))
            );
        
        $this -> Search -> SearchBox($ObjArray, $Des, $Feald, array(), $button);
        
        exit();
           
    }
}