<?php 
include("../models/VideoModel.php");
include("../models/File.php");


class DeleteVideo{
    private $video_id;
    private $section_id;
    public function __construct(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->video_id = $_POST['video_id'];
            $this->section_id = $_POST['section_id'];
            
        }
    }
    public function deleteVideo(){
        try{
            $videoobj = new Video();
            $result = $videoobj->getVideo($this->video_id, $this->section_id);
            $video = $result->fetch_assoc();
            File::deleteFile($video['video_url']);
            $videoobj->deleteVideo($this->video_id, $this->section_id);
            echo json_encode(array('msg'=>'deleted Video successfully'));
        }
        catch(Exception $e){
            echo json_encode(array('error'=> $e->getMessage()));
        }
    }

}

$deleteobj =  new DeleteVideo();
$deleteobj->deleteVideo();