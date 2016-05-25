<?php 
require_once (dirname(__FILE__) . "/content.php");

class contents extends content{
    
    public function __construct() {
        $this -> _header = NULL ;
        $this -> _footer = NULL ;
        $this -> _meta = NULL ;
    }

    function Content (view $view){

        require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
        $int_mg = new interface_magic();

        echo "<!--    Diyanada J. Gunawardena     (diyanada@gmail.com) -->";
        echo "<!DOCTYPE html>";

        echo "<head><title>" . $view -> _title . "</title>";
        
        if ($view -> _meta != NULL){
            include_once ($view -> _meta);
        }

        foreach ($view -> _js as $value) {
            echo "<script src=" . $int_mg -> external_source($value) . " type='text/javascript'></script>";
        }
        foreach ($view -> _css as $value) {
            echo "<link rel='stylesheet' type='text/css' href=" . $int_mg -> external_source($value) . " />";
        }
        echo "</head><body>";
        
        foreach ($view -> _prams as $key => $value) {
           echo ("<input type='hidden' name = " . $key . " id = '" . $key . "' value = '" . $value . "' />");
        }

        include_once ($view -> _body);

        echo "</body></html>";

    }
}
