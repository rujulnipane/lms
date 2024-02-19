<?php

session_start();

$file_path = "../config.txt";

if(!file_exists($file_path)){
    header('Location: '. "./adminReg.php");
    
    echo "file exists";
}
else{
    // header('Location: '. "./Login.php");
}
echo "Installation process completed";



