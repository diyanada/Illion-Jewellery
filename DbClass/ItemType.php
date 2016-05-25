<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class ItemType {
   
    public $_Id = NULL;
    public $_Name = NULL;
    public $_CreateBy = NULL;
    public $_Deleted = 0;     
     
}
class ItemTypeMapper {
    
    private $errors;
    
    public function  error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }
    
    public function Insert(ItemType $ItemType, $Connection){
        
        if ($this -> Validate($ItemType) == false){
            return false;
        }
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array(
            "ID" => $ItemType -> _Id
            , "NAME" => $ItemType -> _Name
            , "CREATED_BY" => $ItemType -> _CreateBy
            , "CREATED_DATETIME" => date("Y-m-d H:i:s")
        );
        $temp = $query -> insertINTO("ITEM_TYPE", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
        
    }
    
    public function Update(ItemType $ItemType, $Connection){
                
        if ($this -> Validate($ItemType, true) == false){
            return false;
        }
               
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "NAME", $ItemType -> _Name);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $ItemType -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $ItemType -> _Id);
        
        $temp = $query -> update("ITEM_TYPE", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
    }
    
    public function Delete(ItemType $ItemType, $Connection){
        
        if ($this -> Validate($ItemType, true) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "DELETED", 1);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $ItemType -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $ItemType -> _Id);
        
        $temp = $query -> update("ITEM_TYPE", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Select(ItemType $ItemType, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", $ItemType -> _Id);
        $where = $query ->Data($where, "DELETED", $ItemType -> _Deleted);
        
        $temp = $query -> select($query -> From("ITEM_TYPE"),$query -> DataCombine($where));

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
        
        $ItemType = new ItemType;
        
        $ItemType -> _Id = $actor["ID"];
        $ItemType -> _Name = $actor["NAME"];
        $ItemType -> _CreateBy = $actor["CREATED_BY"];
        $ItemType -> _Deleted = $actor["DELETED"];
        
        return $ItemType; 
        
        
    }
    
    public function Search(ItemType $ItemType, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", "%" . $ItemType -> _Id . "%", "LIKE");
        $where = $query ->Data($where, "NAME", "%" . $ItemType -> _Name . "%", "LIKE");
        $where = $query ->Data($where, "DELETED", $ItemType -> _Deleted);
        
        $temp = $query -> select($query -> From("ITEM_TYPE"),$query -> DataCombine($where));

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        
        $ItemTypeArray = array();
        
        $row = $result -> fetch_fields() ;
                
        $ItemType = new ItemType;

        $ItemType -> _Id = ucwords(strtolower($row[0]->name));
        $ItemType -> _Name = ucwords(strtolower($row[1]->name));
        $ItemType -> _CreateBy = ucwords(strtolower($row[2]->name));
        $ItemType -> _Deleted = ucwords(strtolower($row[3]->name));

        array_push($ItemTypeArray, $ItemType);
        
        
        
        
        while ($row = $result -> fetch_assoc()) {
            $ItemType = new ItemType;
            
            $ItemType -> _Id = $row["ID"];
            $ItemType -> _Name = $row["NAME"];
            $ItemType -> _CreateBy = $row["CREATED_BY"];
            $ItemType -> _Deleted = $row["DELETED"];
            
            array_push($ItemTypeArray, $ItemType);
        }
        
        
        
        return $ItemTypeArray; 
        
        
    }
    
    private function Validate(ItemType $ItemType, $OnUpdate = false){
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate();    
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ID" => $ItemType -> _Id), "ITEM_TYPE") != 1 and $OnUpdate == true){
            $this -> errors = ("<br /> This ID is NOT exists, Try another one !.");
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($ItemType -> _Name, "Type Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        else if($valid -> AlphaOrWhitespace($ItemType -> _Name, "Type Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        if($valid -> fromDB(array("NAME" => $ItemType -> _Name), "ITEM_TYPE") != 0){
            $this -> errors = ("<br /> This Name is exist, Try another one !.");
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else {
            return true;
        }
        //-------------------------------------------------------------------------------------------------------
    }
    
}
