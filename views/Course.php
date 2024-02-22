<?php include 'partials/_header.php'?>

<body>
    <?php include "partials/navbar.php"?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <section>
                    <div class="navbar">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Accordion Item #1
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="video-list">
                                            <!-- Videos will be dynamically added here -->
                                        </div>
                                        <button class="btn btn-primary add-video-btn" data-bs-toggle="modal"
                                            data-bs-target="#uploadVideoModal">Add Video</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <button class="btn btn-success mt-3" data-bs-toggle="modal"
                    data-bs-target="#addSectionModal">Add New Section</button>
            </div>
            <div class="col-md-9">
                <main style="margin-top: 58px;">
                    <div class="container pt-4">
                        <!-- Main content goes here -->
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Upload Video Modal -->
    <div class="modal fade" id="uploadVideoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

    <!-- Add Section Modal -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
        $(document).ready(function () {
            // Function to add a new video to the current section
            $(".add-video-btn").click(function () {
                // Your code to add a new video goes here
            });

            // Function to add a new section
            $("#addSectionForm").submit(function (e) {
                e.preventDefault();
                var sectionTitle = $("#sectionTitle").val();
                var newSection = `
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-${sectionTitle}" aria-expanded="true" aria-controls="collapse-${sectionTitle}">
                                ${sectionTitle}
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
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
