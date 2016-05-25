<?php

//error_reporting(0);
require_once (dirname(__FILE__) . '/Common.php');

class StockAction extends Common{
    
    function __construct() {
        
        parent::__construct();       
        
        $function = $this -> Action -> GetVarb("func");
        
        switch ($function) {
            case "Add":                
                $this -> Add();
                break;
            case "Delete":                
                $this -> Delete();
                break;
            default :
                $this -> _404();
                break;
            
        }
    }

    private function Add(){
        
    
        $this -> Action -> MakeObj("Stock");

        $this -> Action -> _Obj -> _ItemId = $this -> Action -> GetVarb("ID");

        $stock = $this -> Action -> ObjFunction("Select");
        
        $this -> Action -> _Obj = $stock;
        
        $this -> Action -> _Obj -> _Quantity += $this -> Action -> GetVarb("_Quantity");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];
        
        $stock = $this -> Action -> ObjFunction("Update");
        
        $this -> Action -> MakeObj("Quantity");

        $this -> Action -> _Obj -> _ItemId = $this -> Action -> GetVarb("ID");

        $quantity = $this -> Action -> ObjFunction("Select");
        
        $this -> Action -> _Obj = $quantity;
        
        $this -> Action -> _Obj -> _Quantity += $this -> Action -> GetVarb("_Quantity");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];
        
        $stock = $this -> Action -> ObjFunction("Update");

        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    }    
    
    private function Delete(){
        
        $this -> Action -> MakeObj("SystemUser");

        $this -> Action -> _Obj -> _Id = $_SESSION["userid"];
        $this -> Action -> _Obj -> _Password = md5($this -> Action -> GetVarb("pass"));
        $this -> Action -> _Obj -> _IsAdmin = 1; 

        $this -> Action -> ObjFunction("LoginCheck");        
    
        $this -> Action -> MakeObj("Stock");

        $this -> Action -> _Obj -> _ItemId = $this -> Action -> GetVarb("ID");

        $stock = $this -> Action -> ObjFunction("Select");
        
        $this -> Action -> _Obj = $stock;
        
        $this -> Action -> _Obj -> _Quantity -= $this -> Action -> GetVarb("_Quantity");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];
        
        $stock = $this -> Action -> ObjFunction("Update");
        
        $this -> Action -> MakeObj("Quantity");

        $this -> Action -> _Obj -> _ItemId = $this -> Action -> GetVarb("ID");

        $quantity = $this -> Action -> ObjFunction("Select");
        
        $this -> Action -> _Obj = $quantity;
        
        $this -> Action -> _Obj -> _Quantity -= $this -> Action -> GetVarb("_Quantity");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];
        
        $stock = $this -> Action -> ObjFunction("Update");

        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    }    
}