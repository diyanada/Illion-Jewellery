<?php 

//********************************************************************************************
//	Diyanada J. Gunawardena
// 	diyanada@gmail.com
//********************************************************************************************

require_once (dirname(__FILE__) . "/../views/Contents.php");
$page = new Contents();


require_once (dirname(__FILE__) . "/../class/hostage.php");
$hostage = new hostage($page);
$view = new view($page);

require_once (dirname(__FILE__) . "/../views/ContentsScript.php");

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

switch ($arr[1]) {
    //-----------------------------------------
    case "Style":
        $Passer = new Passer();
        $Css = new Css();
        //-----------------------------------------
        switch ($arr[2]) {
        
            //-----------------------------------------
            case "QCOKZGQYLF":
                $Passer -> body(dirname(__FILE__) . "/CSS/common.css");
                die($Css -> Content($Passer));
                break;
            //-----------------------------------------
            case "XFPJNRSPGK":
                $Passer -> body(dirname(__FILE__) . "/CSS/input.css");
                die($Css -> Content($Passer));
                break;
            //-----------------------------------------
            case "VQTIUVWORX":
                $Passer -> body(dirname(__FILE__) . "/CSS/avatar.css");
                die($Css -> Content($Passer));
                break;
            //-----------------------------------------
            case "IEVKTXQPTM":
                $Passer -> body(dirname(__FILE__) . "/CSS/cropper.min.css");
                die($Css -> Content($Passer));
                break;
            //-----------------------------------------
            case "XJUHGWSRXM":
                $Passer -> body(dirname(__FILE__) . "/CSS/admin.css");
                die($Css -> Content($Passer));
                break;
            //-----------------------------------------
            case "ACCFYDAXKV":
                $Passer -> body(dirname(__FILE__) . "/CSS/search.css");
                die($Css -> Content($Passer));
                break;
            //-----------------------------------------
            case "HYOFYDARUT":
                $Passer -> body(dirname(__FILE__) . "/CSS/Collection.css");
                die($Css -> Content($Passer));
                break;
            //-----------------------------------------
            case "FTSWKYDART":
                $Passer -> body(dirname(__FILE__) . "/CSS/invoice.css");
                die($Css -> Content($Passer));
                break;            
            //-----------------------------------------
            default:
                $hostage ->_404();
                exit();
                break;
            //-----------------------------------------
        }
        break;
        //-----------------------------------------
    //-----------------------------------------
    case "JavaScript":
        $Passer = new Passer();
        $Js = new Js();
        //-----------------------------------------
        switch ($arr[2]) {
            //-----------------------------------------
            case "AOUZKENYQS":
                $Passer -> body(dirname(__FILE__) . "/JS/validator.js");
                die($Js -> Content($Passer));      
                break;
            //-----------------------------------------
            case "GLBEQTNEIE":
                $Passer -> body(dirname(__FILE__) . "/JS/common.php");
                $Passer -> body(dirname(__FILE__) . "/JS/account.js");
                die($Js -> Content($Passer));        
                break;
            //-----------------------------------------
            case "CZCVCDFOTK":
                $Passer -> body(dirname(__FILE__) . "/JS/common.php");
                $Passer -> body(dirname(__FILE__) . "/JS/register.js");
                die($Js -> Content($Passer));        
                break;
            //-----------------------------------------
            case "DPZWJMDGBE":
                $Passer -> body(dirname(__FILE__) . "/JS/common.php");
                $Passer -> body(dirname(__FILE__) . "/JS/login.js");
                die($Js -> Content($Passer));       
                break;
            //-----------------------------------------
            case "VXFLQXYMQP":
                $Passer -> body(dirname(__FILE__) . "/JS/common.php");
                $Passer -> body(dirname(__FILE__) . "/JS/common.js");
                $Passer -> body(dirname(__FILE__) . "/JS/input.js");
                $Passer -> body(dirname(__FILE__) . "/JS/item.js");
                die($Js -> Content($Passer));       
                break;
            case "JVQPTMYIMQ":
                $Passer -> body(dirname(__FILE__) . "/JS/common.php");
                $Passer -> body(dirname(__FILE__) . "/JS/common.js");
                $Passer -> body(dirname(__FILE__) . "/JS/input.js");
                $Passer -> body(dirname(__FILE__) . "/JS/stock.js");
                die($Js -> Content($Passer));       
                break;
            case "LJOYBUPVOF":
                include (dirname(__FILE__) . "/JS/jquery.js");
                die($Js -> Content($Passer));        
                break;
            case "CWANIIGEME":
                $Passer -> body(dirname(__FILE__) . "/JS/common.php");
                $Passer -> body(dirname(__FILE__) . "/JS/common.js");
                $Passer -> body(dirname(__FILE__) . "/JS/Collection.js");
                die($Js -> Content($Passer));        
                break;
            //-----------------------------------------
            case "UUNTOMMNWN":
                include (dirname(__FILE__) . "/JS/cropper.min.js");
                die($Js -> Content($Passer));       
                break;
            case "SKTJTUKDTS":
                $Passer -> body(dirname(__FILE__) . "/JS/common.php");
                $Passer -> body(dirname(__FILE__) . "/JS/common.js");
                $Passer -> body(dirname(__FILE__) . "/JS/input.js");
                $Passer -> body(dirname(__FILE__) . "/JS/basket.js");
                die($Js -> Content($Passer));       
                break;
            //-----------------------------------------
            default:
                $hostage ->_404();
                exit();
                break;
            //-----------------------------------------
        }
        break;
        //-----------------------------------------
    //-----------------------------------------
    default:
        $hostage ->_404();
        exit();
        break;
    //-----------------------------------------
}
