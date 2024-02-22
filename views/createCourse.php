<?php

session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./Login.php");
} else if (isset($_SESSION["isAdmin"]) and !$_SESSION["isAdmin"]) {
    $_SESSION['error'] = "Access Denied";
    header('Location: ' . "./Courses.php");
}

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}

?>

<?php include 'partials/_header.php'?>

<body>
<?php include "partials/navbar.php"?>
<div class="container my-2">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <h2 class="text-center">Create New Course</h2>
    <form action="../controllers/CreateCourse.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="courseTitle">Enter Title of the Course</label>
            <input type="text" name="courseTitle" class="form-control" id="courseTitle" placeholder="Enter title of the course" required>
        </div>
        <div class="form-group">
            <label for="courseDes">Write description of Course</label>
            <textarea name="courseDes" class="form-control" id="courseDes" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="courseImg">Upload Course Thumbnail:</label>
            <input type="file" id="courseImg" name="courseImg" class="form-control-file" accept="image/*">
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-success">Create Course</button>
        </div>
    </form>
</div>


    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>