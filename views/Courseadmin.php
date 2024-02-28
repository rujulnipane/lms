<?php

// include("partials/_session.php");
include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
}
if (!Auth::isAdminUser()) {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    header('Location: ' . "./courseuser.php?id=$id");
}
?>
<?php include 'partials/_header.php' ?>


<body>
    <?php include "partials/navbar.php" ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 shadow-sm p-2 mb-5 rounded">
                <div class="navbar">
                    <h2>Course Contents</h2>
                    <div class="accordion w-100" id="accordionExample">
                    </div>
                </div>
                <button class="btn btn-success mt-3 float-end" data-bs-toggle="modal" data-bs-target="#addSectionModal">Add New Section</button>
            </div>
            <div class="col-md-9 shadow-sm p-2 mb-5 bg-body rounded d-flex flex-column">

                <div class="container pt-2">
                    <header class="d-flex justify-content-between align-items-center">
                        <h1 id="course-title"></h1>
                        <div>
                            <button class="btn btn-danger me-2" id="delete-course-btn">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                            <button class="btn btn-primary" id="edit-course-btn">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                    </header>
                </div>
                <div class="video-container d-flex flex-column justify-content-center align-items-center">
                    <h4 id="video-title" class="text-center text-success mb-4"></h4>
                    <video controls autoplay id="video-item" class="video-item mb-2 w-75 h-75 border rounded">

                    </video>
                </div>
                <div class="bg-light p-3">
                    <div class="container">
                        <div class="d-flex justify-content-between">
                            <button id="prev-video-btn" class="btn btn-primary">Prev</button>
                            <button id="next-video-btn" class="btn btn-primary">Next</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include "partials/_addVideoModal.php" ?>
    <?php include "partials/_addSectionModal.php" ?>
    <?php include "partials/_footer.php"; ?>

    <script src="scripts/courseadmin.js"></script>