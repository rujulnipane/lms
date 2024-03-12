<?php

include_once("../models/CourseModel.php");
include_once("Auth.php");
include_once("../models/File.php");
include_once("../models/SectionModel.php");
session_start();


if (!Auth::isLogin() or !Auth::isAdminUser()) {
    header('Location: ' . "../views/Login.php");
    exit;
}
if(!Auth::isAdminUser()){
    $_SESSION["error"] = "Not Authorized";
    header('Location: '. "../views/Login.php");
    exit;
}

class CreateCourse
{
    private $Course;
    private $courseTitle;
    private $courseDes;
    private $sectionUrl;
    private $courseImgurl;
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->courseTitle = $_POST['courseTitle'];
            $this->courseDes = $_POST['courseDes'];
            
        } else {
            header('Location:' . '../views/partials/404.php');
        }
        try {
            $this->Course = new Course();
        } catch (Exception $e) {
        }
    }

    public function createCourse()
    {
        // create new course and dection in course table
        try {
            $id = $this->Course->createCourse(array(
                $this->courseTitle,
                $this->courseDes,
                $this->courseImgurl,
            ));
            $sectionobj = new Section();
            $sectionobj->createSection($id,"Section 1", $this->sectionUrl);
            $_SESSION["success"] = "New Course Created successfully";
            header('Location: ' . "../views/Course.php?id=$id");
        } catch (Exception $e) {
            $_SESSION["error"] = $e->getMessage();
            header("Location" . "../views/createCourse.php");
        }
    }
    
    public function uploadFiles()
    {   
        // create hashcode of course title 
        $target_dir = "/uploads/Courses/";
        $targetfile = File::encrypt($this->courseTitle);
        $target_dir .= $targetfile . "/";

        // create course directory 
        try{
            File::createDir($_SERVER['DOCUMENT_ROOT'] . $target_dir);
        }
        catch( Exception $e)    {
            header('Location: ' . "../views/createCourse.php");
            $_SESSION["error"] = $e->getMessage();
            exit;
        }

        // upload image 
        if (isset($_FILES["courseImg"])) {
            $target_file = $target_dir . basename($_FILES['courseImg']['name']);
            try{
                echo $target_file;
                File::uploadFile($_FILES["courseImg"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file);
                $this->courseImgurl = $target_file;
            }
            catch( Exception $e) {
                header('Location: ' . "../views/createCourse.php");
                $_SESSION["error"] = $e->getMessage();
                exit;
            }
        }

        // creating default section 
        $targetsection = File::encrypt("default");
        $sectiondir = $target_dir . $targetsection . "/";
        try{
            File::createDir( $_SERVER['DOCUMENT_ROOT'] . $sectiondir);
            $this->sectionUrl = $sectiondir;
        }
        catch( Exception $e)    {
            header('Location: ' . "../views/createCourse.php");
            $_SESSION["error"] = $e->getMessage();
            exit;
        }

    }
    
}


$course = new CreateCourse();
$course->uploadFiles();
$course->createCourse();
