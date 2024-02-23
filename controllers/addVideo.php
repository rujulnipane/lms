<?php

// echo json_encode("sf");


class AddVideo{
    public function __construct(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo json_encode($_FILES);
        }
    }

    

}

$addobj = new AddVideo();
