<?php
session_start();
include "../models/CourseModel.php";
include "Auth.php";

echo json_encode("hi");
echo json_encode(session_id());

if(!Auth::isLogin()){
    $_SESSION["error"] = "Login First";
    header('Location: '. "../views/Login.php");
}

class CourseController{
    private $Course;
    private $courses;
    public function __construct(){
        try{
            // echo json_encode(",kovkos");
            $this->Course = new Course();
        }
        catch(Exception $e){
            echo json_encode(array("error"=> "cannot fetch courses"));
            exit;
        }
    }
    public function getCourses(){
        // get course details from course table
        $result = $this->Course->getCourses();
        while ($row = $result->fetch_assoc()) {
            $this->courses[] = $row;
        }
        echo json_encode($this->courses);
    }
}

$cc = new CourseController();
$cc->getCourses();   