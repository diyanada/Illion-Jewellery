
<?php 
require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
$int_mg = new interface_magic();
?>


<div class="nav_div">

    	<a href="<?php echo $int_mg->external_source("Admin")?>">
        	<img class="image_logo" src="<?php echo $int_mg->external_source("Image/Logo.jpg") ?>" />
        </a>
    <!----------------------------------------------------------------->
    	<a href="<?php echo $int_mg->external_source("Logout")?>">
        	<input type="button" value="Logout" class="nav_btn" />
        </a>
    <!----------------------------------------------------------------->
    	<a href="<?php echo $int_mg->external_source("Admin/Item")?>">
        	<input type="button" value="Item" class="nav_btn" />
        </a>
    <!----------------------------------------------------------------->
    	<a href="<?php echo $int_mg->external_source("Admin/Stock")?>">
        	<input type="button" value="Stock" class="nav_btn" />
        </a>
    <!----------------------------------------------------------------->
    	<a href="<?php echo $int_mg->external_source("Admin/Order")?>">
        	<input type="button" value="Order" class="nav_btn" />
        </a>
    <!----------------------------------------------------------------->
    	<a href="<?php echo $int_mg->external_source("Admin/Quantity")?>">
        	<input type="button" value="Quantity" class="nav_btn" />
        </a>
    
    
    </div>





