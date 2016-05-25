<?php 
require_once (dirname(__FILE__) . "/../../views/Contents.php");
$page = new Contents();

require_once (dirname(__FILE__) . "/../../class/hostage.php");
$hostage = new hostage($page);

$hostage ->_404();