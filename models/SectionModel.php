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

    public function createSection($courseid, $data){
       
        $id = $this->db->insertRecord("SECTION",array(
            "course_id"=> $courseid,
            "title"=> $data[0],
            "details" => $data[1]
        ));
        foreach($data[2] as $video){
            $this->video->createVideo($id,$video);
        }
    }
}