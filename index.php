<?php 
require_once (dirname(__FILE__) . "/views/Contents_Header.php");
$page = new Contents_Header();

require_once (dirname(__FILE__) . "/class/hostage.php");
$hostage = new hostage($page);
$view = new view($page);


$view -> css("Script/Style/QCOKZGQYLF"); // common.css
$view -> _body = (dirname(__FILE__) . "/Page/default.php");

$page -> Content($view);

die();