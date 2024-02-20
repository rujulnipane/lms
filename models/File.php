<?php

class File{
    public function __construct(){}
    public static function createDir($dir){
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        } else {
            throw new Exception("Course alrready Exists");
        }
    }

    public static function uploadFile($file){

    }
    public static function deleteFile($file_path){

    }

}