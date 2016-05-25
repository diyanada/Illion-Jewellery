<?php
//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

class HostageMain {
    
    private $_Serf = array();
    private $_Page = NULL;
    private $_PageAdmin = NULL;
    private $_View = NULL;
    
    public $_Hostage = NULL;
    public $_Return = true;
            
    function __construct($Arr) {        
        
        require_once (dirname(__FILE__) . "/views/Contents_Header.php");
        $this -> _Page = new Contents_Header();

        require_once (dirname(__FILE__) . "/views/Contents_admin.php");
        $this -> _PageAdmin = new content_admin();

        require_once (dirname(__FILE__) . "/class/hostage.php");
        $this -> _Hostage = new hostage($this -> _Page);
        $this -> _View = new view($this -> _Page);
        
        $this -> _Serf = $this -> _Hostage -> Url($Arr);
        
        $_Pathing = $this ->Pathing();
        
        if ($_Pathing == false){
            
            $this -> _Return = false;
        }
    }
    
    function __destruct() {
        
        unset ($this -> _Page);
        unset ($this -> _PageAdmin);
        unset ($this -> _Hostage);
        unset ($this -> _View);
    }
    
    private function Execute(view $View, $Page = NULL){
        
        if($Page == NULL){
            $Page = $this -> _Page;
        }
        
        $Page -> Content($View);
        
        unset($View);
        unset($Page);
        
        exit();
    }
    
    private function Surfing($Index = 1){
        
        if (isset($this -> _Serf[$Index])) {
            
            return $this -> _Serf[$Index];
        }
        else {
            
            return NULL;
        }
    }
    
    private function Pathing(){
        
        switch ($this ->Surfing()) {
            
            case "Basket":
                $this -> Basket();
                break;
            case "Item":
                $this -> Item();
                break;
            case "Account":
                $this -> Account();
                break;
            case "Heritage":
                $this -> Heritage();
                break;
            case "Purchase":
                $this -> Purchase();
                break;
            case "Collection":
                $this -> Collection();
                break;
            case "Custom":
                $this -> Custom();
                break;
            case "Login":
                $this -> Login();
                break;
            case "Register":
                $this -> Register();
                break;
            case "Logout":
                $this -> Logout();
                break;
            default:
                return false;
        }
    }

    private function Basket() {
        
        if($this -> _Hostage -> IsLogin("Basket") == false){
            exit();
        }
        
        $view = $this -> _View;
        
        $view -> prams(array("DES" => "Purchase"));
        
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        $view -> css("Script/Style/ACCFYDAXKV"); // search.css
        $view -> css("Script/Style/XFPJNRSPGK"); // input.css
        $view -> js("Script/JavaScript/AOUZKENYQS"); // validator.js
        $view -> js("Script/JavaScript/SKTJTUKDTS"); // basket.js
                
        $view -> _body = (dirname(__FILE__) . "/Page/basket.php");
        
        $this -> Execute($view);
    }
    
    private function Account() {
        
        if($this -> _Hostage -> IsLogin("Account") == false){
            
            exit();
        }
        
        $view = $this -> _View;        
        
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        $view -> css("Script/Style/XFPJNRSPGK"); // input.css
        $view -> css("Script/Style/VQTIUVWORX"); // avatar.css
        $view -> css("Script/Style/IEVKTXQPTM"); // cropper.min.css

        $view -> js("Script/JavaScript/LJOYBUPVOF"); // jqueary.js
        $view -> js("Script/JavaScript/UUNTOMMNWN"); // cropper.min.js
        $view -> js("Script/JavaScript/AOUZKENYQS"); // validator.js
        $view -> js("Script/JavaScript/GLBEQTNEIE"); // account.js

        $view -> _body = (dirname(__FILE__) . "/Page/account.php");

        $this -> Execute($view);
    }
    
    private function Item() {
        
        if($this -> _Hostage -> IsLogin("Item") == false){
            
            exit();
        }
        
        $Cheks = array("ID" => $this ->Surfing(2));
        
        if($this -> _Hostage -> CheckDB($Cheks, "ITEM") == false){
            
            $this -> _Hostage ->_404();
            exit();
        }
        
        $view = $this -> _View;
        
        $view -> prams(array("ID" => $this -> _Serf[2]));     
        $view -> prams(array("DES" => "Purchase"));
        $view -> prams(array("Endurl" => "Basket"));
        
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        $view -> css("Script/Style/XFPJNRSPGK"); // input.css
        $view -> css("Script/Style/VQTIUVWORX"); // avatar.css
        $view -> js("Script/JavaScript/AOUZKENYQS"); // validator.js
        $view -> js("Script/JavaScript/SKTJTUKDTS"); // basket.js
        
        $view -> _body = (dirname(__FILE__) . "/Page/item.php");
        
        $this -> Execute($view);
    }
    
    private function Purchase() {
        
        if($this -> _Hostage -> IsLogin("Purchase") == false){
            
            exit();
        }
        
        if(!isset($_SESSION)) { 
            session_start(); 
        } 
        
        $Cheks = array("ID" => $this ->Surfing(2), "USER_ID" => $_SESSION["userid"]);
        
        if($this -> _Hostage -> CheckDB($Cheks, "BASKET") == false){
            
            $this -> _Hostage ->_404();
            exit();
        }
        
        $view = $this -> _View;   
        
        $view -> prams(array("ID" => $this -> _Serf[2]));     
        $view -> prams(array("Endurl" => "Basket"));
        
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        $view -> css("Script/Style/FTSWKYDART"); // input.css
        
        $view -> js("Script/JavaScript/AOUZKENYQS"); // validator.js
        $view -> js("Script/JavaScript/SKTJTUKDTS"); // basket.js

        $view -> _body = (dirname(__FILE__) . "/Page/purchase.php");

        $this -> Execute($view);
    }
    
    private function Collection() {
        
        $view = $this -> _View;        
        
        $view -> prams(array("DES" => "Item"));
        
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        $view -> css("Script/Style/XJUHGWSRXM"); // admin.css
        $view -> css("Script/Style/ACCFYDAXKV"); // search.css
        $view -> css("Script/Style/HYOFYDARUT"); // Collection.css
        $view -> js("Script/JavaScript/CWANIIGEME"); // Collection.js
        
        $view -> _NavBody = (dirname(__FILE__) . "/Page/Collection/navigation.php");
        $view -> _body = (dirname(__FILE__) . "/Page/Collection/default.php");
        
        $this -> Execute($view, $this -> _PageAdmin);
    }
    
    private function Custom() {
        
        $view = $this -> _View;        
        
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        
        $this -> Execute($view);
    }
    
    private function Heritage() {
        
        $view = $this -> _View;        
        
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        
        $this -> Execute($view, $this -> _PageAdmin);
    }
    
    private function Login() {
        
        $view = $this -> _View;        
        
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        $view -> css("Script/Style/XFPJNRSPGK"); // input.css
        $view -> js("Script/JavaScript/AOUZKENYQS"); // validator.js
        $view -> js("Script/JavaScript/DPZWJMDGBE"); // login.js
        
        $view -> _body = (dirname(__FILE__) . "/Page/login.php");
        
        $this -> Execute($view);
    }
    
    private function Logout() {
        
        $view = $this -> _View;        
        
        $view -> _body = (dirname(__FILE__) . "/Page/logout.php");
        
        $this -> Execute($view, $this -> _PageAdmin);
    }
    
    private function Register() {
        
        $view = $this -> _View;        
        
        $view -> css("Script/Style/QCOKZGQYLF"); // common.css
        $view -> css("Script/Style/XFPJNRSPGK"); // input.css
        $view -> js("Script/JavaScript/AOUZKENYQS"); // validator.js
        $view -> js("Script/JavaScript/CZCVCDFOTK"); // register.js
        
        $view -> _body = (dirname(__FILE__) . "/Page/register.php");
        
        $this -> Execute($view, $this -> _PageAdmin);
    }
}
