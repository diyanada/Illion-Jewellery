<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class ItemOfferType {
    
     public $_Id = NULL;
     public $_Name = NULL;
     public $_IsIncrease = NULL;
     public $_Percentage = NULL;
     public $_CreateBy = NULL;
     public $_Deleted = 0;     
     
}
class ItemOfferTypeMapper {
    
    private $errors;
    
    public function error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }
    
    public function Insert(ItemOfferType $ItemOfferType, $Connection){
        
        if ($this -> Validate($ItemOfferType) == false){
            return false;
        }
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array(
            "ID" => $ItemOfferType -> _Id
            , "NAME" => $ItemOfferType -> _Name
            , "IS_INCREASE" => $ItemOfferType -> _IsIncrease
            , "PERCENTAGE" => $ItemOfferType -> _Percentage
            , "CREATED_BY" => $ItemOfferType -> _CreateBy
            , "CREATED_DATETIME" => date("Y-m-d H:i:s")
        );
        $temp = $query -> insertINTO("ITEM_OFFER_TYPE", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
        
    }
    
    public function Update(ItemOfferType $ItemOfferType, $Connection){
                
        if ($this -> Validate($ItemOfferType, true) == false){
            return false;
        }
               
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "NAME", $ItemOfferType -> _Name);
        $data = $query ->Data($data, "IS_INCREASE", $ItemOfferType -> _IsIncrease);
        $data = $query ->Data($data, "PERCENTAGE", $ItemOfferType -> _Percentage);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $ItemOfferType -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $ItemOfferType -> _Id);
        
        $temp = $query -> update("ITEM_OFFER_TYPE", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Delete(ItemOfferType $ItemOfferType, $Connection){
        
        if ($this -> Validate($ItemOfferType, true, true) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "DELETED", 1);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $ItemOfferType -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $ItemOfferType -> _Id);
        
        $temp = $query -> update("ITEM_OFFER_TYPE", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Select(ItemOfferType $ItemOfferType, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", $ItemOfferType -> _Id);
        $where = $query ->Data($where, "DELETED", $ItemOfferType -> _Deleted);
        
        $temp = $query -> select($query -> From("ITEM_OFFER_TYPE"),$query -> DataCombine($where));

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
        
        $ItemOfferType = new ItemOfferType;
        
        $ItemOfferType -> _Id = $actor["ID"];
        $ItemOfferType -> _Name = $actor["NAME"];
        $ItemOfferType -> _IsIncrease = $actor["IS_INCREASE"];
        $ItemOfferType -> _Percentage = $actor["PERCENTAGE"];
        $ItemOfferType -> _CreateBy = $actor["CREATED_BY"];
        $ItemOfferType -> _Deleted = $actor["DELETED"];
        
        return $ItemOfferType; 
        
    }
    
    public function Search(ItemOfferType $ItemOfferType, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", "%" . $ItemOfferType -> _Id . "%", "LIKE");
        $where = $query ->Data($where, "NAME", "%" . $ItemOfferType -> _Name . "%", "LIKE");
        $where = $query ->Data($where, "IS_INCREASE", "%" . $ItemOfferType -> _IsIncrease . "%", "LIKE");
        $where = $query ->Data($where, "PERCENTAGE", "%" . $ItemOfferType -> _Percentage . "%", "LIKE");
        $where = $query ->Data($where, "DELETED", $ItemOfferType -> _Deleted);
        
        $temp = $query -> select($query -> From("ITEM_OFFER_TYPE"),$query -> DataCombine($where));

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
         
        
        $ItemOfferTypeArray = array();
        
        $row = $result -> fetch_fields() ;
                
        $ItemOfferType = new ItemOfferType();  
        

        $ItemOfferType -> _Id = $this -> Name($row[0]->name);
        $ItemOfferType -> _Name = $this -> Name($row[1]->name);
        $ItemOfferType -> _IsIncrease = $this -> Name($row[2]->name);
        $ItemOfferType -> _Percentage = $this -> Name($row[3]->name);
        
        

        array_push($ItemOfferTypeArray, $ItemOfferType);
        
        while ($row = $result -> fetch_assoc()) {
            $ItemOfferType = new ItemOfferType();
            
            $ItemOfferType -> _Id = $row["ID"];
            $ItemOfferType -> _Name = $row["NAME"];
            $ItemOfferType -> _IsIncrease = $row["IS_INCREASE"];
            $ItemOfferType -> _Percentage = $row["PERCENTAGE"];
            $ItemOfferType -> _CreateBy = $row["CREATED_BY"];
            
            array_push($ItemOfferTypeArray, $ItemOfferType);
        }
        
        return $ItemOfferTypeArray; 
        
        
    }

    private function Validate(ItemOfferType $ItemOfferType, $OnUpdate = false , $OnDelete = false){
        
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate();    
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ID" => $ItemOfferType -> _Id), "ITEM_OFFER_TYPE") != 1 and $OnUpdate == true){
            $this -> errors = ("This ID is NOT exists, Try another one !.");
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($ItemOfferType -> _Name, "Type Name") == false and $OnDelete = false){
            $this -> errors = $valid -> error();
            return false;
	}
        else if($valid -> AlphaOrWhitespace($ItemOfferType -> _Name, "Type Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        if($valid -> fromDB(array("NAME" => $ItemOfferType -> _Name), "ITEM_OFFER_TYPE") != 0){
            $this -> errors = ("<br /> This Name is exist, Try another one !.");
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($ItemOfferType -> _Percentage, "Percentage") == false and $OnDelete = false){
            $this -> errors = $valid -> error();
            return false;
	}
        else if($valid ->Between($ItemOfferType -> _Percentage, "Percentage", 0, 100) == false  and $OnDelete = false){
            $this -> errors = $valid -> error();
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($ItemOfferType -> _IsIncrease, "IsIncrease") == false  and $OnDelete = false){
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
