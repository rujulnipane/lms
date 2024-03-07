<?php

include("../models/VideoModel.php");
include("../models/File.php");
include("../models/SectionModel.php");
include("../models/CourseModel.php");
include_once("Auth.php");

// check if user is $login;
if(!Auth::isLogin()){
    header("Location" . "../views/Login.php");
    exit;
}
// check if user is admin 
if(!Auth::isAdminUser()){
    header("Location:" . "../views/partials/404.php");
    exit;
}
class AddVideo
{

    private $section_id;
    private $course_id;
    private $video_title;
    public function __construct()
    {
        // get video details 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->section_id = $_POST['sectionId'];
            $this->course_id = $_POST['courseId'];
            $this->video_title = $_POST['video-title'];
            // echo json_encode($_POST);   
        }
        else{
            header('Location:' . '../views/partials/404.php');
            exit;
        }
    }

    public function addVideo()
    {
        // get section of video added 
        try {
            $sectionobj = new Section();
            $result = $sectionobj->getSection($this->section_id, $this->course_id);
            $section = $result->fetch_assoc();
        } catch (Exception $e) {
            echo json_encode(array("error" => $e->getMessage()));
        }

        $target_dir = $section['section_url'];
        if (isset($_FILES["videoFile"])) {
            // hashing the video file 
            $videoname = basename($_FILES['videoFile']['name']);
            // $hash_value = hash_file('sha1', $_FILES['videoFile']['tmp_name']);
            //  echo json_encode($hash_value);

            $extension = pathinfo($videoname, PATHINFO_EXTENSION);
            // $videofilename =   "/uploads/videos/" . substr($hash_value, 0, 6) . '.' . $extension;
            // echo json_encode($videofilename);
            
            $videoname = strtolower(str_replace(' ', '', basename($_FILES['videoFile']['name'])));
            $current_date_time = date('YmdHis');
            $filename = $videoname . $current_date_time;
            $hashedcode = hash('sha1', $filename);
            $file = substr($hashedcode, 0, 6);
            $target_file = $target_dir . $file . '.' . $extension;

            // if (!file_exists($videofilename)) {
            //     move_uploaded_file($_FILES['$videoFile']['tmp_name'],$_SERVER['DOCUMENT_ROOT'] . $videofilename);
            //     echo json_encode("sj");
            // }
            // else{
            //     echo json_encode("sdcs");
            // }

            // if (symlink($videofilename, $target_file)) {
            //     // echo "Symbolic link created successfully.";
            // } else {
            //     // echo "Error creating symbolic link.";
            // }
            // upload video file in the directory 
             try {
                 File::uploadFile($_FILES["videoFile"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file);
             } catch (Exception $e) {
                 echo json_encode(array("error" => $e->getMessage()));
                 exit;
             }
            
        }
        // save video details in database 
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
