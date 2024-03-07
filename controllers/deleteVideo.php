<?php 
include("../models/VideoModel.php");
include("../models/File.php");
include_once("Auth.php");

if(!Auth::isLogin()){
    header("Location" . "../views/Login.php");
}
// check if user is admin 
if(!Auth::isAdminUser()){
    header("Location:" . "../views/partials/404.php");
}
class DeleteVideo{
    private $video_id;
    private $section_id;
    public function __construct(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->video_id = $_POST['video_id'];
            $this->section_id = $_POST['section_id'];
        }
        else{
            header('Location:' . '../views/partials/404.php');
            exit;
        }
    }
    public function deleteVideo(){
        try{
            $videoobj = new Video();
            $result = $videoobj->getVideo($this->video_id, $this->section_id);
            $video = $result->fetch_assoc();
            File::deleteFile($_SERVER['DOCUMENT_ROOT'] . $video['video_url']);
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