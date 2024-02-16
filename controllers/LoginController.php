<?php

include "../models/UserModel.php";
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
            echo "bd";
        }

        $this->User = new User();
    }

    public function loginUser(){
        $user = $this->User->getUser($this->username);
        var_dump($user);
        if($user->num_rows == 0){
            $_SESSION['error'] = "User Not Exist";
            header('Location: '. "../views/Login.php");
            exit;
        }
        else{
            $row = $user->fetch_assoc();
            if(password_verify($this->password,$row["password"])){
                echo("Logged in successfully");
                $_SESSION['username'] = $row['username'];
                $_SESSION['successmsg'] = "Logged in successfully";
                header('Location: '. "../views/Courses.php");
            }
            else{
                echo("Invalid password");
                $_SESSION['error'] = "Invalid username or password. Please try again.";
                header('Location: '. "../views/Login.php");
                exit;
            } 
        }
        
    }

}


$login = new Login();
$login->loginUser();




