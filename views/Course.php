<?php

include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
}

?>
<?php
include("partials/navbar.php");

?>
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">

<div class="container-fluid pb-3">
<div class="alert alert-success alert-dismissible fade show m-2" role="alert" id="myAlert" style="display: none;">
        <span id="alertMessage"></span>
        <button type="button" class="btn-close" aria-label="Close" onclick="closeAlert()"></button>
    </div>
    <div class="d-grid gap-2" style="grid-template-columns: 1fr 3fr;">
        <div class="bg-light border rounded-3">
            <div class="flex-shrink-0 p-3 bg-white">
                <a href="" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                    <svg class="bi me-2" width="30" height="24">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span class="fs-5 fw-semibold">Course Contents</span>
                </a>
                <ul class="list-unstyled" id="sectionContainer">

                </ul>
                <?php if (Auth::isAdminUser()) : ?>
                <button class="btn btn-success mt-3 float-end" data-bs-toggle="modal" data-bs-target="#addSectionModal">Add New Section</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="bg-light rounded-3">
            <div class="d-sm-flex align-items-center justify-content-between m-2">
                <h1 class="h3 mb-0 text-gray-800" id="course-title">Course Title</h1>
                <?php if (Auth::isAdminUser()) : ?>
                <div class="" role="group" aria-label="Basic example">
                    <button class="btn btn-danger me-2" id="delete-course-btn">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <button class="btn btn-primary" id="edit-course-btn">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </div>
                <?php endif; ?>
            </div>
            <div class="row justify-content-center">

                <div class="col-xl-12 col-lg-7">
                    <div class="card">
                        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between text-center">
                            <h6 class="m-0 font-weight-bold text-primary" id="video-title"></h6>

                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <video controls autoplay id="video-item" class="video-item w-75 h-75 border rounded">

                            </video>
                        </div>
                    </div>
                </div>

                <div class="col-xl-11 col-lg-7 d-flex justify-content-between p-2" role="group" aria-label="Basic example">
                    <button type="button" id="prev-video-btn" class="btn btn-primary">Prev</button>
                    <button type="button" id="next-video-btn" class="btn btn-primary">next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (Auth::isAdminUser()) : ?>
    <li class="mb-1 visually-hidden" id="admin-section" data-section-id="">
        <div class="d-flex justify-content-between bg-dark rounded">
            
            <button class="btn btn-toggle align-items-center rounded collapsed text-light" data-bs-toggle="collapse" data-bs-target="" aria-expanded="false">
            
        </button>
            <button class="btn btn-danger delete-section-btn" data-section-id="">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="collapse show" id="" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small video-list">

            </ul>
            <button class="btn btn-primary add-video-btn btn-sm mb-1">Add Video</button>
        </div>
    </li>

    <div class="video-item mb-2 d-flex justify-content-between border-bottom visually-hidden mt-2" id="admin-video">
        <div>
            <i class="fas fa-video"></i>
            <a href="#" data-video-url="" class="video-link" data-section-id="" data-video-id="" data-video-title="">

            </a>
        </div>
        <div>
            <button type="button" class="btn btn-danger delete-btn float-end btn-sm" id="delete-video" data-section-id="" data-video-id="">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>

<?php else : ?>
    <li class="mb-1 visually-hidden" id="user-section" data-section-id="">
        <button class="btn btn-toggle align-items-center bg-dark text-light rounded collapsed" data-bs-toggle="collapse" data-bs-target="" aria-expanded="false">
        <i class="fa-solid fa-angle-down"></i> 
        </button>
        <div class="collapse show mt-2" id="" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small video-list">

            </ul>
        </div>
    </li>

    <div class="video-item mb-2 d-flex justify-content-between border-bottom visually-hidden" id="user-video">
        <div>
            <i class="fas fa-video"></i>
            <a href="#" data-video-url="" class="video-link" data-section-id="" data-video-id="" data-video-title="">

            </a>
        </div>
    </div>
<?php endif; ?>




<?php include "partials/_addVideoModal.php" ?>
<?php include "partials/_addSectionModal.php" ?>


<script src="../scripts/course.js"></script>

<?php include "partials/_footer.php"; ?>