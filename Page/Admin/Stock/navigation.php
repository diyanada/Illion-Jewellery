<?php
require_once (dirname(__FILE__) . '/../../../Class/interface_magic.php');
$int_mg = new interface_magic();

?>

<ul>  
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Stock")?>">
            Search Item (Stock Add)
        </a>
    </li>
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Stock/Search")?>">
            Search Item (Stock Destroy)
        </a>
    </li>    
</ul>

