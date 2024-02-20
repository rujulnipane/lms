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

// $config = fopen("../config.txt", "w") or die("Unable to open file!");
$config = fopen("../config.php", "w") or die("Unable to open file!");

$content = <<<EOD
<?php
\$config = array(
'server' => 'localhost',
'dbuser' => '$user',
'dbpass' => '$password',
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









/*
<?php

class Installer
{
    private $filePath;
    private $user;
    private $password;
    private $email;
    private $dbName;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function processInstallation()
    {
        if ($this->checkConfigExists()) {
            header('Location: ../views/Login.php');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->user = $_POST["username"];
            $this->email = $_POST["email"];
            $this->password = $_POST["password"];
            $this->dbName = $_POST["dbName"];
        }

        $this->writeConfigFile();

        try {
            $installation = new InstallationModel();
            $installation->initialize();
            $installation->createTables();
            $installation->createAdminUser();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ../views/adminReg.php');
            exit;
        }

        header('Location: ../views/welcome.php');
    }

    private function checkConfigExists()
    {
        return file_exists($this->filePath);
    }

    private function writeConfigFile()
    {
        $configContent = <<<EOD
<?php
\$config = array(
    'server' => 'localhost',
    'dbuser' => '{$this->user}',
    'dbpass' => '{$this->password}',
    'dbname' => '{$this->dbName}',
    'email' => '{$this->email}'
);
?>
EOD;

        $configFile = fopen($this->filePath, "w") or die("Unable to open file!");
        fwrite($configFile, $configContent);
        fclose($configFile);
    }
}

// Usage:
$installer = new Installer("../config.php");
$installer->processInstallation();

?>
