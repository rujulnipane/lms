<?php 

include("../models/CourseModel.php");
include("../models/File.php");
class DeleteCourse{
    private $id;
    public function __construct(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->id = $_POST['id'];
        }
        else{
            header('Location:' . '../views/partials/404.php');
        }
    }
    public function deleteCourese(){
        $courseobj = new Course();
        $result = $courseobj->getCourseById($this->id);
        $course = $result->fetch_assoc();
        $title = dirname($course['url']);
        // echo json_encode($title);
        File::deleteDir($title);
        $courseobj->deleteCourse($this->id);
        echo json_encode(array("success"=>true,"message"=> "Deleted Course Successfully"));
    }
}

$deleteObj = new DeleteCourse();
$deleteObj->deleteCourese();