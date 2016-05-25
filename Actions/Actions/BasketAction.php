<?php

//error_reporting(0);
require_once (dirname(__FILE__) . '/Common.php');

class BasketAction extends Common{
    
    function __construct() {
        
        parent::__construct();       
        
        $function = $this -> Action -> GetVarb("func");
        
        switch ($function) {
            case "ToBasket":                
                $this -> ToBasket();
                break;
            default :
                $this -> _404();
                break;
            
        }
    }

    private function ToBasket(){
        
        $ID = $this -> Action -> GetId("BASKET");
        
        require_once (dirname(__FILE__) . '/../../Class/interface_magic.php');
        $int_mg = new interface_magic();

        require_once (dirname(__FILE__) . '/../../Class/invoice.php');
        $invoice = new invoice();

        $file = $int_mg -> Invoice_Path() . "/" . $ID. ".php";

        $Invoice = fopen($file, "w");
        if ($Invoice == false){

            unset ($this -> Action);
            die("Unable Create Invoice");
        }
        
        $invoice -> _BasketId = $ID;
        $invoice -> _ItemId = $this -> Action -> GetVarb("ID");
        $invoice -> _UserId = $_SESSION["userid"];
        $invoice -> _Quantity = $this -> Action -> GetVarb("_Quantity");
        
        $invoice ->InvoiceId();

        fwrite($Invoice, $invoice ->Table("Invoice"));
        fwrite($Invoice, $invoice ->HeadDesign());
        fwrite($Invoice, $invoice ->UserDesign());
        fwrite($Invoice, $invoice ->Bill());
        fwrite($Invoice, $invoice ->TableEnd());
        fclose($Invoice);
        
        $_Amount = $invoice -> _Amount;
        $_Discount = $invoice -> _Discount;
        $_Tax = $invoice -> _Tax;
        $_Invoice = $invoice -> _InvoiceId;

        unset($invoice);
    
        $this -> Action -> MakeObj("Basket");

        $this -> Action -> _Obj -> _Id = $ID;
        $this -> Action -> _Obj -> _ItemId = $this -> Action -> GetVarb("ID");
        $this -> Action -> _Obj -> _UserId = $_SESSION["userid"];
        $this -> Action -> _Obj -> _Quantity = $this -> Action -> GetVarb("_Quantity");
        $this -> Action -> _Obj -> _Amount = $_Amount;
        $this -> Action -> _Obj -> _Discount = $_Discount;
        $this -> Action -> _Obj -> _Tax = $_Tax;
        $this -> Action -> _Obj -> _InvoiceId = $_Invoice;
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];

        $this -> Action -> ObjFunction("Insert");
        
        $this -> Action -> MakeObj("Quantity");

        $this -> Action -> _Obj -> _ItemId = $this -> Action -> GetVarb("ID");

        $quantity = $this -> Action -> ObjFunction("Select");
        
        $this -> Action -> _Obj = $quantity;
        
        $this -> Action -> _Obj -> _Quantity -= $this -> Action -> GetVarb("_Quantity");
        $this -> Action -> _Obj -> _CreateBy = $_SESSION["userid"];
        
        $this -> Action -> ObjFunction("Update");       

        $this -> Action -> Over($this -> Action -> GetVarb("Endurl"));
        
        exit();
           
    }   
}