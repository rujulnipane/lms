<?php
include_once("dbModel.php");

class Installation{
    private $db;
    private $user;
    private $password;
    private $email;
    private $dbname;

    public function __construct(){
        $this->db = Database::getInstance();
    }
    public function initialize(){   
        $this->db->initializeDatabase();
    }
    public function createAdminUser(){
        $this->db->getConnection();
        $this->db->createAdminUser();
    }

    public function createTables(){
        $this->db->getConnection();
        $this->db->createTables();
    }

}
