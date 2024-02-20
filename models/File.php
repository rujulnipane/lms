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
        echo $src . $des;
        if (move_uploaded_file($src, $des)) {
        } else {
            throw new Exception("Cannot Upload File");
        }
    }
    public static function deleteFile($file_path){

    }

}