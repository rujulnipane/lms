<?php

include("../../controllers/Auth.php");
session_start();

if(!Auth::isLogin()){

    header("Location: " . "../views/Login.php");
}

if(Auth::isLogin()){
    echo "ccdd";
    header("Location: " . "../views/Courses.php");
}
