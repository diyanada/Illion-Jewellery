<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class Basket {
    
    public $_Id = NULL;
    public $_ItemId = NULL;
    public $_UserId = NULL;
    public $_IsPerches = 0;
    public $_Quantity = NULL;
    public $_Amount = 0.00;
    public $_Discount = 0.00;
    public $_Tax = 0.00;
    public $_InvoiceId = NULL;
    public $_CreateBy = NULL;
    public $_DisplayName = NULL;
    public $_Name = NULL;
    public $_Deleted = 0;     
     
}
class BasketMapper {
    
    private $errors;
    
    public function  error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }

    private function Validate(Basket $Basket, $OnUpdate = false){
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate(); 
        
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ID" => $Basket -> _Id), "BASKET") != 1 and $OnUpdate == true){
            $this -> errors = ("<br />This ID is NOT exists!.");
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
	else if($valid -> fromDB(array("ID" => $Basket -> _ItemId), "ITEM") != 1 and $OnUpdate == true){
            $this -> errors = ("<br />This ID is NOT exists!.");
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
	else if($valid -> fromDB(array("ID" => $Basket -> _UserId), "SYSTEM_USER") != 1 and $OnUpdate == true){
            $this -> errors = ("<br />This ID is NOT exists!.");
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
	else if($valid -> isPrice($Basket -> _Amount, "Amount") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
	else if($valid -> isPrice($Basket -> _Tax, "Tax") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else {
            return true;
        }
    }
    
    public function Insert(Basket $Basket, $Connection){
        
        if ($this -> Validate($Basket) == false){
            return false;
        }
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array(
            "ID" => $Basket -> _Id
            , "ITEM_ID" => $Basket -> _ItemId
            , "USER_ID" => $Basket -> _UserId
            , "QUANTITY" => $Basket -> _Quantity
            , "AMOUNT" => $Basket -> _Amount
            , "DISCOUNT" => $Basket -> _Discount
            , "TAX" => $Basket -> _Tax
            , "INVICE_ID" => $Basket -> _InvoiceId
            , "CREATED_BY" => $Basket -> _CreateBy
            , "CREATED_DATETIME" => date("Y-m-d H:i:s")
        );
        
        $temp = $query -> insertINTO("BASKET", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Update(Basket $Basket, $Connection){
        
         if ($this -> Validate($Basket, true) == false){
            return false;
        }
               
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        
        $temp = $query -> update(
                   array(
                   array ("ITEM_ID", $Basket -> _ItemId)
                        , array ("USER_ID", $Basket -> _UserId)  
                        , array ("IN_PERCHES", $Basket -> _InPerches)
                        , array ("PRICE", $Basket -> _Price)
                        , array ("CREATED_BY", $Basket -> _CreateBy)
                        , array ("CREATED_DATETIME", date("Y-m-d H:i:s"))
                    )
                    , "BASKET"
                    , array(
                        array("ID" , $Basket -> _Id)
                    )
                    );
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Delete(Basket $Basket, $Connection){
        
        if ($this -> Validate($Basket) == false){
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
                    , "BASKET"
                    , array(
                        array("ID" , $Basket -> _Id)
                    )
                    );
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
                
    }
    
    public function Search(Basket $Basket, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "BASKET.ID", "%" . $Basket -> _Id . "%", "LIKE");
        $where = $query ->Data($where, "BASKET.ITEM_ID", "%" . $Basket -> _ItemId . "%", "LIKE");
        $where = $query ->Data($where, "BASKET.USER_ID", "%" . $Basket -> _UserId . "%", "LIKE");
        $where = $query ->Data($where, "BASKET.IS_PERCHES", $Basket -> _IsPerches);
        $where = $query ->Data($where, "BASKET.QUANTITY", "%" . $Basket -> _Quantity . "%", "LIKE");
        $where = $query ->Data($where, "BASKET.DELETED", $Basket -> _Deleted);
        
        $data = array("BASKET", "ITEM_ID", "ITEM" ,"ID");         
        $join = array($query ->Join($data));
        $select = array("BASKET.ID", "BASKET.ITEM_ID", "USER_ID", "IS_PERCHES", "QUANTITY", "BASKET.CREATED_BY", "NAME", "DISPLAY_NAME");
        
        $temp = $query -> select($query -> From("BASKET", $join), $query -> DataCombine($where), $select);

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        
        $BasketArray = array();
        
        $row = $result -> fetch_fields() ;
                
        $Basket = new Basket();

        $Basket -> _Id = $this -> Name($row[0]->name);
        $Basket -> _ItemId = $this -> Name($row[1]->name);
        $Basket -> _UserId = $this -> Name($row[2]->name);
        $Basket -> _IsPerches = $this -> Name($row[3]->name);
        $Basket -> _Quantity = $this -> Name($row[4]->name);
        $Basket -> _Name = $this -> Name($row[5]->name);
        $Basket -> _DisplayName = $this -> Name($row[6]->name);
        
        array_push($BasketArray, $Basket);
        
        while ($row = $result -> fetch_assoc()) {
            $Basket = new Basket();
            
            $Basket -> _Id = $row["ID"];
            $Basket -> _ItemId = $row["ITEM_ID"];
            $Basket -> _UserId = $row["USER_ID"];
            $Basket -> _IsPerches = $row["IS_PERCHES"];
            $Basket -> _Quantity = $row["QUANTITY"];
            $Basket -> _CreateBy = $row["CREATED_BY"];
            $Basket -> _Name = $row["NAME"];
            $Basket -> _DisplayName = $row["DISPLAY_NAME"];
            
            array_push($BasketArray, $Basket);
        }
               
        return $BasketArray; 
        
        
    }
    
    public function Select(Basket $Basket, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", $Basket -> _Id);
        $where = $query ->Data($where, "DELETED", $Basket -> _Deleted);
        
        $temp = $query -> select($query -> From("BASKET"),$query -> DataCombine($where));
        
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
        
        $Basket = new Basket;       
        $Basket -> _Id = $actor["ID"];
        $Basket -> _ItemId = $actor["ITEM_ID"];
        $Basket -> _UserId = $actor["USER_ID"];
        $Basket -> _InPerches = $actor["IS_PERCHES"];
        $Basket -> _Quantity = $actor["QUANTITY"];
        $Basket -> _Amount = $actor["AMOUNT"];
        $Basket -> _Discount = $actor["DISCOUNT"];
        $Basket -> _Tax = $actor["TAX"];
        $Basket -> _InvoiceId = $actor["INVICE_ID"];
        $Basket -> _CreateBy = $actor["CREATED_BY"];
        $Basket -> _Deleted = $actor["DELETED"];
        
        return $Basket; 
        
    }
    
    private function Name($name) {
        
        $name = strtolower($name);
        $name = ucwords($name);
        $name = str_replace("_", " ", $name);
        
        return $name;
    }
}
