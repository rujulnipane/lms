<?php

$file = "config.txt";

if(file_exists($file)){
    header('Location: '. "./views/Login.php");
    echo "file exists";
}
else{
    echo "not";
    // header('Location: '. "./views/Login.php");
    header('Location: '. "./views/adminReg.php");
    // get_installation();
}