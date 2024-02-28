$(document).ready(function () {
    $.get(
        "../controllers/CourseController.php",
        function (response) {
            let courses = response;
            console.log(courses);
            courses.forEach(function (course) {

const coursecard = `
    <div class="col-md-4 d-flex justify-content-center align-items-center my-2" data-course-id=${course['id']}>
        <div class="card h-100 w-100" style="width: 18re;">
        <?php if(Auth::isAdminUser()) : ?>
    <a href="#" class="btn-delete" aria-label="Delete" data-course-id=${course['id']}>
        <i class="fas fa-trash text-danger"></i>
    </a>
    <?php endif; ?>
            <img src=${course['url']} class="card-img-top" alt="...">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">${course['title']}</h5>
                    <p class="card-text">${course['details']}</p>
                    <a href="Courseadmin.php?id=${course['id']}" class="btn mr-2"><i class="fas fa-link"></i> View Course</a>
                </div>
        </div>
    </div>
`

                $(".row").append(coursecard);
            });
        },
        "json"
    ).fail(function (xhr, status, error) {
        console.error("Error:", error);
    });

    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();
        var course_id = $(this).data('course-id');
        $.post("../controllers/deleteCourse.php",
            {
                id: course_id
            }, function (res, status) {
                console.log(res);

            }, 'json').fail(function (xhr, status, error) {
                console.log(error);
            })

        $(this).closest('.col-md-4').remove();
    });
});



