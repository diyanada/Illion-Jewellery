<?php

//error_reporting(0);

$funct = filter_input(INPUT_GET, "func");

if($funct == "save"){
    
    $btn  = '<input type="button" name="submit" id="submit" class="submit" '
            . 'value="' . filter_input(INPUT_GET, "submit") . '" onclick="submit()"><br />';
    
    require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
    $sql = new system_strings();
    
    require_once (dirname(__FILE__) . '/../../DbClass/UserDetails.php');
    $UserDetails = new UserDetails();
    $UserDetailsMapper = new UserDetailsMapper();
    
    $Connection = $sql -> connect();
    if($Connection == false){
        echo $btn;
        exit ($sql -> error());
    }
    
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    
    $UserDetails -> _UserId = $_SESSION["userid"];

    $UserDetails = $UserDetailsMapper -> Select($UserDetails, $Connection);
    if ($UserDetails == false){
        echo $btn;
        exit ($UserDetailsMapper ->error());
    }
    
    
    $UserDetails -> _FirstName = filter_input(INPUT_GET, "f_name");
    $UserDetails -> _LastName = filter_input(INPUT_GET, "l_name");
    $UserDetails -> _Address = urldecode(filter_input(INPUT_GET, "user_add"));
    $UserDetails -> _Email = filter_input(INPUT_GET, "user_mail");
    $UserDetails -> _Tel = filter_input(INPUT_GET, "tel_mob");
    $UserDetails -> _CreateBy = $_SESSION["userid"];
    
    
    if($UserDetailsMapper -> Update ($UserDetails, $Connection) == false){
        echo $btn;
        exit($UserDetailsMapper -> error());
    }
    
    $sql ->close($Connection);
    
    $Endurl = filter_input(INPUT_GET, "Endurl");

    if($Endurl == ""){
        echo '<input type="button" value="Go to main page" class="submit" onclick="set_url()"><br />';
    }
    else{
        echo '<input type="button" value="Go to ' . $Endurl . '" class="submit" onclick="set_url()"><br />';
    }
    echo 'Successfully ' . filter_input(INPUT_GET, "submit")  . '.';    
}

if($funct == "save_pass"){ 
    
    $btn  = '<input type="button" name="submit2" id="submit2" class="submit" '
            . 'value="' . filter_input(INPUT_GET, "submit") . '" onclick="submit_pass()"><br />';
    
    require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
    $sql = new system_strings();
    
    require_once (dirname(__FILE__) . '/../../DbClass/SystemUser.php');
    $SystemUser = new SystemUser();
    $SystemUserMapper = new SystemUserMapper();
    
    $Connection = $sql -> connect();
    if($Connection == false){
        echo $btn;
        exit ($sql -> error());
    }
    
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    $SystemUser -> _Id = $_SESSION['userid'];
    
    $SystemUser = $SystemUserMapper ->Select($SystemUser, $Connection);
    
    if ($SystemUser == false){
        echo $btn;
        exit ($SystemUserMapper -> error());
    }
    
    $SystemUser -> _Password = md5(urldecode(filter_input(INPUT_GET, "pass")));
    $SystemUser -> _Password2 = md5(urldecode(filter_input(INPUT_GET, "pass2")));
    $SystemUser -> _PasswordOld = md5(urldecode(filter_input(INPUT_GET, "pass_old")));
    
    
    if ($SystemUserMapper ->Update($SystemUser, $Connection) == false){
        echo $btn;
        exit ($SystemUserMapper -> error());
    }
    
    $Endurl = filter_input(INPUT_GET, "Endurl");

    if($Endurl == ""){
        echo '<input type="button" value="Go to main page" class="submit" onclick="set_url()"><br />';
    }
    else{
        echo '<input type="button" value="Go to ' . $Endurl . '" class="submit" onclick="set_url()"><br />';
    }
    echo 'Successfully ' . filter_input(INPUT_GET, "submit")  . '.';  
}
