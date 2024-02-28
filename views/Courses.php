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
        <div class="container mx-auto mt-4" style="position: relative;">
            <div class="row">

            </div>
        </div>
        
    </main>
    
    <script src="scripts/courses.js"></script>

<?php include "partials/_footer.php"; ?>