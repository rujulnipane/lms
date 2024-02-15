<?php

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
            echo "User already exist";
        } else {
            $array = array(
                'name' => $this->username,
                'email' => $this->email,
                'password' => $this->password
            );
            $this->User->createUser($array);
            echo ("user created successfully");
            header('Location: ' . "../views/Login.php");
        }
    }
}


$reg = new Register();

$reg->registerUser();


