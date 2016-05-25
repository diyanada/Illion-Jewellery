<?php
//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

class HostageStock {
    
    protected $_Serf = array();
    protected $_Page = NULL;
    protected $_PageNON = NULL;
    protected $_View = NULL;
    protected $_Login= NULL;
    
    public $_Hostage = NULL;
    public $_Return = true;
            
    public function __construct($Arr) {
        
        require_once (dirname(__FILE__) . "/../views/Contents_Admin.php");
        $this -> _Page = new content_admin();

        require_once (dirname(__FILE__) . "/../views/Contents_Header.php");
        $this -> _PageNON = new Contents_Header();

        require_once (dirname(__FILE__) . "/../class/hostage.php");
        $this -> _Hostage = new hostage($this -> _Page);
        $this -> _View = new view($this -> _Page);
        $this -> _Login = new Login();
        
        if ($this -> _Login -> Admin() == false){

            $hostage = new hostage($this -> _PageNON);
            $hostage ->_404();
            exit();
        }
        
        $this -> _Serf = $this -> _Hostage -> Url($Arr);
        
        $this -> _View -> prams(array("Endurl" => "Admin/Main"));
        
        $this -> _View -> css("Script/Style/QCOKZGQYLF"); // common.css
        $this -> _View -> css("Script/Style/XJUHGWSRXM"); // admin.css
        $this -> _View -> css("Script/Style/XFPJNRSPGK"); // input.css
        $this -> _View -> js("Script/JavaScript/AOUZKENYQS"); // validator.js
        $this -> _View -> js("Script/JavaScript/JVQPTMYIMQ"); // stock.js
        
        $this -> _View -> _NavBody = (dirname(__FILE__) . "/../Page/Admin/Stock/navigation.php");
        
        $_Pathing = $this -> Pathing();
        
        if ($_Pathing == false){
            
            $this -> _Return = false;
            $this -> _Hostage = new hostage($this -> _PageNON);
        }
        
        else {
            $this -> _Return = true;
        }
        
    }
    
    public function __destruct() {
        
        unset ($this -> _Page);
        unset ($this -> _PageNON);
        unset ($this -> _Hostage);
        unset ($this -> _View);
    }
    
    protected function Execute(view $View, $Page = NULL){
        
        if($Page == NULL){
            $Page = $this -> _Page;
        }
        
        $Page -> Content($View);
        
        unset($View);
        unset($Page);
    }
    
    protected function Surfing($Index = 1){
        
        if (isset($this -> _Serf[$Index])) {
            
            return $this -> _Serf[$Index];
        }
        else {
            
            return NULL;
        }
    }
    
    protected function Pathing(){
        
        if ($this ->Surfing(1) != "Stock"){
            return false;
        }
        
        switch ($this ->Surfing(2)) {
            
            case NULL:
                $this -> Stock();
                return true;
            case "Add":
                $this -> StockAdd();
                return true;
            case "Search":
                $this -> StockSearch();
                return true;
            case "Delete":
                $this -> StockDelete();
                return true;
            default:
                return false;
        }
    }

    private function Stock() {   
        
        
        $view = $this -> _View;
        
        $view -> prams(array("DES" => "Admin/Stock/Add"));
        
        $view -> css("Script/Style/ACCFYDAXKV"); // search.css
        $view -> js("Script/JavaScript/VXFLQXYMQP"); // item.js
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/item_search.php");
        
        $this -> Execute($view);
    }
    
    private function StockAdd() {
        
        $Cheks = array("ID" => $this ->Surfing(3));
        
        if($this -> _Hostage -> CheckDB($Cheks, "ITEM") == false){
            
            $this -> _Hostage ->_404();
            exit();
        } 
        
        $view = $this -> _View;
        
        $view -> prams(array("ID" => $this -> Surfing(3)));
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Stock/stock_add.php");
        
        $this -> Execute($view);
    }
    
    private function StockSearch() {       
        
        
        $view = $this -> _View;
        
        $view -> prams(array("DES" => "Admin/Stock/Delete"));
        
        $view -> css("Script/Style/ACCFYDAXKV"); // search.css
        $view -> js("Script/JavaScript/VXFLQXYMQP"); // item.js
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/item_search.php");
        
        $this -> Execute($view);
    }
    
    private function StockDelete() {
        
        $view = $this -> _View;
        
        $view -> prams(array("ID" => $this -> Surfing(3)));
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Stock/stock_delete.php");
        
        $this -> Execute($view);
    }
}