<?php 
require_once (dirname(__FILE__) . "/content.php");

class content_admin extends content{
    
    function __construct() {
        $this -> _header = dirname(__FILE__) . "/../Utility/header_admin.php" ;
        $this -> _footer = dirname(__FILE__) . "/../Utility/footer_admin.php" ;
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
        
        echo '<div class="admin_body">'
                . '<div class="left admin_nav clear">';
        include_once ($view -> _NavBody);     
        
        echo    '</div>'
                . '<div class="left container">';
        
        include_once ($view -> _body);
        
        echo '</div>'
        . '</div>';
        
        include_once ($view -> _footer);

        echo "</body></html>";

    }
}
