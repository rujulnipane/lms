<?php

include("../controllers/Auth.php");
// include("partials/_session.php");

session_start();

if (!Auth::isLogin()) {
    header('Location: ' . "../views/Login.php");
}

?>
<?php include 'partials/_header.php' ?>

<link rel="stylesheet" href="styles/courses.css">

<body>
    <?php include "partials/navbar.php" ?>
    <?php include "partials/_alerts.php" ?>

    <main>
        <?php if (Auth::isAdminUser()) : ?>
            <div class="container text-end my-4">
                <a class="btn btn-success" href="createCourse.php">Create New Course</a>
            </div>
        <?php endif; ?>
        <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
            <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">

            </div>
        </div>
    </main>
    
    <script src="scripts/courses.js"></script>

<?php include "partials/_footer.php"; ?>