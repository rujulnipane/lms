<?php

include_once("dbModel.php");
include_once("SectionModel.php");
class Course{
    private $db;
    private $section;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->db->getConnection();
    }
    public function getCourses(){
        return $this->db->getRecords("COURSE");
    }
    public function getCoursesByCourseId($courseId){
        
    }

    public function createCourse($data){
        $id = $this->db->insertRecord("COURSE", array(
            "title"=> $data[0],
            "details"=> $data[1],
            "url"=> $data[2],
        ));
        // echo $id;
    //    print_r($data[3]);
    //     print_r($data[4]);
    //     print_r($data[5]);

        $count = 0;
        $this->section = new Section();
        foreach($data[3] as $key){
            $this->section->createSection(
                $id,
                array(
                    $key,
                    $data[4][$count],
                    $data[5][$count],
                )
            );
            $count++;
        }

    }
}