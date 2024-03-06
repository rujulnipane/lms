<?php
session_start();
$user = $_SESSION["username"];
include("../../controllers/Auth.php");

?>
<?php include("_header.php");?>

<body>
  <header class="p-2 bg-dark border-bottom">
<div class="container">
  <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
    <a href="Courses.php" class="d-flex align-items-center mb-2 mb-lg-0  text-decoration-none  navbar-brand text-light">
      LMS
    </a>

    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 text-light">
      <li><a href="Courses.php" class="nav-link px-2 link-light">Home</a></li>
      <li><a href="#" class="nav-link px-2 link-light">About</a></li>
     
    </ul>

    <div class="dropdown text-end">
      <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle"> --><?= $user ?>
      </a>
      <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
        
      <?php if (Auth::isAdminUser()) : ?>
        <li><a class="dropdown-item" href="createCourse.php">Create New Course</a></li>
        <?php endif; ?>
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="../controllers/Logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>
</header>