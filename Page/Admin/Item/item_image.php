<?php
require_once (dirname(__FILE__) . '/../../../Class/input.php');
$input = new input();

//------------------------------------------------------------------------------------------------
$input->table();
$input->topic("Image");
//------------------------------------------------------------------------------------------------
?>


<form action="<?php echo $int_mg -> external_source("Actions/FSAWAUNJAG") ?>" 
      onsubmit="return image_validate();" 
      enctype="multipart/form-data"
      method="post">

    <tr>
        <td>
            <div id="imgcon">
                <img id="image" 
                     src=" <?php echo $int_mg->external_item("DEFAULT.JPG"); ?> "
                     alt="Item Image" /> 
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
            <input type="hidden" name="ID" id="ID" value="<?php echo $view->_prams["ID"] ?>">
        </td>
    </tr>

<?php
//------------------------------------------------------------------------------------------------
    $data = $input->makeAR("Avatar", "avatar");
    $data["onchange"] = "cheker_inline.isImage(this.id, \"Avatar\"); PreviewImage();";
    $data["accept"] = "image/jpeg";
    $input->add_ex($data, "file");
//------------------------------------------------------------------------------------------------
    $data = $input->makeAR("Image Type", "image_type");
    $data["onchange"] = array("cheker_inline.isNotEmpty(this.id, \"Image Type\");", "Select_Change(this);");
    $input->select_ex($data, "ITEM_IMAGE_TYPE");
//------------------------------------------------------------------------------------------------
    $input->submit_from("Upload Iamge");
    $input->result();
    $input->drow();
?>
</form>