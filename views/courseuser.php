<?php
include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
}
if (Auth::isAdminUser()) {
    header('Location: ' . "./Courseadmin.php");
}
?>
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
</div>
            <div class="col-md-9 shadow-sm p-2 mb-5 bg-body rounded min-vh-100 d-flex flex-column">

                <div class="container pt-2">
                    <header class="d-flex justify-content-between align-items-center">
                        <h1 id="course-title"></h1>
                        
                    </header>
                </div>
                <div class="video-container">
                    <video controls autoplay id="video-item" class="video-item mb-2 d-flex w-100 h-100">

                    </video>
                </div>
                <div class="bg-light p-3 justify-self-end">
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
                        $("#accordionExample").append('<h5>No contents available</h5>');
                    }
                    

                    sections.forEach(element => {
                        var newSection = `
                    <div class="accordion-item" data-section-id="${element['id']}" section-id=${res["id"]}>
                        <h2 class="accordion-header d-flex">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-${element["id"]}" aria-expanded="true"
                                aria-controls="collapse-${element["id"]}">
                                ${element["title"]}
                            </button>
                        </h2>
                        <div id="collapse-${element["id"]}" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="video-list">
                                    <!-- Videos will be dynamically added here -->
                                </div>    
                            </div>
                        </div>
                    </div>`;
                        $("#accordionExample").append(newSection);
                    });
                    const videos = res["videos"];
                    if(videos.length == 0){
                        $("#accordionExample").append('<h5>No contents available</h5>');
                    }
                    videos.forEach(element => {
                        element.forEach(e => {
                            var videoElement = ` <div class="video-item mb-2 d-flex justify-content-between border-bottom">
                            
                            <i class="fas fa-video"></i>
                            <a href="#" data-video-url="${e['video_url']}" class="video-link" data-section-id=${e['section_id']} data-video-id=${e['id']}>
                                ${e["title"]}
                            </a>
                            
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


            // play video by clinking from navigation panel
            $(document).on('click', '.video-link', playVideoOnClick);

            // next video on video end function
            $("#video-item").on("ended", onVideoComplete);

            // play next video function
            $("#next-video-btn").click(playNextVideo);

            // play prev video function
            $("#prev-video-btn").click(playPrevVideo);

            
            function playVideoOnClick(e) {
                e.preventDefault();
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