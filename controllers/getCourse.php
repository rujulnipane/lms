<?php
include("../models/CourseModel.php");
echo "ff";
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
        $this->Course = new Course();
    }

    public function getCourse(){
        $this->course = $this->Course->getCoursesByCourseId($this->id);
        echo json_encode($this->course);
    }
    public function getSections(){
        
    }

    public function getVideos($sectio_id){

    }
}

$obj = new GetCourse();
$obj->getCourse();
// echo json_encode($obj->course);