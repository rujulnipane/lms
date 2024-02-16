
<?php
include_once("dbModel.php");

class User{
    private $db;

    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }

    public function getUser($name){
        return $this->db->getRecord("USER", array("username"=> $name));
    }
    public function createUser($data){
        $this->db->insertRecord("USER", $data);
    }

}