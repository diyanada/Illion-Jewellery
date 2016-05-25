<?php 
class Passer{
    
    public $_body = array();
    
    public function body($data){
        array_push($this -> _body ,$data);
    }
}

class Css{

    function Content (Passer $css){
       header("Content-type: text/css; charset: UTF-8");

        foreach ($css -> _body as $value) {
            include_once $value;
        }
    }
}

class Js{

    function Content (Passer $css){

        foreach ($css -> _body as $value) {
            include_once $value;
        }
    }
}

