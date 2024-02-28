$(document).ready(function() {
    $.get(
        "../controllers/CourseController.php",
        function(response) {
            let courses = response;
            console.log(courses);
            courses.forEach(function(course) {
                const coursecard = `<div class="col" data-course-id=${course['id']}>
            <div class="card h-100 shadow-sm"> <img src=${course['url']} class="card-img-top" alt=${course['title']}>
            <?php if(Auth::isAdminUser()) : ?>
    <a href="#" class="btn-delete" aria-label="Delete" data-course-id=${course['id']}>
        <i class="fas fa-trash"></i>
    </a>
    <?php endif; ?>
                <div class="card-body">
                    <div class="clearfix mb-3"> 
                       <h3>${course['title']}</h3>

                    </div>
                    <h5 class="card-title">${course['details']}</h5>
                    <div class="text-center my-4"> <a href="Courseadmin.php?id=${course['id']}" class="btn btn-warning">View Course</a> </div>
                </div>
            </div>
            </div>`
                $(".row").append(coursecard);
            });
        },
        "json"
    ).fail(function(xhr, status, error) {
        console.error("Error:", error);
    });

    $(document).on("click",".btn-delete",function(e){
        e.preventDefault();
        var course_id = $(this).data('course-id');
        $.post("../controllers/deleteCourse.php",
        {
            id:course_id
        },function(res,status){
            console.log(res);

        },'json').fail(function(xhr,status,error){
            console.log(error);
        })

        $(this).closest('.col').remove();
    });
});


            /*const colDiv = document.createElement("div");
            colDiv.className = "col-xl-3 col-lg-4 col-md-auto mb-4 imgcontainer";

            const cardDiv = document.createElement("div");
            cardDiv.className = "bg-white rounded shadow-sm imgcard";

            const img = document.createElement("img");
            img.alt = "Image Not Available";
            img.className = "card-img-top mx-auto img";

            const contentDiv = document.createElement("div");
            contentDiv.className = "p-4";

            const title = document.createElement("h5");
            const titleLink = document.createElement("a");
            const icon = document.createElement('img');
            icon.className = "icon";
            icon.src = imgsrc;
            titleLink.className = "text-dark";
            titleLink.textContent = source;
            titleLink.setAttribute("target", "_blank");
            title.appendChild(icon);
            title.appendChild(titleLink);

            const description = document.createElement("p");
            description.className = "small text-muted mb-0";

            contentDiv.appendChild(title);
            contentDiv.appendChild(description);

            cardDiv.appendChild(img);
            cardDiv.appendChild(contentDiv);

            colDiv.appendChild(cardDiv);
            this.imgContainer.appendChild(colDiv);

            */
