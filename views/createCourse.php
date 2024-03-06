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

    <div class="container mt-3 vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 pb-2 rounded-lg my-4 py-4">
                <h2 class="mb-4 text-center">Create Course</h2>
                <form action="../controllers/CreateCourse.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="courseTitle">Course Title:</label>
                        <input type="text" name="courseTitle" class="form-control" id="courseTitle" name="courseTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="courseDescription">Course Description:</label>
                        <textarea class="form-control" name="courseDes" id="courseDescription" name="courseDescription" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail Image:</label>
                        <input type="file" class="form-control-file" name="courseImg" id="thumbnail" accept="image/*" required>
                    </div>
                    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>
                    <button type="submit" class="btn btn-success btn-block">Create Course</button>
                </form>
            </div>
        </div>
    </div>


    <?php include "partials/_footer.php"; ?>