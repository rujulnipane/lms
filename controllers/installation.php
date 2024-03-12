<?php

include_once("../models/installationModel.php");

// check if config file is present or not
$file_path = "../config.php";
session_start();
if(file_exists($file_path)){
    header('Location: '. "../views/Login.php");
}


$user;
$password;
$email;
$dbname;
$dbuser;
$dbpass;

// get details from submitted form 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $dbuser = $_POST['dbuser'];
    $dbname = $_POST["dbname"];
    $dbpass = $_POST['dbpass'];
} else {
    header('Location:' . '../views/partials/404.php');
}

// creating config file and storing details
try{
    $config = fopen("../config.php", "w") or throw new Exception("Make sure have neccessary permissions");
}
catch(Exception $e){
    $_SESSION['error'] = $e->getMessage();
    header('Location: '. "../views/adminReg.php");
    exit;
}

$content = <<<EOD
<?php
\$config = array(
    'server' => 'localhost',
    'user' => '$user',
    'pass' => '$password',
    'dbuser' => '$dbuser',
    'dbpass' => '$dbpass',
    'dbname' => '$dbname',
    'email' => '$email'
);
?>
EOD;


fwrite($config, $content);
fclose($config);

// initialie the database and create tables and admin user
try{
    Installation::initialize();
    header('Location: '. "../views/welcome.php");
}
catch(Exception $e){
    unlink($file_path);
    $_SESSION['error'] = $e->getMessage();
    header('Location: '. "../views/adminReg.php");
    exit;
}













