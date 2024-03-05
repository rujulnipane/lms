<?php

include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
}

?>
<?php
include("partials/navbar.php");

?>

<style>
    .btn-toggle[aria-expanded="true"]::before {
        transform: rotate(90deg);
    }

    .btn-toggle::before {
        width: 1.25em;
        line-height: 0;
        content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
        transition: transform .35s ease;
        transform-origin: 0.5em 50%;
    }

    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }
</style>
<!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="../styles/course.css">

<div class="container-fluid pb-3">
    <div class="alert alert-success alert-dismissible fade show m-2" role="alert" id="myAlert" style="display: none;">
        <span id="alertMessage"></span>
        <button type="button" class="btn-close" aria-label="Close" onclick="closeAlert()"></button>
    </div>
    <div class="d-grid gap-2" style="grid-template-columns: 1fr 3fr;">
        <div class="bg-light border rounded-3">
            <div class="flex-shrink-0 p-3">
                <a href="/" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
                    <span class="fs-5 fw-semibold">Course Contents</span>
                </a>
                <ul class="list-unstyled ps-0">
                    <li class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                            Home
                        </button>
                        <div class="collapse show" id="home-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="border-top my-3"></li>
                </ul>
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
                        <!-- <div class="card-header py-2 d-flex flex-row align-items-center justify-content-center"> -->
                        <h6 class="mt-2 font-weight-bold text-primary text-center" id="video-title"></h6>

                        <!-- </div> -->
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


<script src="../scripts/course.js"></script>

<?php include "partials/_footer.php"; ?>