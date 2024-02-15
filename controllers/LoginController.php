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
            echo "User not exist";
            return;
        }
        else{
            echo "else block";
            $row = $user->fetch_assoc();
            echo "fg";
            // if($this->password === $row["password"]){
                echo("Logged in successfully");
                $_SESSION['username'] = $row['name'];
                header('Location: '. "../views/Courses.php");
            // }
            // else{
                // echo("Invalid password");
                // header('Location: '. "../views/Login.php");
                // $this->response["passerror"] = "Invalid password";
            // }
            // echo json_encode($this->response);   
        }
        
    }

}


$login = new Login();
$login->loginUser();




