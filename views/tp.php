<?php

include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
}
// if (!Auth::isAdminUser()) {
//     $id = isset($_GET['id']) ? $_GET['id'] : '';
//     header('Location: ' . "./courseuser.php?id=$id");
// }
?>
<?php
include("partials/navbar.php");

?>
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">
<div class="container-fluid pb-3">
    <div class="d-grid gap-3" style="grid-template-columns: 1fr 3fr;">
        <div class="bg-light border rounded-3">
            <div class="flex-shrink-0 p-3 bg-white">
                <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                    <svg class="bi me-2" width="30" height="24">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span class="fs-5 fw-semibold">Course Contents</span>
                </a>
                <ul class="list-unstyled" id="sectionContainer">

                </ul>
                <button class="btn btn-success mt-3 float-end" data-bs-toggle="modal" data-bs-target="#addSectionModal">Add New Section</button>

            </div>
        </div>
        <div class="bg-light border rounded-3">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Course Title</h1>
                <div class="" role="group" aria-label="Basic example">
                    <button class="btn btn-danger me-2" id="delete-course-btn">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <button class="btn btn-primary" id="edit-course-btn">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Video Title</h6>

                        </div>
                        <div class="card-body">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary">Prev</button>
                <button type="button" class="btn btn-primary">next</button>
            </div>


        </div>
    </div>
</div>

<?php if (Auth::isAdminUser()) : ?>
    <li class="mb-1 visually-hidden" id="admin-section" data-section-id="">
    <div class="d-flex justify-content-between">  
    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="" aria-expanded="true">
        </button>
        <button class="btn btn-danger delete-section-btn" data-section-id="">
            <i class="fas fa-trash"></i>
        </button>
        </div> 
        <div class="collapse" id="" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small video-list">

            </ul>
            <button class="btn btn-primary add-video-btn">Add Video</button>
        </div>
    </li>
<?php else : ?>
    <li class="mb-1 visually-hidden" id="user-section" data-section-id="">
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="" aria-expanded="true">
            ${sectionTitle}
        </button>
        <div class="collapse" id="" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small video-list">
                
            </ul>
        </div>
    </li>
<?php endif; ?>




<?php include "partials/_addVideoModal.php" ?>
<?php include "partials/_addSectionModal.php" ?>


<script src="scripts/course.js"></script>

<?php include "partials/_footer.php"; ?>
