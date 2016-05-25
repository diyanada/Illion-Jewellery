<?php 
class interface_magic{

    private $_ImagePath;
    private $_Url;
    private $_InvicePath;
    
    function __construct() {
        
        include (dirname(__FILE__) . '/../owsh_secret.php');
        
        $this -> _ImagePath = $image_path;
        $this -> _InvicePath = $invice_path;
        $this -> _Url = $url_path;
    }
    
    public function external_source($url = NULL){
        
        return $this -> _Url . $url;
    }
    
    public function external_image($url = NULL){
        
        return $this -> _ImagePath . $url;
    }

    public function external_avatar($image, $target = "500X500"){

        return $this -> _Url . "Image/Avatar/" . $target . "/" . $image;
    }

    public function external_item($image, $target = "600X800"){

        return $this -> _Url . "Image/Item/" . $target . "/" . $image;
    }

    public function Invoice_Path(){
        
        return $this -> _InvicePath;
    }
}