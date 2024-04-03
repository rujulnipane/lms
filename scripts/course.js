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
    getCourseDetails();

    // add event listeners to to the elements 
    $("#addSectionForm").submit(addSection);
    $(document).on("click", ".delete-section-btn", deleteSection);
    $("#delete-course-btn").click(deleteCourse);
    $("#edit-course-btn").click(editCourse);
    $(document).on('click', '.add-video-btn', uploadVideo);
    $("#uploadVideoForm").submit(addVideo);
    $(document).on('click', '#delete-video', deleteVideo);
    $(document).on('click', '.video-link', playVideoOnClick);
    $("#video-item").on("ended", onVideoComplete);
    $("#next-video-btn").click(playNextVideo);
    $("#prev-video-btn").click(playPrevVideo);

    // get course details and diplay on page 
    function getCourseDetails() {
        $.post(
            "../controllers/getcontroller.php", {
            id: course_id
        },
            function (res, status) {
                course = res;
                // console.log(res);
                $("#sectionContainer").empty();
                const sections = res["sections"];
                $("#course").html(res["course"]["title"]);

                const videos = res["videos"];
                if (sections == null) {
                    // $("#video-item").addClass("visually-hidden");
                } else {
                    sections.forEach(section => {
                        const sectionId = section['id'];
                        const sectionTitle = section['title'];
                        const cardTemplate = $("#admin-section").length ? $("#admin-section") : $("#user-section");
                        const newCard = cardTemplate.clone().appendTo("#sectionContainer");
                        newCard.attr("data-section-id", sectionId);
                        newCard.find(".btn-toggle").html(sectionTitle);
                        newCard.find(".delete-section-btn").attr("data-section-id", sectionId);
                        newCard.find(".btn-toggle").attr("data-bs-target", "#section-" + sectionId);
                        newCard.find(".collapse").attr("id", "section-" + sectionId);
                        newCard.removeClass('visually-hidden');
                    });
                }
                videos.forEach(element => {
                    element.forEach(e => {
                        console.log(e);
                        var videoTemplate = $("#admin-video").length ? $("#admin-video") : $("#user-video");
                        var sectionLi = $('li[data-section-id="' + e['section_id'] + '"]');
                        var videoElement = videoTemplate.clone().removeClass('visually-hidden');
                        sectionLi.find('.video-list').append(videoElement);
                        videoElement.find(".video-link").attr("data-video-url", e["video_url"]);
                        videoElement.find(".video-link").attr("data-video-id", e["id"]);
                        videoElement.find(".video-link").attr("data-video-title", e["title"]);
                        videoElement.find(".video-link").text(e["title"]);
                        videoElement.find(".video-link").attr("data-section-id", e["section_id"]);
                        videoElement.find("#delete-video").attr("data-video-id", e["id"]);
                        videoElement.find("#delete-video").attr("data-section-id", e["section_id"]);
                    });
                });
                playFirstVideo();
            },
            'json'
        ).fail(function (xhr, status, error) {
            console.log("Error:", xhr);
        });
    }

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
            function (res, status) {
                // console.log(res);
                getCourseDetails();
                showAlert("New Section Added!", 3000);
                $('#addSectionModal').modal('hide');
            },
            'json'
        ).fail(function (xhr, status, error) {
            console.log("Error:", xhr);
        });
    }

    function deleteSection() {
        var sectionId = $(this).data("section-id");
        // console.log(sectionId);
        let course_id = $.urlParam('id');
        if (confirm("Are you sure you want to delete this section?")) {
            $.post(
                "../controllers/deleteSection.php", {
                course_id: course_id,
                section_id: sectionId
            },
                function (res, status) {
                    console.log(res);
                    showAlert("Deleted Section successfully!", 3000);
                },
                'json'
            ).fail(function (xhr, status, error) {
                console.log("Error:", xhr);
            });

            $(this).closest("li").remove();
        }
    }

    // edit course button function
    function editCourse() {
        $.post("editcourse.php", {
            course: course['course']
        }, function (res, status) {
            window.location.href = "editcourse.php";
        });
    }

    // delete course button function
    function deleteCourse() {
        let course_id = $.urlParam('id');
        if (confirm("Are you sure you want to delete this course?")) {
            $.post("../controllers/deleteCourse.php", {
                id: course_id
            }, function (res, status) {
                console.log(res);
                window.location.href = "Courses.php";
            },
                'json').fail(function (xhr, status, error) {
                    console.log(error);
                });
        }
    }

    // add video button function
    function uploadVideo(e) {
        var sectionId = $(this).closest('li').data('section-id');
        $('#sectionIdInput').val(sectionId);
        $('#uploadVideoModal').modal('show');
    }

    // function to add video
    function addVideo(e) {
        e.preventDefault();
        let courseId = $.urlParam('id');
        var formData = new FormData($("#uploadVideoForm")[0]);
        var fileSize = formData.get('videoFile').size; // Accessing file size correctly
        if (fileSize > 5 * 1024 * 1024) {
            showAlert("File size is too large!", 2000);
        }
        var sectionId = $('#sectionIdInput').val();
        let videotitle = $('#video-t').val();
        // console.log(videotitle);
        // console.log(sectionId);
        formData.append('sectionId', sectionId);
        formData.append('courseId', courseId);
        formData.append('video-title', videotitle);
        // console.log(formData);
        $.ajax({
            url: "../controllers/addVideo.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                console.log(res);
                showAlert("Added new Video!", 3000);
                getCourseDetails();
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
        $('#uploadVideoModal').modal('hide');
    }

    // function for delete video
    function deleteVideo(e) {
        e.preventDefault();
        const videoid = $(this).data('video-id');
        const sectionid = $(this).data('section-id');
        if (confirm("Are you sure you want to delete this video?")) {
            $.post("../controllers/deleteVideo.php", {
                video_id: videoid,
                section_id: sectionid
            },
                function (res, status) {
                    console.log(res);
                    showAlert("Deleted video Successfully!", 3000);
                    getCourseDetails();
                }, 'json').fail(function (xhr, status, error) {
                    console.log(error);
                })
        }
    }

    // play video by clinking from navigation panel
    function playVideoOnClick(e) {
        e.preventDefault();
        var links = document.querySelectorAll('.video-link');
        links.forEach(function (link) {
            link.style.color = 'black';
        });
        $(this).css('color', '#007bff');
        var videoUrl = $(this).data('video-url');
        var sectionid = $(this).data('section-id');
        var videoid = $(this).data('video-id');
        var title = $(this).data('video-title');
        var sectionButton = $(`#admin-section[data-section-id="${sectionid}"] .btn-toggle`);
        var video = $("#video-item");
        var video_title = $("#video-title");
        video_title.html(sectionButton.text() + ' / ' + title);
        $("#sec").html(sectionButton.text());
        video.attr("src", videoUrl);
        video.attr("data-section-id", sectionid);
        video.attr("data-video-id", videoid);
        video[0].load();
        video[0].play();
    }

    // next video on video end function
    function onVideoComplete(e) {
        const videos = course['videos'];
        // console.log(videos);
        var sectionid = $(this).attr("data-section-id");
        var videoid = $(this).attr("data-video-id");
        const nextVideo = getNextVideo(sectionid, videoid, videos);
        // console.log(nextVideo);
        var links = document.querySelectorAll('.video-link');
        links.forEach(function (link) {
            link.style.color = 'black';
        });
        if (nextVideo) {
            var videolink = $(`.video-link[data-section-id=${nextVideo['section_id']}][data-video-id=${nextVideo['id']}]`);
            videolink.css('color', '#007bff');
            var video = $("#video-item");
            var video_title = $("#video-title");
            var sectionButton = $(`#admin-section[data-section-id="${nextVideo['section_id']}"] .btn-toggle`);
            video_title.html(sectionButton.text() + ' / ' + nextVideo['title']);
            $("#sec").html(sectionButton.text());
            video.attr("src", nextVideo['video_url']);
            video.attr("data-section-id", nextVideo['section_id']);
            video.attr("data-video-id", nextVideo['id']);
            video[0].load();
            video[0].play();
        }
        else {
            playFirstVideo();
        }
    }

    // play next video function
    function playNextVideo(e) {
        e.preventDefault();
        const videos = course['videos'];
        // console.log(videos);
        var video = $("#video-item");
        var sectionid = video.attr("data-section-id");
        var videoid = video.attr("data-video-id");
        // console.log(sectionid);
        // console.log(videoid);
        const nextVideo = getNextVideo(sectionid, videoid, videos);
        // console.log(nextVideo);
        if (nextVideo) {
            var links = document.querySelectorAll('.video-link');
            links.forEach(function (link) {
                link.style.color = "black";
            });
            var videolink = $(`.video-link[data-section-id=${nextVideo['section_id']}][data-video-id=${nextVideo['id']}]`);
            videolink.css('color', '#007bff');
            var sectionButton = $(`#admin-section[data-section-id="${nextVideo['section_id']}"] .btn-toggle`);
            var video_title = $("#video-title");
            video_title.html(sectionButton.text() + ' / ' + nextVideo['title']);
            $("#sec").html(sectionButton.text());
            video.attr("src", nextVideo['video_url']);
            video.attr("data-section-id", nextVideo['section_id']);
            video.attr("data-video-id", nextVideo['id']);
            video[0].load();
            video[0].play();
        }
        else {
            playFirstVideo();
        }
    }

    // play prev video function
    function playPrevVideo(e) {
        e.preventDefault();
        const videos = course['videos'];
        var video = $("#video-item");
        var sectionid = video.attr("data-section-id");
        var videoid = video.attr("data-video-id");
        // console.log(sectionid);
        // console.log(videoid);
        const prevVideo = getprevVideo(sectionid, videoid, videos);
        if (prevVideo) {
            var links = document.querySelectorAll('.video-link');
            links.forEach(function (link) {
                link.style.color = 'black';
            });
            var videolink = $(`.video-link[data-section-id=${prevVideo['section_id']}][data-video-id=${prevVideo['id']}]`);
            videolink.css('color', '#007bff');
            var sectionButton = $(`#admin-section[data-section-id="${prevVideo['section_id']}"] .btn-toggle`);
            var video_title = $("#video-title");
            video_title.html(sectionButton.text() + ' / ' + prevVideo['title']);
            video.attr("src", prevVideo['video_url']);
            video.attr("data-section-id", prevVideo['section_id']);
            $("#sec").html(sectionButton.text());
            video.attr("data-video-id", prevVideo['id']);
            video[0].load();
            video[0].play();
        } else {
            playFirstVideo();
        }
    }

    // get next video
    function getNextVideo(sectionid, videoid, videos) {
        const Videos = [];
        videos.forEach(element => {
            element.forEach(e => {
                if (e['section_id'] == sectionid && e['id'] > videoid) {
                    Videos.push(e);
                }
                else if (e['section_id'] > sectionid) {
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
                if (e['section_id'] == sectionid && e['id'] < videoid) {
                    Videos.push(e);
                }
                else if (e['section_id'] < sectionid) {
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

    function playFirstVideo() {
        var videos = course['videos'];
        var video = $("#video-item");
        var sectionButton = $(`#admin-section[data-section-id="${videos[0][0]['section_id']}"] .btn-toggle`);
        var video_title = $("#video-title");
        video_title.html(sectionButton.text() + ' / ' + videos[0][0]['title']);
        video.attr("src", videos[0][0]['video_url']);
        video.attr("data-section-id", videos[0][0]['section_id']);
        video.attr("data-video-id", videos[0][0]['id']);
        video[0].load();
        video[0].pause();
        var links = document.querySelectorAll('.video-link');
        links.forEach(function (link) {
            link.style.color = 'black';
        });
        var videolink = $(`.video-link[data-section-id=${videos[0][0]['section_id']}][data-video-id=${videos[0][0]['id']}]`);
        videolink.css('color', '#007bff');
    }

    function showAlert(message, duration) {
        $("#alertMessage").text(message);

        $("#myAlert").fadeIn();

        setTimeout(function () {
            $("#myAlert").fadeOut();
        }, duration);
    }

    function closeAlert() {
        $("#myAlert").fadeOut();
    }

});