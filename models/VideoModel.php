<?php
include_once("dbModel.php");
class Video{
    private $db;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }


    public function createVideo($title,$video_url,$section_id){
        $id = $this->db->insertRecord("VIDEO",array(
            "section_id"=> $section_id,
            "video_url" => $video_url,
            "title" => $title
        ));
        return $id;
    }
    public function getVideos($sectionid){
        return $this->db->getRecord("VIDEO",array("section_id" =>$sectionid));
    }
    
    public function getVideo($videoid,$sectionid){
        return $this->db->getRecord("VIDEO",array('id' => $videoid,'section_id'=> $sectionid));
    }

    public function deleteVideo($videoid,$sectionid){
         $this->db->deleteRecord('VIDEO',array('id' => $videoid,'section_id'=> $sectionid));
    }
}   