<?php
include_once("dbModel.php");
class Video{
    private $db;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }


    public function createVideo($sectionid,$video){
            $this->db->insertRecord("VIDEO",array(
                "section_id"=> $sectionid,
                "video_url" => $video,
            ));
    }
    
}