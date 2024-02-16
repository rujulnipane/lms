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
            header('Location: '. "../views/Registration.php");
            exit;
        }
        try{
            $this->User = new User();
        }
        catch(Exception $e){
            header('Location: '. "../views/Login.php");
            $_SESSION['error'] = $e->getMessage();
        }
    }
    public function registerUser()
    {   
        try{
            $userbyemail = $this->User->getUser(array("email"=> $this->email));
        }
        catch(Exception $e){
            header('Location: '. "../views/Login.php");
            $_SESSION['error'] = $e->getMessage();
        }
        try{
            $userbyname = $this->User->getUser(array("username"=> $this->username));
        }
        catch(Exception $e){
            header('Location: '. "../views/Login.php");
            $_SESSION['error'] = $e->getMessage();
        }
        if ($userbyname->num_rows > 0) {
            $_SESSION['error'] = "Username already exists";
            $_SESSION['details'] = array('username'=> $this->username, 'email' => $this->email);
            header('Location: '. "../views/Registration.php");
            exit;
        } 
        else if($userbyemail->num_rows > 0){
            $_SESSION['error'] = "Email already exists";
            $_SESSION['details'] = array('username'=> $this->username, 'email' => $this->email);
            header('Location: '. "../views/Registration.php");
            exit;
        }else {
            $options = [
                'cost' => 10,
            ];
            $hashed_password = password_hash($this->password, PASSWORD_BCRYPT, $options);
            $array = array(
                'username' => $this->username,
                'email' => $this->email,
                'password' => $hashed_password
            );
            try{
                $this->User->createUser($array);
            }
            catch(Exception $e){
                header('Location: '. "../views/Login.php");
            $_SESSION['error'] = $e->getMessage();
            }
            $_SESSION['success'] = "User Created Successfully.";
            header('Location: ' . "../views/Login.php");
        }
    }
}


$reg = new Register();

$reg->registerUser();


