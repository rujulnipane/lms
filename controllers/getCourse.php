<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo json_encode(array('status'=> 'success','message'=> 'nj'));
}

/*
include("../models/CourseModel.php");
include("../models/SectionModel.php");
// echo "f";
/*
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
        echo "json";
        $result = $this->Course->getCourseById($this->id);
        $this->course = $result->fetch_assoc();
        echo json_encode($this->course);
        // $this->getSections();
    }
    public function getSections(){
        $section = new Section();
        $result = $section->getSections($this->id);
        while($result->fetch_assoc()){
            $this->sections[] = $result->fetch_assoc();
        }
        // echo json_encode($this->sections);
    }

    public function getVideos($sectio_id){

    }
}

$obj = new GetCourse();
$obj->getCourse();
// echo json_encode($obj->course);