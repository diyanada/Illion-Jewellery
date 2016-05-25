<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class Item {
  
    public $_Id = NULL;
    public $_TypeId = NULL;
    public $_Name = NULL;
    public $_DisplayName = NULL;
    public $_Description = NULL;
    public $_Price = NULL;
    public $_CreateBy = NULL;
    public $_Deleted = 0;     
     
}
class ItemMapper {
    
    private $errors;
    
    public function  error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }
    
    public function Insert(Item $Item, $Connection){
        
        if ($this -> Validate($Item) == false){
            return false;
        }
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array(
            "ID" => $Item -> _Id
            , "TYPE_ID" => $Item -> _TypeId
            , "NAME" => $Item -> _Name
            , "DISPLAY_NAME" => $Item -> _DisplayName
            , "DESCRIPTION" => $Item -> _Description
            , "PRICE" => floatval(str_replace(",", "", $Item -> _Price))
            , "CREATED_BY" => $Item -> _CreateBy
            , "CREATED_DATETIME" => date("Y-m-d H:i:s")
        );
        
        $temp = $query -> insertINTO("ITEM", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;      
        
    }
    
    public function Update(Item $Item, $Connection){
        
        if ($this -> Validate($Item, true) == false){
            return false;
        }
               
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "NAME", $Item -> _Name);
        $data = $query ->Data($data, "DISPLAY_NAME", $Item -> _DisplayName);
        $data = $query ->Data($data, "DESCRIPTION", $Item -> _Description);
        $data = $query ->Data($data, "PRICE", $Item -> _Price);
        $data = $query ->Data($data, "TYPE_ID", $Item -> _TypeId);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $Item -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $Item -> _Id);
        
        $temp = $query -> update("ITEM", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Delete(Item $Item, $Connection){
        
        if ($this -> Validate($Item) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        
        $temp = $query -> update(
                    array(
                    array ("DELETED", 1) 
                    )
                    , "ITEM"
                    , array(
                        array("ID" , $Item -> _Id)
                    )
                    );
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Select(Item $Item, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", $Item -> _Id);
        $where = $query ->Data($where, "DELETED", $Item -> _Deleted);
        
        $temp = $query -> select($query -> From("ITEM"),$query -> DataCombine($where));

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
        
        $Item = new Item;       
        $Item -> _Id = $actor["ID"];
        $Item -> _TypeId = $actor["TYPE_ID"];
        $Item -> _Name = $actor["NAME"];
        $Item -> _DisplayName = $actor["DISPLAY_NAME"];
        $Item -> _Description = $actor["DESCRIPTION"];
        $Item -> _Price = $actor["PRICE"];
        $Item -> _CreateBy = $actor["CREATED_BY"];
        $Item -> _Deleted = $actor["DELETED"];
        
        return $Item; 
        
    }
    
    public function Search(Item $Item, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", "%" . $Item -> _Id . "%", "LIKE");
        $where = $query ->Data($where, "TYPE_ID", "%" . $Item -> _TypeId . "%", "LIKE");
        $where = $query ->Data($where, "NAME", "%" . $Item -> _Name . "%", "LIKE");
        $where = $query ->Data($where, "DISPLAY_NAME", "%" . $Item -> _DisplayName . "%", "LIKE");
        $where = $query ->Data($where, "DESCRIPTION", "%" . $Item -> _Description . "%", "LIKE");
        $where = $query ->Data($where, "PRICE", "%" . $Item -> _Price . "%", "LIKE");
        $where = $query ->Data($where, "DELETED", $Item -> _Deleted);
        
        $temp = $query -> select($query -> From("ITEM"),$query -> DataCombine($where));

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        
        $ItemArray = array();
        
        $row = $result -> fetch_fields() ;
                
        $Item = new Item;

        $Item -> _Id = $this -> Name($row[0]->name);
        $Item -> _TypeId = $this -> Name($row[1]->name);
        $Item -> _Name = $this -> Name($row[2]->name);
        $Item -> _DisplayName = $this -> Name($row[3]->name);
        $Item -> _Description = $this -> Name($row[4]->name);
        $Item -> _Price = $this -> Name($row[5]->name);
        $Item -> _CreateBy = $this -> Name($row[6]->name);

        array_push($ItemArray, $Item);
        
        while ($row = $result -> fetch_assoc()) {
            $Item = new Item();
            
            $Item -> _Id = $row["ID"];
            $Item -> _TypeId = $row["TYPE_ID"];
            $Item -> _Name = $row["NAME"];
            $Item -> _DisplayName = $row["DISPLAY_NAME"];
            $Item -> _Description = $row["DESCRIPTION"];
            $Item -> _Price = $row["PRICE"];
            $Item -> _CreateBy = $row["CREATED_BY"];
            
            array_push($ItemArray, $Item);
        }
               
        return $ItemArray; 
        
        
    }
    
    private function Validate(Item $Item, $OnUpdate = false){
        
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate(); 
        
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ID" => $Item -> _Id), "ITEM") != 1 and $OnUpdate == true){
            $this -> errors = ("<br />This ID is NOT exists!.");
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($Item -> _Name, "Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid -> AlphaOrWhitespace($Item -> _DisplayName, "Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        if($valid -> fromDB(array("NAME" => $Item -> _Name), "ITEM") != 0){
            $this -> errors = ("<br /> This name is exists!.");
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
	else if($valid -> isNotEmpty($Item -> _DisplayName, "DisplayLast Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid -> AlphaOrWhitespace($Item ->_DisplayName, "Display Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ID" => $Item -> _TypeId), "ITEM_TYPE") != 1){
            $this -> errors = ("<br /> This ID is NOT exists!.");
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($Item -> _Description, "Description") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
	else if($valid -> isNotEmpty($Item -> _Price, "Price") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid ->isPrice($Item -> _Price, "Price") == false){
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

