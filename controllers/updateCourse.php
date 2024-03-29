<?php
session_start();

include("../models/CourseModel.php");
include ("../models/File.php");
include_once("Auth.php");

if(!Auth::isLogin()){
    header("Location" . "../views/Login.php");
}
// check if user is admin 
if(!Auth::isAdminUser()){
    $_SESSION["error"] = "Not Authorized";
    header('Location: '. "../views/Login.php");
    exit;
}

class UpdateCourse
{
    private $Course;
    private $courseTitle;
    private $courseDes;
    private $course_id;
    private $course_url;
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->courseTitle = $_POST['courseTitle'];
            $this->courseDes = $_POST['courseDes'];
        }
        else{
            header('Location:' . '../views/partials/404.php');
            exit;
        }

        if(isset($_SESSION['course'])) {
            $this->course_id = $_SESSION['course']['id'];
            $this->course_url = $_SESSION['course']['url'];
            unset($_SESSION['course']);
        }
        
        try {
            $this->Course = new Course();
        } catch (Exception $e) {
            exit;
        }

    }

    public function updateCourse()
    {
        // get the course directory and update course img
        if (isset($_FILES["courseImg"])) {
            $title = dirname($this->course_url);
            $target_file = $title . "/" . basename($_FILES['courseImg']['name']);
            try{
                File::uploadFile($_FILES["courseImg"]["tmp_name"], $target_file);
                $this->course_url = $target_file;
            }
            catch( Exception $e) {
                // header('Location: ' . "../views/editcourse.php");
                $_SESSION["error"] = $e->getMessage();
                // exit;
            }
        }
        // update the course in course table
        try{
            $this->Course->updateCourse(array(
                "id"  => $this->course_id,
                "title" => $this->courseTitle,
                 "details" => $this->courseDes,
                  "url"=>$this->course_url
            ));
            header("Location: ". "../views/Courses.php");
        }
        catch(Exception $e) {
            $_SESSION["error"] = $e->getMessage();
            header("Location: ". "../views/editcourse.php");
        }
    }
}


$updateobj = new UpdateCourse();
$updateobj->updateCourse();