<?php

include("../../controllers/Auth.php");
session_start();

if(!Auth::isLogin()){
    header("Location" . "../Login.php");
}

