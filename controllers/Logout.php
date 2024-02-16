<?php
session_start();
session_unset();
session_destroy();

setcookie("token",$token,time()-3600,'/',"",true,true);
header('Location: '. "../views/Login.php");