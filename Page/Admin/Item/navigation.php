<?php
require_once (dirname(__FILE__) . '/../../../Class/interface_magic.php');
$int_mg = new interface_magic();

?>

<ul>  
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Item/Type")?>">
            Create Item Type
        </a>
    </li>
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Item/Type/Search")?>">
            Search Item Type (Edit)
        </a>
    </li>
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Item")?>">
            Create Item
        </a>
    </li>
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Item/Search")?>">
            Search Item (Edit)
        </a>
    </li>
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Item/Image/Search")?>">
            Search Item (Image Mapping)
        </a>
    </li>
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Item/Image/Search-img")?>">
            Search Image (Delete)
        </a>
    </li>
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Item/Offer/Type")?>">
            Create Offer Type
        </a>
    </li>
    <li>
        <a href="<?php echo $int_mg->external_source("Admin/Item/Offer/Type/Search")?>">
            Search Offer Type (Delete)
        </a>
    </li>
</ul>

