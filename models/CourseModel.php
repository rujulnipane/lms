<?php

include_once("dbModel.php");
class Course{
    private $db;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }
    public function getCourses(){
        return $this->db->getRecords("COURSE");
    }
    public function getCoursesByCourseId($courseId){
    
    }
}