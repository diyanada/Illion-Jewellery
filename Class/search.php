<?php

class search {

    private function tr($data) {
        return "<tr>" . $data . "</tr>";
    }

    private function td($data) {
        return "<td>" . $data . "</td>";
    }

    private function th($data) {
        return "<th>" . $data . "</th>";
    }
    
    private function split(array $data){
            
            $ret = NULL;
            
            foreach ($data as $key => $value){
                               
                $ret .= " " . $key . " = '" . $value . "'";
                
            }
            
            return $ret;
        }

    public function table($class = "searchTB", $align = "center", $border = 0) {
        echo "<table align='" . $align . "' border='" . $border . "' class='" . $class . "'>";
    }
    
    public function drow() {
        echo "</table>";
    }

    public function button($path, array $data = array()) {
        
        $data = array_merge(array("type" => "button", "class" => "searchTB"), $data);
            
        require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
        $int_mg = new interface_magic();

        return "<a href=" . $int_mg->external_source($path) . "><input ". $this ->split($data) . "/></a>";
    }
    
    public function Image($Image, $Size = "75X100", array $data = array()) {
        
        $data = array_merge(array("class" => "searchTB"), $data);

        require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
        $int_mg = new interface_magic();
        
        $iamge_path =  $int_mg->external_item($Image, $Size);

        return "<img src='" . $iamge_path . "' " . $this ->split($data) . " />";
    }

    public function add(array $param, $th = false) {

        $ret = NULL;

        foreach ($param as $value) {

            if ($th == false) {
                $ret .= $this->td($value);
            } else {
                $ret .= $this->th($value);
            }
        }
        echo $this->tr($ret);
    }    
    
    public function SearchBox(array $ObjArray, $Des, array $Feald =  array("_Id", "_Name") , array $Image = array(), array $Buton = array(array())){ 
        
        if(count($ObjArray) <= 1){
            $this -> table();
            echo $this->tr($this->th("No Data."));
            $this->drow();
            
            return;
        }
        
        $this -> table();

        for ($index = 0; $index < count($ObjArray); $index++) {
            
            $data = array();

            for ($index1 = 0; $index1 < count($Feald); $index1++) {
                
                array_push($data, $ObjArray[$index] -> $Feald[$index1]);   
            }

            if ($index == 0) {                
                $th = true;
            } 
            else {
                
                $th = false;
            }

            foreach ($Image as $value) {

                $value = array_merge($value, array("75X100", "_Image", array("value" => "Image")));
                
                if($th === false){
                    array_push($data, $this ->Image($ObjArray[$index] -> $value[1], $value[0], $value[2])); 
                }
                else {
                    array_push($data, $value[2]["value"]);  
                }
                
            }

            foreach ($Buton as $value) {

                $value =  array_merge($value,array($Des, "_Id", array("value" => "Select")));
                
                if($th === false){
                    array_push($data, $this -> button($value[0] . "/" . $ObjArray[$index] -> $value[1], $value[2]));
                }
                else {
                    array_push($data, $value[2]["value"]);  
                }
            }

            $this->add($data, $th);
        }

        $this->drow();
    }

}
