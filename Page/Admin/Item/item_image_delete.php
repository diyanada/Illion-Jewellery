<?php
require_once (dirname(__FILE__) . '/../../../Class/CommonAction.php');
$action = new CommonAction();
 
require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

$action ->MakeObj("ItemImage");

$action -> _Obj -> _Id = $view -> _prams["ID"];

$obj = $action ->ObjFunction("Select");

//------------------------------------------------------------------------------------------------
$input->table();
$input->topic("Image");
//------------------------------------------------------------------------------------------------
?>
    <tr>
        <td>
            <div id="imgconitem">
                <img id="image" 
                     src=" <?php echo $int_mg->external_item($obj -> _Image); ?> "
                     alt="Item Image" /> 
            </div>
        </td>
    </tr>    
<?php
//------------------------------------------------------------------------------------------------
$data = $input -> makeAR ("User Password", "pass");
$data["onkeyup"] = array(   "cheker_inline.isNotEmpty(this.id, this.placeholder);", 
                            "cheker_inline.Password(this.id, this.placeholder);"    );
$input -> add_ex($data, "password");
//------------------------------------------------------------------------------------------------
$data = array("onclick" => "delete_image();");

$input->submit("Delete", $data);
$input -> drow();
//------------------------------------------------------------------------------------------------