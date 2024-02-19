<?php

// echo "Hello";

if($_SERVER["REQUEST_METHOD"] == "POST") {
   
    echo $_POST["courseTitle"] .' '. $_POST["courseDes"] .' ';
    print_r($_POST["courseImg"]);
    print_r($_POST["sectionTitle"]) ;
    print_r($_POST["sectionDes"]) ;
    $target_dir = "../assets/Courses/";
    $courseTitle = $_POST["courseTitle"];
    $courseimg = basename($_FILES['courseImg']['name']);
    $target_dir = "../assets/Courses/" . $courseTitle . "/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES['courseImg']['name']);;
    // echo $target_file;
    if(move_uploaded_file($_FILES["courseImg"]["tmp_name"], $target_file)){
        echo "File Uploaded Successfully";
    }
    else{
        echo " FAiled";
    }

    foreach($_POST["sectionTitle"] as $key => $value) {


}   