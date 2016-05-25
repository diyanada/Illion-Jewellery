<?php

//error_reporting(0);

class Common{
    
    protected $Action = NULL;  
    protected $Search = NULL;
            
    function __construct() {
        
        require_once (dirname(__FILE__) . '/../../Class/CommonAction.php');
        $this -> Action = new CommonAction();                     
        
        $this -> ErButton();
        
        require_once (dirname(__FILE__) . '/../../Class/search.php');
        $this -> Search = new search(); 
    }
    
    function __destruct() {
        
        unset($this -> Action);
        unset($this -> Search);
    }
    
    protected function _404(){        
        
        require_once (dirname(__FILE__) . "/../../views/Contents.php");
        $page = new Contents();

        require_once (dirname(__FILE__) . "/../../class/hostage.php");
        $hostage = new hostage($page);
        
        $hostage ->_404();
    }

    protected function ErButton(){
        
        $data = array();
        $data["value"] = $this -> Action -> GetVarb("submit");
        $data["onclick"] = $this -> Action -> GetVarb("submit_on");

        $this -> Action -> ErButton($data);
    }
    
}