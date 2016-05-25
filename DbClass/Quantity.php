<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class Quantity {
    
    public $_ItemId = NULL;
    public $_Quantity = NULL; 
    public $_CreateBy = NULL;
    public $_Deleted = 0;   

     
}
class QuantityMapper {
    
    private $errors;
    
    public function  error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }
    
    public function Insert(Quantity $Quantity, $Connection){
        
        if ($this -> Validate($Quantity) == false){
            return false;
        }
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array(
            "ITEM_ID" => $Quantity -> _ItemId
            , "QUANTITY" => $Quantity -> _Quantity
            , "CREATED_BY" => $Quantity -> _CreateBy
            , "CREATED_DATETIME" => date("Y-m-d H:i:s")
        );
        $temp = $query -> insertINTO("QUANTITY", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
        
    }
    
    public function Update(Quantity $Quantity, $Connection){
                
        if ($this -> Validate($Quantity, true) == false){
            return false;
        }
               
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "QUANTITY", $Quantity -> _Quantity);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $Quantity -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ITEM_ID", $Quantity -> _ItemId);
        
        $temp = $query -> update("QUANTITY", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Delete(Quantity $Quantity, $Connection){
        
        if ($this -> Validate($Quantity, true) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "DELETED", 1);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $Quantity -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ITEM_ID", $Quantity -> _ItemId);
        
        $temp = $query -> update("QUANTITY", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Select(Quantity $Quantity, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ITEM_ID", $Quantity -> _ItemId);
        $where = $query ->Data($where, "DELETED", $Quantity -> _Deleted);
        
        $temp = $query -> select($query -> From("QUANTITY"),$query -> DataCombine($where));

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        if($sql ->row($result) != 1){
            $this -> errors = "This id is NOT exit";
            return false;
        }
        
        $actor = $sql->actors($result);
        
        $Quantity = new Quantity;
        
        $Quantity -> _ItemId = $actor["ITEM_ID"];
        $Quantity -> _Quantity = $actor["QUANTITY"];
        $Quantity -> _CreateBy = $actor["CREATED_BY"];
        $Quantity -> _Deleted = $actor["DELETED"];
        
        return $Quantity; 
        
    }

    public function Search(Quantity $Quantity, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ITEM_ID", "%" . $Quantity -> _ItemId . "%", "LIKE");
        $where = $query ->Data($where, "QUANTITY", "%" . $Quantity -> _Quantity . "%", "LIKE");
        $where = $query ->Data($where, "DELETED", $Quantity -> _Deleted);
        
        $temp = $query -> select($query -> From("QUANTITY"),$query -> DataCombine($where));

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
         
        
        $QuantityArray = array();
        
        $row = $result -> fetch_fields() ;
                
        $Quantity = new Quantity;

        $Quantity -> _ItemId = $this -> Name($row[0]->name);
        $Quantity -> _Quantity = $this -> Name($row[1]->name);
        $Quantity -> _CreateBy = $this -> Name($row[2]->name);

        array_push($QuantityArray, $Quantity);
        
        while ($row = $result -> fetch_assoc()) {
            $Quantity = new Quantity();
            
            $Quantity -> _ItemId = $row["ITEM_ID"];
            $Quantity -> _Quantity = $row["QUANTITY"];
            $Quantity -> _CreateBy = $row["CREATED_BY"];
            
            array_push($QuantityArray, $Quantity);
        }
               
        return $QuantityArray; 
        
        
    }
    
    private function Validate(Quantity $Quantity, $OnUpdate = false){
        
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate();    
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ITEM_ID" => $Quantity -> _ItemId), "QUANTITY") != 1 and $OnUpdate == true){
            $this -> errors = ("This ITEM_ID is NOT exists, Try another one !.");
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($Quantity -> _Quantity, "Quantity") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else {
            return true;
        }
        //-------------------------------------------------------------------------------------------------------
    }
    
    private function Name($name) {
        
        $name = strtolower($name);
        $name = ucwords($name);
        $name = str_replace("_", " ", $name);
        
        return $name;
}
}

   