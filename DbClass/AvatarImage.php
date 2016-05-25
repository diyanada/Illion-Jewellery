<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class AvatarImage {
    
     public $_Id = NULL;
     public $_Image = NULL;
     public $_CreateBy = NULL;
     public $_Deleted = 0;     
     
}
class AvatarImageMapper {
    
    private $errors;
    
    public function  error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }
    
    public function Insert(AvatarImage $AvatarImage, $Connection){
        
        if ($this -> Validate($AvatarImage) == false){
            return false;
        }
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array(
            "ID" => $AvatarImage -> _Id
            , "IMAGE" => $AvatarImage -> _Image
            , "CREATED_BY" => $AvatarImage -> _CreateBy
            , "CREATED_DATETIME" => date("Y-m-d H:i:s")
        );
        $temp = $query -> insertINTO("AVATAR_IMAGE", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
        
    }
    
    public function Update(AvatarImage $AvatarImage, $Connection){
                
        if ($this -> Validate($AvatarImage, true) == false){
            return false;
        }
               
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "IMAGE", $AvatarImage -> _Image);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $AvatarImage -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $AvatarImage -> _Id);
        
        $temp = $query -> update("AVATAR_IMAGE", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Delete(AvatarImage $AvatarImage, $Connection){
        
        if ($this -> Validate($AvatarImage, true) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "DELETED", 1);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $AvatarImage -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $AvatarImage -> _Id);
        
        $temp = $query -> update("AVATAR_IMAGE", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Select(AvatarImage $AvatarImage, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", $AvatarImage -> _Id);
        $where = $query ->Data($where, "DELETED", $AvatarImage -> _Deleted);
        
        $temp = $query -> select($query -> From("AVATAR_IMAGE"),$query -> DataCombine($where));

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
        
        $AvatarImage = new AvatarImage;
        
        $AvatarImage -> _Id = $actor["ID"];
        $AvatarImage -> _Image = $actor["IMAGE"];
        $AvatarImage -> _CreateBy = $actor["CREATED_BY"];
        $AvatarImage -> _Deleted = $actor["DELETED"];
        
        return $AvatarImage; 
        
    }

    private function Validate(AvatarImage $AvatarImage, $OnUpdate = false){
        
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate();    
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ID" => $AvatarImage -> _Id), "AVATAR_IMAGE") != 1 and $OnUpdate == true){
            $this -> errors = ("This ID is NOT exists, Try another one !.");
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else {
            return true;
        }
        //-------------------------------------------------------------------------------------------------------
    }
}
