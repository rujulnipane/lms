<?php

include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
}

?>
<?php
include("partials/navbar.php");

?>

<!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="../styles/course.css">

<div class="container-fluid mt-2" style="min-height:84vh">
    <div class="alert alert-success alert-dismissible fade show m-2" role="alert" id="myAlert" style="display: none;">
        <span id="alertMessage"></span>
        <button type="button" class="btn-close" aria-label="Close" onclick="closeAlert()"></button>
    </div>
    <div class="d-flex align-items-center justify-content-between m-3">
        <!-- <a href=""></a> -->
        <!-- <div class="vw-75 d-block m-auto"> -->
        <h4 class="h3 d-block mb-0 text-gray-800 text-center" id="course-title"></h4>
        <!-- </div> -->
        <?php if (Auth::isAdminUser()) : ?>
            <div class="" role="group" aria-label="Basic example">
                <button class="btn btn-outline-danger me-2 cursor-pointer" id="delete-course-btn">
                    <i class="fas fa-trash"></i> Delete Course
                </button>
                <button class="btn btn-outline-secondary cursor-pointer" id="edit-course-btn">
                    <i class="fas fa-edit"></i> Edit Course
                </button>
            </div>
        <?php endif; ?>
    </div>
    <div class="d-grid gap-1" style="grid-template-columns: 1fr 3fr;">
        <div class="border shadow-sm rounded-3">
            <div class="flex-shrink-0 p-3">
                <a href="" class="d-flex align-items-center mb-2 link-body-emphasis text-decoration-none pb-2" style="border-bottom: 4px solid gray;">
                    <span class="fs-5 fw-semibold">Course Contents</span>
                </a>
                <ul class="list-unstyled ps-0" id="sectionContainer">

                </ul>
                <?php if (Auth::isAdminUser()) : ?>
                    <button class="btn btn-outline-primary rounded mt-3 mb-2 float-end" data-bs-toggle="modal" data-bs-target="#addSectionModal">Add New Section</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="rounded-3 border shadow-sm">
            <!-- <div class="d-flex align-items-center justify-content-between m-2"> -->
            <!-- <h1 class="h3 d-block mb-0 text-gray-800 text-center" id="course-title"></h1> -->
            <!-- <?php if (Auth::isAdminUser()) : ?>
                    <div class="" role="group" aria-label="Basic example">
                        <a class="link-danger me-2 cursor-pointer" id="delete-course-btn">
                            <i class="fas fa-trash"></i> Delete Course
                        </a>
                        <a class="link-primary cursor-pointer" id="edit-course-btn">
                            <i class="fas fa-edit"></i> Edit Course
                        </a>
                    </div>
                <?php endif; ?> -->
            <div class="px-4 py-2 d-flex flex-row align-items-center">
                <h6 class="mt-2 font-weight-bold text-primary" id="video-title"></h6>

                <!-- </div> -->
            </div>
            <div class="row justify-content-center">

                <div class="col-xl-12 col-lg-7">
                    <div class="">
                        <!-- <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" id="video-item" src=""></iframe>
                        </div> -->
                        <div class="p-2 d-flex justify-content-center">
                            <video controls autoplay id="video-item" class="video-item border rounded" style="width: 80%;">

                            </video>
                        </div>
                    </div>
                </div>

                <div class="col-xl-11 col-lg-7 d-flex justify-content-between p-2 m-2" role="group" aria-label="Basic example">
                    <button type="button" id="prev-video-btn" class="btn btn-outline-primary">Prev</button>
                    <button type="button" id="next-video-btn" class="btn btn-outline-primary">next</button>
                </div>
            </div>
        </div>
    </div>
</div>



<?php if (Auth::isAdminUser()) : ?>
    <li class="mb-3 visually-hidden" id="admin-section" data-section-id="" style="border-bottom: 2px solid grey;">
        <div class="d-flex justify-content-between align-items-center">


            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="" aria-expanded="true">

            </button>
            <button class="btn btn-outline-danger btn-sm rounded delete-section-btn" data-section-id="">
                Delete 
            </button>
        </div>
        <div class="collapse show px-5" id="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small video-list">

            </ul>
            <button class="btn-outline-primary btn-sm add-video-btn mb-2">Add Video</button>
        </div>
    </li>

    <!-- <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a></li> -->
    <div class="video-item mb-2 d-flex align-items-center justify-content-between visually-hidden mt-2" id="admin-video">
        <div>
            <!-- <i class="fas fa-video"></i> -->
            <a href="#" data-video-url="" class="video-link" data-section-id="" data-video-id="" data-video-title="">

            </a>
        </div>
        <div>
            <a class="link cursor-pointer delete-btn float-end btn-sm" id="delete-video" data-section-id="" data-video-id="">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    </div>

<?php else : ?>
    <li class="mb-3 visually-hidden" id="admin-section" data-section-id="" style="border-bottom: 2px solid grey;">
        <div class="d-flex justify-content-between align-items-center">


            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="" aria-expanded="true">

            </button>
        </div>
        <div class="collapse show px-5" id="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small video-list">

            </ul>
        </div>
    </li>

    <!-- <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a></li> -->
    <div class="video-item mb-2 d-flex align-items-center justify-content-between visually-hidden mt-2" id="admin-video">
        <div>
            <!-- <i class="fas fa-video"></i> -->
            <a href="#" data-video-url="" class="video-link" data-section-id="" data-video-id="" data-video-title="">

            </a>
        </div>
    </div>
<?php endif; ?>

<?php include "partials/_addVideoModal.php" ?>
<?php include "partials/_addSectionModal.php" ?>

<script src="../scripts/course.js"></script>

<?php include "partials/_footer.php"; ?>