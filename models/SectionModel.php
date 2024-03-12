<?php
include_once("dbModel.php");
include_once("VideoModel.php");
class Section{
    private $db;
    private $video;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
        $this->video = new Video();
    }

    // function to get all sections of particular course
    public function getSections($courseid){
        return $this->db->getRecord("SECTION",array(
            "course_id" => $courseid
        ));
    }

    // function to get particular section
    public function getSection($section_id, $course_id){
        return $this->db->getRecord("SECTION",array("id" => $section_id,"course_id"=> $course_id));
    }

    // function to create section
    public function createSection($courseid, $data, $section_url){
        $id = $this->db->insertRecord("SECTION",array(
            "course_id"=> $courseid,
            "title"=> $data,
            "section_url" => $section_url
        ));
        return $id;
    }

    // function to delete section
    public function deleteSection($data){
        $this->db->deleteRecord("SECTION",array(
            "id" => $data["section_id"],
            "course_id" => $data["course_id"],
        ));
    }
}