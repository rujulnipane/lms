<?php

include("../models/CourseModel.php");
include("../models/File.php");
include_once("Auth.php");

if (!Auth::isLogin() or !Auth::isAdminUser()) {
    header('Location: ' . "../views/Login.php");
    exit;
}
if(!Auth::isAdminUser()){
    $_SESSION["error"] = "Not Authorized";
    header('Location: '. "../views/Login.php");
    exit;
}
class DeleteCourse
{
    private $id;
    public function __construct()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->id = $_POST['id'];
        } else {
            header('Location:' . '../views/partials/404.php');
            exit;
        }
    }
    public function deleteCourese()
    {
        try {
            $courseobj = new Course();
            $result = $courseobj->getCourseById($this->id);
            $course = $result->fetch_assoc();
            $title = dirname($course['url']);
            File::deleteDir($_SERVER['DOCUMENT_ROOT'] . $title);
            $courseobj->deleteCourse($this->id);
            echo json_encode(array("success" => true, "message" => "Deleted Course Successfully"));
        } catch (Exception $e) {
            echo json_encode(array("success" => false, "message" => $e->getMessage()));
        }
    }
}

$deleteObj = new DeleteCourse();
$deleteObj->deleteCourese();
