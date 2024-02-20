<?php

session_start();

$file_path = "../config.php";

if(!file_exists($file_path)){
    header('Location: '. "./adminReg.php");
}
else{
    $_SESSION['$success'] = "Installation process completed";
    header('Location: '. "./Login.php");
}




