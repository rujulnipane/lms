<?php include 'partials/_header.php' ?>

<body>
    <?php include "partials/navbar.php" ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 shadow-sm p-2 mb-5 bg-body rounded min-vh-100 ">
                <div class="navbar">
                    <div class="accordion w-100" id="accordionExample">
</div>
                </div>
                <button class="btn btn-success mt-3 float-end" data-bs-toggle="modal" data-bs-target="#addSectionModal">Add New Section</button>
            </div>
            <div class="col-md-9 shadow-sm p-2 mb-5 bg-body rounded min-vh-100 ">
                <main>
                    <div class="container pt-2">
                        <header class="d-flex justify-content-between align-items-center">
                            <h1 id="course-title"></h1>
                            <div>
                                <button class="btn btn-danger me-2" id="delete-course-btn">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                <!-- <a href="/views/createCourse.php"> -->
                                    <button class="btn btn-primary" id="edit-course-btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                <!-- </a> -->
                            </div>
                        </header>
                    </div>
                    <div class="video-container">
                        <!-- Video player goes here -->
                    </div>
                    <div class="bg-light p-3">
                        <div class="container">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary">Prev</button>
                                <button class="btn btn-primary">Next</button>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>


    <div class="modal fade" id="uploadVideoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="uploadVideoForm">
                        <div class="mb-3">
                            <label for="videoFile" class="form-label">Choose Video File</label>
                            <input type="file" class="form-control" id="videoFile" name="videoFile" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSectionForm">
                        <div class="mb-3">
                            <label for="sectionTitle" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="sectionTitle" name="sectionTitle" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Section</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            $.post(
                "../controllers/getcontroller.php", {
                    id: course_id
                },
                function(res, status) {
                    course = res;
                    console.log(res);
                    const sections = res["sections"];
                    $("#course-title").html(res["course"]["title"]);
                    if(sections === null){
                        console.log("fd");
                    }

                    sections.forEach(element => {
                        var newSection = `
                    <div class="accordion-item" data-section-id="${element['id']}">
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
                                <button class="btn btn-primary add-video-btn" data-bs-toggle="modal"
                                    data-bs-target="#uploadVideoModal">Add Video</button>
                                    
                            </div>
                        </div>
                    </div>`;
                        $("#accordionExample").append(newSection);
                    });
                },
                'json'
            ).fail(function(xhr, status, error) {
                console.log("Error:", xhr);
            });


            $(".add-video-btn").click(function() {
                // Your code to add a new video goes here
            });

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
                    },
                    'json'
                ).fail(function(xhr, status, error) {
                    console.log("Error:", xhr);
                });

                var newSection = `
                    <div class="accordion-item" data-section-id="${sectionTitle}">
                        <h2 class="accordion-header d-flex">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-${sectionTitle}" aria-expanded="true"
                                aria-controls="collapse-${sectionTitle}">
                                ${sectionTitle}
                                <button class="btn btn-danger delete-section-btn" data-section-id="${sectionTitle}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </button>
                        </h2>
                        <div id="collapse-${sectionTitle}" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="video-list">
                                    <!-- Videos will be dynamically added here -->
                                </div>
                                <button class="btn btn-primary add-video-btn" data-bs-toggle="modal"
                                    data-bs-target="#uploadVideoModal">Add Video</button>
                                    
                            </div>
                        </div>
                    </div>`;
                $("#accordionExample").append(newSection);
                $('#addSectionModal').modal('hide');
            });

            // Function to delete a section
            $(document).on("click", ".delete-section-btn", function() {
                var sectionId = $(this).data("section-id");
                console.log(sectionId);
                let course_id = $.urlParam('id');
                $.post(
                    "../controllers/deleteSection.php",
                    {
                        course_id : course_id,
                        section_id : sectionId
                    },
                    function(res, status) {
                        console.log(res);
                    },
                    'json'
                ).fail(function(xhr, status, error) {
                    console.log("Error:", xhr);
                });

                // $('[data-section-id="' + sectionId + '"]').remove();

            });

            $("#delete-course-btn").click(function(){
                let course_id = $.urlParam('id');
                $.post("../controllers/deleteCourse.php",{id:course_id}, function(res,status){
                    console.log(res);
                    window.location.href = "/views/Courses.php";
                },
                'json').fail(function(xhr,status,error){
                    console.log(error);
                });
            });

            $("#edit-course-btn").click(function(){
                console.log(course);
                $.post("editcourse.php", {course: course['course']},function(res,status){
                    window.location.href = "/views/editcourse.php";
                });
            });

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>