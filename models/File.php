<?php

class File{
    public function __construct(){}
    public static function createDir($dir){
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        } else {
            throw new Exception("Course already Exists");
        }
    }

    public static function uploadFile($src,$des){
        if (move_uploaded_file($src, $des)) {
        } else {
            throw new Exception("Cannot Upload File");
        }
    }
    public static function deleteDir($dir){
        if (!is_dir($dir)) {
            return false; 
        }
        $handle = opendir($dir);

        while (false !== ($item = readdir($handle))) {
            if ($item != "." && $item != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $item)) {
                    File::deleteDir($dir . DIRECTORY_SEPARATOR . $item);
                } else {
                    unlink($dir . DIRECTORY_SEPARATOR . $item);
                }
            }
        }
        closedir($handle);
        return rmdir($dir);
    }

}