<?php

require "../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key =  "ssfvsfv16";
session_start();

if (isset($_COOKIE['token'])) {
    $decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
} else {
    // header('Location: '. "../views/Login.php");
}
if (!isset($_SESSION["username"])) {
    $_SESSION["error"] = "Please login first";
    header('Location: ' . "../views/Login.php");
}

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <script>
        $(document).ready(function() {
            let courses = [];

            $.ajax({
                url: "../controllers/CourseController.php",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    let courses = response;
                    courses.forEach(element => {
                        let carddiv = $("<div></div>");
                        let cardimg = $("<img>");
                        let cardbody = $("<div></div>");
                        let cardtitle = $("<h5></h5>");
                        let cardetails = $("<p></p>");
                        let cardlink = $("<a></a>");
                        carddiv.css("width", "18rem")
                        carddiv.attr("id", element["id"]);
                        carddiv.addClass('card m-2');
                        cardimg.attr("src", element["url"]);
                        cardimg.attr("alt", "not available");
                        cardbody.addClass('card-body');
                        cardimg.addClass('card-img-top');
                        cardtitle.addClass("card-title");
                        cardtitle.append(element['title']);
                        cardetails.addClass("card-text");
                        cardetails.append(element['details']);
                        cardlink.attr('href', "#");
                        cardlink.addClass("btn btn-primary");
                        cardlink.append("View Course");

                        cardbody.append(cardtitle);
                        cardbody.append(cardetails);
                        cardbody.append(cardlink);
                        carddiv.append(cardimg);
                        carddiv.append(cardbody);

                        $("#container").append(carddiv);

                    });
                    courses = response;
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        });
    </script>
</head>

<body>

    <?php include "navbar.php"; ?>
    <!-- <?php if (isset($_SESSION["username"])) : ?>
        WELCOME: <?php echo $_SESSION["username"]; ?>
    <?php endif; ?> -->
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <div class="container my-2">

       
    <?php if(isset($_SESSION["isAdmin"]) and $_SESSION["isAdmin"] == true) : ?>
    <button type="button" class="btn btn-light"><a class="nav-link" href="createCourse.php">Create Course</a></button>
    <?php endif; ?>
    </div>
    <div id="container" class="container d-flex justify-content-center">
        
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>

</html>