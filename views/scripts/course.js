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

    getCourseDetails();

    $("#addSectionForm").submit(addSection);

     // add video button function
     $(document).on('click', '.add-video-btn', uploadVideo);

     // function to add video
     $("#uploadVideoForm").submit(addVideo);

    function getCourseDetails() {
        $.post(
            "../controllers/getcontroller.php", {
                id: course_id
            },
            function(res, status) {
                course = res;
                console.log(res);
                $("#sectionContainer").empty();
                const sections = res["sections"];
                $("#course-title").html(res["course"]["title"]);
                if (sections === null) {
                    
                }
                const videos = res["videos"];
                if (sections === null) {
                    console.log("No sections found");
                } else {
                    sections.forEach(section => {
                        const sectionId = section['id'];
                        const sectionTitle = section['title'];
                        const cardTemplate = $("#admin-section").length ? $("#admin-section") : $("#user-section");
                        const newCard = cardTemplate.clone().appendTo("#sectionContainer");
                        newCard.attr("data-section-id", "section-" + sectionId);
                        newCard.find(".btn-toggle").text(sectionTitle);
                        newCard.find(".delete-section-btn").attr("data-section-id", sectionId);
                        newCard.find(".btn-toggle").attr("data-bs-target", "#section-" + sectionId);
                        newCard.find(".collapse").attr("id", "section-" + sectionId);
                        newCard.removeClass('visually-hidden');
                    });
                }
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
                    <button type="button" class="btn btn-danger delete-btn float-end btn-sm" id="delete-video" data-section-id=${e['section_id']} data-video-id=${e['id']}>
                        <i class="fas fa-trash"></i>
                    </button>
                   
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
        ).fail(function(xhr, status, error) {
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
                console.log(res);
                getCourseDetails();
                showAlert("New Section Added!", 3000); 
                $('#addSectionModal').modal('hide');
            },
            'json'
        ).fail(function (xhr, status, error) {
            console.log("Error:", xhr);
        });
    }
});