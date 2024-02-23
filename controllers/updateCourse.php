<?php
session_start();

include("../models/CourseModel.php");
include ("../models/File.php");
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

        if(isset($_SESSION['course'])) {
            $this->course_id = $_SESSION['course']['id'];
            $this->course_url = $_SESSION['course']['url'];
            // print_r($_SESSION['course']);
        }
        try {
            $this->Course = new Course();
        } catch (Exception $e) {

        }

    }

    public function updateCourse()
    {
        if (isset($_FILES["courseImg"])) {
            $title = dirname($this->course_url);
            $target_file = $title . "/" . basename($_FILES['courseImg']['name']);
            try{
                File::uploadFile($_FILES["courseImg"]["tmp_name"], $target_file);
                $this->course_url = $target_file;
            }
            catch( Exception $e) {
                header('Location: ' . "../views/editcourse.php");
                $_SESSION["error"] = $e->getMessage();
                exit;
            }
            $this->Course->updateCourse($this->course_id, array("title" => $this->courseTitle, "details" => $this->courseDes, "url"=>$this->course_url));
            
        }
    }
}


$updateobj = new UpdateCourse();
$updateobj->updateCourse();