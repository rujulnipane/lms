$(document).ready(function () {
    var course_id;
    var course;

    $.urlParam = function (name) {
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
        function (res, status) {
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
            <div class="accordion-item bg-dark text-light" data-section-id="${element['id']}" section-id=${res["id"]}>
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

            videos.forEach(element => {
                element.forEach(e => {
                    var videoElement = ` <div class="video-item mb-2 d-flex justify-content-between border-bottom">
                    <div>
                    <i class="fas fa-video"></i>
                    <a href="#" data-video-url="${e['video_url']}" class="video-link" data-section-id=${e['section_id']} data-video-id=${e['id']} data-video-title=${e['title']}>
                        ${e["title"]}
                    </a>
                    </div>
                    <div>
                    </div>
                </div>`;
                    var accordionItem = $('[data-section-id="' + e['section_id'] + '"]');
                    accordionItem.find('.video-list').append(videoElement);
                });
            })
            var links = document.querySelectorAll('.video-link');
    links.forEach(function (link) {
        link.style.color = 'white';
    });
        },
        'json'
    ).fail(function (xhr, status, error) {
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
        links.forEach(function (link) {
            link.style.color = 'white';
        });
        $(this).css('color', '#007bff');
        var videoUrl = $(this).data('video-url');
        var sectionid = $(this).data('section-id');
        var videoid = $(this).data('video-id');
        var title = $(this).data('video-title');
        // console.log(title);
        // console.log(sectionid);
        // console.log(videoid);
        var video = $("#video-item");
        var video_title = $("#video-title");
        video_title.html(title);
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
        // console.log(nextVideo);
        var links = document.querySelectorAll('.video-link');
        links.forEach(function (link) {
            link.style.color = 'white';
        });
        var videolink = $(`.video-link[data-section-id=${nextVideo['section_id']}][data-video-id=${nextVideo['id']}]`);
        videolink.css('color', '#007bff');
        var video = $("#video-item");
        var video_title = $("#video-title");
        video_title.html(nextVideo['title']);
        video.attr("src", nextVideo['video_url']);
        video.attr("data-section-id", nextVideo['section_id']);
        video.attr("data-video-id", nextVideo['id']);
        video[0].load();
        video[0].play();
    }

    function playNextVideo(e) {
        e.preventDefault();
        const videos = course['videos'];
        console.log(videos);
        var video = $("#video-item");
        var sectionid = video.attr("data-section-id");
        var videoid = video.attr("data-video-id");
        console.log(sectionid);
        console.log(videoid);
        const nextVideo = getNextVideo(sectionid, videoid, videos);
        // console.log(nextVideo);
        var links = document.querySelectorAll('.video-link');
        links.forEach(function (link) {
            link.style.color = 'white';
        });
        var videolink = $(`.video-link[data-section-id=${nextVideo['section_id']}][data-video-id=${nextVideo['id']}]`);
        videolink.css('color', '#007bff');
        var video_title = $("#video-title");
        video_title.html(nextVideo['title']);
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
        links.forEach(function (link) {
            link.style.color = 'white';
        });
        var videolink = $(`.video-link[data-section-id=${prevVideo['section_id']}][data-video-id=${prevVideo['id']}]`);
        videolink.css('color', '#007bff');
        var video_title = $("#video-title");
        video_title.html(prevVideo['title']);
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
                if (e['section_id'] == sectionid && e['id'] > videoid) {
                    Videos.push(e);
                }
                else if(e['section_id']>sectionid){
                    Videos.push(e);
                }
            });
        });
        console.log(Videos);
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
                if (e['section_id'] == sectionid && e['id'] < videoid) {
                    Videos.push(e);
                }
                else if(e['section_id']<sectionid){
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