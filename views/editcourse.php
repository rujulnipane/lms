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
    <div class="container my-2" style="min-height:84.5vh">
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-md-6 pb-2 rounded-lg my-4 py-4 border shadow-sm">
                <h2 class="mb-4 text-center">Update Course</h2>
                <form action="../controllers/updateCourse.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="courseTitle" class="text-bold">Change TItle</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-graduation-cap"></i></span>
                        </div>
                        <input type="text" name="courseTitle" class="form-control" id="courseTitle" name="courseTitle" required value=<?= $_SESSION['course']['title']?>>
                        <!-- <div id="usernameError" class="invalid-feedback" style="width: 100%;">
                        </div> -->
                    </div>
                </div>

                <div class="mb-3">
                    <label for="courseDescription">Chage Description</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <!-- <span class="input-group-text"><i class="fa fa-lock"></i></span> -->
                        </div>
                        <textarea class="form-control" name="courseDes" id="courseDescription" name="courseDescription" rows="5" required><?= $_SESSION['course']['details'] ?></textarea>
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
                        <input type="file" class="form-control-file" name="courseImg" id="thumbnail" accept="image/*">
                 <!-- <div id="passwordError" class="invalid-feedback">
                        </div> -->
                    </div>
                </div>
                <?php if (isset($error_message)) : ?>
                    <p class="text-center" style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Update Course</button>
            </form>
            </div>
        </div>
    </div>

<?php include "partials/_footer.php";?>