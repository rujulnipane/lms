<?php

include_once("../models/CourseModel.php");
include_once("Auth.php");
include_once("../models/File.php");
session_start();


include_once("Auth.php");
if (!Auth::isLogin() or !Auth::isAdminUser()) {
    header('Location: ' . "../views/Login.php");
}

class CreateCourse
{
    private $Course;
    private $courseTitle;
    private $courseDes;
    private $sectionTitles;
    private $sectionDes;
    private $sectionUrl;
    private $courseImgurl;
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->courseTitle = $_POST['courseTitle'];
            $this->courseDes = $_POST['courseDes'];
            $this->sectionTitles = $_POST["sectionTitle"];
            $this->sectionDes = $_POST["sectionDes"];
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
            echo "fdfdf";
            $this->Course->createCourse(array(
                $this->courseTitle,
                $this->courseDes,
                $this->courseImgurl,
                $this->sectionTitles,
                $this->sectionDes,
                $this->sectionUrl
            ));
            echo "nj";
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
        $target_dir = "../uploads/Courses/" . $this->courseTitle . "/";
        // try{
        //     File::createDir($target_dir);
        // }
        // catch( Exception $e)    {
        //     header('Location: ' . "../views/createCourse.php");
        //     $_SESSION["error"] = $e->getMessage();
        //     exit;
        // }
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        } else {
            $_SESSION["error"] = "Course Already exists";
            header('Location: ' . "../views/createCourse.php");
            exit;
        }
        if (isset($_FILES["courseImg"])) {
            $target_file = $target_dir . basename($_FILES['courseImg']['name']);
            $this->courseImgurl = $target_file;

            if (move_uploaded_file($_FILES["courseImg"]["tmp_name"], $target_file)) {
            } else {
                echo "Failed to upload course thumbnail";
            }
        }
        // print_r($_FILES);
        foreach ($this->sectionTitles as $index => $title) {
            $sectionDir = $target_dir . $title . "/";
            if (!file_exists($sectionDir)) {
                mkdir($sectionDir, 0777, true);
            }

            $section = "section" . $index + 1;
            // echo $section;
            $videourl = [];
            if (isset($_FILES[$section])) {


                $sectionimg = $_FILES[$section];

                $count = 0;
                foreach ($sectionimg["name"] as $name) {
                    $videoName = basename($name);
                    // echo $sectionimg["tmp_name"][$count];
                    // echo $videoName;
                    $video_file = $sectionDir . $videoName;
                    echo $video_file;
                    $videourl[] = $video_file;
                    if (move_uploaded_file($sectionimg["tmp_name"][$count], $video_file)) {
                    } else {
                        echo "Failed to upload Video";
                    }
                    $count++;
                }
            }

            $this->sectionUrl[] = $videourl;
        }
        echo "df";
    }
}


$course = new CreateCourse();
$course->uploadFiles();
$course->createCourse();
