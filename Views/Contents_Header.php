<?php 
require_once (dirname(__FILE__) . "/contents.php");

class contents_header extends content{
    
    public function __construct() {
        $this -> _header = dirname(__FILE__) . "/../Utility/header.php" ;
        $this -> _footer = dirname(__FILE__) . "/../Utility/footer.php" ;
        $this -> _meta = dirname(__FILE__) . "/../meta/default.php" ;
    }

    function Content (view $view){

        require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
        $int_mg = new interface_magic();

        echo "<!--    Diyanada J. Gunawardena     (diyanada@gmail.com) -->";
        echo "<!DOCTYPE html>";

        echo "<head><title>" . $view -> _title . "</title>";

        include_once ($view -> _meta);

        foreach ($view -> _js as $value) {
            echo "<script src=" . $int_mg -> external_source($value) . " type='application/javascript'></script>";
        }
        foreach ($view -> _css as $value) {
            echo "<link rel='stylesheet' type='text/css' href=" . $int_mg -> external_source($value) . " />";
        }
        echo "</head><body>";
        
        foreach ($view -> _prams as $key => $value) {
           echo ("<input type='hidden' name = " . $key . " id = '" . $key . "' value = '" . $value . "' />");
        }

        include_once ($view -> _header);
        include_once ($view -> _body);
        include_once ($view -> _footer);

        echo "</body></html>";

    }
}
