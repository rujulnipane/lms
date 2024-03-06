<?php
include_once("dbModel.php");

class Installation{
    public static function initialize(){  
        $db = Database::getInstance(); 
        $db->initializeDatabase();
    }
}
