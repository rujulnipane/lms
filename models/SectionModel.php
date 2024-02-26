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
    public function getSections($courseid){
        return $this->db->getRecord("SECTION",array(
            "course_id" => $courseid
        ));
    }

    public function getSection($section_id, $course_id){
        return $this->db->getRecord("SECTION",array("id" => $section_id,"course_id"=> $course_id));
    }
    public function createSection($courseid, $data, $section_url){
       
        $id = $this->db->insertRecord("SECTION",array(
            "course_id"=> $courseid,
            "title"=> $data,
            "section_url" => $section_url
        ));
        return $id;
    }

    public function deleteSection($data){
        $this->db->deleteRecord("SECTION",array(
            "id" => $data["section_id"],
            "course_id" => $data["course_id"],
        ));
    }
}