<?php

include_once("dbModel.php");
include_once("SectionModel.php");
// include_once("../controllers/controller.php");
class Course
{
    private $db;
    private $section;
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }

    // function to get all courses 
    public function getCourses()
    {
        return $this->db->getRecords("COURSE");
    }

    // function to get particular course by course id 
    public function getCourseById($courseId)
    {
        return $this->db->getRecord("COURSE", array(
            "id" => $courseId
        ));
    }

    // function to create course 
    public function createCourse($data)
    {
        $id = $this->db->insertRecord("COURSE", array(
            "title" => $data[0],
            "details" => $data[1],
            "url" => $data[2],
        ));
        return $id;
    }   
    
    // function to update course
    public function updateCourse($data){
        $this->db->updateRecord("COURSE",array(
            "title"=> $data["title"],
            "details" => $data["details"],
            "url" => $data["url"],
        ),
        array("id"=> $data["id"]));
    }

    // function to delete particular course
    public function deleteCourse($courseId){
        $this->db->deleteRecord("COURSE", array("id" => $courseId));
    }
}
