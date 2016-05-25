<?php
//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

class HostageMain {
    
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
        
        $this -> _View -> css("Script/Style/QCOKZGQYLF"); // common.css
        $this -> _View -> css("Script/Style/XJUHGWSRXM"); // admin.css
        
        $this -> _View -> _NavBody = (dirname(__FILE__) . "/../Page/Admin/navigation.php");
        
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
        
        switch ($this ->Surfing(1)) {
            
            case "Main":
                $this -> Main();
                return true;
            default:
                return false;
        }
    }

    private function Main() {
        
        $view = $this -> _View;
        
        $view -> _body = (dirname(__FILE__) . "/../Page/Admin/default.php");
        
        $this -> Execute($view);
    }
}

