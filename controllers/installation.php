<?php




include_once("../models/installationModel.php");

$file_path = "../config.php";

if(file_exists($file_path)){
    header('Location: '. "../views/Login.php");
    echo "file exists";
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
    echo "bd";
}

// $config = fopen("../config.txt", "w") or die("Unable to open file!");
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

// $content = "server=localhost \nuser=$user \nemail=$email \npassword=$password \ndbname=$dbname";
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








