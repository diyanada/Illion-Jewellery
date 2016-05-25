<?php

//error_reporting(0);

class CommonAction{
    
    private $_Sql = NULL;
    private $_Query = NULL;
    private $_Connection = NULL; 
    private $_ObjMapper;
    
    public $_Obj;
    public $_Ermsg = NULL;  

    private function SetID($table){
        
        $table = strtoupper($table);
        
        switch ($table) {
            case "AVATAR_IMAGE":
                $data = "IJ-ATRIMG";
                break;
            case "BASKET":
                $data = "IJ-BST";
                break;
            case "ITEM_IMAGE_TYPE":
                $data = "IJ-ITM-IMGTY";
                break;
            case "ISSUE":
                $data = "IJ-ISE";
                break;
            case "ITEM":
                $data = "IJ-ITM";
                break;
            case "ITEM_IMAGE":
                $data = "IJ-ITM-IMG";
                break;
            case "ITEM_TYPE":
                $data = "IJ-ITM-TY";
                break;
            case "ORDER":
                $data = "IJ-ODR";
                break;
            case "PERCHES":
                $data = "IJ-PCS";
                break;
            case "QUANTITY":
                $data = "IJ-QNY";
                break;
            case "STOCK":
                $data = "IJ-STK";
                break;
            case "SYSTEM_USER":
                $data = "IJ-SUR";
                break; 
            case "ITEM_OFFER_TYPE":
                $data = "IJ-ITM-OTY";
                break;
            default:
                $data = "IJ-ID";
                break;
        }
        
        return $data;
    }
    
    private function Split(array $data){
            
            $ret = NULL;
            
            foreach ($data as $key => $value){
                               
                $ret .= " " . $key . " = '" . $value . "'";
                
            }
            
            return $ret;
        }
        
    private function Button(array $data = array()){
               
            $data = array_merge(array(
                "type" =>"button", 
                "value" =>"submit", 
                "onclick" => "set_url();", 
                "id" => "submit", 
                "name" => "submit", 
                "class" => "submit"
                ), $data);
                        
        return "<input " . $this -> Split($data) . "/>";	
	}
            
    function __construct() {
        
        require_once (dirname(__FILE__) . '/system_strings.php');
        $this -> _Sql = new system_strings();
        
        require_once (dirname(__FILE__) . '/query.php');
        $this -> _Query = new query();
           
        $this -> _Connection = $this -> _Sql -> connect();
        
        if ($this -> _Connection == false) {
            exit($this -> _Ermsg . $this -> _Sql -> error());
        }
        else{
            $this -> _Sql -> autocommit($this -> _Connection, false);
        }
        
    }
    
    function __destruct() {
        
        $this -> _Sql -> close($this -> _Connection);
        
        unset($this -> _Sql);
        unset($this -> _Query);
        unset($this -> _Obj);
        unset($this -> _ObjMapper);
    }

    public function ErButton(array $data = array()){
               
        $data = array_merge(array(
            "type" =>"button", 
            "value" =>"submit", 
            "onclick" => "submit();", 
            "id" => "submit", 
            "name" => "submit", 
            "class" => "submit"
            ), $data);

        $this -> _Ermsg = "<input " . $this -> Split($data) . "/><br />";	
    }
    
    public function GetId($table) {
        
        $data = $this ->SetID ($table);
        
        $temp = $this -> _Query ->makeID($table, $data);
        
        $result = $this -> _Sql -> query($this -> _Connection, $temp);
        
        if ($result == false) {
            
            
            $result -> free();          
            $this -> _Sql -> roleback($this -> _Connection);
            exit($this -> _Ermsg . $this -> _Sql -> error());
        }
        else{
            
            $actor = $this -> _Sql -> actors($result);
            $ID = $actor["ID"];
            $result -> free();
            
            return $ID;
        }
    }
    
    public function MakeObj($Name) {
        
        require_once (dirname(__FILE__) . "/../DbClass/" . $Name . ".php");
        
        $this -> _Obj = new $Name;
        
        $Class = $Name . "Mapper";
        $this -> _ObjMapper = new $Class;
    }
    
    public function ObjFunction($Name) {
        
        $Result = $this -> _ObjMapper -> $Name ($this -> _Obj, $this -> _Connection);
        
        if ($Result == false) {
            
            $this -> _Sql -> roleback($this -> _Connection);
            exit($this -> _Ermsg . $this -> _ObjMapper -> error());
        }
         else {
            return $Result;
         }
        
    }
    
    public function GetVarb($Name){
        
        return urldecode(filter_input(INPUT_GET, $Name));
    }
    
    public function Over($Endurl){
        
        $this -> _Sql -> commit($this -> _Connection);
                
        if ($Endurl == NULL) {
            echo $this -> Button(array("value" => "Main page"));
        } else {
            
            $data = array();
            $data["value"] = "(" . $Endurl . ") page";
    
            echo $this -> Button($data);
        }
        
        echo "<br /> The operation may have succeeded.";
        
        exit();
    }
    
    
}

