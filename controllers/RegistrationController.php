<?php

session_start();

include "../models/UserModel.php";

class Register
{
    private $username;
    private $email;
    private $password;
    private $User;
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->username = $_POST["username"];
            $this->email = $_POST["email"];
            $this->password = $_POST["password"];
        } else {
            echo "bd";
        }
        $this->User = new User();
    }
    public function registerUser()
    {   
        $user = $this->User->getUser($this->username);
        
        if ($user->num_rows > 0) {
            $_SESSION['error'] = "Username already taken";
            header('Location: '. "../views/Registration.php");
            exit;
        } else {
            $options = [
                'cost' => 10,
            ];
            $hashed_password = password_hash($this->password, PASSWORD_BCRYPT, $options);
            $array = array(
                'username' => $this->username,
                'email' => $this->email,
                'password' => $hashed_password
            );
            $this->User->createUser($array);
            $_SESSION['successmsg'] = "User Created Successfully.";
            header('Location: ' . "../views/Login.php");
        }
    }
}


$reg = new Register();

$reg->registerUser();


