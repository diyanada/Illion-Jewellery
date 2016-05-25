<?php 
require_once (dirname(__FILE__) . "/../views/Contents.php");
$page = new Contents();

require_once (dirname(__FILE__) . "/../class/hostage.php");
$hostage = new hostage($page);

if($hostage ->IsLoginAdmin("Admin/Main") == true){
    
    require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
    $int_mg = new interface_magic();
    
    header("Location: " . $int_mg ->external_source("Admin/Main"));
    die();
    
}