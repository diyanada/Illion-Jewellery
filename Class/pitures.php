<?php

class pitures {

    private $error = NULL;
    private $target_pic = NULL;
    public $data = NULL;

    //------------------------------------------------------------------------------------------------------

    private function history($oldpic, $file_dir) {

        $target_dir = $file_dir . "HISTORY/";
        $this->directory($target_dir);

        if (rename(($file_dir . $oldpic), ($target_dir . $oldpic)) == false) {
            $this->error = "Sorry, there was an error uploading your file.";
            return false;
        }
    }

    //------------------------------------------------------------------------------------------------------

    private function path($folder, $dir = NULL, $width = 0, $height = 0) {

        require_once (dirname(__FILE__) . '/interface_magic.php');
        $int_mg = new interface_magic();

        if ($dir == NULL) {
            $target_dir = "/" . $folder . "/" . $height . "X" . $width . "/";
        } else {
            $target_dir = "/" . $folder . "/" . $dir . "/";
        }

        return ($int_mg ->external_image() . $target_dir);
    }

    //------------------------------------------------------------------------------------------------------

    private function directory($path) {


        if (file_exists($path) == false) {
            mkdir($path, 0777, true);
        }
    }

    //------------------------------------------------------------------------------------------------------

    private function resize_image($src, $w, $h) {
        
        switch (exif_imagetype($src)) {
            case IMAGETYPE_GIF:
                $src_img = imagecreatefromgif($src);
                break;
            case IMAGETYPE_JPEG:
                $src_img = imagecreatefromjpeg($src);
                break;
            case IMAGETYPE_PNG:
                $src_img = imagecreatefrompng($src);
                break;
        }    

        $size = getimagesize($src);
        $size_w = $size[0]; // natural width
        $size_h = $size[1]; // natural height

        $src_img_w = $size_w;
        $src_img_h = $size_h;

        $tmp_img_w = $this->data["CP_width"];
        $tmp_img_h = $this->data["CP_height"];

        $dst_img_w = $w;
        $dst_img_h = $h;

        $src_x = $this->data["CP_x"];
        $src_y = $this->data["CP_y"];

        if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
            $src_x = $src_w = $dst_x = $dst_w = 0;
        } else if ($src_x <= 0) {
            $dst_x = -$src_x;
            $src_x = 0;
            $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
        } else if ($src_x <= $src_img_w) {
            $dst_x = 0;
            $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
        }

        if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
            $src_y = $src_h = $dst_y = $dst_h = 0;
        } else if ($src_y <= 0) {
            $dst_y = -$src_y;
            $src_y = 0;
            $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
        } else if ($src_y <= $src_img_h) {
            $dst_y = 0;
            $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
        }
        // Scale to destination position and size
        $ratio = $tmp_img_w / $dst_img_w;
        $dst_x /= $ratio;
        $dst_y /= $ratio;
        $dst_w /= $ratio;
        $dst_h /= $ratio;

        $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);
        // Add transparent background to destination image
        imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
        imagesavealpha($dst_img, true);

        imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

        return $dst_img;
    }

    //------------------------------------------------------------------------------------------------------

    function save($FILES, $folder, $type = "IJPIC", $dir = NULL, $oldpic = NULL) {

        $check = getimagesize($FILES["tmp_name"]);
        if ($check == false) {
            $this->error = "File is not an image.";
            return false;
        } else {
            list($width, $height) = $check;
        }
        
        if ($width < 500 or $height < 500){
            $this->error = "Sorry, Image is to small try onother one.";
            return false;
        }

        $target_file = $type . date("dhis", time()) . rand(111, 999) . ".JPG";

        $target_dir = $this->path($folder, $dir, $width, $height);
        $target = $target_dir . $target_file;


        $imageFileType = pathinfo($FILES["name"], PATHINFO_EXTENSION);

        $this->directory($target_dir);

        if ($oldpic != NULL) {
            if ($this->history($oldpic, $target_dir) == false) {
            }
        }

        if (file_exists($target)) {
            $this->error = "Sorry, there was an error uploading your file.";
            return false;
        } else if ($FILES["size"] > 150000000) {
            $this->error = "Sorry, your file is too large.";
            return false;
        } else if ($imageFileType != "jpg") {
            $this->error = "Sorry, only JPG allowed.";
            return false;
        } else if (move_uploaded_file($FILES["tmp_name"], $target)) {

            if (file_exists($target)) {
                $this->target_pic = $target;
                return $target_file;
            } else {
                $this->error = "Sorry, there was an error uploading your file.";
                return false;
            }
        } else {
            $this->error = "Sorry, there was an error uploading your file.";
            return false;
        }
    }

    //------------------------------------------------------------------------------------------------------

    function resize($filename, $folder, $width, $height, $dir = NULL) {

        $target_dir = $this->path($folder, $dir, $width, $height);
        $target_file = $filename;
        $target = $target_dir . $target_file;

        $this->directory($target_dir);

        if (file_exists($target)) {
            if ($this->history($filename, $target_dir) == false) {
                return false;
            }
        }

        if ($this->target_pic == NULL) {
            $this->error = "Sorry, there was an error uploading your file.";
            return false;
        }

        if ($this->data == NULL) {
            $this->error = "Sorry, there was an error uploading your file.";
            return false;
        }

        imagepng($this->resize_image($this->target_pic, $width, $height), $target);

        if (file_exists($target)) {
            return true;
        } else {
            $this->error = "Sorry, there was an error uploading your file.";
            return false;
        }
    }

    //------------------------------------------------------------------------------------------------------

    function errors() {
        $errors = $this->error;
        $this->error = NULL;
        return $errors;
    }

}
