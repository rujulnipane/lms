<?php

include "../models/UserModel.php";
include "Auth.php";

if(!Auth::isLogin()){
    // $_SESSION["error"] = "Login First";
    header('Location: '. "../views/Login.php");
}

session_start();
class Login{
    private $username;
    private $password;
    private $User;
    public function __construct(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $this->username = $_POST["username"];
            $this->password = $_POST["password"];
        }   
        else{
            header('Location:' . '../views/partials/404.php');
            exit;
        }
        try{
            $this->User = new User();
        }
        catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header('Location: '. "../views/Login.php");
            exit;
        }
    }

    public function loginUser(){
        // check whether user present or not in database
        try{
            $user = $this->User->getUser(array("username"=> $this->username));
        }
        catch(Exception $e){
            header('Location: '. "../views/Login.php");
            $_SESSION['error'] = $e->getMessage();
            exit;
        }
        if($user->num_rows == 0){
            $_SESSION['error'] = "Invalid username or password. Please try again.";
            $_SESSION['details'] = array('username'=> $this->username);
            header('Location: '. "../views/Login.php");
            exit;
        }
        else{
            // login the user by verifying password
            $row = $user->fetch_assoc();
            if(Auth::Login($row,$this->password)){
                $_SESSION['success'] = "Logged in successfully";
                header('Location: '. "../views/Courses.php");
            }
            else{
                $_SESSION['error'] = "Invalid username or password. Please try again.";
                $_SESSION['details'] = array('username'=> $this->username);
                header('Location: '. "../views/Login.php");
                exit;
            }
        }
    }
}


$login = new Login();
$login->loginUser();




