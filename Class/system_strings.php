<?php 

class system_strings{
	
	private $errors = NULL;

	function connect(){
		include dirname(__FILE__) . '/../owsh_secret.php';
			  
	  	$sql = new mysqli($server_name, $db_username, $db_password, $database);
	  
	  	if ($sql -> connect_errno) {
			$this -> errors = "<br /> Sorry, this website is experiencing problems. <br /><br />";
			$this -> errors .= "Error: Failed to make a MySQL connection, here is why: <br />";
			$this -> errors .= "Errno: " . $sql -> connect_errno . "<br />";
			$this -> errors .= "Error: " . $sql -> connect_error . "<br />";
		
			return false;
		}
		else { 
			return $sql; 
		}
	}
	
	function query($link, $sql){
		$result = $link -> query($sql);
		
		if ($result == false){
			$this -> errors = "<br /> Sorry, the website is experiencing problems .<br />";

			$this -> errors .= "Error: Our query failed to execute and here is why: <br />";
			$this -> errors .= "Errno: " . $link -> errno . "<br />";
			$this -> errors .= "Error: " . $link -> error . "<br />";
			
			return false;
		}
		else{
			return $result;
		}
	}
	
	function actors($result){
		return $result->fetch_assoc();
	}
	
	function autocommit($link, $stats = TRUE){
		mysqli_autocommit($link, $stats);
	}
	
	function roleback($link){
		mysqli_rollback($link);
	}
	
	function commit($link){
		mysqli_commit($link);
	}
	
	function close($link){
		$link -> close();
	}
        
        function result($result){
                mysqli_free_result($result);
	}
	
	function row($result){
		return mysqli_num_rows($result);
	}
	
	function error(){
		$err = $this -> errors;
		$this -> errors = NULL;
		return $err;
	}
}