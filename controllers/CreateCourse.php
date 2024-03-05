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
        try {
            $id = $this->Course->createCourse(array(
                $this->courseTitle,
                $this->courseDes,
                $this->courseImgurl,
            ));
            $sectionobj = new Section();
            $sectionobj->createSection($id,"Section 1", $this->sectionUrl);
            $_SESSION["success"] = "New Course Created successfully";
            header('Location: ' . "../views/Courses.php");
        } catch (Exception $e) {
            $_SESSION["error"] = $e->getMessage();
            header("Location" . "../views/createCourse.php");
        }
    }
    
    public function uploadFiles()
    {   
        $target_dir = "/uploads/Courses/";
        $target_dir = "/uploads/Courses/";
        $coursetitle = strtolower(str_replace(' ', '', $this->courseTitle));
        $current_date_time = date('YmdHis');
        $filename = $coursetitle . $current_date_time;
        $hashedcode = hash('sha1', $filename);
        $targetfile = substr($hashedcode, 0, 6);
        $target_dir .= $targetfile . "/";

        try{
            File::createDir($_SERVER['DOCUMENT_ROOT'] . $target_dir);
        }
        catch( Exception $e)    {
            header('Location: ' . "../views/createCourse.php");
            $_SESSION["error"] = $e->getMessage();
            exit;
        }

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
        $default_section = "default";
        $filename = $default_section . $current_date_time;
        $hashedcode = hash('sha1', $filename);
        $targetsection = substr($hashedcode, 0, 6);
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
