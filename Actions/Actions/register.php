<?php

//error_reporting(0);

$btn  = '<input type="button" name="submit" id="submit" class="submit" value="' 
        . filter_input(INPUT_GET, "submit") . '" onclick="submit()"><br />';

require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
$sql = new system_strings();

require_once (dirname(__FILE__) . '/../../Class/query.php');
$query = new query();

require_once (dirname(__FILE__) . '/../../DbClass/AvatarImage.php');
$AvatarImage = new AvatarImage();
$AvatarImageMapper = new AvatarImageMapper();

require_once (dirname(__FILE__) . '/../../DbClass/SystemUser.php');
$SystemUser = new SystemUser();
$SystemUserMapper = new SystemUserMapper();

require_once (dirname(__FILE__) . '/../../DbClass/UserDetails.php');
$UserDetails = new UserDetails();
$UserDetailsMapper = new UserDetailsMapper();

$Connection = $sql -> connect();
if($Connection == false){
    echo $btn;
    exit ($sql -> error());
}
$sql ->autocommit($Connection, false);


$result = $sql -> query($Connection, $query -> makeID("SYSTEM_USER", "IJSU"));
if($result == false){
    echo $btn;
    $sql ->roleback($Connection);
    exit ($sql -> error());
}

$actor = $sql->actors($result);
$ID = $actor["ID"];

$result = $sql -> query($Connection, $query -> makeID("AVATAR_IMAGE", "IJSUPIC"));
if($result == false){
    echo $btn;
    $sql ->roleback($Connection);
    exit ($sql -> error());
}

$actor = $sql -> actors($result);
$picID = $actor["ID"];

$SystemUser -> _Id = $ID;
$SystemUser -> _Username = filter_input(INPUT_GET, "u_name");
$SystemUser -> _Password = md5(urldecode(filter_input(INPUT_GET, "pass")));
$SystemUser -> _Password2 = md5(urldecode(filter_input(INPUT_GET, "pass2")));
$SystemUser -> _PasswordOld = md5(urldecode(filter_input(INPUT_GET, "pass")));
$SystemUser -> _Password2Old = md5(urldecode(filter_input(INPUT_GET, "pass2")));
$SystemUser -> _CreateBy = $ID;

$AvatarImage -> _Id = $picID;
$AvatarImage -> _Image = "DEFAULT.JPG";
$AvatarImage -> _CreateBy = $ID;

$UserDetails -> _UserId = $ID;
$UserDetails -> _AvatarImageId = $picID;
$UserDetails -> _FirstName = filter_input(INPUT_GET, "f_name");
$UserDetails -> _LastName = filter_input(INPUT_GET, "l_name");
$UserDetails -> _Address = urldecode(filter_input(INPUT_GET, "user_add"));
$UserDetails -> _Email = filter_input(INPUT_GET, "user_mail");
$UserDetails -> _Tel = filter_input(INPUT_GET, "tel_mob");
$UserDetails -> _CreateBy = $ID;


if($SystemUserMapper -> Insert($SystemUser, $Connection) == false){
    echo $btn;
    $sql ->roleback($Connection);
    exit($SystemUserMapper -> error());
}

if($UserDetailsMapper -> Insert($UserDetails, $Connection) == false){
    echo $btn;
    $sql ->roleback($Connection);
    exit($UserDetailsMapper -> error());
}

if($AvatarImageMapper -> Insert($AvatarImage, $Connection) == false){
    echo $btn;
    $sql ->roleback($Connection);
    exit($AvatarImageMapper -> error());
}

if($SystemUserMapper ->Login($SystemUser, $Connection) == false){
    echo $btn;
    $sql ->roleback($Connection);
    exit($SystemUserMapper -> error());
}

$sql -> commit($Connection);
$sql -> autocommit($Connection, true);
$sql ->close($Connection);

$Endurl = filter_input(INPUT_GET, "Endurl");

if($Endurl == ""){
    echo '<input type="button" value="Go to main page" class="submit" onclick="set_url()"><br />';
}
else{
    echo '<input type="button" value="Go to ' . $Endurl . '" class="submit" onclick="set_url()"><br />';
}
echo 'Successfully ' . filter_input(INPUT_GET, "submit")  . '.';    

 
