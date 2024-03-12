<?php

session_start();
include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
}

if (!Auth::isAdminUser()) {
    header('Location: ' . "./Courses.php");
}


if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}

?>

<?php include "partials/navbar.php" ?>

<div class="container mt-3" style="min-height:83vh">
    <div class="row justify-content-center">
        <div class="col-md-6 pb-2 rounded-lg my-4 py-4 border shadow-sm">
            <h2 class="mb-4 text-center">Create Course</h2>
            <!-- <p class="text-center">Fill the Course Title, description about the course and select one thumbnail image to display on the course card</p> -->
            <form action="../controllers/CreateCourse.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="courseTitle" class="text-bold">Course Title:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-graduation-cap"></i></span>
                        </div>
                        <input type="text" name="courseTitle" class="form-control" id="courseTitle" name="courseTitle" required>
                        <!-- <div id="usernameError" class="invalid-feedback" style="width: 100%;">
                        </div> -->
                    </div>
                </div>

                <div class="mb-3">
                    <label for="courseDescription">Course Description:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <!-- <span class="input-group-text"><i class="fa fa-lock"></i></span> -->
                        </div>
                        <textarea class="form-control" name="courseDes" id="courseDescription" name="courseDescription" rows="5" required></textarea>
                        <!-- <div id="passwordError" class="invalid-feedback">
                        </div> -->
                    </div>
                </div>
                <div class="mb-3">
                <label for="thumbnail">Thumbnail Image:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <!-- <span class="input-group-text"><i class="fa fa-lock"></i></span> -->
                        </div>
                        <input type="file" class="form-control-file" name="courseImg" id="thumbnail" accept="image/*" required>
                 <!-- <div id="passwordError" class="invalid-feedback">
                        </div> -->
                    </div>
                </div>
                <?php if (isset($error_message)) : ?>
                    <p class="text-center" style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Create Course</button>
            </form>
        </div>
    </div>
</div>


<?php include "partials/_footer.php"; ?>