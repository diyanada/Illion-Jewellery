<?php 
require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
$int_mg = new interface_magic();

if(!isset($_SESSION)) { 
    session_start(); 
}
session_unset();
session_destroy();	

header("Location: " . $int_mg-> external_source("") );
exit;

