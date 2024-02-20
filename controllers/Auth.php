<?php

session_start();

class Auth {
    public static function isLogin() {
        if(isset($_SESSION["username"])){
            return true;
        }
        return false;
    }

    public static function isAdminUser() {
        if(isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true){
            return true;
        }
        return false;
    }

    public static function Login($user) {
        
    }


}