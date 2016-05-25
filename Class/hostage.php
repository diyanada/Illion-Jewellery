<?php

//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

class view{
    
    public $_body = NULL;
    public $_title = "Illion Jewellery";
    public $_js = array();
    public $_css = array();
    public $_prams = array("Endurl" => "");
    public $_meta = NULL;
    public $_header = NULL;
    public $_footer = NULL;
    public $_page = NULL;
    public $_NavBody = NULL;
            
    function __construct(content $content) {
        $this -> _body = dirname(__FILE__) . "/../page/default.php" ;
        $this -> _NavBody = dirname(__FILE__) . "/../page/default.php" ;
        
        $this -> _meta = $content -> _meta ;
        $this -> _header = $content -> _header ;
        $this -> _footer = $content -> _footer ;
        
        $this -> _page = $content;
    }

    public function js($data){
        array_push($this -> _js ,$data);
    }
    
    public function css($data){
        array_push($this -> _css ,$data);
    }
    
    public function prams(array $data){
        
        foreach ($data as $key => $value) {
            $this -> _prams[$key] = $value;
        }
    }
}

class hostage {
    
    public $page = NULL;
    
    function __construct(content $content) {
        $this -> page = $content;
    }

    public function _404(){
        
        $view = new view($this -> page);        
        $view -> _body = dirname(__FILE__) . "/../Page/404.php" ;
        $view -> css("Script/Style/QCOKZGQYLF"); //common.css
        
        $this -> page -> content ($view);
    }
    
    public function IsLogin($from){
	
        $login = new Login();
	
        if ($login -> User() == false) {
            
            $view = new view($this -> page); 
            $view -> _body = dirname(__FILE__) . "/../Page/login.php";
            $view -> css("Script/Style/QCOKZGQYLF"); // common.css
            $view -> css("Script/Style/XFPJNRSPGK"); // inpit.css
            
            $view -> js("Script/JavaScript/AOUZKENYQS"); // vlidator.js
            $view -> js("Script/JavaScript/DPZWJMDGBE"); // login.js
            $view ->prams(array("Endurl" => $from));
            
            $this -> page -> content($view);
            return false;
        } 
        else {
            return true;
        }
    }
    
    public function IsLoginAdmin($from){
        
        $login = new Login();
	
        if ($login -> Admin() == false) {
            
            $view = new view($this -> page); 
            $view -> _body = dirname(__FILE__) . "/../Page/Admin/login.php";
            $view -> css("Script/Style/QCOKZGQYLF"); // common.css
            $view -> css("Script/Style/XFPJNRSPGK"); // inpit.css
            
            $view -> js("Script/JavaScript/AOUZKENYQS"); // vlidator.js
            $view -> js("Script/JavaScript/DPZWJMDGBE"); // login.js
            $view ->prams(array("Endurl" => $from));
            
            $this -> page -> content($view);
            return false;
        } 
        else {
            return true;
        }
    }
    
    public function User(){
        
        $login = new Login();
        
        if ($login -> User() == false) {
            
            $this ->_404();
                        
            return false;
        } 
        else {
            return true;
        }
    }
    
    public function Admin(){
        
        $login = new Login();
        
        if ($login -> Admin() == false) {
            
            $this ->_404();
                        
            return false;
        } 
        else {
            return true;
        }
    }

    public function Url($url){
                
        if($url == NULL){
            $this ->_404($this -> page);
            exit();
        }
        $arr = array();
        $arr = (explode("/", $url));
        
        return $arr;
    }
    
    public function CheckDB(array $data, $table){
        require_once (dirname(__FILE__) . '/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/system_strings.php');
        $sql = new system_strings();
        
        
        
        $where = array();  
        foreach ($data as $key => $value) {
            $where = $query ->Data($where, $key, $value);
        }
        $where = $query ->Data($where, "DELETED", 0);
        
        $temp = $query -> select($query -> From($table),$query -> DataCombine($where));

        $Connection = $sql -> connect();
        
        if ($Connection == false) {
            return false;
        }        
        
        $result = $sql -> query($Connection, $temp);
        
        if ($result == false) {
            return false;
        }
        
        else if($sql -> row($result) !=  1){
            return false;
        }
        else {
            return true;
        }
        
    }

}

class Login{
    
    public function User(){
        
        if(!isset($_SESSION)) { 
            session_start(); 
        } 

        if (isset($_SESSION["admin"])){
            $admin = $_SESSION["admin"];
        }
        else {
            $admin = 0;
        }
        
            
        if (isset($_SESSION['userid']) and $admin == 0) {
            return true;
        } 
        else {
            return false;
        }
        
    }
    
    public function Admin(){
        
        if(!isset($_SESSION)) { 
            session_start(); 
        } 

        if (isset($_SESSION["admin"])){
            $admin = $_SESSION["admin"];
        }
        else {
            $admin = 0;
        }
            
        if (isset($_SESSION['userid']) and $admin == 1) {
            return true;
        } else {
            return false;
        }
    }
}