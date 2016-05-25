<?php
//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

class HostageItem {
    
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
        $this -> _View -> js("Script/JavaScript/VXFLQXYMQP"); // item.js
        
        $this -> _View -> _NavBody = (dirname(__FILE__) . "/../Page/Admin/Item/navigation.php");
        
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
        
        if ($this ->Surfing(1) != "Item"){
            return false;
        }
        
        switch ($this ->Surfing(2)) {
            
            case NULL:
                $this -> Item();
                return true;
            case "Search":
                $this -> ItemSearch();
                return true;
            case "Edit":
                $this ->ItemEdit();
                return true;
            default:
                return false;
        }
    }

    private function Item() {
        
        $view = $this -> _View;
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/item.php");
        
        $this -> Execute($view);
    }
    
    private function ItemSearch() {
        
        $view = $this -> _View;
        
        $view -> prams(array("DES" => "Admin/Item/Edit"));
        
        $view -> css("Script/Style/ACCFYDAXKV"); // search.css
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/item_search.php");
        
        $this -> Execute($view);
    }
    
    private function ItemEdit() {
        
        $Cheks = array("ID" => $this ->Surfing(3));
        
        if($this -> _Hostage -> CheckDB($Cheks, "ITEM") == false){
            
            $this -> _Hostage ->_404();
            exit();
        }        
        
        $view = $this -> _View;
        
        $view -> prams(array("ID" => $this -> Surfing(3)));
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/Item_edit.php");
        
        $this -> Execute($view);
    }
}

class HostageItemType extends HostageItem{    

    protected function Pathing(){
        
        if ($this ->Surfing(1) != "Item"){
            return false;
        }
        
        if ($this ->Surfing(2) != "Type"){
            return false;
        }
        
        switch ($this ->Surfing(3)) {
            
            case NULL:
                $this -> ItemType();
                return true;
            case "Search":
                $this -> ItemTypeSearch();
                return true;
            case "Edit":
                $this ->ItemTypeEdit();
                return true;
            default:
                return false;
        }
    }

    private function ItemType() {
        
        $view = $this -> _View;
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/type.php");
        
        $this -> Execute($view);
    }
    
    private function ItemTypeSearch() {
        
        $view = $this -> _View;
        
        $view -> prams(array("DES" => "Admin/Item/Type/Edit"));
        
        $view -> css("Script/Style/ACCFYDAXKV"); // search.css
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/type_search.php");
        
        $this -> Execute($view);
    }
    
    private function ItemTypeEdit() {
        
        $Cheks = array("ID" => $this ->Surfing(4));
        
        if($this -> _Hostage -> CheckDB($Cheks, "ITEM_TYPE") == false){
            
            $this -> _Hostage ->_404();
            exit();
        }        
        
        $view = $this -> _View;
        
        $view -> prams(array("ID" => $this -> Surfing(4)));
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/type_edit.php");
        
        $this -> Execute($view);
    }
}

class HostageItemImage extends HostageItem{
    
    protected function Pathing(){
                
        if ($this -> Surfing(1) != "Item"){
            return false;
        }
        
        if ($this -> Surfing(2) != "Image"){
            return false;
        }
        
        switch ($this ->Surfing(3)) {
            
            case "Search":
                $this -> ItemImageSearch();
                return true;
            case "Add":
                $this -> ItemImageAdd();
                return true;
            case "Search-img":
                $this -> ItemImageSearch_img();
                return true;
            case "Delete":
                $this -> ItemImageDelete();
                return true;
            default:
                return false;
        }
    }

    private function ItemImageSearch() {
        
        $view = $this -> _View;
        
        $view -> prams(array("DES" => "Admin/Item/Image/Add"));
        
        $view -> css("Script/Style/ACCFYDAXKV"); // search.css
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/item_search.php");
        
        $this -> Execute($view);
    }
    
    private function ItemImageAdd() {
        
        $Cheks = array("ID" => $this ->Surfing(4));
        
        if($this -> _Hostage -> CheckDB($Cheks, "ITEM") == false){
            
            $this -> _Hostage ->_404();
            exit();
        } 
        
        $view = $this -> _View;
        
        $view -> prams(array("ID" => $this ->Surfing(4)));
        $view -> prams(array("BEerror" => $this ->Surfing(5)));
        
        $view -> css("Script/Style/VQTIUVWORX"); // avatar.css
        $view -> css("Script/Style/IEVKTXQPTM"); // cropper.min.css
        $view -> js("Script/JavaScript/LJOYBUPVOF"); // jqueary.js
        $view -> js("Script/JavaScript/UUNTOMMNWN"); // cropper.min.js
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/item_image.php");
        
        $this -> Execute($view);
    }
    
    private function ItemImageSearch_img() {       
        
        $view = $this -> _View;
        
        $view -> prams(array("DES" => "Admin/Item/Image/Delete"));
        
        $view -> css("Script/Style/ACCFYDAXKV"); // search.css
        $view -> css("Script/Style/VQTIUVWORX"); // avatar.css
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/item_image_search.php");
        
        $this -> Execute($view);
    }
    
    private function ItemImageDelete() {
        
        $Cheks = array("ID" => $this ->Surfing(4));
        
        if($this -> _Hostage -> CheckDB($Cheks, "ITEM_IMAGE") == false){
            
            $this -> _Hostage ->_404();
            exit();
        } 
        
        $view = $this -> _View;
        
        $view -> prams(array("ID" => $this ->Surfing(4)));
        $view -> prams(array("BEerror" => $this ->Surfing(5)));
        
        $view -> css("Script/Style/VQTIUVWORX"); // avatar.css
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/item_image_delete.php");
        
        $this -> Execute($view);
    }
}

class HostageItemOffer extends HostageItem{
    
    protected function Pathing(){
        
        if ($this ->Surfing(1) != "Item"){
            return false;
        }
        
        if ($this ->Surfing(2) != "Offer"){
            return false;
        }
        
        if ($this ->Surfing(3) != "Type"){
            return false;
        }
        
        switch ($this ->Surfing(4)) {
            
            case NULL:
                $this -> ItemOffer();
                return true;
            case "Search":
                $this -> ItemOfferSearch();
                return true;
            case "Delete":
                $this -> ItemOfferDelete();
                return true;
            default:
                return false;
        }
    }

    private function ItemOffer() {
        
        $view = $this -> _View;
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/offer_type.php");
        
        $this -> Execute($view);
    }
    
    private function ItemOfferSearch() {       
        
        $view = $this -> _View;
        
        $view -> prams(array("DES" => "Admin/Item/Offer/Type/Delete"));
        
        $view -> css("Script/Style/ACCFYDAXKV"); // search.css
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/offer_type_search.php");
        
        $this -> Execute($view);
    }
    
    private function ItemOfferDelete() {
        
        $Cheks = array("ID" => $this ->Surfing(5));
        
        if($this -> _Hostage -> CheckDB($Cheks, "ITEM_OFFER_TYPE") == false){
            
            $this -> _Hostage ->_404();        
            
            exit();
        } 
        
        $view = $this -> _View;
        
        $view -> prams(array("ID" => $this ->Surfing(5)));
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/Item/offer_type_delete.php");
        
        $this -> Execute($view);
    }
}
