<?php

session_start();

class Auth
{
    // function to check whether user id login or not 
    public static function isLogin()
    {
        if(!file_exists("../config.php")){
            Auth::Logout();
            header('Location: '. "../views/adminReg.php");  
            exit;
        }
        if (isset($_SESSION["username"])) {
            return true;
        }
        return false;
    }

    // function to check if user is admin or not 
    public static function isAdminUser()
    {
        if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true) {
            return true;
        }
        return false;
    }
    
    // function to login user 
    public static function Login($row, $password)
    {
        if (password_verify($password, $row["password"])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['userId'] = $row['id'];
            if ($row['isAdmin'] === "yes") {
                $_SESSION['isAdmin'] = true;
            } else {
                $_SESSION['isAdmin'] = false;
            }
            return true;
        }
        return false;
    }
     
    // function to logout user 
    public static function Logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . "../views/Login.php");
    }
}
