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
                    console.log(response);
                    console.log(courses);
                    courses.forEach(element => {
                        let carddiv = $("<div></div>");
                        let cardimg = $("<img>");
                        let cardbody = $("<div></div>");
                        let cardtitle = $("<h5></h5>");
                        let cardetails = $("<p></p>");
                        let cardlink = $("<a></a>");
                        carddiv.css("width", "18rem")
                        carddiv.attr("id" , element["id"]);
                        carddiv.addClass('card');
                        cardimg.attr("src",element["url"]);
                        cardimg.attr("alt","not available");
                        cardbody.addClass('card-body');
                        cardimg.addClass('card-img-top');
                        cardtitle.addClass("card-title");
                        cardtitle.append(element['title']);
                        cardetails.addClass("card-text");
                        cardetails.append(element['details']);
                        cardlink.attr('href',"#");
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
    <?php if (isset($_SESSION["username"])) : ?>

        WELCOME: <?php echo $_SESSION["username"]; ?>
    <?php endif; ?>
    <a href="../controllers/Logout.php">Logout</a>
        <div id="container">
    
    <div class="card" style="width: 18rem;">
        <img src="" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
</body>

</html>