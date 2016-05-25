<?php 

//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

require_once (dirname(__FILE__) . "/../views/Contents_Header.php");
$page = new Contents_Header();

require_once (dirname(__FILE__) . "/../class/hostage.php");
$hostage = new hostage($page);
$view = new view($page);

require_once (dirname(__FILE__) . "/../Class/interface_magic.php");
$int_mg = new interface_magic();

$url = filter_input(INPUT_GET, "_url");

if($url == NULL or $url == false){    
    $hostage ->_404();
    exit();
}

$arr = $hostage -> Url($url);

if (!isset($arr[1])) {
    $arr[1] = NULL;
}
if (!isset($arr[2])) {
    $arr[2] = NULL;
}
if (!isset($arr[3])) {
    $arr[3] = NULL;
}



//------------------------------------------------------------------------------
if($arr[1] == NULL){
    $hostage ->_404();
    exit();
}
//------------------------------------------------------------------------------
else if($arr[1] != NULL and $arr[2] == NULL){
    $name = $int_mg ->external_image("/" . $arr[1]);
        
    $path =  realpath($name);
	
	if (file_exists($path)) {
		$fp = fopen($path, 'rb');
		header("Content-Type: image/jpeg");
		header("Content-Length: " . filesize($path));

		fpassthru($fp);
		exit;
	} 
	else {
		$name =  $int_mg -> external_image("/DEFAULT.JPG") ;
		
		$path =  realpath($name);
		$fp = fopen($path, 'rb');
		header("Content-Type: image/jpeg");
		header("Content-Length: " . filesize($path));

		fpassthru($fp);
		exit;
	}
}
//------------------------------------------------------------------------------
else if($arr[1] != NULL and $arr[2] != NULL){
    $name = $int_mg ->external_image("/" . $arr[1] . "/" . $arr[2] . "/" . $arr[3]);
        
    $path =  realpath($name);
	
	if (file_exists($path)) {
		$fp = fopen($path, 'rb');
		header("Content-Type: image/jpeg");
		header("Content-Length: " . filesize($path));

		fpassthru($fp);
		exit;
	} 
	else {
		$name =  $int_mg -> external_image("/" . $arr[1] . "/" . $arr[2] . "/DEFAULT.JPG") ;
                
                $path =  realpath($name);
		$fp = fopen($path, 'rb');
		header("Content-Type: image/jpeg");
		header("Content-Length: " . filesize($path));

		fpassthru($fp);
		exit;	
	}
}
//------------------------------------------------------------------------------
else{
    $hostage ->_404();
    exit();
}


