<?php

include("../controllers/Auth.php");
// include("partials/_session.php");

session_start();

if (!Auth::isLogin()) {
    header('Location: ' . "../views/Login.php");
}

?>


<!-- <link rel="stylesheet" href="styles/courses.css"> -->

    <?php include "partials/navbar.php" ?>
    <?php include "partials/_alerts.php" ?>
    <?php if(Auth::isAdminUser()):?>
        <div class="col-md-4 d-flex justify-content-center align-items-center visually-hidden" data-course-id="" id="admin-card">
        <div class="card" style="width: 90%; height:90%">
        <a href="#" class="btn-edit" aria-label="edit" data-course-id=>
            <i class="fas fa-edit"></i>
        </a>
        <a href="#" class="btn-delete" aria-label="Delete" data-course-id=>
            <i class="fas fa-trash text-danger"></i>
        </a>
            <img src="" class="card-img-top h-50" alt="...">
            <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title text-center"></h5>
                <p class="card-text">hjj</p>
                <a href="Courseadmin.php?id=" class=""><button class="btn btn-primary btn-block"><i class="fas fa-book"></i> View Course</button></a>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="col-md-4 d-flex justify-content-center align-items-center visually-hidden" data-course-id="" id="user-card">
        <div class="card" style="width: 90%; height:90%">
            <img src="" class="card-img-top h-50" alt="...">
            <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title text-center"></h5>
                <p class="card-text">user</p>
                <a href="Courseadmin.php?id=" class=""><button class="btn btn-primary btn-block"><i class="fas fa-book"></i> View Course</button></a>
            </div>
        </div>
    </div>
    <?php endif;?>
    <main>
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-light" role="status" id="spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <?php if (Auth::isAdminUser()) : ?>
            <div class="container text-center mx-auto p-4 w-100">
                <a class="btn btn-success" href="createCourse.php">Create New Course</a>
            </div>
        <?php endif; ?>
        <div>
            <h3 class="text-center text-light mt-2">Available Courses</h3>
        </div>
        <div class="container mx-auto m-4" style="position: relative;">
            <div class="row">

            </div>
        </div>

    </main>

    <script src="scripts/courses.js"></script>

    <?php include "partials/_footer.php"; ?>