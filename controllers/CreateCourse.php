<?php

include_once("../models/CourseModel.php");
include_once("Auth.php");
// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     $target_dir = "../assets/Courses/";
//     $courseTitle = $_POST["courseTitle"];
//     $sectionTitles = $_POST["sectionTitle"];
//     $courseimg = basename($_FILES['courseImg']['name']);
//     $target_dir = "../assets/Courses/" . $courseTitle . "/";


//     if (!file_exists($target_dir)) {
//         mkdir($target_dir, 0777, true);
//     }

//     $target_file = $target_dir . basename($_FILES['courseImg']['name']);

//     if(move_uploaded_file($_FILES["courseImg"]["tmp_name"], $target_file)){
//         // Course thumbnail uploaded successfully
//     }
//     else{
//         echo "Failed to upload course thumbnail";
//     }
//     // print_r($_FILES);
//     foreach ($sectionTitles as $index => $title) {
//         $sectionDir = $target_dir . $title . "/";
//         if (!file_exists($sectionDir)) {
//             mkdir($sectionDir, 0777, true);
//         }

//         $section = "section". $index+1;
//         // echo $section;
//         $sectionimg = $_FILES[$section];
//         $count = 0;
//         foreach($sectionimg["name"] as $name){
//             $videoName = basename($name);
//             // echo $sectionimg["tmp_name"][$count];
//             // echo $videoName;
//             $video_file = $sectionDir . $videoName;
//             echo $video_file;
//             if(move_uploaded_file($sectionimg["tmp_name"][$count], $video_file)){
//                 // Course thumbnail uploaded successfully
//             }
//             else{
//                 echo "Failed to upload course thumbnail";
//             }
//             $count++;
//         }
//     }
//     }

include_once("Auth.php");
if(!Auth::isLogin() or !Auth::isAdminUser()){
    header('Location: '. "../views/Login.php");
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
        $this->Course = new Course();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->courseTitle = $_POST['courseTitle'];
            $this->courseDes = $_POST['courseDes'];
            $this->sectionTitles = $_POST["sectionTitle"];
            $this->sectionDes = $_POST["sectionDes"];
        }
    }

    public function createCourse()
    {
        $this->Course->createCourse(array(
            $this->courseTitle, 
            $this->courseDes, 
            $this->courseImgurl, 
            $this->sectionTitles, 
            $this->sectionDes, 
            $this->sectionUrl
        ));
    }
    public function uploadFiles()
    {
        $target_dir = "../assets/Courses/";
        $target_dir = "../assets/Courses/" . $this->courseTitle . "/";
        if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES['courseImg']['name']);
        $this->courseImgurl = $target_file;

        if (move_uploaded_file($_FILES["courseImg"]["tmp_name"], $target_file)) {
        } else {
            echo "Failed to upload course thumbnail";
        }
        
        // print_r($_FILES);
        foreach ($this->sectionTitles as $index => $title) {
            $sectionDir = $target_dir . $title . "/";
            if (!file_exists($sectionDir)) {
                mkdir($sectionDir, 0777, true);
            }

            $section = "section" . $index + 1;
            // echo $section;
            $sectionimg = $_FILES[$section];
            $videourl = [];
            $count = 0;
            foreach ($sectionimg["name"] as $name) {
                $videoName = basename($name);

                // echo $sectionimg["tmp_name"][$count];
                // echo $videoName;
                $video_file = $sectionDir . $videoName;
                echo $video_file;
                $videourl[] = $video_file;
                if (move_uploaded_file($sectionimg["tmp_name"][$count], $video_file)) {
                    // Course thumbnail uploaded successfully
                } else {
                    echo "Failed to upload course thumbnail";
                }
                $count++;
            }
            $this->sectionUrl[] = $videourl;
            
        }
    }
}


$course = new CreateCourse();
$course->uploadFiles();
$course->createCourse();
