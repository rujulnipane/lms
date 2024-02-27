<?php

include("../controllers/Auth.php");
session_start();

if (!Auth::isLogin()) {
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
<?php include 'partials/_header.php' ?>
<style>
    .create {
        color: white;
    }

    .create:hover {
        color: white;
    }
</style>

<body>

    <?php include "partials/navbar.php" ?>

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
    <div id="container" class="container mt-5">
        <div class="row">

        </div>
    </div>
    <script>
        $(document).ready(function() {
    $.get(
        "../controllers/CourseController.php",
        function(response) {
            let courses = response;
            courses.forEach(function(course) {
                const coursecard = `
                    <div class="col-md-4">
                        <div class="card course-card">
                            <img src="${course.url}" class="card-img-top" alt="${course.title}">
                            <div class="card-body">
                                <h5 class="card-title">${course.title}</h5>
                                <p class="card-text">${course.details}</p>
                                <a href="/views/Course.php?id=${course.id}" class="btn btn-primary">View Course</a>
                            </div>
                        </div>
                    </div>`;
                $(".row").append(coursecard);
            });
        },
        "json"
    ).fail(function(xhr, status, error) {
        console.error("Error:", error);
    });
});

    </script>


    <?php include "partials/_footer.php"; ?>