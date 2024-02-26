<?php
include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
} ?>
<?php include 'partials/_header.php' ?>

<body>
    <?php include "partials/navbar.php" ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 shadow-sm p-2 mb-5 bg-body rounded min-vh-100 ">
                <div class="navbar">
                    <h2>Course Contents</h2>
                    <div class="accordion w-100" id="accordionExample">
                    </div>
                </div>
                <button class="btn btn-success mt-3 float-end" data-bs-toggle="modal" data-bs-target="#addSectionModal">Add New Section</button>
            </div>
            <div class="col-md-9 shadow-sm p-2 mb-5 bg-body rounded min-vh-100 d-flex flex-column">

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
                <div class="video-container">

                </div>
                <div class="bg-light p-3 justify-self-end">
                    <div class="container">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary">Prev</button>
                            <button class="btn btn-primary">Next</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include "partials/_addVideoModal.php" ?>

    <?php include "partials/_addSectionModal.php" ?>


    <script>
        $(document).ready(function() {
            var course_id;
            var course;

            $.urlParam = function(name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results == null) {
                    return null;
                }
                return decodeURI(results[1]) || 0;
            }

            course_id = $.urlParam('id');

            // function to load course sections and videos

            $.post(
                "../controllers/getcontroller.php", {
                    id: course_id
                },
                function(res, status) {
                    course = res;
                    const sections = res["sections"];
                    $("#course-title").html(res["course"]["title"]);
                    if (sections === null) {
                        console.log("fd");
                    }
                    const videos = res["videos"];

                    sections.forEach(element => {
                        var newSection = `
                    <div class="accordion-item" data-section-id="${element['id']}" section-id=${res["id"]}>
                        <h2 class="accordion-header d-flex">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-${element["id"]}" aria-expanded="true"
                                aria-controls="collapse-${element["id"]}">
                                ${element["title"]}
                                <button class="btn btn-danger delete-section-btn" data-section-id="${element["id"]}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </button>
                        </h2>
                        <div id="collapse-${element["id"]}" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="video-list">
                                    <!-- Videos will be dynamically added here -->
                                </div>

                                <button class="btn btn-primary add-video-btn"
                                    >Add Video</button>
                                    
                            </div>
                        </div>
                    </div>`;
                        $("#accordionExample").append(newSection);
                    });

                    videos.forEach(element => {
                        element.forEach(e => {
                            var videoElement = ` <div class="video-item mb-2 d-flex">
                            <div>
                            <a href="#" data-video-url="${e['video_url']}" class="video-link" data-section-id=${e['section-id']} data-video-id=${e['id']}>
                            <i class="fas fa-video"></i>
                                ${e["title"]}
                            </a>
                            </div>
                            <div>
                            <button type="button" class="btn btn-danger delete-btn float-end btn-sm" data-section-id=${e['section-id']} data-video-id=${e['id']}>
                                <i class="fas fa-trash"></i>
                            </button>
                            </div>
                        </div>`;
                            var accordionItem = $('[data-section-id="' + e['section_id'] + '"]');
                            accordionItem.find('.video-list').append(videoElement);
                        });

                    })

                },
                'json'
            ).fail(function(xhr, status, error) {
                console.log("Error:", xhr);
            });

            // function to add new section

            $("#addSectionForm").submit(function(e) {
                let course_id = $.urlParam('id');
                e.preventDefault();
                var sectionTitle = $("#sectionTitle").val();

                $.post(
                    "../controllers/addSection.php", {
                        title: sectionTitle,
                        id: course_id
                    },
                    function(res, status) {
                        console.log(res);
                        var newSection = `
                    <div class="accordion-item" data-section-id="${res["id"]}" section-id=${res["id"]}>
                        <h2 class="accordion-header d-flex">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-${res["id"]}" aria-expanded="true"
                                aria-controls="collapse-${res["id"]}">
                                ${sectionTitle}
                                <button class="btn btn-danger delete-section-btn" data-section-id="${res["id"]}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </button>
                        </h2>
                        <div id="collapse-${res["id"]}" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="video-list">
                                    <!-- Videos will be dynamically added here -->
                                </div>
                                <button class="btn btn-primary add-video-btn" 
                                >Add Video</button>
                                    
                            </div>
                        </div>
                    </div>`;
                        $("#accordionExample").append(newSection);
                        $('#addSectionModal').modal('hide');
                    },
                    'json'
                ).fail(function(xhr, status, error) {
                    console.log("Error:", xhr);
                });
            });

            // Function to delete a section
            $(document).on("click", ".delete-section-btn", function() {
                var sectionId = $(this).data("section-id");
                console.log(sectionId);
                let course_id = $.urlParam('id');
                $.post(
                    "../controllers/deleteSection.php", {
                        course_id: course_id,
                        section_id: sectionId
                    },
                    function(res, status) {
                        console.log(res);
                    },
                    'json'
                ).fail(function(xhr, status, error) {
                    console.log("Error:", xhr);
                });

                $('[data-section-id="' + sectionId + '"]').remove();

            });

            // delete course button function
            $("#delete-course-btn").click(function() {
                let course_id = $.urlParam('id');
                $.post("../controllers/deleteCourse.php", {
                        id: course_id
                    }, function(res, status) {
                        console.log(res);
                        window.location.href = "/views/Courses.php";
                    },
                    'json').fail(function(xhr, status, error) {
                    console.log(error);
                });
            });

            // edit course button function

            $("#edit-course-btn").click(function() {
                console.log(course);
                $.post("editcourse.php", {
                    course: course['course']
                }, function(res, status) {
                    window.location.href = "/views/editcourse.php";
                });
            });

            // add video button function

            $(document).on('click', '.add-video-btn', function(e) {
                var sectionId = $(this).closest('.accordion-item').data('section-id');
                $('#sectionIdInput').val(sectionId);
                $('#uploadVideoModal').modal('show');
            });

            // function to add video

            $("#uploadVideoForm").submit(function(e) {
                e.preventDefault();
                let courseId = $.urlParam('id');
                var formData = new FormData($("#uploadVideoForm")[0]);
                var sectionId = $('#sectionIdInput').val();
                formData.append('sectionId', sectionId);
                formData.append('courseId', courseId);
                console.log(formData);
                $.ajax({
                    url: "../controllers/addVideo.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        console.log(res);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

                $('#uploadVideoModal').modal('hide');
            });


            $(document).on('click', '.video-link', function(e) {
                e.preventDefault();
                console.log("m");
                var links = document.querySelectorAll('.video-link');
                links.forEach(function(link) {
                    link.style.color = 'blue';
                });

                $(this).css('color', 'black');
                var videoUrl = $(this).data('video-url');
                var sectionid = $(this).data('section-id');
                var videoid = $(this).data('video-id');
                var videoElement = `<video controls autoplay class="video-item mb-2 d-flex w-100 h-100 data-section-id=${sectionid} data-video-id=${videoid}">
                <source src="${videoUrl}" type="video/mp4">
            </video>`;
                $('.video-container').html(videoElement);
                var video = document.querySelector('video');
                video.play();

                video.addEventListener('ended', function() {
                    console.log(course);
                    let sectionid = $(this).data('section-id');
                    let videoid = $(this).data('video-id');
                    console.log(videoid);
                    console.log(sectionid);
                });
            });

        });
    </script>
    <?php include "partials/_footer.php"; ?>