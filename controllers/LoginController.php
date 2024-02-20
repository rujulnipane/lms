<?php

include "../models/UserModel.php";
require "../vendor/autoload.php";
use Firebase\JWT\JWT;


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
        try{
            $this->User = new User();
        }
        catch(Exception $e){
            header('Location: '. "../views/Login.php");
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function loginUser(){
        try{
            $user = $this->User->getUser(array("username"=> $this->username));
        }
        catch(Exception $e){
            header('Location: '. "../views/Login.php");
            $_SESSION['error'] = $e->getMessage();
        }
        if($user->num_rows == 0){
            $_SESSION['error'] = "User Not Exist";
            $_SESSION['details'] = array('username'=> $this->username);
            header('Location: '. "../views/Login.php");
            exit;
        }
        else{
            $row = $user->fetch_assoc();
            // Auth::Login($row);
            if(password_verify($this->password,$row["password"])){
                echo("Logged in successfully");
                $_SESSION['username'] = $row['username'];
                $_SESSION['userId'] = $row['id'];
                // $key = "ssfvsfv16";
                // $token = JWT::encode(
                //     array(
                //         'iat' =>  time(),
                //         'nbf' =>  time(),
                //         'exp' =>  time()+3600,
                //         'data' => array(
                //             'userid' => $row['id'],
                //             'username' => $row['username'],
                //         )
                //     ),$key,'HS256'
                // );
                // setcookie("token",$token,time()+3600,'/',"",true,true);
                if($row['isAdmin'] === "yes"){
                    $_SESSION['isAdmin'] = true;
                }
                else{
                    $_SESSION['isAdmin'] = false;
                }
                $_SESSION['successmsg'] = "Logged in successfully";
                header('Location: '. "../views/Courses.php");
            }
            else{
                echo("Invalid password");
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




