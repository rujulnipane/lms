<?php
include_once("dbModel.php");

class Installation{
    // function to install the website 
    public static function initialize(){  
        $db = Database::getInstance(); 
        $db->initializeDatabase();
    }
}
