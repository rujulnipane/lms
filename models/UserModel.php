
<?php
include_once("dbModel.php");

class User{
    private $db;

    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }
    public function __destruct() {
        $this->db->closeConnection();
    }
    public function getUser($query){
        return $this->db->getRecord("USER",$query);
    }
    public function createUser($data){
        $this->db->insertRecord("USER", $data);
    }

}