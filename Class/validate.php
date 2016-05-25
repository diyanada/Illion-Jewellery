<?php 

class validate{
	public $errors = NULL;
	
	public function isNotEmpty($value, $msg){
		if ($value == "" and $value != 0){
			$this -> errors = $msg . " can't be empty.";
			return false;
		}
		else
			return true;
	}
	
	public function AlphaOrWhitespace($value, $msg){
		if (preg_match("/^[a-z\s]*$/i", $value) == false){
			$this -> errors = $msg . " can't contain non alpha characters.";
			return false;
		}		else
			return true;
	}
	
	public function Alpha($value, $msg){
		if (preg_match("/^[a-z]+$/i", $value) == false){
			$this -> errors = $msg . " can't contain non alpha characters or spaces.";
			return false;
		}
		else
			return true;
	}
	
	public function AlphaNumeric($value, $msg){
		if (preg_match("/^[a-z0-9]+$/i", $value) == false){
			$this -> errors = $msg . " can't contain non alphanumeric characters.";
			return false;
		}
		else
			return true;
	}
	
	public function Password($value, $msg){
		
		if (preg_match("/[0-9]/", $value) == false){
			$this -> errors = $msg . " must contain at least one number (0-9)!.";
			return false;
		}
		else if (preg_match("/[a-z]/", $value) == false){
			$this -> errors = $msg . " must contain at least one lowercase letter (a-z)!.";
			return false;
		}
		else if (preg_match("/[A-Z]/", $value) == false){
			$this -> errors = $msg . " must contain at least one uppercase letter (A-Z)!.";
			return false;
		}
		else
			return true;
	}
	
	public function PaswordCP($value, $value2, $msg){
		if ($value != $value2){
			$this -> errors = $msg . " must match with password.";
			return false;
		}
		else
			return true;
	}
	
	public function AlphaNumericOrWhitespace($value, $msg){
		if (preg_match("/^[a-z0-9\s]*$/i", $value) == false){
			$this -> errors = $msg . " can't contain non alphanumeric characters.";
			return false;
		}
		else
			return true;
	}
	
	public function isEmail($value, $msg){
		
		$rex = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
		
		if (preg_match($rex, $value) == false){
			$this -> errors = $msg . " is not valid.";
			return false;
		}
		else
			return true;
	}
	
	public function isTel($value, $msg){
            if (preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im", $value) == false) {
            $this->errors = $msg . " is not valid.";
            return false;
        } 
        else {
            return true;
        }
    }
        
        public function isPrice($value, $msg){
            if (preg_match("/^(\d{1,3})?(,?\d{3})*(\.\d{2})?$/", $value) == false) {
            $this->errors = $msg . " is not valid.";
            return false;
        } 
        else {
            return true;
        }
    }
    
        public function isNumber($value, $msg){
            if (preg_match("/^\+?(0|[1-9]\d*)$/", $value) == false) {
            $this->errors = $msg . " is not number.";
            return false;
        } 
        else {
            return true;
        }
    }
	
	public function fromDB(array $data, $table){
		require_once (dirname(__FILE__) . '/system_strings.php');
		$sql = new system_strings();
		
		$link = $sql -> connect();
		if($link == false){
			$sql -> error();
			return false;
		}
		
		$temp = "SELECT * FROM " . $table . " WHERE ";
		
		$i = 0;
			
			foreach ($data as $key => $value) {
                            if ($i == 0) {
                                $temp .= " " . $key . " = '" . $value . "' ";
                            } else {
                                $temp .= " AND " . $key . " = '" . $value . "' ";
                            }

            $i++;
			}
		
		$result = $sql -> query($link, $temp);
		if($result == false){
			$sql -> error();
			$sql -> roleback($link);
			return false;
		}
		
		$ret = $sql -> row($result);
		
		$sql -> close ($link);
		
		return $ret;
	}
        
        public function Between($value, $msg, $min, $max){
		if (!is_numeric($value)){
			$this -> errors = $msg . " is not a number.";
			return false;
		}
                else if($value < $min){
                    $this -> errors = $msg . " must greater than " . $min . ".";
                    return false;
                }
                else if($value > $max){
                    $this -> errors = $msg . " must less than " . $max . ".";
                    return false;
                }
		else{
			return true;
                }
	}
	
	function error(){
		$ret =  $this -> errors;
		$this -> errors = NULL;
                return $ret;
	}
}
