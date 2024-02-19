<?php
include_once("dbModel.php");
class Section{
    private $db;
    private $video;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }

    public function createSection($courseid, $data){
        // echo $data[0];
        // echo $data[1];
        $id = $this->db->insertRecord("SECTION",array(
            "course_id"=> $courseid,
            "title"=> $data[0],
            "details" => $data[1]
        ));
        $this->video->createVideo($id,$data[2]);
    }
}