<?php

include_once("../models/SectionModel.php");
include_once("../models/CourseModel.php");
include_once("../models/File.php");
include_once("Auth.php");

// check if user is login
if(!Auth::isLogin()){
    header("Location" . "../views/Login.php");
    exit;
}
// check if user is admin 
if(!Auth::isAdminUser()){
    header("Location:" . "../views/partials/404.php");
    exit;
}

class AddSection{
    private $course_id;
    private $sectionTitle;
    private $Section;

    public function __construct(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->course_id = $_POST['id'];
            $this->sectionTitle = $_POST['title'];
        } else {
            header('Location:' . '../views/partials/404.php');
            exit;
        }
        try {
            $this->Section = new Section();
        } catch (Exception $e) {
            exit;
        }
    }
    public function createSection(){
        // hash the section title
        $sectiontitle = strtolower(str_replace(' ', '', $this->sectionTitle));
        $current_date_time = date('YmdHis');
        $filename = $sectiontitle . $current_date_time;
        $hashedcode = hash('sha1', $filename);
        $targetfile = substr($hashedcode, 0, 6);
        // get course of section
        try{
            $courseobj = new Course();
            $result = $courseobj->getCourseByID($this->course_id);
            $course = $result->fetch_assoc();
        }
       catch (Exception $e) {
        json_encode(array('error'=> $e->getMessage()));
       }

        $title = dirname($course['url']);
        
        $target_dir ="$title/" . $targetfile . "/";
    //    creating section directory 
        try{
            File::createDir($_SERVER['DOCUMENT_ROOT'] . $target_dir);
        }
        catch( Exception $e)    {
            echo json_encode(array("error"=> $e->getMessage()));
            exit;
        }
        // saving section in Database
        try{
            $id = $this->Section->createSection($this->course_id,$this->sectionTitle, $target_dir);
            echo json_encode(array("status"=> "success","message"=> "Section Created", "id" => $id));
        }
        catch(Exception $e) {
            echo json_encode(array('error'=> $e->getMessage()));
        }
    }
}


$addobj = new AddSection();
$addobj->createSection();


