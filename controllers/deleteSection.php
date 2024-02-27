<?php
include ("../models/SectionModel.php");
include("../models/File.php");
include_once("Auth.php");

if(!Auth::isLogin()){
    header("Location" . "../views/Login.php");
}
class DeleteSection{
    private $section_id;
    private $course_id;
    private $Section;
    public function __construct(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $this->course_id = $_POST["course_id"];
            $this->section_id = $_POST["section_id"];
        }
        try{
            $this->Section= new Section();
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
    public function deleteSection(){
        try{
            $result = $this->Section->getSection($this->section_id, $this->course_id);
            $section = $result->fetch_assoc();
            File::deleteDir($section['section_url']);
        }
        catch(Exception $e){
            echo json_encode(array("error"=> $e->getMessage()));
        }
        try{
            $this->Section->deleteSection(array("course_id"=> $this->course_id, "section_id" => $this->section_id));
            echo json_encode(array("success"=>true));
        }
        catch(Exception $e){
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
}

$deleteobj = new DeleteSection();
$deleteobj->deleteSection();
