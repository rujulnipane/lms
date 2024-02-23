<?php
include("../controllers/Auth.php");
if (!Auth::isLogin()) {
    header('Location: ' . "./Login.php");
} 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["course"])) {
        $_SESSION["course"] = $_POST["course"];
        print_r($_SESSION["course"]);
    }
}

?>
<?php include 'partials/_header.php' ?>

<body>
    <?php include 'partials/navbar.php' ?>
    <div class="container my-2">
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <div class="container">

            <h2 class="text-center">Update Course <?= $_SESSION['course']["title"] ?></h2>
            <form action="../controllers/updateCourse.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="courseTitle">Change Title</label>
                    <input type="text" name="courseTitle" class="form-control" id="courseTitle" value=<?= $_SESSION['course']['title'] ?> required>
                </div>
                <div class="form-group">
                    <label for="courseDes">Write description of Course</label>
                    <textarea name="courseDes" class="form-control" id="courseDes" rows="3" required><?= $_SESSION['course']['details'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="courseImg">Upload Course Thumbnail:</label>
                    <input type="file" id="courseImg" name="courseImg" class="form-control-file" accept="image/*">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success">Update Course</button>
                </div>
            </form>
        </div>
    </div>


<?php include "partials/_footer.php";?>