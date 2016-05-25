<?php 
require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
$int_mg = new interface_magic();
?>

<img src="<?php echo $int_mg->external_source("Image/404.jpg") ?>" id="centered" />
