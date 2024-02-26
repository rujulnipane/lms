<?php

include_once("dbModel.php");
include_once("SectionModel.php");
class Course
{
    private $db;
    private $section;
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }
    public function getCourses()
    {
        return $this->db->getRecords("COURSE");
    }
    public function getCourseById($courseId)
    {
        return $this->db->getRecord("COURSE", array(
            "id" => $courseId
        ));
    }

    public function createCourse($data)
    {
        $id = $this->db->insertRecord("COURSE", array(
            "title" => $data[0],
            "details" => $data[1],
            "url" => $data[2],
        ));

        // $this->section = new Section();
        // $this->section->createSection(
        //     $id,
        //     $data[3]
        // );
    }   

    public function updateCourse($data){
        $this->db->updateRecord("COURSE",array(
            "title"=> $data["title"],
            "details" => $data["details"],
            "url" => $data["url"],
        ),
        array("id"=> $data["id"]));
    }

    public function deleteCourse($courseId){
        $this->db->deleteRecord("COURSE", array("id" => $courseId));
    }
}
