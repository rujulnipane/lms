<?php


session_start();

if(!isset($_SESSION["username"])){
    header('Location: '. "../views/Login.php");
}
else{
    echo "Logged In successfully";
}