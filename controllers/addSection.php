<?php



include_once("../models/SectionModel.php");
include_once("../models/CourseModel.php");
include_once("../models/File.php");
include_once("Auth.php");

if(!Auth::isLogin()){
    header("Location" . "../views/Login.php");
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
            echo "Invalid Request Method";
        }
        try {
            $this->Section = new Section();
        } catch (Exception $e) {
        }
    }

    public function createSection(){
        $sectiontitle = strtolower(str_replace(' ', '', $this->sectionTitle));
        $current_date_time = date('YmdHis');
        $filename = $sectiontitle . $current_date_time;
        $hashedcode = hash('sha1', $filename);
        $targetfile = substr($hashedcode, 0, 6);
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

        
        try{
            File::createDir($target_dir);
        }
        catch( Exception $e)    {
            header('Location: ' . "../views/createCourse.php");
            $_SESSION["error"] = $e->getMessage();
            json_encode(array("error"=> $e->getMessage()));
            exit;
        }
        try{
            $id = $this->Section->createSection($this->course_id,$this->sectionTitle, $target_dir);
            echo json_encode(array("status"=> "success","message"=> "Course Created", "id" => $id));
        }
        catch(Exception $e) {
            json_encode(array('error'=> $e->getMessage()));
        }
    }
}


$addobj = new AddSection();

$addobj->createSection();


