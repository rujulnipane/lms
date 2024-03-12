<?php
include_once("dbModel.php");
class Video{
    private $db;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }

    // function to create partucilar video
    public function createVideo($title,$video_url,$section_id){
        $id = $this->db->insertRecord("VIDEO",array(
            "section_id"=> $section_id,
            "video_url" => $video_url,
            "title" => $title
        ));
        return $id;
    }

    // function to get all videos of particular section
    public function getVideos($sectionid){
        return $this->db->getRecord("VIDEO",array("section_id" =>$sectionid));
    }

    // function to get particular video
    public function getVideo($videoid,$sectionid){
        return $this->db->getRecord("VIDEO",array('id' => $videoid,'section_id'=> $sectionid));
    }

    // function to delete video
    public function deleteVideo($videoid,$sectionid){
         $this->db->deleteRecord('VIDEO',array('id' => $videoid,'section_id'=> $sectionid));
    }
}   