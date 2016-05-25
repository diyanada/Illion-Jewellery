<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class UserDetails {
    
     public $_UserId = NULL;
     public $_AvatarImageId = NULL;
     public $_FirstName = NULL;
     public $_LastName = NULL;
     public $_Address = NULL;
     public $_Email = NULL;
     public $_Tel = NULL;
     public $_CreateBy = NULL;
     public $_Deleted = NULL;    
     
}
class UserDetailsMapper {
    
    private $errors;
    
    public function  error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }
    
    public function Insert(UserDetails $UserDetails, $Connection){
        
        if ($this -> Validate($UserDetails) == false){
            return false;
        }
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array(
            "USER_ID" => $UserDetails -> _UserId
            , "AVATAR_IMAGE_ID" => $UserDetails -> _AvatarImageId
            , "FIRST_NAME" => $UserDetails -> _FirstName
            , "LAST_NAME" => $UserDetails -> _LastName
            , "ADDRESS" => $UserDetails -> _Address
            , "EMAIL" => $UserDetails -> _Email
            , "TEL" => $UserDetails -> _Tel
            , "CREATED_BY" => $UserDetails -> _CreateBy
            , "CREATED_DATETIME" => date("Y-m-d H:i:s")
        );
        $temp = $query -> insertINTO("USER_DETAILS", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
        
    }
    
    public function Update(UserDetails $UserDetails, $Connection){
        
        if ($this -> Validate($UserDetails, true) == false){
            return false;
        }
               
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();   
        
        $data = array();
        $data = $query ->Data($data, "FIRST_NAME", $UserDetails -> _FirstName);
        $data = $query ->Data($data, "LAST_NAME", $UserDetails -> _LastName);
        $data = $query ->Data($data, "ADDRESS", $UserDetails -> _Address);
        $data = $query ->Data($data, "EMAIL", $UserDetails -> _Email);
        $data = $query ->Data($data, "TEL", $UserDetails -> _Tel);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $UserDetails -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "USER_ID", $UserDetails -> _UserId);
        
        $temp = $query -> update("USER_DETAILS", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
            
    public function Delete(UserDetails $UserDetails, $Connection){
        
        if ($this -> Validate($UserDetails, true) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
                
        $data = array();
        $data = $query ->Data($data, "DELETED", 1);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $UserDetails -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "USER_ID", $UserDetails -> _UserId);
        
        $temp = $query -> update("USER_DETAILS", $data, $query -> DataCombine($where));  
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Select(UserDetails $UserDetails, $Connection){
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
                
        $where = array();
        $where = $query ->Data($where, "USER_ID", $UserDetails -> _UserId);
        $where = $query ->Data($where, "DELETED", $UserDetails -> _Deleted);
        
        $temp = $query -> select($query -> From("USER_DETAILS"),$query -> DataCombine($where));

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
        
        $UserDetails = new UserDetails;
        
        $UserDetails -> _UserId = $actor["USER_ID"];
        $UserDetails -> _AvatarImageId = $actor["AVATAR_IMAGE_ID"];
        $UserDetails -> _FirstName = $actor["FIRST_NAME"];
        $UserDetails -> _LastName = $actor["LAST_NAME"];
        $UserDetails -> _Address = $actor["ADDRESS"];
        $UserDetails -> _Email = $actor["EMAIL"];
        $UserDetails -> _Tel = $actor["TEL"];
        $UserDetails -> _CreateBy = $actor["CREATED_BY"];
        $UserDetails -> _Deleted = $actor["DELETED"];
        
        return $UserDetails; 
               
    }
    
    private function Validate(UserDetails $UserDetails, $OnUpdate = false){
        
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate(); 
        
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("USER_ID" => $UserDetails -> _UserId), "USER_DETAILS") != 1 and $OnUpdate == true){
            $this -> errors = ("This ID is NOT exists!.");
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($UserDetails -> _FirstName, "First Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid -> AlphaOrWhitespace($UserDetails -> _FirstName, "First Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
	else if($valid -> isNotEmpty($UserDetails -> _LastName, "Last Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid -> Alpha($UserDetails ->_LastName, "Last Name") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($UserDetails -> _Address, "Address") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
	else if($valid -> isNotEmpty($UserDetails -> _Email, "E-mai") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid -> isEmail($UserDetails -> _Email, "E-mail") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        else if($valid -> fromDB(array("EMAIL" => $UserDetails -> _Email), "USER_DETAILS") != 0 and $OnUpdate == false){
            $this -> errors = ("This E-mail is already exists, Try another one !.");
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
	else if($valid -> isNotEmpty($UserDetails -> _Tel, "Tel Number") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid -> isTel($UserDetails -> _Tel, "Tel Number") == false){
            $this -> errors = $valid -> error();
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else {
            return true;
        }
        //-------------------------------------------------------------------------------------------------------
    }
    
}
