<?php

error_reporting(0);
$funct = filter_input(INPUT_GET, "func");

if($funct == "user"){

    $btn  = '<input type="button" name="submit" id="submit" class="submit" value="' 
            . filter_input(INPUT_GET, "submit") . '" onclick="submit()"><br />';

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

    $SystemUser -> _Username = filter_input(INPUT_GET, "u_name");
    $SystemUser -> _Password = md5(urldecode(filter_input(INPUT_GET, "pass")));
    $SystemUser -> _Password2 = md5(urldecode(filter_input(INPUT_GET, "pass2")));
    $SystemUser -> _PasswordOld = md5(urldecode(filter_input(INPUT_GET, "pass")));
    $SystemUser -> _Password2Old = md5(urldecode(filter_input(INPUT_GET, "pass2")));

    if($SystemUserMapper ->Login($SystemUser, $Connection) == false){
        echo $btn;
        exit($SystemUserMapper -> error());
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

else if($funct == "admin"){

    $btn  = '<input type="button" name="submit" id="submit" class="submit" value="' 
            . filter_input(INPUT_GET, "submit") . '" onclick="submit_admin()"><br />';

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

    $SystemUser -> _Username = filter_input(INPUT_GET, "u_name");
    $SystemUser -> _Password = md5(urldecode(filter_input(INPUT_GET, "pass")));
    $SystemUser -> _Password2 = md5(urldecode(filter_input(INPUT_GET, "pass2")));
    $SystemUser -> _PasswordOld = md5(urldecode(filter_input(INPUT_GET, "pass")));
    $SystemUser -> _Password2Old = md5(urldecode(filter_input(INPUT_GET, "pass2")));

    if($SystemUserMapper ->LoginAdmin($SystemUser, $Connection) == false){
        echo $btn;
        exit($SystemUserMapper -> error());
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
		
	


