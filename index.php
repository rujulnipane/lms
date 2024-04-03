<?php

include_once("Router.php");
include_once("controllers/Auth.php");
$file = "config.php";

if(file_exists($file)){
    header('Location: '. "./views/Login.php");
    echo "file exists";
}
else{
    echo "not";
    header('Location: '. "./views/adminReg.php");
}


// Router::handle();