<?php 

require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
$int_mg = new interface_magic();

require_once (dirname(__FILE__) . '/../Class/input.php');
$input = new input();

require_once (dirname(__FILE__) . '/../Class/system_strings.php');
$sql = new system_strings();

require_once (dirname(__FILE__) . '/../DbClass/UserDetails.php');
$UserDetails = new UserDetails();
$UserDetailsMapper = new UserDetailsMapper();

require_once (dirname(__FILE__) . '/../DbClass/AvatarImage.php');
$AvatarImage = new AvatarImage();
$AvatarImageMapper = new AvatarImageMapper();

$Connection = $sql -> connect();
if($Connection == false){
    exit ($sql -> error());
}

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

$UserDetails -> _UserId = $_SESSION["userid"];

$user = $UserDetailsMapper -> Select($UserDetails, $Connection);

if($user == false){
    exit($UserDetailsMapper -> error());
}

$AvatarImage -> _Id = $user -> _AvatarImageId;

$user2 = $AvatarImageMapper -> Select($AvatarImage, $Connection);

if($user2 == false){
    exit($AvatarImageMapper -> error());
}


//------------------------------------------------------------------------------------------------
$input -> table();

//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("First Name", "f_name", $user -> _FirstName);
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.AlphaOrWhitespace(this.id, this.placeholder);"
						);
$data["onkeydown"] = array("save_act();");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Last Name", "l_name", $user -> _LastName);
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.Alpha(this.id, this.placeholder);"
						);
$data["onkeydown"] = array("save_act();");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Address", "user_add");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);"
						);
$data["onkeydown"] = array("save_act();");
$input -> add_textarea_ex($data, $user -> _Address);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("E-mail", "user_mail", $user -> _Email);
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.isEmail(this.id, this.placeholder);"
						);
$data["onkeydown"] = array("save_act();");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Tel Number", "tel_mob", $user -> _Tel);
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.isTel(this.id, this.placeholder);"
						);
$data["onkeydown"] = array("save_act();");
$input -> add_ex($data);
//------------------------------------------------------------------------------------------------
$data = array("disabled" => "true");
$input->submit("Save", $data );

$input -> drow();
//------------------------------------------------------------------------------------------------

$BEerror = NULL;

if(isset($view -> _prams["BEerror"])){
    $BEerror = $view -> _prams["BEerror"];
}

//------------------------------------------------------------------------------------------------
$input -> table();
//------------------------------------------------------------------------------------------------
?>


<form action="<?php echo $int_mg -> external_source("Actions/SUWKCKBZBP") ?>" 
      onsubmit="return image_validate()" 
      enctype="multipart/form-data"
      method="post">

  <tr>
    <td>
        <div id="imgcon">
                <img id="image" 
                     src=" <?php echo $int_mg->external_avatar($user2 -> _Image); ?> "
                     alt="Avtar Image" /> 
            </div>
    </td>
  </tr>
  <tr>
    <td>
        <input type="hidden" name="CP_width" id="CP_width"  />
        <input type="hidden" name="CP_height" id="CP_height" />
        <input type="hidden" name="CP_x" id="CP_x" />
        <input type="hidden" name="CP_y" id="CP_y" />
        <input type="hidden" name="CP_scaleX" id="CP_scaleX" />
        <input type="hidden" name="CP_scaleY" id="CP_scaleY" />
        <input type="hidden" name="tragets" id="tragets" value="Account" />
    </td>
  </tr>
  <tr>
      <td>
          <input id="avatar" type="file" name="avatar" accept="image/*"  onchange="return cheker_inline.isImage(this.id, 'Avatar'); PreviewImage();" class="inputTB" placeholder="Avtar Image" />
      </td>
  </tr>
  <tr>
    <td align="right">
        <div id="avatar_ex">
            
        </div>
    </td>
  </tr>
  
 <?php
 //------------------------------------------------------------------------------------------------
    $input -> submit_from("Upload Iamge");
    $input ->result($BEerror);
    $input -> drow();


?>
</form>
<?php
$input -> table();
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Old Password", "pass_old");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.Password(this.id, this.placeholder);"
						);
$data["onkeydown"] = array("save_act_pass();");
$input -> add_ex($data, "password");   
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Password", "pass");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.Password(this.id, this.placeholder);"
						);
$data["onkeydown"] = array("save_act_pass();");
$input -> add_ex($data, "password");
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("Confirm Pasword", "pass2");
$data["onkeyup"] = array(	
							"cheker_inline.isNotEmpty(this.id, this.placeholder);", 
							"cheker_inline.PaswordCP(this.id, this.placeholder, \"pass\");"
						);
$data["onkeydown"] = array("save_act_pass();");
$input -> add_ex($data, "password");
//------------------------------------------------------------------------------------------------ 
$data = array("onclick" => "submit_pass();", "id" => "submit2", "name" => "submit2", "disabled" => "true");
$data2 = array("id" => "resoult2");
$input->submit("Save Password", $data, $data2);
$input -> drow();
//------------------------------------------------------------------------------------------------
    

