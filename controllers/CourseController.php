<?php
session_start();
include "../models/CourseModel.php";
include "Auth.php";

if(!Auth::isLogin()){
    $_SESSION["error"] = "Login First";
    header('Location: '. "../views/Login.php");
}

class CourseController{
    private $Course;
    private $courses;
    public function __construct(){
        try{
            $this->Course = new Course();
        }
        catch(Exception $e){
            header('Location: '. "../views/Courses.php");
            $_SESSION['error'] = $e->getMessage();
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