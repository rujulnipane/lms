<?php

include_once("../models/installationModel.php");

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


$install = new Installation();
// $install->initialize();
// $install->createTables();
$install->createAdminUser();


