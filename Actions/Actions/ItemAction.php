<?php

//error_reporting(0);
require_once (dirname(__FILE__) . '/Common.php');

class ItemAction extends Common{
    
    function __construct() {
        
        parent::__construct();       
        
        $function = $this -> Action -> GetVarb("func");
        
        switch ($function) {
            case "TypeSave":                
                $this -> TypeSave();
                break;
            case "TypeSearch":                
                $this -> TypeSearch();
                break;
            case "TypeEdit":                
                $this -> TypeEdit();
                break;
            case "Save":                
                $this -> Save();
                break;
            case "Search":                
                $this -> Search();
                break;
            case "Edit":                
                $this -> Edit();
                break;
            case "SearchImage":                
                $this -> SearchImage();
                break;
            case "ImageDelete":                
                $this -> ImageDelete();
                break;
            case "OfferTypeSave":                
                $this -> OfferTypeSave();
                break;
            case "OfferTypeSearch":                
                $this -> OfferTypeSearch();
                break;
            case "OfferTypeDelete":                
                $this -> OfferTypeDelete();
                break;
            default :
                $this -> _404();
                break;
            
        }
    }

    private function TypeSave(){
        
        $ID = $this -> Action -> GetId("ITEM_TYPE");
    
        $this -> Action -> MakeObj("ItemType");

        $this -> Action -> _Obj -> _Id = $ID;
        $this -> Action -> _Obj -> _Name = $this -> Action -> GetVarb("name");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];

        $this -> Action -> ObjFunction("Insert");

        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    }    
        
    private function TypeSearch(){
    
        $this -> Action -> MakeObj("ItemType");

        $this -> Action -> _Obj -> _Id = $this -> Action -> GetVarb("type_id");
        $this -> Action -> _Obj -> _Name = $this -> Action -> GetVarb("name");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];

        $ObjArray = $this -> Action -> ObjFunction("Search");
        
        $Des = $this -> Action -> GetVarb("DES");
        
        $this -> Search -> SearchBox($ObjArray, $Des);
        
        exit();
           
    }
    
    private function TypeEdit(){
    
        $this -> Action -> MakeObj("ItemType");

        $this -> Action -> _Obj -> _Id = $this -> Action -> GetVarb("ID");
        $this -> Action -> _Obj -> _Name = $this -> Action -> GetVarb("name");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];

        $this -> Action -> ObjFunction("Update");
        
        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    }
    
    private function Save(){
        
        $ID = $this -> Action -> GetId("ITEM");
    
        $this -> Action -> MakeObj("Item");

        $this -> Action -> _Obj -> _Id = $ID;
        $this -> Action -> _Obj -> _Name = $this -> Action -> GetVarb("name");
        $this -> Action -> _Obj -> _DisplayName = $this -> Action -> GetVarb("d_name");
        $this -> Action -> _Obj -> _TypeId = $this -> Action -> GetVarb("type");
        $this -> Action -> _Obj -> _Description = $this -> Action -> GetVarb("disc");
        $this -> Action -> _Obj -> _Price = $this -> Action -> GetVarb("price");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];
        
        
        $this -> Action -> ObjFunction("Insert");
        
        $this -> Action -> MakeObj("Stock");
        
        $this -> Action -> _Obj -> _ItemId = $ID;
        $this -> Action -> _Obj -> _Quantity = 0;
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];
        
        
        $this -> Action -> ObjFunction("Insert");
        
        $this -> Action -> MakeObj("Quantity");
        
        $this -> Action -> _Obj -> _ItemId = $ID;
        $this -> Action -> _Obj -> _Quantity = 0;
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];
        
        
        $this -> Action -> ObjFunction("Insert");
        
        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    }
    
    private function Search(){
    
        $this -> Action -> MakeObj("Item");

        $this -> Action -> _Obj -> _Id = $this -> Action -> GetVarb("item_id");
        $this -> Action -> _Obj -> _Name = $this -> Action -> GetVarb("name");
        $this -> Action -> _Obj -> _DisplayName = $this -> Action -> GetVarb("d_name");
        $this -> Action -> _Obj -> _Description = $this -> Action -> GetVarb("disc");
        $this -> Action -> _Obj -> _TypeId = $this -> Action -> GetVarb("type");
        $this -> Action -> _Obj -> _Price = $this -> Action -> GetVarb("price");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];

        $ObjArray = $this -> Action -> ObjFunction("Search");
        
        $Feald = array("_Id", "_Name", "_DisplayName", "_Description", "_Price");
        $Des = $this -> Action -> GetVarb("DES");
        
        $this -> Search -> SearchBox($ObjArray, $Des, $Feald);
        
        exit();
           
    }
    
    private function Edit(){
    
        $this -> Action -> MakeObj("Item");

        $this -> Action -> _Obj -> _Id = $this -> Action -> GetVarb("ID");
        $this -> Action -> _Obj -> _Name = $this -> Action -> GetVarb("name");
        $this -> Action -> _Obj -> _DisplayName = $this -> Action -> GetVarb("d_name");
        $this -> Action -> _Obj -> _TypeId = $this -> Action -> GetVarb("type");
        $this -> Action -> _Obj -> _Description = $this -> Action -> GetVarb("disc");
        $this -> Action -> _Obj -> _Price = $this -> Action -> GetVarb("price");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];

        $this -> Action -> ObjFunction("Update");
        
        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    }
    
    private function SearchImage(){
    
        $this -> Action -> MakeObj("ItemImage");

        $this -> Action -> _Obj -> _Id = $this -> Action -> GetVarb("item_id");
        $this -> Action -> _Obj -> _TypeId = $this -> Action -> GetVarb("type");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];

        $ObjArray = $this -> Action -> ObjFunction("Search");
        
        $Feald = array();
        $Image = array(array());
        $Des = $this -> Action -> GetVarb("DES");
        
        $this -> Search -> SearchBox($ObjArray, $Des, $Feald, $Image);
        
        exit();
           
    }
    
    private function ImageDelete(){
    
        $this -> Action -> MakeObj("SystemUser");

        $this -> Action -> _Obj -> _Id = $_SESSION["userid"];
        $this -> Action -> _Obj -> _Password = md5($this -> Action -> GetVarb("pass"));
        $this -> Action -> _Obj -> _IsAdmin = 1; 

        $this -> Action -> ObjFunction("LoginCheck");
        
        $this -> Action -> MakeObj("ItemImage");

        $this -> Action -> _Obj -> _Id = $this -> Action -> GetVarb("ID");

        $this -> Action -> ObjFunction("Delete");
        
        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    }
    
    private function OfferTypeSave(){
        
        $ID = $this -> Action -> GetId("ITEM_OFFER_TYPE");
    
        $this -> Action -> MakeObj("ItemOfferType");

        $this -> Action -> _Obj -> _Id = $ID;
        $this -> Action -> _Obj -> _Name = $this -> Action -> GetVarb("_Name");
        $this -> Action -> _Obj -> _IsIncrease = $this -> Action -> GetVarb("_IsIncrease");
        $this -> Action -> _Obj -> _Percentage = $this -> Action -> GetVarb("_Percentage");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];

        $this -> Action -> ObjFunction("Insert");

        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    } 
    
    private function OfferTypeSearch(){
    
        $this -> Action -> MakeObj("ItemOfferType");

        $this -> Action -> _Obj -> _Id = $this -> Action -> GetVarb("_Id");
        $this -> Action -> _Obj -> _Name = $this -> Action -> GetVarb("_Name");
        $this -> Action -> _Obj -> _IsIncrease = $this -> Action -> GetVarb("_IsIncrease");
        $this -> Action -> _Obj -> _Percentage = $this -> Action -> GetVarb("_Percentage");

        $ObjArray = $this -> Action -> ObjFunction("Search");
        
        $Feald = array("_Id", "_Name", "_Percentage", "_IsIncrease");
        $Des = $this -> Action -> GetVarb("DES");
        
        $this -> Search -> SearchBox($ObjArray, $Des, $Feald);
        
        exit();
           
    }
    
    private function OfferTypeDelete(){
    
        $this -> Action -> MakeObj("SystemUser");

        $this -> Action -> _Obj -> _Id = $_SESSION["userid"];
        $this -> Action -> _Obj -> _Password = md5($this -> Action -> GetVarb("pass"));
        $this -> Action -> _Obj -> _IsAdmin = 1; 

        $this -> Action -> ObjFunction("LoginCheck");
        
        $this -> Action -> MakeObj("ItemOfferType");

        $this -> Action -> _Obj -> _Id = $this -> Action -> GetVarb("ID");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];

        $this -> Action -> ObjFunction("Delete");
        
        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    }
}