<?php 
class query {
    
    private function Split(array $data, $combine, $quotes = false){
        
        $sql = NULL;
        
        for ($index = 0; $index < count($data); $index++) {
            
            if($index == 0 or $combine == NULL){
                $sql .= " " . $this ->Quites($data[$index], $quotes);
            }
            else{                
                $sql .= " " . $combine . " " . $this ->Quites($data[$index], $quotes);                              
            }
        }
        
        return $sql;        
    }
    
    private function Quites($data, $quotes = false){
        if ($quotes == false){
            return $data;
        }
        else {
            return "'" . $data . "'";
        }
    }

    public function Data(array $arr, $column, $data, $operator = "="){
        
        if($data === "%%"){
            return $arr;  
        }
        else if($data === "%"){
            return $arr;              
        }
        else {
            array_push($arr, $column . " " . $operator . " '" . $data . "'");
            return $arr;  
        }
           
    }
    
    public function DataCombine(array $data, $combine = "AND", $starter = "WHERE"){
        
        $sql = NULL;
        
        if (empty($data)){
            return NULL;
        }
        
        if ($starter != NULL){
            $sql = $starter . " ";
        }
        
        $sql .= "(" . $this -> Split($data, $combine) . ")"; 
        
        return $sql;
    }
    
    public function From ($table , array $join = array()){
        
        $sql = "FROM " . $table;
        
        if (empty($join) == false){
            
            $sql .= $this -> Split($join, NULL);
        }
        
        return $sql;
    }
    
    public function Join(array $dat, $join = "INNER JOIN"){
        
        $sql = " " . $join . " " . $dat[2] . " ON " . $dat[0] . "." . $dat[1] . " = " . $dat[2] . "." . $dat[3];
        
        return $sql;
        
    }
            
    function Select($from, $where, array $data = array("*")){
		
        $sql = "SELECT";

        $sql .= $this -> Split($data, ",") . " " . $from . " " . $where;

        return $sql;
    }

    function makeID($table, $data = "IJID"){

            $sql = "SELECT CONCAT('" . $data . "',CONVERT(COUNT(*) + 1 , CHAR(10))) AS ID FROM " . $table;

            return $sql;
    }

    function insertINTO($table, array $data = array()){
            			
            $sql = "INSERT INTO " . $table . " (";

            $sql .= $this -> Split(array_keys($data), ",");

            $sql .= ") VALUES (";
            
            $sql .= $this -> Split(array_values($data), ",", true);
            
            $sql .= ")";

            return $sql;
    }
    
    function update($table, array $data, $where){

            $sql = "UPDATE " . $table . " SET ";

            $sql .= $this -> Split($data, ",");

            $sql .= " " . $where;
            
            return $sql;
    }
    
    function search($table, $where , $data = array("ID", "NAME")){
        			
            $sql = "SELECT ";

            $sql .= $this -> Split($data, ",");

            $sql .= " FROM " . $table . " WHERE ";
            
            $sql .= " " . $where;

            return $sql;
    }

}

