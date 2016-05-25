<?php 

class input{
	
	function tr($data, $class = NULL){
		return  "<tr class='" . $class . "'><td>" . $data . "</td></tr>";
	}
        
        private function split(array $data){
            
            $ret = NULL;
            
            foreach ($data as $key => $value){
                               
                $ret .= " " . $key . " = '" . $this ->split_by($value) . "'";
                
            }
            
            return $ret;
        }
        
        private function split_by($value){
            
            $ret = NULL;
                                       
            if (is_array($value)){
                    foreach ($value as $val){
                        $ret .= " " . $val;
                    }
            }
            else{
                    $ret =  $value ;
            }
                   
            return $ret;
        }
	
	function table($class = "inputTB", $align = "center", $border = 0){
		echo "<table align='" . $align ."' border='" . $border . "' class='" . $class . "'>";
	}
                        
	function add(array $data, $type = "text"){
		$ret = "<input type='" . $type . "'";
					
		$ret .= $this ->split($data);
					
		$ret .= " />";
		
		echo $this -> tr($ret);
		
	}
        
        function add_ex(array $data, $type = "text", $align = "right"){
			
		$this -> add($data, $type);
		
		if(isset($data["id"])){
			echo $this -> tr("<div align='" . $align . "' id='" . $data["id"] . "_ex'></div>");
		}
		
	}
	
	function add_textarea(array $data, $txt = NULL){
		$ret = "<textarea ";
					
		$ret .= $this ->split($data);
					
		$ret .= " >" . $txt . "</textarea></td></tr>";
		
		echo $this -> tr($ret);
		
	}
		
	function add_textarea_ex($data = array(),$value = NULL, $align = "right"){
			
		$this -> add_textarea($data, $value);
		
		if(isset($data["id"])){
			echo $this -> tr("<div align='" . $align . "' id='" . $data["id"] . "_ex'></div>");
		}
		
	}
                
	function submit($value, array $data = array(), array $data2 = array()){
               
            $data = array_merge(array("onclick" => "submit();", "id" => "submit", "name" => "submit", "class" => "submit"), $data);
            
            $data2 = array_merge(array("align" => "left", "id" => "resoult", "class" => "resoult"), $data2);
            
            $ret = "<input type='button' ";  

            $ret .= $this ->split($data);

            $ret .= " value='" . $value . "' />";		
            $ret2 = "<div " ;

            $ret2 .= $this ->split($data2);

            $ret2 .= " >" . $ret . " </div>";

            echo $this -> tr($ret2);
	}
        
        function submit_from($value, array $data = array()){ 
            
            $data = array_merge(array("type" => "submit", "id" => "submit", "name" => "submit", "class" => "submit"), $data);
            
            $ret = "<input " . $this ->split($data) . " value='" . $value . "' />";		

            echo $this -> tr($ret);
	}
	
	function result($dta = NULL, $id = "resoult", $align = "left", $class = "resoult"){ 
	
		$ret = "<div align='" . $align . "' id='" . $id . "' class='" . $class . "'>" . $dta . "</div>";
		
		echo $this -> tr($ret);
	}
	
	function drow(){
		echo "</table>";
	}
	
	function makeAR($name, $id, $value = NULL, $class = "inputTB"){
		$ret = array ("id" => $id, "name" => $id, "placeholder" => $name, "value" => $value, "class" => $class);
		return $ret;
	}
        
        function topic($topic){
            echo $this -> tr($topic, "topic");
        }
        
        function search($value, array $data = array()){ 
            
            $data = array_merge(array("onclick" => "search();", "id" => "submit", "name" => "submit", "class" => "submit"), $data);
            
            $ret = "<input type='button' ";  

            $ret .= $this ->split($data);

            $ret .= " value='" . $value . "' />";		

            echo $this -> tr($ret);
	}
        
        function select(array $data, $table,  array $feaild, $selected, $option) {
            
            require_once (dirname(__FILE__) . '/system_strings.php');
            $sql = new system_strings();
            
            require_once (dirname(__FILE__) . '/query.php');
            $query = new query();
            
            $Connection = $sql -> connect();
            if($Connection == false){
                exit ($sql -> error());
            }
            
            $temp = $query ->Select($query ->From($table), NULL, $feaild);
        
            $result = $sql -> query($Connection, $temp);

            if($result == false){
                exit ($sql -> error());
            }
            
            $ret = "<select ";
            
            if($selected != NULL){
                
                $ret .= " style='color:#000;'";             
            }
					
            $ret .= $this ->split($data);
            
            $ret .= "><option value = '' disabled";
            
            if($selected == NULL){
                $ret .= " selected";
            }
            
            $ret .= ">" . $option . "</option>";
            
            while ($actor = $sql->actors($result)) {
                
                if($selected == $actor["ID"]){
                    $ret .= "<option  value='" . $actor["ID"] . "' selected>" . $actor["NAME"] . "</option>";
                }
                else{
                    $ret .= "<option value='" . $actor["ID"] . "'>" . $actor["NAME"] . "</option>";
                }
            }

            $ret .= "</select>";
            
            echo $this -> tr($ret);
            
        }
        
        function select_ex(array $data, $tabele, $selected = NULL, $option = NULL, array $feaild = array("ID", "NAME"), $align = "right") {
            
            $this -> select($data, $tabele, $feaild, $selected, $option);
		
		if(isset($data["id"])){
			echo $this -> tr("<div align='" . $align . "' id='" . $data["id"] . "_ex'></div>");
		}
            
        }
        
        function searchDIV($id = "serdiv", $class = "inputTB"){
            echo $this -> tr("<div id = '" . $id . "' class = '" . $class . "'> </div>");
        }
        
        function select_normal(array $data, array $option){
                                   
            $ret = "<select " .$this ->split($data) . ">";
            
            foreach ($option as $key => $value) {
                
                if($key === "placeholder"){
                    $ret .= "<option disabled selected value=''>" . $value . "</option>";
                }
                else{                    
                    $ret .= "<option value='" . $key. "'>" . $value . "</option>";                
                }
                
                
            }

            $ret .= "</select>";
            
            echo $this -> tr($ret);
            
        }
        
        function select_normal_ex(array $data, array $option, $align = "right") {
            
            $this -> select_normal($data, $option);
		
		if(isset($data["id"])){
			echo $this -> tr("<div align='" . $align . "' id='" . $data["id"] . "_ex'></div>");
		}
            
        }
        
        function anchor_li ($table,  array $feaild  = array("ID", "NAME"), $function = "Load") {
            
            require_once (dirname(__FILE__) . '/system_strings.php');
            $sql = new system_strings();
            
            require_once (dirname(__FILE__) . '/query.php');
            $query = new query();
            
            $Connection = $sql -> connect();
            if($Connection == false){
                exit ($sql -> error());
            }
            
            $temp = $query ->Select($query ->From($table), NULL, $feaild);
        
            $result = $sql -> query($Connection, $temp);

            if($result == false){
                exit ($sql -> error());
            }
            
            $ret = "<ul>";
            
            while ($actor = $sql->actors($result)) {
                
                $ret .= "<li>";
                $ret .= "<a onclick = \"" . $function . " ('" . $actor["ID"] . "');\">" . $actor["NAME"] . "</a>";
                $ret .= "</li>";
            }

            $ret .= "<ul>";
            
            echo $ret;
            
        }
        
}