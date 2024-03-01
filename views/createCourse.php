<?php

session_start();
include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
}


if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}

?>

    <?php include "partials/navbar.php" ?>

    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-dark text-light text-info pb-2 shadow rounded-lg my-4 py-4">
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
                    <button type="submit" class="btn btn-success btn-block">Create Course</button>
                </form>
            </div>
        </div>
    </div>


    <?php include "partials/_footer.php"; ?>