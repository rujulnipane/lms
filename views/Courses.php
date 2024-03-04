<?php
include("../controllers/Auth.php");

session_start();

if (!Auth::isLogin()) {
  header('Location: ' . "../views/Login.php");
}

?>
<?php include("partials/navbar.php");?>
<main role="main">

  <?php if (Auth::isAdminUser()) : ?>
    <div class="col-md-4 visually-hidden" data-course-id="" id="admin-card">
      <div class="card mb-4 shadow-sm">
        <img class="card-img-top" data-src="" alt="Thumbnail [100%x225]" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18df84ab71a%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18df84ab71a%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.71249771118164%22%20y%3D%22120.18000011444092%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
        <div class="card-body">
          <h5 class="card-title text-center"></h5>
          <p class="card-text"></p>
          <div class="d-flex justify-content-between align-items-center">
            <a href="Courseadmin.php?id="><button type="button" class="btn btn-sm btn-outline-success"><i class="fas fa-book"></i> View</button></a>
            <button type="button" class="btn btn-sm btn-outline-primary btn-edit"><i class="fas fa-edit"></i> Edit</button>
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash text-danger"></i> Delete</button>
          </div>
        </div>
      </div>
    </div>
  <?php else : ?>
    <div class="col-md-4 visually-hidden" data-course-id="" id="user-card">
      <div class="card mb-4 shadow-sm">
        <img class="card-img-top" data-src="" alt="Thumbnail [100%x225]" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18df84ab71a%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18df84ab71a%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.71249771118164%22%20y%3D%22120.18000011444092%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
        <div class="card-body">
          <h5 class="card-title text-center"></h5>
          <p class="card-text"></p>
          <div class="d-flex justify-content-center align-items-center">
            <a href="Courseadmin.php?id="><button type="button" class="btn btn-sm btn-outline-success"><i class="fas fa-book"></i> View Course</button></a>
            </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading">Welcome to the Learning Platform</h1>
      <p class="lead text-muted">We have the most wide ranges of free courses. You can accsee the free videos.</p>
      <?php if (Auth::isAdminUser()) : ?>
        <p>
          <a href="createCourse.php" class="btn btn-primary my-2">Create Course</a>
        </p>
    </div>
  <?php endif; ?>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row align-items-center">
        <!-- Courses goes here -->
      </div>
    </div>
  </div>

</main>

<script src="../scripts/courses.js"></script>

<?php include "partials/_footer.php"; ?>