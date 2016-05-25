<?php

/* 
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

class SystemUser {

    public $_Id = NULL;
    public $_Username = NULL;
    public $_Password = NULL;
    public $_Password2 = NULL;
    public $_PasswordOld = NULL;
    public $_Password2Old = NULL;
    public $_Counter = NULL;
    public $_LastLogin = NULL;
    public $_IsAdmin = 0;
    public $_CreateBy = NULL;
    public $_Deleted = 0;

}

class SystemUserMapper {
    
    private $errors = NULL;
    
    public function error(){
        $er = $this -> errors;
        $this -> errors = null;
        return $er;
    }
    
    public function Insert(SystemUser $SystemUser, $Connection){
        
        if ($this -> Validate($SystemUser) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array(
            "ID" => $SystemUser -> _Id
            , "USERNAME" => $SystemUser -> _Username
            , "PASSWORD" => $SystemUser -> _Password
            , "CREATED_BY" => $SystemUser -> _CreateBy
            , "CREATED_DATETIME" => date("Y-m-d H:i:s")
        );
        $temp = $query -> insertINTO("SYSTEM_USER", $data);
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Update(SystemUser $SystemUser, $Connection){
        
        if ($this -> Validate($SystemUser, true) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "PASSWORD", $SystemUser -> _Password);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $SystemUser -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $SystemUser -> _Id);
        
        $temp = $query -> update("SYSTEM_USER", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Delete(SystemUser $SystemUser, $Connection){
        
        if ($this -> Validate($SystemUser, true) == false){
            return false;
        }
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "DELETED", 1);
        $data = $query ->Data($data, "LAST_UPDATED_BY", $SystemUser -> _CreateBy);
        $data = $query ->Data($data, "LAST_UPDATED_TIME", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $SystemUser -> _Id);
        
        $temp = $query -> update("SYSTEM_USER", $data, $query -> DataCombine($where));        
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        return $result;
        
    }
    
    public function Select(SystemUser $SystemUser, $Connection){
        
        
                
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();
        $where = $query ->Data($where, "ID", $SystemUser -> _Id);
        $where = $query ->Data($where, "DELETED", $SystemUser -> _Deleted);
        
        $temp = $query -> select($query -> From("SYSTEM_USER"),$query -> DataCombine($where));
        

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
        
        $SystemUser = new SystemUser;
        
        $SystemUser -> _Id = $actor["ID"];
        $SystemUser -> _Username = $actor["USERNAME"];
        $SystemUser -> _Password = $actor["PASSWORD"];
        $SystemUser -> _Password2 = $actor["PASSWORD"];
        $SystemUser -> _PasswordOld = $actor["PASSWORD"];
        $SystemUser -> _Password2Old = $actor["PASSWORD"];
        $SystemUser -> _Counter = $actor["COUNTER"];
        $SystemUser -> _LastLogin = $actor["LAST_LOGING"];
        $SystemUser -> _IsAdmin = $actor["IS_ADMIN"];
        $SystemUser -> _CreateBy = $actor["CREATED_BY"];
        $SystemUser -> _Deleted = $actor["DELETED"];
        
        return $SystemUser; 
        
    }
    
    public function Login(SystemUser $SystemUser, $Connection){
        
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
        session_unset();
        session_destroy();
        
        $SystemUser  = $this ->LoginCheck($SystemUser, $Connection);
        
        if($SystemUser == false){
            return false;
        }
        
        return $this ->Session($SystemUser, $Connection);
        
    }
    
    public function LoginAdmin(SystemUser $SystemUser, $Connection){
        
        $SystemUser -> _IsAdmin = 1;
        
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
        session_unset();
        session_destroy();
        
        $SystemUser = $this ->LoginCheck($SystemUser, $Connection);
        
        if($SystemUser  == false){
            return false;
        }
        
        return $this ->Session($SystemUser, $Connection, 1);
        
    }

    private function Validate(SystemUser $SystemUser, $OnUpdate = false){
        
        require_once (dirname(__FILE__) . '/../Class/validate.php');
        $valid = new validate();    
        //-------------------------------------------------------------------------------------------------------
	if($valid -> fromDB(array("ID" => $SystemUser -> _Id), "SYSTEM_USER") != 1 and $OnUpdate == true){
            $this -> errors = ("This ID is NOT exists, Try another one !.");
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($SystemUser -> _Username, "Username") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid -> AlphaNumeric($SystemUser -> _Username, "Username") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid -> fromDB(array("USERNAME" => $SystemUser -> _Username), "SYSTEM_USER") != 0 and $OnUpdate == false){
            $this -> errors = ("This username is already exists, Try another one !.");
            return false;
	}
	//-------------------------------------------------------------------------------------------------------
        else if($valid -> isNotEmpty($SystemUser -> _Password, "Password") == false){
            $this -> errors = $valid -> error();
            return false;
	}
	else if($valid ->PaswordCP($SystemUser -> _Password, $SystemUser -> _Password2, "Confirm Password" ) == false){
            $this -> errors = $valid -> error();
            return false;
	}
        else if($valid ->PaswordCP($SystemUser -> _PasswordOld, $SystemUser -> _Password2Old, "Old Password" ) == false){
            $this -> errors = $valid -> error();
            return false;
	}
        //-------------------------------------------------------------------------------------------------------
        else {
            return true;
        }
        //-------------------------------------------------------------------------------------------------------
    }
    
    public function LoginCheck(SystemUser $SystemUser, $Connection){
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $where = array();      
        
        if ($SystemUser -> _Id == NULL){
            $where = $query ->Data($where, "USERNAME", $SystemUser -> _Username);
            $where = $query ->Data($where, "PASSWORD", $SystemUser -> _Password);
        }
        else{
            $where = $query ->Data($where, "ID", $SystemUser -> _Id);
            $where = $query ->Data($where, "PASSWORD", $SystemUser -> _Password);            
        }
        
        $where = $query ->Data($where, "IS_ADMIN", $SystemUser -> _IsAdmin);
        $where = $query ->Data($where, "DELETED", 0);
        
        $temp = $query -> select($query -> From("SYSTEM_USER"),$query -> DataCombine($where), array("ID, COUNTER"));

        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
                
        if($sql -> row($result) !=  1){
            $this -> errors = "Username or password is incorrect.";
            return false;
        }
        
        $actor = $sql->actors($result);
        
        $user = new SystemUser();
        $user ->_Id = $ID = $actor["ID"];
        $user ->_Counter = $ID = $actor["ID"];
        
        return $user;
        
    }
    
    private function Session(SystemUser $SystemUser, $Connection, $IsAdmin = 0){
        
        require_once (dirname(__FILE__) . '/../Class/query.php');
        $query = new query();
        
        require_once (dirname(__FILE__) . '/../Class/system_strings.php');
        $sql = new system_strings();
        
        $data = array();
        $data = $query ->Data($data, "COUNTER", $SystemUser -> _Counter + 1);
        $data = $query ->Data($data, "LAST_LOGING", date("Y-m-d H:i:s"));
        
        $where = array();
        $where = $query ->Data($where, "ID", $SystemUser -> _Id);
        
        $temp = $query -> update("SYSTEM_USER", $data, $query -> DataCombine($where));
        
        $result = $sql -> query($Connection, $temp);
        
        if($result == false){
            $this -> errors = $sql -> error();
            return false;
        }
        
        session_start(); 

            $_SESSION['userid'] = $SystemUser -> _Id;
            $_SESSION['uname'] = $SystemUser -> _Username;
            $_SESSION['admin'] = $IsAdmin;
            $_SESSION['login'] = true;
            $_SESSION['password'] = $SystemUser -> _Password ;


        return true;
    }
    
}