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
    public function createSection($courseid, $data){
       
        $id = $this->db->insertRecord("SECTION",array(
            "course_id"=> $courseid,
            "title"=> $data,
        ));
    }

    public function deleteSection($data){
        $this->db->deleteRecord("SECTION",array(
            "id" => $data["section_id"],
            "course_id" => $data["course_id"],
        ));
    }
}