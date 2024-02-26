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

    public static function replaceFile($src,$des){
        if (file_exists($des)) {
            unlink($des);
        }
        if(move_uploaded_file($src, $des)){

        }
        else{
            throw new Exception("Cnnot replace");
        }
    }

    public static function deleteFile($file){
        if (file_exists($file)) {
            if (unlink($file)) {
            } else {
                throw new Exception("Cannot delete file");
            }
        } else {
            throw new Exception("File Not found");
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