<?php
include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
} 

if (!Auth::isAdminUser()) {
    header('Location: ' . "./Courses.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["course"])) {
        $_SESSION["course"] = $_POST["course"];
    }
}

?>

    <?php include 'partials/navbar.php' ?>
    <div class="container my-2">
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-6 pb-2 rounded-lg my-4 py-4">
                <h2 class="mb-4 text-center">Update Course <?= $_SESSION['course']["title"] ?></h2>
                <form action="../controllers/updateCourse.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="courseTitle">Change Title:</label>
                        <input type="text" name="courseTitle" class="form-control" id="courseTitle" name="courseTitle" value=<?= $_SESSION['course']['title']?> required>
                    </div>
                    <div class="form-group">
                        <label for="courseDescription">Change Description:</label>
                        <textarea class="form-control" name="courseDes" id="courseDescription" name="courseDescription" rows="3" required><?= $_SESSION['course']['details'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail Image:</label>
                        <input type="file" class="form-control-file" name="courseImg" id="thumbnail" accept="image/*" >
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Update Course</button>
                </form>
            </div>
        </div>
    </div>

<?php include "partials/_footer.php";?>