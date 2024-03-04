<?php

include_once("../models/installationModel.php");

$file_path = "../config.php";

if(file_exists($file_path)){
    header('Location: '. "../views/Login.php");
}


$user;
$password;
$email;
$dbname;
$dbuser;
$dbpass;

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


$config = fopen("../config.php", "w") or die("Unable to open file!");

$content = <<<EOD
<?php
\$config = array(
'server' => 'localhost',
'user' => '$user',
'pass'=>'$password',
'dbuser' => '$dbuser',
'dbpass' => '$dbpass',
'dbname' => '$dbname',
'email' => '$email'
);
?>
EOD;

fwrite($config, $content);
fclose($config);

try{
    Installation::initialize();
    header('Location: '. "../views/welcome.php");
}
catch(Exception $e){
    $_SESSION['error'] = $e->getMessage();
    header('Location: '. "../views/adminReg.php");
    exit;
}













