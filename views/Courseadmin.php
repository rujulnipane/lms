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
            <div class="col-md-3 shadow-sm p-2 mb-5 bg-body rounded">
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
                <div class="video-container">
                    <div class="video-header"></div>
                    <video controls autoplay id="video-item" class="video-item mb-2 d-flex w-100 h-75">

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
                    console.log(res);
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
                            var videoElement = ` <div class="video-item mb-2 d-flex justify-content-between border-bottom">
                            <div>
                            <i class="fas fa-video"></i>
                            <a href="#" data-video-url="${e['video_url']}" class="video-link" data-section-id=${e['section_id']} data-video-id=${e['id']}>
                                ${e["title"]}
                            </a>
                            </div>
                            <div>
                            <button type="button" class="btn btn-danger delete-btn float-end btn-sm" id="delete-video" data-section-id=${e['section_id']} data-video-id=${e['id']}>
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


            $("#addSectionForm").submit(addSection);

            $(document).on("click", ".delete-section-btn", deleteSection);

            $("#delete-course-btn").click(deleteCourse);

            // edit course button function
            $("#edit-course-btn").click(editCourse);

            // add video button function
            $(document).on('click', '.add-video-btn', uploadVideo);

            // function to add video
            $("#uploadVideoForm").submit(addVideo);

            // function for delete video
            $(document).on('click', '#delete-video', deleteVideo);

            // play video by clinking from navigation panel
            $(document).on('click', '.video-link', playVideoOnClick);

            // next video on video end function
            $("#video-item").on("ended", onVideoComplete);

            // play next video function
            $("#next-video-btn").click(playNextVideo);

            // play prev video function
            $("#prev-video-btn").click(playPrevVideo);

            // function to add new section
            function addSection(e) {
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
            }

            // Function to delete a section
            function deleteSection() {
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

            }

            function editCourse() {
                console.log(course);
                $.post("editcourse.php", {
                    course: course['course']
                }, function(res, status) {
                    window.location.href = "/views/editcourse.php";
                });
            }

            // delete course button function
            function deleteCourse() {
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
            }

            function uploadVideo(e) {
                var sectionId = $(this).closest('.accordion-item').data('section-id');
                $('#sectionIdInput').val(sectionId);
                $('#uploadVideoModal').modal('show');
            }

            function addVideo(e) {
                e.preventDefault();
                let courseId = $.urlParam('id');
                var formData = new FormData($("#uploadVideoForm")[0]);
                var sectionId = $('#sectionIdInput').val();
                var videotitle = $('#video-title').val();
                formData.append('sectionId', sectionId);
                formData.append('courseId', courseId);
                formData.append('video-title', videotitle);
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
            }

            function deleteVideo(e) {
                e.preventDefault();
                const videoid = $(this).data('video-id');
                const sectionid = $(this).data('section-id');
                $.post("../controllers/deleteVideo.php", {
                        video_id: videoid,
                        section_id: sectionid
                    },
                    function(res, status) {
                        console.log(res);
                        location.reload();
                    }, 'json').fail(function(xhr, status, error) {
                    console.log(error);
                })
            }

            function playVideoOnClick(e) {
                e.preventDefault();
                // console.log("m");
                var links = document.querySelectorAll('.video-link');
                links.forEach(function(link) {
                    link.style.color = '#007bff';
                });

                $(this).css('color', 'black');
                var videoUrl = $(this).data('video-url');
                var sectionid = $(this).data('section-id');
                var videoid = $(this).data('video-id');
                console.log(sectionid);
                console.log(videoid);
                var video = $("#video-item");
                video.attr("src", videoUrl);
                video.attr("data-section-id", sectionid);
                video.attr("data-video-id", videoid);
                video[0].load();
                video[0].play();
            }

            function onVideoComplete(e) {
                const videos = course['videos'];
                // console.log(videos);
                var sectionid = $(this).attr("data-section-id");
                var videoid = $(this).attr("data-video-id");
                // console.log(sectionid);
                // console.log(videoid);
                const nextVideo = getNextVideo(sectionid, videoid, videos);
                console.log(nextVideo);
                var links = document.querySelectorAll('.video-link');
                links.forEach(function(link) {
                    link.style.color = '#007bff';
                });
                var videolink = $(`.video-link[data-section-id=${nextVideo['section_id']}][data-video-id=${nextVideo['id']}]`);
                videolink.css('color', 'black');
                var video = $("#video-item");
                video.attr("src", nextVideo['video_url']);
                video.attr("data-section-id", nextVideo['section_id']);
                video.attr("data-video-id", nextVideo['id']);
                video[0].load();
                video[0].play();
            }

            function playNextVideo(e) {
                e.preventDefault();
                const videos = course['videos'];
                var video = $("#video-item");
                var sectionid = video.attr("data-section-id");
                var videoid = video.attr("data-video-id");
                // console.log(sectionid);
                // console.log(videoid);
                const nextVideo = getNextVideo(sectionid, videoid, videos);
                var links = document.querySelectorAll('.video-link');
                links.forEach(function(link) {
                    link.style.color = '#007bff';
                });
                var videolink = $(`.video-link[data-section-id=${nextVideo['section_id']}][data-video-id=${nextVideo['id']}]`);
                videolink.css('color', 'black');
                video.attr("src", nextVideo['video_url']);
                video.attr("data-section-id", nextVideo['section_id']);
                video.attr("data-video-id", nextVideo['id']);
                video[0].load();
                video[0].play();
            }

            function playPrevVideo(e) {
                e.preventDefault();
                const videos = course['videos'];
                var video = $("#video-item");
                var sectionid = video.attr("data-section-id");
                var videoid = video.attr("data-video-id");
                // console.log(sectionid);
                // console.log(videoid);
                const prevVideo = getprevVideo(sectionid, videoid, videos);
                var links = document.querySelectorAll('.video-link');
                links.forEach(function(link) {
                    link.style.color = '#007bff';
                });
                var videolink = $(`.video-link[data-section-id=${prevVideo['section_id']}][data-video-id=${prevVideo['id']}]`);
                videolink.css('color', 'black');
                video.attr("src", prevVideo['video_url']);
                video.attr("data-section-id", prevVideo['section_id']);
                video.attr("data-video-id", prevVideo['id']);
                video[0].load();
                video[0].play();
            }
            // get next video
            function getNextVideo(sectionid, videoid, videos) {
                const Videos = [];
                videos.forEach(element => {
                    element.forEach(e => {
                        if (e['section_id'] >= sectionid && e['id'] > videoid) {
                            Videos.push(e);
                        }
                    });
                });
                // console.log(Videos);
                if (Videos.length > 0) {
                    return Videos[0];
                }
                return null;
            }

            // get prev video
            function getprevVideo(sectionid, videoid, videos) {
                const Videos = [];
                videos.forEach(element => {
                    element.forEach(e => {
                        if (e['section_id'] <= sectionid && e['id'] < videoid) {
                            Videos.push(e);
                        }
                    });
                });
                // console.log(Videos);
                if (Videos.length > 0) {
                    return Videos[Videos.length - 1];
                }
                return null;
            }
        });
    </script>
    <?php include "partials/_footer.php"; ?>