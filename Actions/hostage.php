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



//------------------------------------------------------------------------------
switch ($arr[1]) {
    //-----------------------------------------	
    case "MEPZXFXOBQ":				  	
        include ('Actions/register.php');
        die ();
        break;	
    //-----------------------------------------
    case "ZNLGDXSJLE":				  	
        include ('Actions/login.php');
        die ();
        break;
    //-----------------------------------------
    case "RVFUHCRWOZ":	
        if($hostage -> User()){
            include ('Actions/account.php');
            die ();
        }
        break;
    //-----------------------------------------
    case "SUWKCKBZBP":	
        if($hostage -> User()){
            include ('Form_action/account.php');
            die ();
        }
        break;
    //-----------------------------------------
    case "FSAWAUNJAG":	
        if($hostage -> Admin()){
            include ('Form_action/item.php');
            die ();
        }
        break;
    //-----------------------------------------
    case "RJHVEQXBPZ":
        if($hostage -> Admin()){
            require_once (dirname(__FILE__) . '/Actions/ItemAction.php');
            new ItemAction();
        }
        break;
    //-----------------------------------------
    case "SBXASKGEPB":
        if($hostage -> Admin()){
            require_once (dirname(__FILE__) . '/Actions/StockAction.php');
            new StockAction();
        }
        break;
    //-----------------------------------------
    case "SQOISZLWNS":
        require_once (dirname(__FILE__) . '/Actions/ItemViewAction.php');
        new ItemViewAction();
        break;
    //-----------------------------------------
    case "SPMOYAMOAS":
        if($hostage -> User()){
            require_once (dirname(__FILE__) . '/Actions/BasketAction.php');
            new BasketAction();
        }
        break;
    //-----------------------------------------
    default :
        $hostage ->_404();
        exit();
        break;
    //----------------------------
}
//------------------------------------------------------------------------------
