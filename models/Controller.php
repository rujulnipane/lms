<?php 

include("dbModel.php");
class Controller{
    protected $db;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }
}