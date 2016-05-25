
<?php 
require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
$int_mg = new interface_magic();

require_once (dirname(__FILE__) . "/../class/hostage.php");
$login = new Login();
?>


<div class="nav_div">
    
    <a href="<?php echo $int_mg->external_source("")?>">
        <img class="image_logo" src="<?php echo $int_mg->external_source("Image/Logo.jpg") ?>" />
    </a>

    
    <?php
    
    if($login -> User() == false){
        echo "
                <a href=" . $int_mg->external_source("Login") . ">
                    <input type='button' value='Login' class='nav_btn' />
                </a>
                <a href=" . $int_mg->external_source("Register") . ">
                    <input type='button' value='Register' class='nav_btn' />
                 </a>
            ";
    }
    
    else{
        echo "
                <a href=" . $int_mg->external_source("Logout") . ">
                    <input type='button' value='Logout' class='nav_btn' />
                </a>
            ";
    }

    ?>

    	
    <!----------------------------------------------------------------->

    <a href="<?php echo $int_mg->external_source("Basket")?>">
        <input type="button" value="Basket" class="nav_btn" />
    </a>


    <a href="<?php echo $int_mg->external_source("Account")?>">
        <input type="button" value="Account" class="nav_btn" />
    </a>

    <!----------------------------------------------------------------->

    <a href="<?php echo $int_mg->external_source("Heritage")?>">
        <input type="button" value="Heritage" class="nav_btn" />
    </a>
    
    <a href="<?php echo $int_mg->external_source("Collection")?>">
        <input type="button" value="Collection" class="nav_btn" />
    </a>


    <a href="<?php echo $int_mg->external_source("Custom")?>">
        <input type="button" value="Custom" class="nav_btn" />
    </a>

</div>




