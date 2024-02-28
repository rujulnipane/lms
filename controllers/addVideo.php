<?php

include("../models/VideoModel.php");
include("../models/File.php");
include("../models/SectionModel.php");
include("../models/CourseModel.php");
include_once("Auth.php");

if(!Auth::isLogin()){
    header("Location" . "../views/Login.php");
}
if(!Auth::isAdminUser()){
    header("Location:" . "../views/partials/404.php");
}
class AddVideo
{

    private $section_id;
    private $course_id;
    private $video_title;
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->section_id = $_POST['sectionId'];
            $this->course_id = $_POST['courseId'];
            $this->video_title = $_POST['video-title'];
            // echo json_encode($_POST);   
        }
        else{
            header('Location:' . '../views/partials/404.php');
        }
    }

    public function addVideo()
    {
        try {
            $sectionobj = new Section();
            $result = $sectionobj->getSection($this->section_id, $this->course_id);
            $section = $result->fetch_assoc();
        } catch (Exception $e) {
            echo json_encode(array("error" => $e->getMessage()));
        }

        $target_dir = $section['section_url'];
        if (isset($_FILES["videoFile"])) {
            $videoname = basename($_FILES['videoFile']['name']);
            $extension = pathinfo($videoname, PATHINFO_EXTENSION);
            $videoname = strtolower(str_replace(' ', '', basename($_FILES['videoFile']['name'])));
            $current_date_time = date('YmdHis');
            $filename = $videoname . $current_date_time;
            $hashedcode = hash('sha1', $filename);
            $file = substr($hashedcode, 0, 6);
            $target_file = $target_dir . $file . '.' . $extension;
            try {
                File::uploadFile($_FILES["videoFile"]["tmp_name"], $target_file);
            } catch (Exception $e) {
                echo json_encode(array("error" => $e->getMessage()));
                exit;
            }
        }
        try {
            $videoobj = new Video();
            $id = $videoobj->createVideo($this->video_title, $target_file, $this->section_id);
            echo json_encode(array('title' => $this->video_title, 'id' => $id, "url" => $target_file));
        } catch (Exception $e) {
            echo json_encode(array("error" => $e->getMessage()));
        }
    }
}

$addobj = new AddVideo();

$addobj->addVideo();
