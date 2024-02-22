<?php

include_once("../models/CourseModel.php");
include_once("Auth.php");
include_once("../models/File.php");
session_start();


include_once("Auth.php");
if (!Auth::isLogin() or !Auth::isAdminUser()) {
    header('Location: ' . "../views/Login.php");
}
if(!Auth::isAdminUser()){
    $_SESSION["error"] = "Not Authorized";
    header('Location: '. "../views/Login.php");
}

class CreateCourse
{
    private $Course;
    private $courseTitle;
    private $courseDes;
    // private $sectionTitles;
    // private $sectionDes;
    // private $sectionUrl;
    private $courseImgurl;
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->courseTitle = $_POST['courseTitle'];
            $this->courseDes = $_POST['courseDes'];
            // $this->sectionTitles = $_POST["sectionTitle"];
            // $this->sectionDes = $_POST["sectionDes"];
        } else {
            echo "Invalid Request Method";
        }
        try {
            $this->Course = new Course();
        } catch (Exception $e) {
        }
    }

    public function createCourse()
    {
        try {
            $this->Course->createCourse(array(
                $this->courseTitle,
                $this->courseDes,
                $this->courseImgurl,
                // $this->sectionTitles,
                // $this->sectionDes,
                // $this->sectionUrl
            ));
            $_SESSION["success"] = "New Course Created successfully";
            header('Location: ' . "../views/Courses.php");
        } catch (Exception $e) {
            $_SESSION["error"] = $e->getMessage();
            header("Location" . "../views/createCourse.php");
        }
    }
    
    public function uploadFiles()
    {
        $target_dir = "../uploads/Courses/";
        $target_dir = "../uploads/Courses/";
        $coursetitle = strtolower(str_replace(' ', '', $this->courseTitle));
        $current_date_time = date('YmdHis');
        $filename = $coursetitle . $current_date_time;
        $hashedcode = hash('sha1', $filename);
        $targetfile = substr($hashedcode, 0, 6);
        $target_dir .= $targetfile . "/";
        try{
            File::createDir($target_dir);
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
                File::uploadFile($_FILES["courseImg"]["tmp_name"], $target_file);
                $this->courseImgurl = $target_file;
            }
            catch( Exception $e) {
                header('Location: ' . "../views/createCourse.php");
                $_SESSION["error"] = $e->getMessage();
                exit;
            }
        }
    
    }
    
}


$course = new CreateCourse();
$course->uploadFiles();




$course->createCourse();

/*
        try{
            File::createDir($target_dir);
        }
        catch( Exception $e)    {
            header('Location: ' . "../views/createCourse.php");
            $_SESSION["error"] = $e->getMessage();
            exit;
        }
        */
/*
        if (isset($_FILES["courseImg"])) {
            $target_file = $target_dir . basename($_FILES['courseImg']['name']);
            try{
                echo $target_file;
                File::uploadFile($_FILES["courseImg"]["tmp_name"], $target_file);
                $this->courseImgurl = $target_file;
            }
            catch( Exception $e) {
                header('Location: ' . "../views/createCourse.php");
                $_SESSION["error"] = $e->getMessage();
                exit;
            }
        }
        */
/*
        foreach ($this->sectionTitles as $index => $title) {
            $sectionDir = $target_dir . $title . "/";
            try{
                File::createDir($sectionDir);
            }
            catch( Exception $e)    {
                header('Location: ' . "../views/createCourse.php");
                $_SESSION["error"] = $e->getMessage();
                exit;
            }
            $section = "section" . $index + 1;
            $videourl = [];
            if (isset($_FILES[$section])) {
                $sectionimg = $_FILES[$section];
                $count = 0;
                foreach ($sectionimg["name"] as $name) {
                    $videoName = basename($name);
                    $video_file = $sectionDir . $videoName;
                    try{
                        $src = $sectionimg["tmp_name"][$count];
                        File::uploadFile($src, $video_file);
                        $this->courseImgurl = $target_file;
                        $videourl[] = $video_file;
                    }
                    catch( Exception $e) {
                        header('Location: ' . "../views/createCourse.php");
                        $_SESSION["error"] = $e->getMessage();
                        exit;
                    }
                    $count++;
                }
            }
            $this->sectionUrl[] = $videourl;
        }*/

    