<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class ItemImage {
  
    public $_Id = NULL;
    public $_ItemId = NULL;
    public $_TypeId = NULL;
    public $_Image = NULL;
    public $_CreateBy = NULL;
    public $_Deleted = 0;     
     
}
class ItemImageMapper {
    
    private $errors;
    
    public function  error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }
        
    public function Insert(ItemImage $ItemImage, $Connection){
        
        if ($this -> Validate($ItemImage) == false){
            return false;
        }
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array("ID" => $ItemImage -> _Id
                , "ITEM_ID" => $ItemImage -> _ItemId
                , "TYPE_ID" => $ItemImage -> _TypeId
                , "IMAGE" => $ItemImage -> _Image
                , "CREATED_BY" => $ItemImage -> _CreateBy
                , "CREATED_DATETIME" => date("Y-m-d H:i:s")
            );
        
        $temp = $query -> insertINTO("ITEM_IMAGE", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> errors();
            return false;
        }
        
        return $result;      
        
        
    }
    
    public function Update(ItemImage $ItemImage, $Connection){
        
        if ($this -> Validate($ItemImage, true) == false){
            return false;
        }
               
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        
        $temp = $query -> update(
                   array(
                   array ("ITEM_ID", $Item -> _ItemId)
                        , array ("IMAGE_ID", $Item -> _ImageId)
                        , array ("TYPE", $Item -> _Type)                                   
                        , array ("CREATED_BY", $Item -> _CreateBy) 
                        , array ("CREATED_DATETIME", date("Y-m-d H:i:s"))
                    )
                    , "ITEMIMAGE"
                    , array(
                        array("ID" , $ItemImage -> _Id)
                    )
                    );
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Delete(ItemImage $ItemImage, $Connection){
        
        if ($this -> Validate($ItemImage) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "DELETED", 1);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $ItemImage -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $ItemImage -> _Id);
        
        $temp = $query -> update("ITEM_IMAGE", $data, $query -> DataCombine($where));   
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Select(ItemImage $ItemImage, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();        
        
        $where = array();
        $where = $query ->Data($where, "ID", $ItemImage -> _Id);
        $where = $query ->Data($where, "DELETED", $ItemImage -> _Deleted);
        
        $temp = $query -> select($query -> From("ITEM_IMAGE"),$query -> DataCombine($where));

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        $actor = $sql->actors($result);
        
        $ItemImage = new ItemImage;       
        $ItemImage -> _Id = $actor["ID"];
        $ItemImage -> _ItemId = $actor["ITEM_ID"];
        $ItemImage -> _TypeId = $actor["TYPE_ID"];
        $ItemImage -> _Image = $actor["IMAGE"];
        $ItemImage -> _CreateBy = $actor["CREATED_BY"];
        $ItemImage -> _Deleted = $actor["DELETED"];
        
        return $ItemImage; 
        
    }
    
    public function SelectSlide(ItemImage $ItemImage, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();        
        
        $where = array();
        if ($ItemImage -> _TypeId != NULL){
            $where = $query ->Data($where, "TYPE_ID", $ItemImage -> _TypeId);
        }  
        $where = $query ->Data($where, "ITEM_ID", $ItemImage -> _ItemId);
        $where = $query ->Data($where, "DELETED", $ItemImage -> _Deleted);
        
        $temp = $query -> select($query -> From("ITEM_IMAGE"),$query -> DataCombine($where));

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        $Image = array();
        
        if($sql ->row($result) == 0){
            array_push($Image, "DEFAULT.JPG");
        }
        else{
            while ($row = $result -> fetch_assoc()) {

                array_push($Image, $row["IMAGE"]);
            }
        }       
        
        return $Image; 
        
    }
    
    public function Search(ItemImage $ItemImage, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", "%" . $ItemImage -> _Id . "%", "LIKE");        
        $where = $query ->Data($where, "TYPE_ID", "%" . $ItemImage -> _TypeId . "%", "LIKE");
        $where = $query ->Data($where, "DELETED", $ItemImage -> _Deleted);
        
        
        $temp = $query -> select($query -> From("ITEM_IMAGE"),$query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        
        $ItemArray = array();
        
        $row = $result -> fetch_fields() ;
                
        $ItemImage = new ItemImage;

        $ItemImage -> _Id = $this -> Name($row[0]->name);
        $ItemImage -> _ItemId = $this -> Name($row[1]->name);
        $ItemImage -> _TypeId = $this -> Name($row[2]->name);
        $ItemImage -> _Image = $this -> Name($row[3]->name);
        $ItemImage -> _CreateBy = $this -> Name($row[4]->name);

        array_push($ItemArray, $ItemImage);
        
        while ($row = $result -> fetch_assoc()) {
            $ItemImage = new ItemImage;

            $ItemImage -> _Id = $row["ID"];
            $ItemImage -> _ItemId = $row["ITEM_ID"];
            $ItemImage -> _TypeId = $row["TYPE_ID"];
            $ItemImage -> _Image = $row["IMAGE"];
            $ItemImage -> _CreateBy = $row["CREATED_BY"];
            
            array_push($ItemArray, $ItemImage);
        }
               
        return $ItemArray; 
        
        
    }
    
    private function Validate(ItemImage $ItemImage, $OnUpdate = false){
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate();    
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ID" => $ItemImage -> _Id), "ITEM_IMAGE") != 1 and $OnUpdate == true){
            $this -> errors = ("This ID is NOT exists, Try another one !.");
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
