$(document).ready(function () {
    let courses = [];
    $('#spinner').show();
    $.get(
        "../controllers/CourseController.php",
        function (response) {
            $('#spinner').hide();
            courses = response;
            console.log(courses);
            courses.forEach(function (course) {
                const cardTemplate = $("#admin-card").length ? $("#admin-card") : $("#user-card");
                const newCard = cardTemplate.clone().appendTo(".row");
                newCard.attr("data-course-id", course['id']);
                newCard.find(".btn-edit").attr("data-course-id", course['id']);
                newCard.find(".btn-delete").attr("data-course-id", course['id']);
                newCard.find("img").attr("src", course['url']);
                newCard.find(".card-title").text(course['title']);
                newCard.find(".card-text").text(course['details']);
                newCard.find("a").attr("href", "Courseadmin.php?id=" + course['id']);
                newCard.removeClass("visually-hidden");
            });
        },
        "json"
    ).fail(function (xhr, status, error) {
        console.error("Error:", error);
    });

    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();
        var course_id = $(this).data('course-id');
        if (confirm("Are you sure you want to delete this Course?")) {
            $.post("../controllers/deleteCourse.php",
                {
                    id: course_id
                }, function (res, status) {
                    console.log(res);

                }, 'json').fail(function (xhr, status, error) {
                    console.log(error);
                })

            $(this).closest('.col-md-4').remove();
        }
    });

    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();
        var course_id = $(this).data('course-id');
        console.log(course_id);
        let course = courses.filter(course => course["id"] == course_id);
        $.post("editcourse.php", {
            course: course
        }, function (res, status) {
            window.location.href = "/views/editcourse.php";
        });

    });
});



