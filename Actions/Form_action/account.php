<?php 

    require_once (dirname(__FILE__) . '/../../Class/pitures.php');
    $pitures = new pitures();
    
    require_once (dirname(__FILE__) . '/../../views/Contents_Header.php');
    $page = new Contents_Header();
    
    require_once (dirname(__FILE__) . "/../..//class/hostage.php");
    $hostage = new hostage($page);
    $view = new view($page);
    
    require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
    $sql = new system_strings();
    
    require_once (dirname(__FILE__) . '/../../DbClass/UserDetails.php');
    $UserDetails = new UserDetails();
    $UserDetailsMapper = new UserDetailsMapper();
    
    require_once (dirname(__FILE__) . '/../../DbClass/AvatarImage.php');
    $AvatarImage = new AvatarImage();
    $AvatarImageMapper = new AvatarImageMapper();
    
    require_once (dirname(__FILE__) . '/../../Class/interface_magic.php');
    $int_mg = new interface_magic();
    
    //-------------------------------------------------------------------
    $view -> css("Script/Style/QCOKZGQYLF"); // common.css
    $view -> css("Script/Style/XFPJNRSPGK"); // input.css
    $view -> css("Script/Style/VQTIUVWORX"); // avatar.css
    $view -> css("Script/Style/IEVKTXQPTM"); // cropper.min.css
    //-------------------------------------------------------------------
    $view -> js("Script/JavaScript/LJOYBUPVOF"); // jqueary.js
    $view -> js("Script/JavaScript/UUNTOMMNWN"); // cropper.min.js
    $view -> js("Script/JavaScript/AOUZKENYQS"); // validator.js
    $view -> js("Script/JavaScript/GLBEQTNEIE"); // account.js
    //-------------------------------------------------------------------
    $view -> _body = (dirname(__FILE__) . "/../../Page/account.php");
    //-------------------------------------------------------------------
    
    $Connection = $sql -> connect();
    if($Connection == false){
        $view -> prams(array("BEerror" => $Connection ->errors()));
        die ($page -> Content($view));
    }
    
    $UserDetails -> _UserId = $_SESSION['userid'];
    
    $UserDetails = $UserDetailsMapper ->Select($UserDetails, $Connection);
    
    if ($UserDetails == false){
        $view -> prams(array("BEerror" => $UserDetailsMapper ->errors()));
        die ($page -> Content($view));
    }
    
    $AvatarImage -> _Id = $UserDetails -> _AvatarImageId;
    
    $AvatarImage = $AvatarImageMapper ->Select($AvatarImage, $Connection);
    
    if ($AvatarImage == false){
        $view -> prams(array("BEerror" => $AvatarImageMapper ->errors()));
        die ($page -> Content($view));
    }
    
    if ($AvatarImage -> _Image == "DEFAULT.JPG"){
        $AvatarImage -> _Image = NULL;
    }
    
    echo $AvatarImage -> _Image;
    
    $pic = $pitures ->save($_FILES["avatar"], "Avatar", "IJAVPIC", "ORIGINAL", $AvatarImage -> _Image);
    
    if($pic == FALSE){
        $view -> prams(array("BEerror" => $pitures ->errors()));
        die ($page -> Content($view));
    }
    
    $pitures -> data = array(
        "CP_width" => filter_input(INPUT_POST, "CP_width") ,
        "CP_height" => filter_input(INPUT_POST, "CP_height") ,
        "CP_x" => filter_input(INPUT_POST, "CP_x") ,
        "CP_y" => filter_input(INPUT_POST, "CP_y")
    );
    
    if($pitures ->resize($pic, "Avatar", 500, 500) == false){
        $view -> prams(array("BEerror" => $pitures ->errors()));
        die ($page -> Content($view));
    }
    
    if($pitures ->resize($pic, "Avatar", 300, 300) == false){
        $view -> prams(array("BEerror" => $pitures ->errors()));
        die ($page -> Content($view));
    }
    
    if($pitures ->resize($pic, "Avatar", 100, 100) == false){
        $view -> prams(array("BEerror" => $pitures ->errors()));
        die ($page -> Content($view));
    }
    
    if($pitures ->resize($pic, "Avatar", 50, 50) == false){
        $view -> prams(array("BEerror" => $pitures ->errors()));
        die ($page -> Content($view));
    }
    
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    
    $AvatarImage -> _Image = $pic;
    
    if($AvatarImageMapper ->Update($AvatarImage, $Connection) == false){
        $view -> prams(array("BEerror" => $AvatarImageMapper ->errors()));
        die ($page -> Content($view));
    }
    else{
        header("Location: " . $int_mg ->external_source("Account"));
			
    }
	  
