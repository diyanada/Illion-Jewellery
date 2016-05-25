<?php

//error_reporting(0);

$funct = filter_input(INPUT_GET, "func");

if ($funct == "typesave") {

    require_once (dirname(__FILE__) . '/../../Class/CommonAction.php');
    $action = new CommonAction();
    
    $data = array();
    $data["value"] = $action -> GetVarb("submit");
    $data["onclick"] = $action -> GetVarb("submit_on");
        
    $action -> ErButton($data);
    
    $ID = $action -> GetId("ITEM_TYPE");
    
    $action -> MakeObj("ItemType");
    
    $action -> _Obj -> _Id = $ID;
    $action -> _Obj -> _Name = $action -> GetVarb("name");
    $action -> _Obj -> _CreateBy = $_SESSION["userid"];
    
    $action -> ObjFunction("Insert");

    $action ->Over($action -> GetVarb("Endurl"));
} 

else if ($funct == "searchitem") {


    require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
    $sql = new system_strings();

    require_once (dirname(__FILE__) . '/../../Class/search.php');
    $search = new search();

    require_once (dirname(__FILE__) . '/../../DbClass/ItemType.php');
    $Item = new ItemType();
    $ItemMapper = new ItemTypeMapper();

    $Connection = $sql->connect();
    if ($Connection == false) {
        exit($sql->error());
    }

    $Item->_Id = filter_input(INPUT_GET, "type_id");
    $Item->_Name = filter_input(INPUT_GET, "name");

    $ObjArray = $ItemMapper->Search($Item, $Connection);

    if ($ObjArray == false) {
        exit($ItemMapper->error());
    }

    $search->table();

    for ($index = 0; $index < count($ObjArray); $index++) {

        if ($index == 0) {
            $th = true;
            $btn = "Select";
        } else {
            $th = false;
            $btn = $search->button("Admin/Item/Type/Edit/" . $ObjArray[$index]->_Id);
        }



        $search->add(array(
            $ObjArray[$index]->_Id
            , $ObjArray[$index]->_Name
            , $btn
                ), $th);
    }

    $search->drow();
} 

else if ($funct == "typeedit") {
    
    $btn = '<input type="button" name="submit" id="submit" class="submit" '
            . 'value="' . filter_input(INPUT_GET, "submit") . '" onclick="edit_type()"><br />';

    require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
    $sql = new system_strings();

    require_once (dirname(__FILE__) . '/../../Class/query.php');
    $query = new query();

    require_once (dirname(__FILE__) . '/../../DbClass/ItemType.php');
    $Item = new ItemType();
    $ItemMapper = new ItemTypeMapper();

    $Connection = $sql->connect();
    if ($Connection == false) {
        echo $btn;
        exit($sql->error());
    }

    $Item->_Id = filter_input(INPUT_GET, "ID");

    $Item = $ItemMapper->Select($Item, $Connection);

    if ($Item == false) {
        echo $btn;
        exit($ItemMapper->error());
    }

    $Item->_Name = filter_input(INPUT_GET, "name");
    $Item->_CreateBy = $_SESSION["userid"];

    if ($ItemMapper->Update($Item, $Connection) == false) {
        echo $btn;
        exit($ItemMapper->error());
    }

    $sql->close($Connection);

    $Endurl = filter_input(INPUT_GET, "Endurl");

    if ($Endurl == "") {
        echo '<input type="button" value="Go to main page" class="submit" onclick="set_url()"><br />';
    } else {
        echo '<input type="button" value="Go to ' . $Endurl . '" class="submit" onclick="set_url()"><br />';
    }
    echo 'Successfully ' . filter_input(INPUT_GET, "submit") . '.';
} 

else if ($funct == "save") {

    $btn = '<input type="button" name="submit" id="submit" class="submit" '
            . 'value="' . filter_input(INPUT_GET, "submit") . '" onclick="submit();"><br />';

    require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
    $sql = new system_strings();

    require_once (dirname(__FILE__) . '/../../Class/query.php');
    $query = new query();

    require_once (dirname(__FILE__) . '/../../DbClass/Item.php');
    $Item = new Item();
    $ItemMapper = new ItemMapper();

    $Connection = $sql->connect();
    if ($Connection == false) {
        echo $btn;
        exit($sql->error());
    }

    $result = $sql->query($Connection, $query->makeID("ITEM", "IJITM"));
    if ($result == false) {
        echo $btn;
        $sql->roleback($Connection);
        exit($sql->error());
    }

    $actor = $sql->actors($result);
    $ID = $actor["ID"];

    $Item->_Id = $ID;
    $Item->_Name = filter_input(INPUT_GET, "name");
    $Item->_DisplayName = filter_input(INPUT_GET, "d_name");
    $Item->_TypeId = filter_input(INPUT_GET, "type");
    $Item->_Description = filter_input(INPUT_GET, "disc");
    $Item->_Price = filter_input(INPUT_GET, "price");
    $Item->_CreateBy = $_SESSION["userid"];

    if ($ItemMapper->Insert($Item, $Connection) == false) {
        echo $btn;
        exit($ItemMapper->error());
    }

    $sql->close($Connection);

    $Endurl = filter_input(INPUT_GET, "Endurl");

    if ($Endurl == "") {
        echo '<input type="button" value="Go to main page" class="submit" onclick="set_url()"><br />';
    } else {
        echo '<input type="button" value="Go to ' . $Endurl . '" class="submit" onclick="set_url()"><br />';
    }
    echo 'Successfully ' . filter_input(INPUT_GET, "submit") . '.';
} 

else if ($funct == "search") {


    require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
    $sql = new system_strings();

    require_once (dirname(__FILE__) . '/../../Class/search.php');
    $search = new search();

    require_once (dirname(__FILE__) . '/../../DbClass/Item.php');
    $Item = new Item();
    $ItemMapper = new ItemMapper();

    $Connection = $sql->connect();
    if ($Connection == false) {
        exit($sql->error());
    }

    $Item->_Id = filter_input(INPUT_GET, "item_id");
    $Item->_Name = filter_input(INPUT_GET, "name");
    $Item->_DisplayName = filter_input(INPUT_GET, "d_name");
    $Item->_Description = filter_input(INPUT_GET, "disc");
    $Item->_TypeId = filter_input(INPUT_GET, "type");
    $Item->_Price = filter_input(INPUT_GET, "price");

    $ObjArray = $ItemMapper->Search($Item, $Connection);

    if ($ObjArray == false) {
        exit($ItemMapper->error());
    }

    $search->table();

    for ($index = 0; $index < count($ObjArray); $index++) {

        if ($index == 0) {
            $th = true;
            $btn = "Select";
        } else {
            $th = false;
            $btn = $search->button("Admin/Item/" . filter_input(INPUT_GET, "DES") . "/" . $ObjArray[$index]->_Id);
        }



        $search->add(array(
            $ObjArray[$index]->_Id
            , $ObjArray[$index]->_Name
            , $ObjArray[$index]->_DisplayName
            , $ObjArray[$index]->_Description
            , $ObjArray[$index]->_Price
            , $btn
                ), $th);
    }

    $search->drow();
} 

else if ($funct == "edit") {
    $btn = '<input type="button" name="submit" id="submit" class="submit" '
            . 'value="' . filter_input(INPUT_GET, "submit") . '" onclick="edit()"><br />';

    require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
    $sql = new system_strings();

    require_once (dirname(__FILE__) . '/../../Class/query.php');
    $query = new query();

    require_once (dirname(__FILE__) . '/../../DbClass/Item.php');
    $Item = new Item();
    $ItemMapper = new ItemMapper();

    $Connection = $sql->connect();
    if ($Connection == false) {
        echo $btn;
        exit($sql->error());
    }

    $Item->_Id = filter_input(INPUT_GET, "ID");

    $Item = $ItemMapper->Select($Item, $Connection);

    if ($Item == false) {
        echo $btn;
        exit($ItemMapper->error());
    }

    $Item->_Name = filter_input(INPUT_GET, "name");
    $Item->_DisplayName = filter_input(INPUT_GET, "d_name");
    $Item->_TypeId = filter_input(INPUT_GET, "type");
    $Item->_Description = filter_input(INPUT_GET, "disc");
    $Item->_Price = filter_input(INPUT_GET, "price");
    $Item->_CreateBy = $_SESSION["userid"];

    if ($ItemMapper->Update($Item, $Connection) == false) {
        echo $btn;
        exit($ItemMapper->error());
    }

    $sql->close($Connection);

    $Endurl = filter_input(INPUT_GET, "Endurl");

    if ($Endurl == "") {
        echo '<input type="button" value="Go to main page" class="submit" onclick="set_url()"><br />';
    } else {
        echo '<input type="button" value="Go to ' . $Endurl . '" class="submit" onclick="set_url()"><br />';
    }
    echo 'Successfully ' . filter_input(INPUT_GET, "submit") . '.';
}

else if ($funct == "search-img"){
    
    require_once (dirname(__FILE__) . '/../../Class/system_strings.php');
    $sql = new system_strings();

    require_once (dirname(__FILE__) . '/../../Class/search.php');
    $search = new search();

    require_once (dirname(__FILE__) . '/../../DbClass/Item.php');
    $Item = new Item();
    
    require_once (dirname(__FILE__) . '/../../DbClass/ItemImage.php');
    $ItemImage = new ItemImage();
    $ItemImageMapper = new ItemImageMapper();
    
    require_once (dirname(__FILE__) . '/../../Class/interface_magic.php');
    $int_mg = new interface_magic();

    $Connection = $sql->connect();
    if ($Connection == false) {
        exit($sql->error());
    }

    $Item->_Id = filter_input(INPUT_GET, "item_id");
    $Item->_Name = filter_input(INPUT_GET, "name");
    $Item->_DisplayName = filter_input(INPUT_GET, "d_name");
    $Item->_Description = filter_input(INPUT_GET, "disc");
    $Item->_TypeId = filter_input(INPUT_GET, "type");
    $Item->_Price = filter_input(INPUT_GET, "price");
    
    $ItemImage->_TypeId = filter_input(INPUT_GET, "img_type");

    $ObjArray = $ItemImageMapper -> Search($ItemImage, $Item, $Connection);

    if ($ObjArray == false) {
        exit($ItemImageMapper->error());
    }

    $search->table();

    for ($index = 0; $index < count($ObjArray); $index++) {

        if ($index == 0) {
            $th = true;
            $btn = "Delete";
            $iamge = "Image";
        } else {
            $th = false;
            $iamge = "<img src='" . $int_mg->external_item($ObjArray[$index] -> _Image, "75X100") . "'>";
            $btn = $search->button("Admin/Item/" . filter_input(INPUT_GET, "DES") . "/" . $ObjArray[$index]->_Id, "Delete");
        }

        $search -> add(array(
            $iamge
            , $btn
                ), $th);
    }

    $search->drow();
   
}
    
