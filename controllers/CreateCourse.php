

<?php

include_once("../models/CourseModel.php");
include_once("Auth.php");
include_once("../models/File.php");
session_start();


include_once("Auth.php");
if (!Auth::isLogin() or !Auth::isAdminUser()) {
    header('Location: ' . "../views/Login.php");
}
if(!Auth::isAdminUser()){
    $_SESSION["error"] = "Not Authorized";
    header('Location: '. "../views/Login.php");
}

class CreateCourse
{
    private $Course;
    private $courseTitle;
    private $courseDes;
    // private $sectionTitles;
    // private $sectionDes;
    // private $sectionUrl;
    private $courseImgurl;
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->courseTitle = $_POST['courseTitle'];
            $this->courseDes = $_POST['courseDes'];
            // $this->sectionTitles = $_POST["sectionTitle"];
            // $this->sectionDes = $_POST["sectionDes"];
        } else {
            echo "Invalid Request Method";
        }
        try {
            $this->Course = new Course();
        } catch (Exception $e) {
        }
    }

    public function createCourse()
    {
        try {
            $this->Course->createCourse(array(
                $this->courseTitle,
                $this->courseDes,
                $this->courseImgurl,
                // $this->sectionTitles,
                // $this->sectionDes,
                // $this->sectionUrl
            ));
            $_SESSION["success"] = "New Course Created successfully";
            header('Location: ' . "../views/Courses.php");
        } catch (Exception $e) {
            $_SESSION["error"] = $e->getMessage();
            header("Location" . "../views/createCourse.php");
        }
    }
    
    public function uploadFiles()
    {
        list($publicKey, $privateKey) = $this->generateRSAKeys();
        $target_dir = "../uploads/Courses/";
        $target_dir = "../uploads/Courses/";
        $coursetitle_lower = strtolower(str_replace(' ', '', $this->courseTitle));
        $current_date_time = date('YmdHis');
        $string_to_hash = $coursetitle_lower . $current_date_time;
        $encryptedStringToHash = $this->encryptData($string_to_hash, $publicKey);
        echo $encryptedStringToHash;
        $decryptedStringToHash = $this->decryptData($encryptedStringToHash, $privateKey);
        echo "Decrypted Data: $decryptedStringToHash\n";
        $target_dir .= $string_to_hash . "/";
        try{
            File::createDir($target_dir);
        }
        catch( Exception $e)    {
            header('Location: ' . "../views/createCourse.php");
            $_SESSION["error"] = $e->getMessage();
            exit;
        }

        if (isset($_FILES["courseImg"])) {
            $target_file = $target_dir . basename($_FILES['courseImg']['name']);
            try{
                echo $target_file;
                File::uploadFile($_FILES["courseImg"]["tmp_name"], $target_file);
                $this->courseImgurl = $target_file;
            }
            catch( Exception $e) {
                header('Location: ' . "../views/createCourse.php");
                $_SESSION["error"] = $e->getMessage();
                exit;
            }
        }
    
    }
    function encryptData($data, $publicKey) {
        list($n, $e) = $publicKey;
        openssl_public_encrypt($data, $encrypted, pack('H*', $n), OPENSSL_PKCS1_PADDING);
        return base64_encode($encrypted);
    }
    public function generateRSAKeys()
    {
        // Generate RSA key pair
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA
        );
        $res = openssl_pkey_new($config);
        
        // Get private key
        openssl_pkey_export($res, $privateKey);

        // Get public key
        $publicKeyDetails = openssl_pkey_get_details($res);
        $publicKey = $publicKeyDetails['key'];

        return array($publicKey, $privateKey);
    }


    function decryptData($encryptedData, $privateKey) {
        list($n, $d) = $privateKey;
        $encrypted = base64_decode($encryptedData);
        openssl_private_decrypt($encrypted, $decrypted, pack('H*', $d), OPENSSL_PKCS1_PADDING);
        return $decrypted;
    }
}


$course = new CreateCourse();
$course->uploadFiles();




$course->createCourse();

/*
        try{
            File::createDir($target_dir);
        }
        catch( Exception $e)    {
            header('Location: ' . "../views/createCourse.php");
            $_SESSION["error"] = $e->getMessage();
            exit;
        }
        */
/*
        if (isset($_FILES["courseImg"])) {
            $target_file = $target_dir . basename($_FILES['courseImg']['name']);
            try{
                echo $target_file;
                File::uploadFile($_FILES["courseImg"]["tmp_name"], $target_file);
                $this->courseImgurl = $target_file;
            }
            catch( Exception $e) {
                header('Location: ' . "../views/createCourse.php");
                $_SESSION["error"] = $e->getMessage();
                exit;
            }
        }
        */
/*
        foreach ($this->sectionTitles as $index => $title) {
            $sectionDir = $target_dir . $title . "/";
            try{
                File::createDir($sectionDir);
            }
            catch( Exception $e)    {
                header('Location: ' . "../views/createCourse.php");
                $_SESSION["error"] = $e->getMessage();
                exit;
            }
            $section = "section" . $index + 1;
            $videourl = [];
            if (isset($_FILES[$section])) {
                $sectionimg = $_FILES[$section];
                $count = 0;
                foreach ($sectionimg["name"] as $name) {
                    $videoName = basename($name);
                    $video_file = $sectionDir . $videoName;
                    try{
                        $src = $sectionimg["tmp_name"][$count];
                        File::uploadFile($src, $video_file);
                        $this->courseImgurl = $target_file;
                        $videourl[] = $video_file;
                    }
                    catch( Exception $e) {
                        header('Location: ' . "../views/createCourse.php");
                        $_SESSION["error"] = $e->getMessage();
                        exit;
                    }
                    $count++;
                }
            }
            $this->sectionUrl[] = $videourl;
        }*/

    