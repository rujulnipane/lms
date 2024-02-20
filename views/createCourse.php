<?php

session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./Login.php");
} else if (isset($_SESSION["isAdmin"]) and !$_SESSION["isAdmin"]) {
    $_SESSION['error'] = "Access Denied";
    header('Location: ' . "./Courses.php");
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
    <title>Create Course</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            var sectionNo = 0;
            $("#addsection").click(function(event) {

                event.preventDefault();
                $("#sectionContainer").append(`
            <div class="section">
            <h3>Section ${sectionNo+1}</h3> 
                <div class="form-group">
                    <label for="sectionTitle">Title of Section</label>
                    <input type="text" class="form-control" name="sectionTitle[]" placeholder="Enter title of the section" required>
                </div>
                <div class="form-group">
                    <label for="sectionDes">Description of Section</label>
                    <textarea class="form-control" name="sectionDes[]" placeholder="Enter description of the section" required></textarea>
                </div>
                <div class="videoContainer">
                </div>
                <div class="form-group">
                    <button class="btn btn-secondary addVideo">Add Video</button>
                </div>

            </div>`);
                sectionNo++;
            });

            $("#sectionContainer").on("click", ".addVideo", function(event) {
                event.preventDefault();
                $(this).closest(".section").find(".videoContainer").append(`
            <div class="form-group">
                <label for="videos">Upload Videos for Section</label>
                <input type="file" class="form-control-file" name="section${sectionNo}[]" multiple accept="video/*" >
            </div>`);
            });

            $(".close").on("click", function() {
            $("#errorMessage").hide();
        });
        });
    </script>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container">
    <?php if (isset($error_message)) : ?>
    <div class="container d-flex align-items-center justify-content-between bg-light-red" id="errorMessage">
        <p><?php echo htmlspecialchars($error_message); ?></p>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

        <h2>Create New Course</h2>
        <form action="../controllers/CreateCourse.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputEmail1">Enter Title of the Course</label>
                <input type="text" name="courseTitle" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter title of the course" required>
            </div>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Write description of Course</span>
                </div>
                <textarea name="courseDes" class="form-control" aria-label="With textarea" required></textarea>
            </div>
            <div class="input-group mb-3">
                <label for="image" name="courseImg" class="form-control">Upload Course Thumbnail:</label>
                <input type="file" id="courseimage" name="courseImg" class="form-control" accept="image/*">
            </div>
            <div id="sectionContainer">
            </div>
            <div class="form-group">
                <button class="btn btn-secondary" id="addsection">Add Section</button>
            </div>
            <div class="form-group">

                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>