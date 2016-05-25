<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class Stock {
    
    public $_ItemId = NULL;
    public $_Quantity = NULL; 
    public $_CreateBy = NULL;
    public $_Deleted = 0; 
     
}
class StockMapper {
    
    private $errors;
    
    public function  error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }
    
    public function Insert(Stock $Stock, $Connection){
        
        if ($this -> Validate($Stock) == false){
            return false;
        }
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array(
            "ITEM_ID" => $Stock -> _ItemId
            , "QUANTITY" => $Stock -> _Quantity
            , "CREATED_BY" => $Stock -> _CreateBy
            , "CREATED_DATETIME" => date("Y-m-d H:i:s")
        );
        $temp = $query -> insertINTO("STOCK", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
        
    }
    
    public function Update(Stock $Stock, $Connection){
                
        if ($this -> Validate($Stock) == false){
            return false;
        }
               
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "ITEM_ID", $Stock -> _ItemId);
        $data = $query ->Data($data, "QUANTITY", $Stock -> _Quantity);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $Stock -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ITEM_ID", $Stock -> _ItemId);
        
        $temp = $query -> update("STOCK", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Delete(Stock $Stock, $Connection){
        
        if ($this -> Validate($Stock, true) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "DELETED", 1);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $Stock -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ITEM_ID", $Stock -> _ItemId);
        
        $temp = $query -> update("STOCK", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Select(Stock $Stock, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ITEM_ID", $Stock -> _ItemId);
        $where = $query ->Data($where, "DELETED", $Stock -> _Deleted);
        
        $temp = $query -> select($query -> From("STOCK"),$query -> DataCombine($where));

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
        
        $Stock = new Stock;
        
        $Stock -> _ItemId = $actor["ITEM_ID"];
        $Stock -> _Quantity = $actor["QUANTITY"];
        $Stock -> _CreateBy = $actor["CREATED_BY"];
        $Stock -> _Deleted = $actor["DELETED"];
        
        return $Stock; 
        
    }

    public function Search(Stock $Stock, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ITEM_ID", "%" . $Stock -> _ItemId . "%", "LIKE");
        $where = $query ->Data($where, "QUANTITY", "%" . $Stock -> _Quantity . "%", "LIKE");
        $where = $query ->Data($where, "DELETED", $Stock -> _Deleted);
        
        $temp = $query -> select($query -> From("STOCK"),$query -> DataCombine($where));

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
         
        
        $StockArray = array();
        
        $row = $result -> fetch_fields() ;
                
        $Stock = new Stock;

        $Stock -> _ItemId = $this -> Name($row[1]->name);
        $Stock -> _Quantity = $this -> Name($row[2]->name);
        $Stock -> _CreateBy = $this -> Name($row[3]->name);

        array_push($StockArray, $Stock);
        
        while ($row = $result -> fetch_assoc()) {
            $Stock = new Stock();
                       
            $Stock -> _ItemId = $row["ITEM_ID"];
            $Stock -> _Quantity = $row["QUANTITY"];
            $Stock -> _CreateBy = $row["CREATED_BY"];
            
            array_push($StockArray, $Stock);
        }
               
        return $StockArray; 
        
        
    }
    
    private function Validate(Stock $Stock, $OnUpdate = false){
        
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate();    
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ITEM_ID" => $Stock -> _ItemId), "STOCK") != 1 and $OnUpdate == true){
            $this -> errors = ("This ID is NOT exists, Try another one !.");
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($Stock -> _Quantity, "Quantity" ) == false){
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
