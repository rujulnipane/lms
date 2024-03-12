<?php

include("../models/CourseModel.php");
include_once("SectionModel.php");
include_once("../models/VideoModel.php");
include_once("Auth.php");

if(!Auth::isLogin()){
    header("Location" . "../views/Login.php");
    exit;
}
class GetCourse{
    private $course;
    private $sections;
    private $videos;
    private $id;
    private $Course;
    public function __construct(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->id = $_POST['id'];
        }
        else{
            header('Location:' . '../views/partials/404.php');
            exit;
        }
        try{
            $this->Course = new Course();
        }
        catch(Exception $e){
            exit;
        }
    }

    // get course details from course table
    public function getCourse(){
        $result = $this->Course->getCourseById($this->id);
        $this->course = $result->fetch_assoc();
        $this->getSections();
    }

    // get all sections of the course from sections table
    public function getSections(){
        $section = new Section();
        $result = $section->getSections($this->id);
        while($row = $result->fetch_assoc()){
            $this->sections[] = $row;
        }
        
        foreach($this->sections as $section){
            $this->videos[] =  $this->getVideos($section['id']);
        }
    }

    // get all videos from all sections of the course from videos table
    public function getVideos($sectio_id){
        $video = new Video();
        $videoarr = [];
        $result = $video->getVideos($sectio_id);
        while($row = $result->fetch_assoc()){
            $videoarr[] = $row;
        }
        return $videoarr;
    }

    // send back the response in json format
    public function sendResponse(){
        echo json_encode(array(
            'status'=> 'success',
            'course'=> $this->course,
            'videos'=> $this->videos,
            "sections"=> $this->sections
        ));
    }
}

$obj = new GetCourse();
$obj->getCourse();

$obj->sendResponse();