<?php

session_start();

$file_path = "../config.php";

if(!file_exists($file_path)){
    header('Location: '. "./adminReg.php");
}
else{
    include("../config.php");
    echo `<h1> Welcome to the LMS Platform </h1>`;

    echo file_get_contents($file_path);

    echo 'Please Login to continue';
    echo `<a href='./Login.php'>Login</a>`;
    $_SESSION['$success'] = "Installation process completed";
    header('Location: '. "./Login.php");
}




