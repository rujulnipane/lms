<?php

include_once("../models/installationModel.php");


$file_path = "../config.txt";

if(file_exists($file_path)){
    header('Location: '. "../views/Login.php");
    
    echo "file exists";
}


$user;
$password;
$email;
$dbname;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $dbname = $_POST["dbName"];
} else {
    echo "bd";
}

$config = fopen("../config.txt", "w") or die("Unable to open file!");

$content = "server=localhost \nuser=$user \nemail=$email \npassword=$password \ndbname=$dbname";
fwrite($config, $content);
fclose($config);

try{
    $install = new Installation();
}
catch(Exception $e){
    
    $_SESSION['error'] = $e->getMessage();
    header('Location: '. "../views/adminReg.php");
    exit;
}
try{
    $install->initialize();
}
catch(Exception $e){
    // echo"". $e->getMessage() ."";
    $_SESSION['error'] = $e->getMessage();
    header('Location: '. "../views/adminReg.php");
    exit;
}

try{
    $install->createTables();
}
catch(Exception $e){
    $_SESSION['error'] = $e->getMessage();
    header('Location: '. "../views/adminReg.php");
    exit;
}

try{
    $install->createAdminUser();
}
catch(Exception $e){
    $_SESSION['error'] = $e->getMessage();
    header('Location: '. "../views/adminReg.php");
    exit;
}

header('Location: '. "../views/welcome.php");

