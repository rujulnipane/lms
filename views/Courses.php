<?php


session_start();

if (!isset($_SESSION["username"])) {
    $_SESSION["error"] = "Please login first";
    header('Location: ' . "../views/Login.php");
}

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
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
    <style>
        .create {
            color: white;
        }

        .create:hover {
            color: white;
        }
    </style>
    <script>
        $(document).ready(function() {
            let courses = [];

            $.get(
                "../controllers/CourseController.php",
                function(response) {
                    let courses = response;
                    console.log(courses);
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
                        cardlink.attr('href', `/views/Course.php?id=${element['id']}`);
                        cardlink.addClass("btn btn-primary");
                        cardlink.append("View Course");
                        cardbody.append(cardtitle);
                        cardbody.append(cardetails);
                        cardbody.append(cardlink);
                        carddiv.append(cardimg);
                        carddiv.append(cardbody);

                        $("#container").append(carddiv);
                    });
                },
                "json"
            ).fail(function(xhr, status, error) {
                console.error("Error:", error);
            });
        });
    </script>
</head>

<body>

    <?php include "navbar.php"; ?>

    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    <?php endif; ?>
    <div class="container my-2">
        <?php if (isset($success)) : ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION["isAdmin"]) and $_SESSION["isAdmin"] == true) : ?>
            <div class="text-center">
                <button type="button" class="btn btn-success"><a class="create" href="createCourse.php">Create New Course</a></button>
            </div>
        <?php endif; ?>

    </div>
    <div id="container" class="container d-flex justify-content-center flex-wrap">

    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>

</html>